// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/components/com_joomgallery/assets/js/mini.js $
// $Id: mini.js 3336 2011-09-25 17:11:28Z chraneco $
/****************************************************************************************\
**   JoomGallery  1.5.6                                                                 **
**   By: JoomGallery::ProjectTeam                                                       **
**   Copyright (C) 2008 - 2009  M. Andreas Boettcher                                    **
**   Based on: JoomGallery 1.0.0 by JoomGallery::ProjectTeam                            **
**   Released under GNU GPL Public License                                              **
**   License: http://www.gnu.org/copyleft/gpl.html or have a look                       **
**   at administrator/components/com_joomgallery/LICENSE.TXT                            **
\****************************************************************************************/

/**
 * Inserts an image into the current editor window
 *
 * @param   int     id      The ID of the image to insert
 * @param   string  editor  The ID of the text area into which the image will be inserted
 * @return  void
 */
function insertJoomPluWithId(id, editor)
{
  thumb       = document.getElementById('jg_bu_typethumb').checked;
  img         = document.getElementById('jg_bu_typeimg').checked;
  orig        = document.getElementById('jg_bu_typeorig').checked;
  dtl_link    = document.getElementById('jg_bu_linked1').checked;
  cat_link    = document.getElementById('jg_bu_linked2').checked;
  linked_img  = document.getElementById('jg_bu_linked_typeimg').checked;
  linked_orig = document.getElementById('jg_bu_linked_typeorig').checked;
  position    = document.getElementById('jg_bu_position').value;
  opt_class   = document.getElementById('jg_bu_class').value;
  text        = document.getElementById('jg_bu_text').value;
  alttext     = document.getElementById('jg_bu_alttext').value;

  options = new Array();

  if(img)
  {
    type = 'img';
    options.push('type=orig');
  }
  else
  {
    if(orig)
    {
      type = 'orig';
    }
    else
    {
      type = 'thumb';
      if(linked_orig)
      {
        options.push('type=orig');
      }
      else
      {
        options.push('type=img');
      }
    }
  }

  container = false;
  align = '';
  if(position == 'right')
  {
    align = ' style="float:right;"';
  }
  else
  {
    if(position == 'left')
    {
      align = ' style="float:left;"';
    }
    else
    {
      if(position == 'center')
      {
        container = true;
      }
      else
      {
        align = '';
      }
    }
  }

  if(alttext)
  {
    alt = alttext;
  }
  else
  {
    alt = 'joomplu:' + id;
  }

  var opt_class_a = '';
  if(opt_class)
  {
    opt_class_a = ' class="' + opt_class + '"';
    opt_class = ' ' + opt_class;
  }
  else
  {
    opt_class = '';
  }

  tag = '';

  if(container)
  {
    tag = tag + '<div style="text-align:center;">';
  }

  if(cat_link)
  {
    options.push('catlink=1');
    dtl_link = true;
  }

  options_string = '';
  if(options.length)
  {
    options_string = ' ' + options.join('|');
  }

  if(dtl_link)
  {
    tag = tag + '<a href="joomplu:' + id + options_string + '"' + opt_class_a + '">';
  }

  if(text)
  {
    tag = tag + text;
  }
  else
  {
    tag  = tag + '<img src="index.php?option=com_joomgallery&view=image&format=raw&id=' + id + '&type=' + type + '" class="jg_photo' + opt_class + '" alt="' + alt + '"' + align + ' />';
  }

  if(dtl_link)
  {
    tag = tag + '</a>';
  }

  if(container)
  {
    tag = tag + '</div>';
  }

  window.parent.jInsertEditorText(tag, editor);
  window.parent.document.getElementById('sbox-window').close();
}

/**
 * Inserts a category into the current editor window
 *
 * @param   int     id      The ID of the category to insert
 * @param   string  editor  The ID of the text area into which the category will be inserted
 * @return  void
 */
function insertCategory(id, editor)
{
  textlink  = document.getElementById('jg_bu_category1').checked;

  if(textlink)
  {
    linkedtext = document.getElementById('jg_bu_category_linkedtext').value;
    if(!linkedtext)
    {
      alert(JText._('JGS_MINI_PLEASE_ENTER_TEXT'));
      document.getElementById('category_catid').selectedIndex = 0;
      return false;
    }

    tag = '<a href="joomplulink:' + id + ' view=category">' + linkedtext + '</a>';
  }
  else
  {
    number    = document.getElementById('jg_bu_thumbnail_number').value;
    columns   = document.getElementById('jg_bu_thumbnail_columns').value;
    ordering  = document.getElementById('jg_bu_thumbnail_ordering').value;

    tag = '{joomplucat:' + id;

    options = new Array();

    if(number)
    {
      options.push('limit=' + number);
    }

    if(columns && columns != 2)
    {
      options.push('columns=' + columns);
    }

    if(ordering != 0)
    {
      options.push('ordering=random')
    }

    if(options.length)
    {
      tag = tag + ' ' + options.join('|');
    }

    tag = tag + '}';
  }

  window.parent.jInsertEditorText(tag, editor);
  window.parent.document.getElementById('sbox-window').close();
}

/**
 * Does an Ajax request for the previous page
 *
 * @param   string  url The URL sending the request to
 * @return  void
 */
function ajaxRequestPrevPage(url)
{
  ajaxRequest(url, jg_minis_page - 1);
}

/**
 * Does an Ajax request for the next page
 *
 * @param   string  url The URL sending the request to
 * @return  void
 */
function ajaxRequestNextPage(url)
{
  ajaxRequest(url, jg_minis_page + 1);
}

/**
 * Does an Ajax request for a specific page
 *
 * @param   string  url   The URL sending the request to
 * @param   int     page  The page to request
 * @return  void
 */
function ajaxRequest(url, page, query)
{
  // Empty the container
  $('jg_bu_minis').empty();

  // Show spinner
  $('jg_bu_minis').addClass('jg_spinner');

  if(query != null)
  {
    query = '&' + query;
  }
  else
  {
    query = '';
  }

  // Do the Ajax request
  new Ajax( url,
            {
              method: 'post',
              data: 'page=' + page + query,
              onComplete: function(response)
              {
                // Evaluate response
                response = Json.evaluate(response);

                // Remove spinner and old pagination
                $('jg_bu_minis').removeClass('jg_spinner');
                $('jg_bu_pagelinks').empty();

                // Set slider height style to auto to force dynamic slider height adaption with mootools 1.11
                if($$('#joomgallery-images-sliders div.jpane-slider').length > 1)
                {
                  $$('#joomgallery-images-sliders div.jpane-slider')[1].setStyle('height', 'auto');
                }
                else
                {
                  $$('#joomgallery-images-sliders div.jpane-slider')[0].setStyle('height', 'auto');
                }

                // Insert response
                $('jg_bu_minis').setHTML(response.minis);
                $('jg_bu_pagelinks').setHTML(response.pagination);

                // Now we have to create the tooltips for all the new images
                var JTooltips = new Tips($$('.hasMiniTip'), { maxTitleChars: 50, fixed: false});

                // Set current page if it was changed
                if(page > 0)
                {
                  jg_minis_page = page;
                }
              }
            }).request();
}