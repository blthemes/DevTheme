<?php //simplified version of Bludit dbjson.class.php with moded json encoding
class jsonDB {

	public $db;
	private $file;	
	
	function __construct($file)
	{
		$this->file = $file;
		$this->db = array();		

		if (file_exists($file)) {
			// Read JSON file
			$lines = file($file);			

			// Regenerate the JSON file
			$implode = implode($lines);

			// Unserialize, JSON to Array
			$array = $this->unserialize($implode);

			if (empty($array)) {
				$this->db = array();				
			} else {
				$this->db = $array;				
			}
		}
	}
	
	// Returns the number of rows in the database
	public function count()
	{
		return count($this->db);
	}

	// Returns the value from the field
	public function getField($field)
	{
		if (isset($this->db[$field])) {
			return $this->db[$field];
		}
		return $this->dbFields[$field];
	}

	// Save the JSON file
	public function save()
	{
		$data = '';
	
		// Serialize database
		$data .= $this->serialize($this->db);

		
		// LOCK_EX flag to prevent anyone else writing to the file at the same time.
		if (file_put_contents($this->file, $data, LOCK_EX)) {
			return true;
		} else {			
			return false;
		}
	}

	// Returns a JSON encoded string on success or FALSE on failure
	private function serialize($data)
	{
		return json_encode($data, JSON_UNESCAPED_UNICODE|JSON_HEX_APOS);
	}

	// Returns the value encoded in json in appropriate PHP type
	private function unserialize($data)
	{
		// NULL is returned if the json cannot be decoded
		$decode = json_decode($data, true);
		if (empty($decode)) {
			return false;
		}
		return $decode;
	}

	public function getDB()
	{
		return $this->db;
	}

	// Truncate all the rows
	public function truncate()
	{
		$this->db = array();
		return $this->save();
	}

}