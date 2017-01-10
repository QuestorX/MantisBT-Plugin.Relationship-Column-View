<?php
// Load RelationshipColumnView configuration
require_once (RELATIONSHIPCOLUMNVIEW_CORE_URI . 'constant_api.php');
   
/*
 * @param $Color  the hexadecimal color value as string w/o '#' 
 * @param $Value  the value to light or dark the rgb color value
 */
function ChangeColorBrightness ($Color, $Value)
{
   $Result = '';
   
   $Color = str_replace ('#', '', $Color);
   if (strlen ($Color) == 3)
   {  // Color is a three digit value
      $Color   =  str_repeat (substr ($Color, 0, 1), 2);
      $Color   .= str_repeat (substr ($Color, 1, 1), 2);
      $Color   .= str_repeat (substr ($Color, 2, 1), 2);
   }
   
   if ($Value > 255)
      $Value = 255;
   else if ($Value < -255)
      $Value = -255;

   $ColorRGB = str_split ($Color, 2);

   foreach ($ColorRGB as $Segment) {
      $Segment = hexdec ($Segment) + $Value;
      if ($Segment > 255)
         $Segment = 255;
      else if ($Segment < 0)
         $Segment = 0;
      $Result .= str_pad (dechex ($Segment), 2, '0', STR_PAD_LEFT);
   }
   return '#' . $Result;
}

/*
 *
 */
function GetRelationshipContent ($p_bug_id, $p_html = false, $p_html_preview = false, $p_summary = false, $p_icons = false)
{
   $t_summary = '';
   $t_status_label = '';
   $t_icons = '';
   $t_show_project = false;
   $t_summary_wrap_at = utf8_strlen (config_get ('email_separator2')) - 10;

   $t_relationship_all = relationship_get_all ($p_bug_id, $t_show_project);
   $t_relationship_all_count = count ($t_relationship_all);

   if ($p_summary)
   {
      for ($i = 0; $i < $t_relationship_all_count; $i++)
      {
         $p_relationship = $t_relationship_all [$i];
         if ($p_bug_id == $p_relationship->src_bug_id)
         {  # root bug is in the src side, related bug in the dest side
            $t_related_bug_id = $p_relationship->dest_bug_id;
            $t_relationship_descr = relationship_get_description_src_side ($p_relationship->type);
         }
         else
         {  # root bug is in the dest side, related bug in the src side
            $t_related_bug_id = $p_relationship->src_bug_id;
            $t_relationship_descr = relationship_get_description_dest_side ($p_relationship->type);
         }
         
         # get the information from the related bug and prepare the link
         $t_bug   = bug_get ($t_related_bug_id, false);
         
         // description
         $t_text = trim (utf8_str_pad ($t_relationship_descr, 20)) . ' ';
         
         if ('1.' != substr (MANTIS_VERSION, 0, 2))
         {  // 2.x
            # choose color based on status  fa fa-square-o fa-xlg status-20-color
            $t_status_label
               =  html_get_status_css_class
                  (  $t_bug->status, 
                     auth_get_current_user_id (), 
                     $t_bug->project_id
                  );
            $t_text .= '<i class="fa fa-square-o fa-xlg ' . $t_status_label . '"></i> ';
         }

         if( $p_html_preview == true ) {
            $t_text .= '<a href="' . string_get_bug_view_url ($t_related_bug_id) . '"';
            $t_text .= ' class="rcv_tooltip"';
            //$t_text .= ' title="' . utf8_str_pad (bug_format_id ($t_related_bug_id), 8) . "\n" . string_attribute ($t_bug->summary) . '"';
            $t_text .= '>';
         }
         
         // id
         $t_text .= string_display_line (bug_format_id ($t_related_bug_id));
         if( $p_html_preview == true )
         {
            $t_text .= '<span class="rcv_tooltip_box">';
            
            $t_text .= '<span class="rcv_tooltip_title">';
            $t_text .= bug_format_id ($t_related_bug_id);
            if ('1.' != substr (MANTIS_VERSION, 0, 2))
            {  // 2.x
               # choose color based on status  fa fa-square-o fa-xlg status-20-color
               $t_status_label
                  =  html_get_status_css_class
                     (  $t_bug->status, 
                        auth_get_current_user_id (), 
                        $t_bug->project_id
                     );
               $t_text .= '<span class="rcv_tooltip_icon">';
               $t_text .= '<i class="fa fa-square-o fa-xlg ' . $t_status_label . '"></i> ';
               $t_text .= '</span>';
            }
            $t_text .= '</span>';
            
            $t_text .= '<span class="rcv_tooltip_content">' . utf8_substr (string_email_links ($t_bug->summary), 0, MAX_TOOLTIP_CONTENT_LENGTH);
            $t_text .= ((MAX_TOOLTIP_CONTENT_LENGTH < strlen ($t_bug->summary)) ? '...' : '');
            $t_text .= '</span>';
            $t_text .= '</span>';
            $t_text .= '</a>';
         }

         if (  plugin_config_get ('ShowRelationshipsControl')
            && !bug_is_readonly ($p_bug_id)
            && !current_user_is_anonymous ()
            && (true == $p_html_preview)
            )
         {  // bug not read only
            if (access_has_bug_level (config_get ('update_bug_threshold'), $p_bug_id))
            {  // user has access level
               // add a delete link
               $t_text .= ' [';
               $t_text .= '<a class="small" href="bug_relationship_delete.php?bug_id=' . $p_bug_id;
               $t_text .= '&amp;rel_id=' . $p_relationship->id;
               $t_text .= '&amp;redirect_url=view_all_bug_page.php';
               $t_text .= htmlspecialchars (form_security_param ('bug_relationship_delete'));
               $t_text .= '">' . lang_get ('delete_link') . '</a>';
               $t_text .= ']';
            }
         }

         // $t_text = relationship_get_details ($p_bug_id, $t_relationship_all[$i], true, false, $t_show_project);

         if (false == $p_html)
         {  // p_html == No
            if ($i != 0) {
               if ($p_html_preview == true) {
                  $t_summary .= ",<br/>";
               } else {
                  $t_summary .= ", ";
               }
            }
            $t_summary .= $t_text;
         }
         else
         {  // p_html == Yes
            if ($p_html_preview == true)
            {
               if ('1.' == substr (MANTIS_VERSION, 0, 2))
               {  // 1.2.x - 1.3.x
                  $t_summary .= '<tr bgcolor="' . get_status_color ($t_bug->status, auth_get_current_user_id (), $t_bug->project_id) . '">';
                  $t_summary .= '<td>' . $t_text . '</td>';
                  $t_summary .= '</tr>' . "\n";
               }
               else
               {  // 2.x
                  if ($i != 0)
                     $t_summary .= "<br/>";
                  $t_summary .= '<div class="rcv_summary_item">';
                  $t_summary .= $t_text;
                  $t_summary .= '</div>';
               }
            } else {
               if ($i != 0)
                  $t_summary .= ", ";
               $t_summary .= $t_text;
            }
         }
      }
   }

   if (  plugin_config_get ('ShowRelationshipIcons')
      && !current_user_is_anonymous ()
      && (true == $p_html_preview)
      )
   {
      if ('1.' != substr (MANTIS_VERSION, 0, 2))
         $t_text = RelationshipsUtils::GetBugSmybols ( $p_bug_id, false );
      else
         $t_text = RelationshipsUtils::GetBugSmybols ( $p_bug_id, !is_blank ( $t_summary ) );
      
      if (!is_blank ($t_text))
      {
         if (false == $p_html)
         {  // p_html == No
            $t_icons .= $t_text;
         }
         else
         {  // p_html == Yes
            if ($p_html_preview == true)
            {
               if ('1.' == substr (MANTIS_VERSION, 0, 2))
               {  // 1.2.x - 1.3.x
                  $t_icons .= '<tr><td>' . $t_text . '</td></tr>' . "\n";
               }
               else
               {  // 2.x
                  $t_icons .= '<div class="rcv_icons">';
                  $t_icons .= $t_text;
                  $t_icons .= '</div>';
               }
            }
            else
            {
               $t_icons .= $t_text;
            }
         }
      }
   }

   if ($p_html_preview == true)
   {
      $t_icons_table = '';
      $t_summary_table = '';
      
      if ('1.' == substr (MANTIS_VERSION, 0, 2))
      {  // 1.2.x - 1.3.x
         if (!is_blank ($t_icons))
         {
            $t_icons_table = '<table border="0" width="100%" cellpadding="0" cellspacing="1">' . $t_icons . '</table>';
         }
         if (!is_blank ($t_summary))
         {
            $t_summary_table = '<table border="0" width="100%" cellpadding="0" cellspacing="1">' . $t_summary . '</table>';
         }

         if (!is_blank ($t_icons_table) && !is_blank ($t_summary_table)) 
         {
            return
               '<table border="0" width="100%" cellpadding="0" cellspacing="0">' 
               . '<tr><td valign="top" style="padding:0px;">' . $t_summary_table . '</td><td valign="top" style="padding:0px;">' . $t_icons_table . '</td></tr>'
               . '</table>';
         }
         else
         {
            return $t_summary_table . $t_icons_table;
         }
      }
      else
      {  // 2.x
         $t_result = '';
         if (!is_blank ($t_icons)) 
            $t_result .= '<label style="padding-bottom: 4px;">' . $t_icons . ' </label>';
         if (!is_blank ($t_icons) && !is_blank ($t_summary)) 
            $t_result .= '<br/>';
         if (!is_blank ($t_summary)) 
            $t_result .= '<div class="rcv_summary_list">' . $t_summary . ' </div>';
         return $t_result;
      }
   }
   else
   {
      $t_result = $t_icons;
      if (!is_blank ($t_icons) && !is_blank ($t_summary)) 
         $t_result .= '<br/>';
      $t_result .= $t_summary;
      return $t_result;
   }
}
