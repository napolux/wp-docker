=== AJAX Thumbnail Rebuild ===
Contributors: junkcoder, RistoNiinemets
Donate link: http://breiti.cc/wordpress/ajax-thumbnail-rebuild/#donate
Tags: ajax, thumbnail, rebuild, regenerate, admin, image, photo
Requires at least: 2.8
Tested up to: 4.8.2
Stable tag: 1.13

AJAX Thumbnail Rebuild allows you to rebuild all thumbnails at once without script timeouts on your server.

== Description ==

AJAX Thumbnail Rebuild allows you to rebuild all thumbnails on your site. There are already some plugins available for this, but they have one thing in common: All thumbnails are rebuilt in a single step. This works fine when you don’t have that many photos on your site. When you have a lot of full-size photos, the script on the server side takes a long time to run. Unfortunately the time a script is allowed to run is limited, which sets an upper limit to the number of thumbnails you can regenerate. This number depends on the server configuration and the computing power your server has available. When you get over this limit, you won’t be able to rebuild your thumbnails.

Why would you want to rebuild your thumbnails? Wordpress allows you to change the size of thumbnails. This way, you can make the size of thumbnails fit the design of your website. When you change the size to fit for a new theme, all future photos you are going to upload will have this new size. Your old thumbnails won’t be resized. That’s where this plugin comes into action. After changing the image sizes, you can rebuild all thumbnails. But instead of telling the server to recreate all thumbnails at once, they are rebuilt one after another. Rebuilding thumbnails for one photo won’t take all too long, so you won’t run into any script timeouts. Note that you still have to wait until all thumbnails have been rebuilt. If you close the page before the task is completed, you have to start all over again.

You can also select the thumbnail sizes you want to rebuild, so that you don't need to recreate all images if you've just changed one thumbnail-size. You can also choose to only rebuild post thumbnails (featured images).

This plugin requires JavaScript to be enabled.


Contributions are welcome at [Github](https://wordpress.org/plugins/ajax-thumbnail-rebuild/)

== Installation ==

Upload the plugin to your blog, activate it, done. You can then rebuild all thumbnails in the tools section (Tools -> Rebuild Thumbnails).

== Changelog ==

= 1.2.2 =

* Compatibility with PHP 7.2 (props @thomas-gordon)
* Implemented throttling and retries for image regeneration (props @da2x)

= 1.2.1 =

* NEW: Allow custom crop areas, [read more](https://developer.wordpress.org/reference/functions/add_image_size/#parameters)

= 1.2 =

* Compatibility with PHP7

= 1.12 =

* FIX: An issue where rebuilding thumbnails in the media gallery
       would not work

= 1.11 =

* FIX: An issue where the plugin would sometimes break the media gallery.

= 1.10 =

* NEW: Rebuild thumbnails of single images on the media attachment page.

= 1.09 =

* NEW: Checkboxes can be activated by clicking on text.

= 1.08 =

* NEW: Slovak translation, provided by Branco Radenovich.

= 1.07 =

* FIX: Don't create metadata with empty size when original image is smaller
       than the target size.

= 1.06 =

* FIX: Don't forget metadata for sizes that aren't rebuilt.
* FIX: Option to only rebuild featured images should now work correctly.
* FIX: Don't fail if there are no attachments.
* NEW: It's now possible to toggle all selected sizes.
* NEW: Added translation: German.

= 1.05 =

* Add option to only rebuild post thumbnails (featured images)

= 1.04 =

* Tested with Wordpress 3.2

= 1.03 =

* Fixed: Show correct height value for thumbnails.

= 1.02 =

* You can now select which thumbnail sizes you want to rebuild. Thanks to Nicolas Juen!

= 1.01 =

* Tested with Wordpress 3.0

= 1.0 =

* Initial release

== Screenshots ==

1. Plugin in action
