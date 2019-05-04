# DevTheme

A simple, clean, minimalist theme, featuring content-focused design and single-column layout.

![screenshot](https://blthemes.pp.ua/devtheme/bl-content/uploads/pages/e7d20df23f4689c9fa7f7c017c562d8b/devtheme38.png
 "DevTheme")

[Live Demo](https://blthemes.pp.ua/devtheme/)

## Changelog

v3.8.1  

* IMPORTANT: Due to some user complaints, the use of CDN for images and image resizing has been disabled. If you want to use it again in `init.php` change this line:
```
$helper = new Helper($useCdn=false);
```
to
```
$helper = new Helper($useCdn=true);
```
* Removed top share box.
* Support for Cyrillic in search.
* Search now is case-insensitive.
* All strings in front-end can be translated.
* Default font changed to [Rubik](https://fonts.google.com/specimen/Rubik)
* Fixed bug in not `pre` `code` blocks. Now they are inline.
* Changed design for code blocks. 

v3.8.0  

* Improved search - faster and most memory-flexible full-text search. Now include accents and diacritics.  
* Added support for Site logo.  
* Improved syntax highlighting for code blocks.  
* Removed some unnecessary code.  
* Other small bug fixes and improvements.

v3.0.0  

*  Initial release