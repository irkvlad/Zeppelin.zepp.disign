<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/components/com_joomgallery/views/mini/view.html.php $
// $Id: view.html.php 2793 2011-02-23 00:49:09Z chraneco $
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
 * Raw View class for the Ajax Mini Joom view
 *
 * @package JoomGallery
 * @since   1.5.5
 */
class JoomGalleryViewMini extends JoomGalleryView
{
  /**
   * Raw view display method
   *
   * @access  public
   * @return  void
   * @since   1.5.5
   */
  function display()
  {
    if(!function_exists('json_encode'))
    {
      echo '{"minis":"You need PHP 5.2 or higher","pagination":""}';

      return;
    }

    $e_name = JRequest::getCmd('e_name', 'text');

    $catid = $this->_mainframe->getUserStateFromRequest('joom.mini.catid', 'catid', 0, 'int');
    $this->assignRef('catid', $catid);

    // Pagination
    $total    = &$this->get('TotalImages');

    // Calculation of the number of total pages
    $limit    = $this->_mainframe->getUserStateFromRequest('joom.mini.limit', 'limit', 30, 'int');
    if(!$limit)
    {
      $totalpages = 1;
    }
    else
    {
      $totalpages = floor($total / $limit);
      $offcut     = $total % $limit;
      if($offcut > 0)
      {
        $totalpages++;
      }
    }

    $total = number_format($total, 0, ',', '.');

    // Get the current page
    $page = JRequest::getInt('page', 0);
    if($page > $totalpages)
    {
      $page = $totalpages;
    }
    if($page < 1)
    {
      $page = 1;
    }

    // Limitstart
    $limitstart = ($page - 1) * $limit;
    JRequest::setVar('limitstart', $limitstart);

    if($total <= $limit)
    {
      $limitstart = 0;
      JRequest::setVar('limitstart', $limitstart);
    }

    JRequest::setVar('limit', $limit);
    $images = &$this->get('Images');

    foreach($images as $key => $image)
    {
      $image->thumb_src = null;
      $thumb = $this->_ambit->getImg('thumb_path', $image);
      if($image->imgthumbname && is_file($thumb))
      {
        $imginfo              = getimagesize($thumb);
        $image->thumb_src     = $this->_ambit->getImg('thumb_url', $image);
        $image->thumb_width   = $imginfo[0];
        $image->thumb_height  = $imginfo[1];
        $this->image          = $image;
        $overlib              = $this->loadTemplate('overlib');
        $image->overlib       = str_replace(array("\r\n", "\r", "\n"), '', htmlspecialchars($overlib, ENT_QUOTES, 'UTF-8'));
      }

      $images[$key]           = $image;
    }

    $this->assignRef('images',      $images);
    $this->assignRef('total',       $total);
    $this->assignRef('totalpages',  $totalpages);
    $this->assignRef('page',        $page);
    $this->assignRef('e_name',      $e_name);

    $output = array();
    $output['minis']      = $this->loadTemplate('minis');
    $output['pagination'] = $this->loadTemplate('pagination');

    echo json_encode($output);
  }
}