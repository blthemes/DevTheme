<?php

class fileCache
{
    /**
     * Cache configurations.
     *
     * @var string[]
     */
    protected $config = [
        'unixLoadUpperThreshold' => -1,
        'gzipCompression'        => true,
        'cacheDirectory'         => '/tmp/cache-storage/',
        'fileExtension'          => 'cache',
    ];

    /**
     * Change the configuration values.
     *
     * @param array $configArray
     *
     * @return bool
     */
    public function changeConfig($config)
    {
        if (!is_array($config)) {
            return false;
        }

        $this->config = array_merge($this->config, $config);

        return true;
    }

    /**
     * Sets an item in the cache.
     *
     * @param mixed $key
     * @param mixed $content
     * @param int   $expiry
     *
     * @return bool
     */
    public function set($key, $content, $expiry = 0)
    {
        $cacheObj = new \stdClass();

        if (!is_string($content)) {
            $content = serialize($content);
        }

        $cacheObj->content = $content;

        if (!$expiry) {
            // If no expiry specified, set to 'Never' expire timestamp (+10 years)
            $cacheObj->expiryTimestamp = time() + 315360000;
        } elseif ($expiry > 2592000) {
            // For value greater than 30 days, interpret as timestamp
            $cacheObj->expiryTimestamp = $expiry;
        } else {
            // Else, interpret as number of seconds
            $cacheObj->expiryTimestamp = time() + $expiry;
        }

        // Do not save if cache has already expired
        if ($cacheObj->expiryTimestamp < time()) {
            $this->delete($key);
            return false;
        }

        $cacheFileData = json_encode($cacheObj);

        if ($this->config['gzipCompression']) {
            $cacheFileData = @gzcompress($cacheFileData);
        }

        $filePath = $this->getFilePathFromKey($key);
        $result = file_put_contents($filePath, $cacheFileData);

        return $result ? true : false;
    }

    /**
     * Returns a value from the cache.
     *
     * @param string $key
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function get($key)
    {
        $filePath = $this->getFilePathFromKey($key);

        if (!file_exists($filePath)) {
            return false;
        }

        if (!is_readable($filePath)) {
            return false;
        }

        $cacheFileData = file_get_contents($filePath);

        if ($this->config['gzipCompression']) {
            $cacheFileData = @gzuncompress($cacheFileData);
        }

        $cacheObj = json_decode($cacheFileData);

        // Unable to decode JSON (could happen if compression was turned off while compressed caches still exist)
        if ($cacheObj === null) {
            return false;
        }

        if (!function_exists('sys_getloadavg') && $this->config['unixLoadUpperThreshold'] !== -1) {
            throw new Exception('Your PHP installation does not support `sys_getloadavg` (Windows?). Please set `unixLoadUpperThreshold` to `-1` in your DOFileCache config.');
        }

        if ($this->config['unixLoadUpperThreshold'] == -1) {
            $unixLoad = [0 => -PHP_INT_MAX, 1 => -PHP_INT_MAX, 2 => -PHP_INT_MAX];
        } else {
            $unixLoad = sys_getloadavg();
        }

        if ($cacheObj->expiryTimestamp > time() || $unixLoad[0] >= $this->config['unixLoadUpperThreshold']) {
            // Cache item has not yet expired or system load is too high
            $content = $cacheObj->content;

            if (($unserializedContent = @unserialize($content)) !== false) {
                // Normal unserialization
                $content = $unserializedContent;
            } elseif ($content == serialize(false)) {
                // Edge case to handle boolean false being stored
                $content = false;
            }

            return $content;
        } else {
            // Cache item has expired
            return false;
        }
    }

    /**
     * Remove a value from the cache.
     *
     * @param string $key
     *
     * @return bool
     */
    public function delete($key)
    {
        $filePath = $this->getFilePathFromKey($key);
        if (!file_exists($filePath)) {
            return false;
        }
		return unlink($filePath);
    }

    /**
     * Wipe out all cache values.
     *
     * @return bool
     */
    public function flush()
    {
        return $this->deleteDirectoryTree($this->config['cacheDirectory']);
    }

    /**
     * Removes cache files from a given directory.
     *
     * @param string $directory
     *
     * @return bool
     */
    private function deleteDirectoryTree($directory)
    {
        $filePaths = scandir($directory);

        foreach ($filePaths as $filePath) {
            if ($filePath == '.' || $filePath == '..') {
                continue;
            }

            $fullFilePath = $directory.'/'.$filePath;
            if (is_dir($fullFilePath)) {
                $result = $this->deleteDirectoryTree($fullFilePath);
                if ($result) {
                    $result = rmdir($fullFilePath);
                }
            } else {
                if (basename($fullFilePath) == '.keep') {
                    continue;
                }
                $result = unlink($fullFilePath);
            }

            if (!$result) {
                return false;
            }
        }

        return true;
    }

    /**
     * Increments a value within the cache.
     *
     * @param string $key
     * @param int    $offset
     *
     * @return bool
     */
    public function increment($key, $offset = 1)
    {
        $filePath = $this->getFilePathFromKey($key);

        if (!file_exists($filePath)) {
            return false;
        }

        if (!is_readable($filePath)) {
            return false;
        }

        $cacheFileData = file_get_contents($filePath);

        if ($this->config['gzipCompression']) {
            $cacheFileData = @gzuncompress($cacheFileData);
        }

        $cacheObj = json_decode($cacheFileData);
        $content = $cacheObj->content;

        if ($unserializedContent = @unserialize($content)) {
            $content = $unserializedContent;
        }

        if (!$content || !is_numeric($content)) {
            return false;
        }

        $content += $offset;

        return $this->set($key, $content, $cacheObj->expiryTimestamp);
    }

    /**
     * Decrements a value within the cache.
     *
     * @param string $key
     * @param int    $offset
     *
     * @return bool
     */
    public function decrement($key, $offset = 1)
    {
        return $this->increment($key, -$offset);
    }

    /**
     * Replaces a value within the cache.
     *
     * @param string $key
     * @param mixed  $content
     * @param int    $expiry
     *
     * @throws Exception
     *
     * @return bool
     */
    public function replace($key, $content, $expiry = 0)
    {
        if (!$this->get($key)) {
            return false;
        }

        return $this->set($key, $content, $expiry);
    }

    /**
     * Returns the file path from a given cache key, creating the relevant directory structure if necessary.
     *
     * @param string $key
     *
     * @return string
     */
    protected function getFilePathFromKey($key)
    {
        $key = basename($key);
        $badChars = ['-', '.', '_', '\\', '*', '\"', '?', '[', ']', ':', ';', '|', '=', ','];
        $key = str_replace($badChars, '/', $key);
        while (strpos($key, '//') !== false) {
            $key = str_replace('//', '/', $key);
        }

        $directoryToCreate = $this->config['cacheDirectory'];

        $endOfDirectory = strrpos($key, '/');

        if ($endOfDirectory !== false) {
            $directoryToCreate = $this->config['cacheDirectory'].substr($key, 0, $endOfDirectory);
        }

        if (!file_exists($directoryToCreate)) {
            $result = mkdir($directoryToCreate, 0777, true);
            if (!$result) {
                return false;
            }
        }

        $filePath = $this->config['cacheDirectory'].$key.'.'.$this->config['fileExtension'];

        return $filePath;
    }
}
