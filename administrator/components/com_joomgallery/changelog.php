<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/administrator/components/com_joomgallery/changelog.php $
// $Id: changelog.php 3627 2012-02-12 15:01:49Z chraneco $
/******************************************************************************\
**   JoomGallery  1.5.7                                                       **
**   By: JoomGallery::ProjectTeam                                             **
**   Copyright (C) 2008 - 2011  M. Andreas Boettcher                          **
**   Based on: JoomGallery 1.0.0 by JoomGallery::ProjectTeam                  **
**   Released under GNU GPL Public License                                    **
**   License: http://www.gnu.org/copyleft/gpl.html or have a look             **
**   at administrator/components/com_joomgallery/LICENSE.TXT                  **
\******************************************************************************/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
?>

CHANGELOG JOOMGALLERY (since Version 1.5 BETA 1 -20081130-)

Legende / Legend:

* -> Security Fix
# -> Bug Fix
+ -> Addition
^ -> Change
- -> Removed
! -> Note

===============================================================================
                                     1.5.7.5
                                    (20120212)
===============================================================================
20120211
# in_hidden flag of categories was not always set correctly

20111215
# wrong information of automatic detection of Image Magick if the path has been
  setted manually before

20111211
# Redirect in Frontend JAVA-Upload not working

20111123
# Rating not working, because Mootools library was not loaded for some
  configuration cases

20111117
# Thickbox did not work in IE 8

20111114
# AJAX rating not working if display of rating in detail view (image information)
  not enabled

20111113
^ Prevent '&amp;' in redirect URLs

20111013
# deactivating the toplists view does not load the CSS for list view of favorites
  completely
# Slideshow does not work if there are quotes in the image title

===============================================================================
                                     1.5.7.4
                                    (20111009)
===============================================================================

20111007
# '1 pixel fault' in cropped images
  , see http://www.forum.joomgallery.net/index.php/topic,4146.0.html
  , thanks to 'quark'

20110925
# Problem with Ajax requests in MiniJoom while SEF is enabled fixed
# Optional class attribute wasn't added correctly while inserting an image into articles with MiniJoom

20110924
# Uploading an image with special signs in name shows a wrong javascript message

20110807
# Inserting images from MiniJoom in backend wasn't possible for general text areas

20110729
# Cooliris does not work in paginated category view

20110726
^ Anchor tag now always at top gallery/catageory view if activated

20110724
# Get the right path to components/com_joomgallery/assets/images/blank.gif
  in pngbehavior.htc

20110711
# Remove duplicate instantiation of JParameter for addtional image parameters in detail view

===============================================================================
                                     1.5.7.3
                                    (20110703)
===============================================================================

20110703
# There weren't always all images of a category shown in popup boxes although
  option 'All images in popup box' is enabled.

20110701
# '- No User -' at the messenger options was not marked after selecting it
  and saving the configuration

20110620
# Several typos, use of undefined configuration parameter 'useruseorigfilename'
  instead of 'jg_useruseorigfilename'

===============================================================================
                                     1.5.7.2
                                    (20110525)
===============================================================================

20110522
# Don't trim already existing aliases

20110520
# Notice: Undefined variable $author: /components/com_joomgallery/views/detail/view.html.php on line 468
  in slideshow with option 'Detail view->General settings->Show author->No'
  thank you @Thomas for bugreport
# Title of images in opened thickbox/slimbox not shown when navigating within the box
  to a image which is not part of the current paginated category view
# Favorites view: Title of images not displayed in opened thickbox/slimbox
# There was a closing 'div' too much in some cases in interface.
# Filter in MiniJoom didn't work correctly

20110519
# BBCode was not displayed correctly when using uppercase letters, wrong
  variable name used in processText()

20110518
# Wrong variable name in upload.php

20110506
# It was not possible to move an image without an existing original image

===============================================================================
                                     1.5.7.1
                                    (20110501)
===============================================================================

20110501
# Toplist links didn't work correctly with SEF enabled

20110430
^ Set default of 'published' to 'yes' for new images and categories
# Additional parameters could not be used correctly
# Inserting images and categories from MiniJoom wasn't possible for general editors

20110429
# IPTC keywords were not always output correctly

20110428
# Wrong number of images was displayed in category and gallery view if there
  where 1000 images or more in a category.
# Wrong position of closing 'div' in category view.

20110427
# Double output of 'class' and 'title' with active slimbox or thickbox

20110424
# Slashes in aliases were removed while storing a category for the second time
   or if the alias was entered manually
^ Uploads: function 'image_type_to_extension' (since PHP 5.2) removed to follow the least
  system requirements of JoomGallery

20110423
# It was not possible to select 'No User' - subcategories of 'User' - categories
  in the select boxes 'Allowed categories' and 'Allowed for usercategories' in
  the backend's configuration manager tab 'User Access Rights >> User Upload'

===============================================================================
                                       1.5.7
                                    (20110418)
===============================================================================

20110418
# Entered aliases for categories which aren't created automatically weren't made safe
# There was a PHP notice while setting new aliases for all images and categories

20110417
# missing imports in install.joomgallery.php added

20110414
# Escape image title in backend edit view

20110404
# It was not possible to search with umlauts and special characters (added MySQL function 'LOWER()')

20110403
# It was not possible to edit certain categories in frontend if Joomla! core SEF was enabled

20110322
# wrong display of Thickbox3 in IE9

20110317
+ Search box and category filter in userpanel view

20110314
+ Plugin events 'onJoomBeforeDownload' and 'onJoomBeforeZipDownload' added
^ Pay attention to 'jg_realname' in select boxes of the backend edit views

20110310
^ Removed redundant code by creating a new class JoomAdminConfig
  and deleting JoomConfig in frontend. From now on JoomConfig in backend
  is also used for frontend and for storing the config JoomAdminConfig is used
# In frontend it was not possible to move a category to another parent
  category which is in the list of allowed parent categories
+ Some additions in MiniJoom for new JoomPlu version
+ Additional parameter for frontend function JoomHelper::getAllSubCategories()
  to optionally return hidden categories too

20110308
# Images with no owner were not found during a search

20110306
+ Ajax pagination in MiniJoom

20110305
+ New tab in configuration manager to configure the search view

20110304
+ Optional possibility for users to create main categories in frontend
+ Optionally messages for new uploads by java in frontend

20110303
+ Improved tooltips in userpanel view and usercategories view
+ CSS tags added for pagination at all views
+ Optional editor links added in favourites, category, detail, toplist and search view
^ 'BBDecode' is only called for comments from now on, so no calls of 'BBDecode' in
  detail view and in JoomHelper::fixForJS() anymore. Addtionally 'nl2br' isn't called
  in 'BBDecode' anymore.
^ Use of JFactory::getSession()->getToken() for the countstop

20110302
+ Optionally messages for new name tags
# ImageMagick isn't dependent on memory_limit so skip the memory check in that case
# Distorted characters in comments

20110301
! TODO regarding state of new images created with the 'New' button removed
^ new JAVA-Applet 5.0.2 Build 1509

20110227
^ Show username or real name in nametags select box dependent on backend
  configuration setting
+ optional message about zip download
+ sort by published or unpublished in image manager

20110226
+ optional message about single image download

20110224
+ Implementation of an improved and more user friendly pagination and redirect
  behaviour in userpanel and usercategories view
+ Improved fault tolerance in the generation of file names for uploaded images

20110223
# Division by 0 error if detail image or thumbnail width or height was set to 0
  (original image instead of a resized one was stored because of that)
+ Don't resize the images (only copy them) if source file is already
  of the same size or smaller than the image which shall be created
+ RSS feed for category view
+ Option for using real paths for images if dynamic cropping and watermark is disabled

20110222
^ Use of language constant 'NO USER' in category and image manager instead of 'Administrator'

20110219
! TODO regarding column 'by' in update script removed

20110220
+ Crop of images: option to determine the background color of cropped image
+ New functions JHTML::_('joomgallery.minithumbimg',..) and JHTML::_('joomgallery.minithumbcat',..)
  introduced to display minithumbs in category, image and comments manager

20110219
! TODO regarding cleaning variables in messenger removed
+ Slideshow: options for behaviour after the last image has been shown
# Afore moving an image in frontend and backend check whether a valid category was selected
+ New option for disabling the default detail view if it is not used in the gallery

20110218
# Images which aren't allowed to be displayed are no longer displayed in favourites view
! TODO regarding check whether version tags exist in XML files removed

20110215
^ Ordering select box in Usercategories view now contains only the neccessary entries
  dependent on the selected parent category

20110214
+ Hidden categories
+ Possibility to hide empty categories
! TODO regarding error messages in backend image model removed (there are already enough messages)

20110212
^ Inline CSS of refresher moved to joomgallery.css
+ State (published/unpublished) and access level of categories are passed on to
  all sub-categories and images from now on. So sub-categories and images of an
  unpublished category cannot be published anymore, for example.
^ Moved function 'BBDecode' from class JoomHelper into class JHTMLJoomGallery
# First installation of JoomGallery failed because of trying to copy the file
  'index.html' into a not yet existing images/joomgallery folder.

20110211
+ Message in image view if wrong document type is used (image displaying problem with certain system plugins)
^ Interface: 'Itemid' and 'option' removed from direct passing to JRoute::_(), 'com_joomgallery
  replaced by _JOOM_OPTION, added setting/resetting of router variables in displayDesc()
- Redundant TODOs regarding sub-menus in backend removed

20110210
+ New functions JHTML::_('joomgallery.minithumbimg',..) and JHTML::_('joomgallery.minithumbcat',..)
  introduced to display minithumbs in Userpanel views

20110207
+ Added fields 'access' and 'published' to the SQL query in JoomAmbit::getCategoryStructure()
^ JHTML_JoomGallery::categoryTree() now uses category structure from JoomAmbit

20110201
# For certain configuration settings the original image could not be opened out of category view.

20110129
# Crop images first and insert watermark afterwards to avoid cropping the watermark
+ Additional individual fields for categories and images,
  may be set up by inserting data into the corresponding XML files

20110126
+ New backend toplist configuration option for showing/hiding a download, favourite
  and report icon. These options are currently also effective in the search view.
+ Triggering 'onJoomDisplayIcons' in toplist views and search view
^ Prevent to search with empty search patterns, because this will return all pictures
  of the gallery.

20110125
^ inline CSS for option list in category view moved to joomgallery.css, div in form removed

20110124
# Migration script for migration from PonyGallery ML removed

20110123
^ Show in Joomla!SEF 'alias-not-found-'id, if alias of image or category not existent
# In backend it was not possible to select a
  category thumbnail for unpublished categories

20110122
# Wrong call for getting parameter for 'show_footer_separator' (set()
  instead of get()) in the 'list_footer.php' of the favourite view
- Removed unnecessary resp double code to show a footer separator in
  favourites templates
^ Added favourite, search and toplist view to the views that show a footer
  separator
+ Output of a message in the search and toplist view, if there are no images
  matching the search pattern or no images were found to fill the toplist
^ Refactoring in merging code with mostly same functionality, avoid needless DB calls
# URL in BBCode longer than 40 chars are wrapped and so invalid
# When creating a new category in userpanel and activated 'Allow users to
  change the acces level' in configuration the user can choose between all available
  access levels

20110121
# Reading the version number of JoomGallery out of the XML file if
  JoomGalley isn't found in the RSS file for the updates
+ Some variable comments added
+ Small description for the FTP upload added
+ Extended description for thumbnail alignment in configuration manager

20110120
# User panel pagination: reset and initialize 'limitstart' to '0'
+ User panel images: added new column 'Published', new filter options
  'published' and 'not published added'
+ User panel categories: added new column 'Published', new filter options
  'published' and 'not published' added, pagination added

20110118
# Using the arrow keys in opened shadowbox (per plugin) closes them
^ FE toplist, favourites, search model and view: method to get number of comments
  removed and integrated into existing database queries
+ Added trigger for 'onJoomAfterDisplayThumb' in search view default template

20110117
^ helpers/html/joomgallery, pagination() german variable names changed to english

===============================================================================
                                     1.5.6.3
                                    (20110116)
===============================================================================

20110116
# Some index.html files were missing

20110115
# Fixed PHP notice when using the IPTC data in detail view

20110114
# It was not possible to rename categories in frontend if the catpath doesn't
  change (for example it was only changed upper and lower case
* Security Fix
# FE toplist view, favourites view, search view: missing comment count in comment
  count output in case of 1 comment
# FE toplist view, favourites view: wrong event ('onAfterDisplayJoomThumb'
  instead of 'onJoomAfterDisplayThumb') triggered, additionally event output
  was not displayed

20110112
# Wrong call for getting parameter for 'show_footer_separator' (set() instead
  of get()) in the 'default_footer.php' files of several front end views
^ Use of JHTML::_('select.radiolist', ..) for displaying of voting area with
  radio buttons in detail view

20110110
^ JoomConfig::_saveCSS() renamed to JoomConfig::saveCSS(), now public
# Calling JoomConfig::saveCSS() in 'install.joomgallery.php' instead of
  JoomConfig::save() to prevent deleting of all EXIF and IPTC Tag settings
  when upgrading the gallery
+ Prevent installing JoomGallery 1.5 in Joomla 1.6
* Security Fixes

===============================================================================
                                     1.5.6.2
                                    (20110105)
===============================================================================

20110105
* Security Fix

20110102
+ Save configuration settings when upgrading to new JoomGallery version
  in order to update dynamic CSS settings (needed for changed rating bar CSS)

20101221
# Prevent that bots trigger votes when using star rating bar
^ Show vote result message without javascript window
+ Added hint for users with deactivated JavaScript that voting is
  not possible when using star rating bar, therefore new language
  constant 'JGS_DETAIL_RATING_NO_SCRIPT' defined
^ Change of language constant 'JGA_CONFIG_UR_RT_DISPLAY_TYPE_LONG' to
  inform admins that voting with star rating bar needs JavaScript to
  be enabled on client side

20101217
# Error '500' because of wrong view instead of error message of the gallery
  while trying to save a new category in frontend although the user's limit is
  already reached
^ After deletion of a category in frontend the user is now redirected to the
  list of categories rather than the list of images.

20101214
# Notice about undefined variable '$abort' when doing a fresh JoomGallery
  installation

20101212
# Wrong resp. undefined language constant used for pathway and breadcrumbs in
  front end view 'editcategory'

20101208
# Hide vote view for menu item selection

===============================================================================
                                     1.5.6.1
                                    (20101205)
===============================================================================

20101201
# Configuration option 'jg_showgallerysubhead' (displaying pathway in
  gallery view) hasn't been used (most probably since version 1.5.5)

20101130
^ Stay in user panel instead of redirecting into user categories list after
  deleting a picture in the user panel.

20101126
+ Prevent that crawlers trigger votes.
# Selecting nametags with option 'Possiblilty of tagging other users?' enabled
  did not work in IE 7/8

20101122
^ Performance optimization, substitution of array_push() in JoomHelper
  class functions sortCategoryList() and sortCategoryListRecurse() with
  'array[] = ...', saves nearly 60% processing time

20101120
# After routing in interface 'Itemid' got the value of 'option'
# In category manager, it was not possible to filter or seach sub-categories

20101118
# Replaced '&amp;' with '&' in javascript URL 'location.href' set when stopping
  the slideshow in detail view, which caused wrong setting of Joomla! breadcrumbs
  and missing Itemid.

20101118
# Chosen category thumbnails weren't displayed if dynamic cropping was enabled

20101117
^ Performance optimization, substitution of 'in_array()' in JoomHelper
  class functions getAllSubCategories(), getTotalHits() and getNumberOfLinks()

20101109
# report button in category view doesn't work with deactivated option for detail view

===============================================================================
                                     1.5.6
                                   (20101106)
===============================================================================

20101104
# Fixed incompatibility of AJAX voting (text based version with radio buttons)
  with mootools 1.2.4

20101101
# Fixed javascript error in JoomHelper::fixForJS() when opening DHTML-Container
  in category view with activated option to show image description and
  descriptions including double quotation marks
# Fixed bug in maintenance manager, batch job 'Delete orphaned folders' in tab
  'Orphaned Folders' did not work
^ new JAVA-Applet 5.0.0 Stable
  http://jupload.sourceforge.net/RELEASE-NOTES.txt
  minor changes in frontend upload to send a correct HTTP 200 in case of HEAD
+ new options to choose which upload methods should be avaliable in frontend

20101023
^ Accordion: closing all sliders now possible

20101018
# Fixed bug at the backlink of category view
# Fixed bug in userpanel, ordering used 'imgtext' instead of 'imgtitle'.
+ Report files/button
+ Replace image files when editing image in Image Manager
^ new refresher function in e.g maintenance manager or ftp upload

20101015
^ Another significant performance optimization in sortCategoryList()

20101013
# Interface: Router problems for variables 'option' and 'Itemid' if not existent

20101012
# Fixed bug at fixing catpaths in joomgallerycategories.php

20101011
+ optional graphical display of ratings and entering the vote by graphical
  rating bar (star rating)
+ optional calculation of the rating according to Bayes (weighted rating)
+ optional AJAX rating

20101004
+ cropping thumbnails in backend upload or dynamically in frontend
  quadratic thumbnails now possible

20101001
# Typing error of 'disable_functions' because of which
  fix 20090502 [#1361] hasn't been active yet.

20100930
# Improved error handling while installing, installation will be aborted
  from now on as soon as an error occurs

20100923
# Fixed check for required versions of PHP and MySQL

20100923
+ Check for required versions of PHP and MySQL afore installing and after updating

20100924
# Error while saving an empty joom_local.css file.
^ IPTC Keywords are now displayed in one row not in several

20100921
# Creating a new category and clicking at button 'Select' shows all thumbs of
  gallery in minijoom
# Unneeded code to construct a list for ordering of all images when trying to edit
  an entry in image manager, so breaks in big galleries with memory problems
# Category manager: editing a category will corrupt a title containing special chars
# 'New' not shown for subcategory in category view

20100917
+ optional hide of number of images in gallery view and category view
# deinstall of components doesn't remove tables __joomgallery_maintenance
  and __joomgallery_orphans

20100915
# Some notices at the batch upload in frontend removed
# Solved 'TODO' at FTP upload in backend

20100914
^ Autoupdate: better compare of versions

20100912
# Voting/Rating: No output of area with texts 'Please login first...' or
  'You can not vote for your own images!'
^ more error information of PCLZip when uploading an invalid archive in batch upload
  now: "PCLZIP_ERR_BAD_FORMAT (-10) : Unable to find End of Central Dir Record signature"
^ Category view: Number of pictures for subcategories now below the subcategory title

20100911
# Prevent, that unregistered users have access to detail view if not configured so
# Textcontainer class in subcategory view was not set in the case that
  'Show Thumbnail' was set to 'No'

20100909
# The author field was not accepted in back end batch upload
# Wrong language constants in debug output of back end batch upload

20100905
# Autoupdate:'Unable to find End of Central Dir Record signature [code -10]'
  and activated curl extension, depends on the curl version
# Detail view: IPTC data not shown even with activated option and with existent data
  in original image

20100903
# Detail view - CSS: Google map doesn't disappear in toggler of accordion with IE7

20100901
# Interface: wrong " in css tag of sectiontableentry1/2, thank you @TeTrix
# usercategories: missing ] in .xml, thank you @TeTrix
# wrong language constant in detail tab of configuration

20100831
^ Maintenance manager setalias: additional trimming / for alias

20100830
^ new JAVA-Applet 5.0 RC4
  http://jupload.sourceforge.net/RELEASE-NOTES.txt

===============================================================================
                                     1.5.5.2
                                Stable (20100829)
===============================================================================

20100829
# Fixed nametags (notice if nametags disabled but tagging other users enabled)
# Fixed creation of aliases

===============================================================================
                                     1.5.5.1
                                Stable (20100827)
===============================================================================

20100827
# Message that updates are available was still displayed even if all extensions
  were updated (solved only for the case that cURL is used for the updates and
  the case that the update of JoomGallery was the last update for having all
  extensions up-to-date).
# Update script updates news feed module in backend also now (new feed URL).
+ Interface is able to display a category with detail images now.
# Wrong settings of slideshow after first installation or update
# Category dropdown box wasn't displayed in MiniJoom popup
# 'height:100%;' removed for JoomGallery logo at the bottom of the backend
# small typing error in the upload helper of the backend
# Default owner of images and categories is now 0 instead of null.
# Typing error in getImage() in detail and image model

20100825
^ Significant performance optimization in sortCategoryList()

===============================================================================
                                     1.5.5
                                Stable (20100822)
===============================================================================

20100822
# Fixed autoupdate
# Fixed auto installation of language files

20100820
# Fixed download link in detail view
+ New parameter for event 'onJoomDisplayIcons' in order to pass the view which triggers the event
# The icons in category view which are returned by event 'onJoomDisplayIcons'
  are dislayed now even if no other icon is displayed there

20100813
+ Slideshow in detail view now starts with actual shown image of detail view and
  when stopped last shown image of slideshow is displayed in detail view
^ no display of text 'desription' in detail view if none existent

20100810
# invalid insertion of br in description of dhtml popup if bbcode conversion is activated

20100805
+ added erftralle to the list of developers in the back end help view

20100804
# opening a picture in slimbox and then clicking on 'prev' results in a skip of one picture

20100803
- Redundant selection 'None' at 'Image processor' in configuration manager removed.
# Original image wasn't copied after using the 'New' button in image manager.

20100728
^ Performance optimizations in JoomAmbit::getCategoryStructure() and JoomHelper
  functions using this category structure.

20100720
# PHP4 compatibility recovered
# Slideshow didn't work with the watermark enabled

20100518
+ If backend language is German German RSS feeds will be loaded
# Download detail image wasn't possible if only the download of detail images is allowed

20100513
# double css id selector for current mini in motiongallery
^ id selector only for current mini in motiongallery
# invalid value for cellspacing and cellpadding in table of commentsarea

20100512
# Bugfix in JHTMLJoomGallery::categoryTree, sometimes not all categories were shown.
  Therefore a new function sortCategoryList in JoomHelper created.

20100427
# wrong count of total images in slimbox and thickbox

===============================================================================
                                    1.5.5 (MVC) Branch
                                     BETA2 (20100425)
===============================================================================

20100429
^ onJoomDisplayName gets information about the context where it is called now

20100425
# Some improvements at the language constants of the upload.
# Fixed bug at the tooltips in user panel
# removed redundant quotes
+ additional parameter for the routing in the ambit
# fixed bug in the pagination of the maintenance manager
+ possibility of deleting categories completely (with images and sub-categories)
  added in category and maintenance manager

20100419
^ new JAVA-Applet 5.0.0 RC3

20100418
# user category created from plugin JoomAutoCat not reachable in userpanel
# current mini in motiongallery not marked with e.g. a border via CSS
! still exists in motiongallery: refresh of detail view results in aligning first to the left
  before scrolling to the current mini

20100416
+ java upload, EXIF information not deleted during upload
# chmod permissions in upload per string paramter

20100324
^ thumbs in category view with defined height and width in img tag, improves browser performance

2010409
- hard-coded integration of EasyCaptcha removed
! no third party extension is integrated hard-coded anymore now
+ new plugin events: 'onJoomGetCaptcha' and 'onJoomCheckCaptcha'

20100321
^ renamed frontend language constants

20100310
+ more features for MiniJoom

20100309
+ added possibility of disabling the anchors in the gallery.
+ added possibility of disabling the tooltips in the gallery.

20100303
^ new JAVA-Applet 5.0.0 RC2

20100302
^ renamed backend language constants

20100208
+ added GeoTagging with the help of Google Maps API in detail view.

20100201
+ new plugin event: 'onJoomGetLastComments', plugins are able to influence the toplist now.

20100130
^ new JAVA-Applet 5.0.0 RC1

20100127
+ new plugin event: 'onJoomOpenImage'.

20100115
+ maintenance manager extended, it is now possible to check the file system of JoomGallery for inconsistencies
+ added the possibility of defining one's own module positions in the gallery per template override

20100112
^ first draft for new 'getCategoryStructure' in the ambit.

20100111
# in frontend it was possible to upload more images than permitted.

20200105
+ new plugin events: 'onAfterJoomAddFavourite', 'onAfterJoomRemoveFavourite' and 'onAfterJoomClearFavourites'.
+ improvements in the update script
+ additional check whether the appropriate image is still available while synchronizing comments, ratings and name tags.
+ added the possibility of displaying the upload date in the interface.

20091229
! proceeding from now in chronological order
# double adding of js function for starting slideshow

===============================================================================
                                    1.5.5 (MVC) Branch
                                      BETA (20091228)
===============================================================================

===============================================================================
                                    1.5.5 (MVC) Branch
                                ALPHA (last version: 20091223)
===============================================================================
Modifications in JoomGallery 1.5.5 (MVC)
- completely rewritten in MVC syntax
- update possible (from JoomGallery 1.0 and more actual) with normal install of the actual component zip,
  update component no more needed
- better use of language constants (with parameters)
- improved ordering in category edit
- improved choosing of category thumb ('own choice')
- new slideshow (Smoothgallery, based on mootools)
- CSS modifications for detail view
- improved nametags (based on mootools)
- router.php added
- messenger tab in backend
- maintenance manager (including now votes and nametags manager)
- batch and java upload possible in frontend
- java applet moved to frontend
- more events added
- new layout in 'picture edit' and 'category edit'
- new DB columns #__joomgallery und #__joomgallery_catg (each 'alias', 'params', 'metakey', 'metadesc')
- image folders now outside of the 'component' folder
- accordion javascript moved from separate file to internal code for in future parametering

===============================================================================
                         Branch to JoomGallery 1.5.5 MVC
===============================================================================
20091105
# slimbox does not work in IE8 with template 'Namibia'
  http://www.joomlaportal.de/joomla-erweiterungen-komponenten/206977-joomlagallery-fehler-im-ie-mit-slimbox.html

===============================================================================
                                   1.5.0.4
                                  20091108
===============================================================================

20091102
^ new JAVA-Applet 4.5.0

20091030
# wrong message of recreated detail picture if original does not exist
  http://www.joomgallery.net/forum/index.php?topic=2333, @erftralle: Danke
# deactivation of all EXIF/IPTC options not possible
^ javascript for check of modified options in configuration manager simplified

20091008
# non working pagination in userpanel
  http://www.joomgallery.net/forum/index.php/topic,2289, @erftralle: Danke

20090823
+ New plugin events: 'onAfterJoomComment', 'onAfterJoomVote',
                     'onBeforeJoomUpload', 'onAfterJoomUpload'

20090821
^ chmod without activated ftp layer. Some servers set the rights for detail and thumbs
  wrong to 0600...

20090806
# Updatescript: The cache file of the update checker should now be deleted when updating
^ Updatescript: No success in altering of jg_category and jg_usercategory to type text
                doesn't lead to error but prints out error message of DB
                changed var_dump($database) to echo $database->getErrorMsg();

20090805
# wrong display in default and category view with user defined category alignments
  DE: http://www.joomgallery.net/forum/index.php/topic,1742

# Joom_cuttingString cuts html code and so destroys the view
  temp. deactivated to find a better solution

===============================================================================
                                   1.5.0.3
                                   20090726
===============================================================================

20090725
^ Joom_cuttingString for image description in category view, fixed on 30 chars
  http://www.joomgallery.net/forum/index.php/topic,997.0.html

20090629
^ new JAVA-Applet 4.4.0
  from RELEASE-NOTES.txt:
  [Major] Prevents the applet to freeze, when a message is displayed to the user during upload.
  [Major] formData would not work on IE7

20090627
# avoid not necessary chmod() with activated ftp-layer if the permissions already ok
# wrong operator for favourites

20090621
# redundant definitions in CSS removed
# some Chmods() added, no more interpretation of return code for this and rollback

20090620
^ Joom_Chmod() now returns always true

20090616
# DHTL-Window don't work with apostrophes in image description
  http://www.forum.en.joomgallery.net/index.php?topic=1396.0

===============================================================================
                                   1.5.0.2
                                   20090614
===============================================================================
20090612
# Voting: faking results by sending false radio-values
  http://joomlacode.org/gf/project/joomgallery/tracker/?action=TrackerItemEdit&tracker_id=4518&tracker_item_id=16777

20090611
# no Joomfish translation of category title displayed in category view and pathway
  http://www.joomgallery.net/forum/index.php/topic,1681
  Danke @hermann
^ new display of subcategories in gallery view with dTree, made by Erftralle. Thanks!
# wrong calculation of catstartpage
  http://www.joomgallery.net/forum/index.php/topic,1747.0.html
  Thanks @hermann
^ new version of JAVA Applet: 4.3.3rc2 Rev 775

20090610
+ Thumbnail and detail image recreation in picture manager

20090608
# some fixes with wrong permissions

20090605
# no search for words including special characters

===============================================================================
                                    1.5.0.1
                                   20090527
===============================================================================

20090526
+ added turkish and bosnian language
^ JAVA Upload, Upload with IE not possible, applet branch version
+ Pagination for subcategories can be now viewed in top and bottom

20090524
+ edit of category owner in backend
  http://www.forum.en.joomgallery.net/index.php?topic=803
  thank you @szopen

20090522
^ JAVA Upload: set picture quality to 1 to override the applet default of 0.8
  when uploading the original picture

20090521
^ new version of JAVA Applet: 4.3.2 Rev 735

20090519
# wrong call of Joom_ResizeImage
  http://www.forum.en.joomgallery.net/index.php?topic=1291

20090518
#^ wrong xml tag for install.sql without utf, added to uninstall xml section

20090512
+ display module title in position 'jg_detailbtm' if configured in module params
- dated $_REQUEST['is_editor'] check removed
^ on success the interface method 'createCategory' will return the ID of the
  created category from now on

20090510
^ cursor right/left in opened slimbox results in a refreshed site with desired picture
  in detail view and closed slimbox view
  http://www.joomgallery.net/forum/index.php/topic,1610

20090507
^ wrong parameter in JFile::copy (batch upload) Danke Mambolus
  http://www.joomgallery.net/forum/index.php/topic,1588

20090505
# category choice in picture manager still effective even when the category was
  deleted before -> set session variable to 0 when category deleted
  http://www.joomgallery.net/forum/index.php/topic,1581
# Use of Joom_Chmod instead of JPath::setPermissions
  because of problems on servers with wwwrun-problem

===============================================================================
                                    1.5.0
                                  20090503
===============================================================================

20090502
# [Forum: http://www.forum.en.joomgallery.net/index.php?topic=1057.0]
  Do not call exec if it is disabled
^ new Codestyle for all frontend files

20090501
^ new version of JAVA Applet: 4.3.1 Rev 727

20090428
^ new version of JAVA Applet: 4.3.0 Rev 713
# it was possible to view unpublished categories
# detail view: redirect if incorrect image id

20090427
+ display subcategories in gallery view
+ new languages (italian, lithuanian)

20090422
+ column 'id' in picture manager
^ free setting of columns in all views

20090421
^ UNIX-LF for all frontend files
^ detail view compressed (Part 1)
# clearboth
^ arrow.png from famfamfam
# CSS class .pngfile deleted from joom_settings.css
  because it already exists in joom.javascript.php (but moved upwards in this file)

20090420
# wrong thumbnail quality setting from configuration in creating detail pictures,
  affects all upload methods, thank you to erftralle
  http://www.joomgallery.net/forum/index.php/topic,1535

20090419
# access to userpanel for registered user via known link if only admin access
  allowed
# showing penultimating picture in slimbox offers not a 'next' link to last picture
# batch upload: uppercased extensions ignored

20090418
^ JoomFish: no translation in detail view
  http://www.forum.en.joomgallery.net/index.php?topic=852.msg3151#msg3151

20090414
+ new languages (persian, polish, finnish)
^ UNIX-LF for all admin files

20090412
# changes regarding xhtml validity
^ new version of JAVA Applet: 4.2.1c Rev 671
^ revised upload functions in backend and frontend:
    new checkbox 'debug' in backend, output of debug always when an error occurs
    new rollback function in case of error, deletion of already created files
    calculation of needed memory before resizing operations
    batch upload: working with zipped (sub)folders is now possible,
                  extracting only relevant files
+ LF: new constants according to upload

20090408
# png fix (pngbehavior.htc) did not work with all search engine-friendly urls
  CSS class .pngfile moved to joom_settings.css
  change in pngbehavior.htc to get an absolute path to the blank.gif
# [Forum: http://www.joomgallery.net/forum/index.php/topic,1497.0.html]
  CSS floats were not cleared
# 9px*9px for arrow.png instead of 16px*16px

20090406
# Link "Back to Category Overview" if the user is in a sub-category

20090404
+ some plugin events added
# [Forum: http://www.forum.en.joomgallery.net/index.php?topic=1064]
  users could create more categories than set in the configuration

20090402
+ new method in interface for creating categories

20090317
^ new version of JAVA Applet: 4.2.1c Rev 658
^ JAVA Upload: check the php.ini setting 'session.cookie_httponly'
  if set and = 1 then build the parameter 'readCookieFrom Navigator=false'
  in Applet (new since V 4.2.1c) and provide the cookie with
  sessionname=token in parameter 'specificHeaders'
# blank category name when Frontend settings->User Panel->Show Mini Thumbs->No
  in showusercats, thanks to 'erftralle'
  http://www.forum.en.joomgallery.net/index.php?topic=973

20090314
+ Cache time for update checker
+ optionally load modules only in certain views
^ Smileys are returned by the function Joom_GetSmileys() now

20090312
# Received http status 400 bad request' error
  http://sourceforge.net/forum/message.php?msg_id=6728044

20090307
^ only one CSS file for all views

20090306
# wrong path to 'loadAnimation.gif' from Thickbox3 with activated SEF
  http://www.forum.en.joomgallery.net/index.php?topic=928
^ Class Joom_DetailView added

20090303
# unnecessary copy procedure removed
  which caused an error on servers with wwwrun-problem
# workaround for servers with wwwrun-problem
  make temp path writeable if it is not

20090301
^ function displayThumb() in Interface modified to consider parameter 'piclink'
  in creating links to category or detail view, needed for JoomImages
  including of modules.class.php should be now deprecated with the module 1.5.1

20090228
^ new version of JAVA Applet: 4.2.0 Rev 642

20090227
+ possibility of auto update with cURL added
^ issue in motiongallery.js in combination with other JS which make a premature
  call of onresize()

20090226
- Output of version in frontend removed
# [Forum: http://www.forum.en.joomgallery.net/index.php?topic=863]
  Output of asterisk comments in java upload page fixed

20090225
# Workaround in Joom_Ambit class for PHP4

20090224
^ Migration manager is now ready for different migration scripts
# On servers with wwwrun problem images could not be deleted
- Some unnecessasy wrapper functions removed

===============================================================================
                                     RC2
                                  20090222
===============================================================================

20090222
! Bridge: deprecated As of version 1.5 RC2

20090221
^ new version of JAVA Applet: 4.1.0 Rev 526
# 'new' image in category view not visible with activated SEF
# accordion not working with activated SEF

20090218
# users could rate their own images
# several fixes with numbering the files and titles in FTP and Batchupload

20090217
* Comments settings checked after form submission

20090215
# settings for the limit and the search text in category manager were also
  used in picture manager and vice versa
+ some module positions added
+ delete copy of the feed module on position 'joom_cpanel' when joomgallery
  gets uninstalled
+ update checker displays a notice on more pages now
+ 'Your system is up-to-date.' is displayed in admin menu
# bugs in reordering pictures in the picture manager


20090214
# Slideshow does not work with Opera and Safari with activated transition effects
  in JoomGallery backend.
# Comments-IP has been visible for reg. Users, Link to whois didn't work,
  reg. Users were able to delete every comment
# Slimbox: opening the last picture in slimbox and click on 'previous' shows
  the same picture again: http://www.joomgallery.net/forum/index.php/topic,1190

20090213
# Moving (detail)pictures failed
# Deleting comments in frontend

20090212
# Deleting categories in frontend

20090211
# Settings for anonymous comments not saveable

===============================================================================
                                     RC
                                  20090208
===============================================================================
20090208
# "Last Commented" view

20090207
+ Functions returning comments in interface
# getPictureLink in interface


20090204
# Bug in countstop function because of a database column with primary key

20090203
# increasing the hit counter of the neighboured pictures even when not clicked
  preloading of this pictures in Slimbox deactivated
# no increasing of the hit counter when originals are shown in Slim/Thickbox

20090202
^ image counter increase now in one query

20090130
+ optional category filtering in Interface
^ do not read RSS file if update check is disabled

20090128
+ Option for update check in the configuration manager
# make category titles in tooltips JS safe

20090127
^ new face for admin menu (CPanel)
+ automatic update check for all JoomGallery extensions and JoomGallery itself

20090120
+ Possibility to assign owner of picture in new picture form (Backend)
+ Possibility to change owner of picture in picture edit form (Backend)

20090119
# Workaround for servers with wwwrun problem
- 'tn_' backwards compatibility removed

20090117
^ Configuration manager revised, new functions introduced to improve clarity

20090111
# Migration creates wrong catpaths if iteration depth > 2,
  instead test1_1/test2_2/test3_3 it generates test1_1test2_2/test3_3

20090109
- Lighbox
+ Files for Editorbutton
^ All javascript codes are added to the head now
# wrong catpath for thumbnails of parent categories was used
  in joom.viewcategory.html.php
# wrong default value for id in #__joomgallery_config
# Cooliris does not show all pictures on paginated categories
^ new JAVA applet version V 4.0.0
# Thickbox 3, keys for next and previous interchanged
^ little hack to show a category thumb in gallery view without showing them in
  category view, only working with 'own choice' and approved/not published

20090103
# if clicking on cpanel in configuration manager the function joom_testDefaultValues()
  is invoked without a need, reactivated function submitbutton

20090101
# Slimbox: dynamically ignore of doublets
# Thickbox3: dynamically ignore of doublets
# accordion.js gives a javascript error with function 'load' -> 'domready'

20081230
^ Configuration is saved in the database now
  -> new table #__joomgallery_config
^ number of globals reduced
  -> usage of contants like JPATH_ROOT, JPATH_COMPONENT, _JOOM_LIVE_SITE

20081229
+ Navigation in User panel

20081228
^ loading of mootools.js with the help of JHTML
  in order to prevent an unnecessary integration
^ JFile, JFolder, JPath

20081227
^ ini language files for exif and iptc data introduced and old language files removed
+ install.sql and uninstall.sql introduced
^ unnecessary hidden fields removed/replaced by url parameters

20081225
# send2friend: no value in hidden input field 'Itemid'
# cooliris: with no original pictures the thumb and a failure symbol will be
  shown in cooliris -> show the detail picture

20081224
# Batch Upload: when the zip upload fails, the temp folder defined in
  configuration manager will be deleted. At second failed try the Joomla! folder
  'media' will be moved

20081223
^ ini language files introduced and old language files removed
^ small performance upgrades in Joom_GetCatPath() and Joom_PagingCategory()
# User panel: the full path of the categories not shown in upload and creation
  of user categories
  http://www.joomgallery.net/forum/index.php/topic,914

20081222
+ Additional parameter in getPageHeader() of interface class
  (workaround for $mainframe->addCustomHeadTag)
^ all 'create table' changed from TYPE=MyISAM to ENGINE=MyISAM,
  TYPE deprecated and removed since mySQL Version 5.1

20081221
# [14080] http://joomlacode.org/gf/project/joomgallery/tracker/?action=TrackerItemEdit&tracker_item_id=14080
  1) with activated page navigation in category view the user sorting does not work
     in subpages > 1
  2) with activated page navigation a change in user sorting on a subpage > 1 opens
     subpage 1, not the actual
# Slimbox does not work in detail view if backend setting
  'Frontend settings->Downsize pictures by Javascript:' set to 'No'

20081220
# Interface in Joomla 1.5 fixed
# URL in link to user profiles

20081212
# cb/cbe linking in module (modules.class.php) deactivated until the
       functions from JG V 1.0 are fully migrated and working
# comments with linebreaks (\r\n or \n) are shown in detail view with 'rn'
       changed before saving in db with nl2br and striptags
# Notice in JAVA upload: undefined $bugtest
# several fixes and changes to let the module joomimages work

20081210
# [Forum: http://www.forum.en.joomgallery.net/index.php?topic=487]
  the function updateOrder() was not yet replaced by the J! 1.5 function reorder()
