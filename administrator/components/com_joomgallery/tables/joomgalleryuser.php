<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/administrator/components/com_joomgallery/tables/joomgalleryuser.php $
// $Id: joomgalleryuser.php 3092 2011-05-20 09:56:58Z aha $
/****************************************************************************************\
**   JoomGallery  1.5.7                                                                 **
**   By: JoomGallery::ProjectTeam                                                       **
**   Copyright (C) 2008 - 2011  JoomGallery::ProjectTeam                                **
**   Based on: JoomGallery 1.0.0 by JoomGallery::ProjectTeam                            **
**   Released under GNU GPL Public License                                              **
**   License: http://www.gnu.org/copyleft/gpl.html or have a look                       **
**   at administrator/components/com_joomgallery/LICENSE.TXT                            **
\****************************************************************************************/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

/**
 * JoomGallery user table class
 *
 * @package JoomGallery
 * @since   1.5.5
 */
class TableJoomgalleryUser extends JTable 
{
  /** @var int Primary key */
  var $uid      = null;
  /** @var int */
  var $uuserid  = null;
  /** @var string */
  var $piclist  = null;
  /** @var int */
  var $layout   = null;
  /** @var string */
  var $time     = null;
  /** @var string */
  var $zipname  = null;

  function TableJoomgalleryUser(&$db)
  {
    parent::__construct(_JOOM_TABLE_USER, 'id', $db);
  }
}