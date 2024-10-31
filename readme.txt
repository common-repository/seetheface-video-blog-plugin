=== Plugin Name ===

Contributors: Seetheface
Donate link: http://www.seetheface.com/
Tags: video, post, posts, plugin, flash, integration
Requires at least: 2.0
Tested up to: 2.3
Stable tag: trunk

SeeTheFace plugin transforms your text blog into a video blog. Utilizing SeeTheFace flash based A/V recorder application it allows you to record your A/V messages using your web camera and microphone and publish on your blog straight away.

== Description ==

SeeTheFace's plugin for WordPress enables you to upgrade your text blog to Video Blog instantaneously.

With the help of SiteClip users will be able to easily use Publisher's video message recorder and filters. Moreover, the mechanism behind SiteClip makes it possible to integrate it with any kind of website, regardless of its type and complexity. SiteClip can be built-in to E-commerce, Educational/Informational and News, Community, Auction sites as well as Job Portals, in a snap.

Activation

Once the plugin is isntalled you have to activate it. Activation is 100% free. All you need is to register on the site, get back to this page, and insert your actiovation key in your wordpress blog (Blog administration - Plugins - SeeTheFace)


== Installation ==

1. Install Wordpress.
2. Unpack the entire archive to the following folder: Wordpress\wp-content\plugins\
3. Login to the Wordpress admin console.
4. Click on the plug-ins button.
5. Locate the line which says "SeeTheFace" and click "Activate". From now on the plug-in is active.
6. While still in the Wordpress admin console, choose the "Manage" option.
7. Click on the "SeeTheFace" button.
8. Scroll down to the bottom of the page and click "Change plug-in settings" link.
9. Type in your api_key which you have received from the Plugin section after the Plugin activation (You should provide your Blog URL for the activation there) in the "API KEY" field , ( www.seetheface.com/plugin/wordpress/ ) . Please bear in mind that the SeeTheFace system has two API Keys, one is for SiteClip and the other one is for the WordPress Plugin. You should use the WordPress Plugin API Key here which you will receive after the activation of your Blog only.
10. "RETURN URL" field should already contain the URL, where the user gets redirected, once he/she is done recording the video. It is assumed, that plug-in is installed to the following directory on your website: http://www.yourdomian.com/wordpress/wp-content/plugins/seetheface/seethefacelist . If this is not the case, then you need to modify " RETURN URL" field, so it contains the real path to the plug-in. i.e. /some_directories/wordpress/wp-content/plugins/seetheface/seethefacelist
11. "HTTP absolute path to uploads dir" field contains an HTTP path to the folder, where all the recorded files are to be stored. It is assumed, that there exists a folder "wp-content/uploads/", which by default, is used by Wordpress for file uploading. If this folder exists and Wordpress is installed to the root directory of your site, then you do not need to change anything.
12. "Server absolute path to uploads dir" holds the server path to the directory, where all the recorded files are to be stored. It is implied that the directory /wp-content/uploads/ exists on your server and has 0777 access permission. By default, Wordpress uses this folder to upload files, however, it is not created during Wordpress installation, therefore, if this folder is absent you will need to create it yourself and set the access permission to 0777. All the recordings, which are made using www.seetheface.com will be stored in this folder.
13. Register on the www.seetheface.com website and navigate to SiteClip->Settings. In the "Handler Page" field specify the path to your SeeTheFace Wordpress plug-in handler file. Note, that the domain name, which you have used when registering an account, needs to be omitted. The path to the handler file should resemble the one: some_folder/some_folder2/wordpress/wp-content/plugins/seetheface/seetheface-client-handler.php


== Frequently Asked Questions ==

= When clicking "New A/V recording" you get a blank page, saying "invalid api_key" =

This means, that you have not registered on the www.seetheface.com website or have supplied an invalid api_key.

= After you've finished recording you get an error message "Your video has not been saved" =

1. Most likely you have an error in the path to your handler file, located on your site in the directory
wordpress/wp-content/plugins/seetheface/seetheface-client-handler.php
2. The directory specified in "Server absolute path to uploads dir" does not exists, or its access permissions are not set to 0777

= The video files, which you've recorded using www.seetheface.com are not displayed in your posts =

1. Make sure you have spelled the tag [seetheface id="some_id"] correctly.
2. The recorded file might be absent for some reason.
3. The path specified in the "HTTP absolute path to uploads dir" might be incorrect.

= You don't have a SeeTheFace button in your WYSIWYG editor. =

Instructions on how to add a SeeTheFace button to your WYSIWYG editor panell, can be found in the official forum.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. /trunk/1.gif
2. /trunk/2.gif
3. /trunk/3.gif
4. /trunk/4.gif
5. /trunk/5.gif
6. /trunk/6.gif
7. /trunk/7.gif
8. /trunk/8.gif
9. /trunk/9.gif
10. /trunk/10.gif

= Support =

The first place to turn for support is our Forum. We strongly recommend you do a search and most likely you will easily find an answer to your question. You can also contact us directly.