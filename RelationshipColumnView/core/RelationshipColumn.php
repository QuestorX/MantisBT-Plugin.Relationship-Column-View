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
function GetRelationshipContent ($p_bug_id, $p_html = false, $p_html_preview = false)
{
   $t_summary = '';
   $t_text = '';
   $t_show_project = false;
   $t_summary_wrap_at = utf8_strlen (config_get ('email_separator2')) - 10;

   $t_relationship_all = relationship_get_all ($p_bug_id, $t_show_project);
   $t_relationship_all_count = count ($t_relationship_all);

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

      $t_text  = trim (utf8_str_pad ($t_relationship_descr, 20)) . ' ';
      if( $p_html_preview == true ) {
         $t_text .= '<a href="' . string_get_bug_view_url ($t_related_bug_id) . '"';
         $t_text .= ' class="rcv_tooltip"';
         //$t_text .= ' title="' . utf8_str_pad (bug_format_id ($t_related_bug_id), 8) . "\n" . string_attribute ($t_bug->summary) . '"';
         $t_text .= '>';
      }
      $t_text .= string_display_line (bug_format_id ($t_related_bug_id));
      if( $p_html_preview == true ) {
         $t_text .= '<span class="rcv_tooltip_box">';
         $t_text .= '<span class="rcv_tooltip_title">' . bug_format_id ($t_related_bug_id) . '</span>';
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
      {
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
      {
         if( $p_html_preview == true ) {
            $t_summary .= '<tr bgcolor="' . get_status_color ($t_bug->status, auth_get_current_user_id (), $t_bug->project_id) . '">';
            $t_summary .= '<td>' . $t_text . '</td>';
            $t_summary .= '</tr>' . "\n";
         } else {
            if ($i != 0)
               $t_summary .= ", ";
            $t_summary .= $t_text;
         }
      }
   }

   if (  !is_blank ($t_summary)
      && $p_html_preview == true
      ) 
   {
      $t_summary = '<table border="0" width="100%" cellpadding="0" cellspacing="1">' . $t_summary . '</table>';
   }

   return $t_summary;
}
