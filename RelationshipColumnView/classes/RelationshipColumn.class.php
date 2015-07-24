<?php
// Load RelationshipColumnView configuration
require_once (RELATIONSHIPCOLUMNVIEW_CORE_URI . 'constant_api.php');

function GetRelationshipContent ($p_bug_id, $p_html = false)
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

      $t_text  = utf8_str_pad ($t_relationship_descr, 20);
      $t_text .= '<a href="' . string_get_bug_view_url ($t_related_bug_id) . '"';
      $t_text .= ' class="rcv_tooltip"';
      //$t_text .= ' title="' . utf8_str_pad (bug_format_id ($t_related_bug_id), 8) . "\n" . string_attribute ($t_bug->summary) . '"';
      $t_text .= '>' . string_display_line (bug_format_id ($t_related_bug_id));
      $t_text .= '<span>';
      $t_text .= '<div class="rcv_tooltip_title">' . bug_format_id ($t_related_bug_id) . '</div>';
      $t_text .= '<div class="rcv_tooltip_content">' . $t_bug->summary . '</div>';
      $t_text .= '</span>';
      $t_text .= '</a>';
      // $t_text = relationship_get_details ($p_bug_id, $t_relationship_all[$i], false, false, $t_show_project);

      if (false == $p_html)
      {
         if ($i != 0)
            $t_summary .= ",\n";
         $t_summary .= $t_text;
      }
      else
      {
         $t_summary .= '<tr bgcolor="' . get_status_color ($t_bug->status, auth_get_current_user_id (), $t_bug->project_id) . '">';
         $t_summary .= '<td>' . $t_text . '</td>';
         $t_summary .= '</tr>' . "\n";
      }
   }

   if (!is_blank ($t_summary)) 
   {
      $t_summary = '<table border="0" width="100%" cellpadding="0" cellspacing="1">' . $t_summary . '</table>';
   }

   return $t_summary;
}

class RelationshipColumn extends MantisColumn
{
   public $title     = '';
   public $column    = "relationship";
   public $sortable  = false;

   public function __construct ()
   {
      plugin_push_current ('RelationshipColumnView');

      $this->title = plugin_lang_get ('relationship');

      plugin_pop_current ();
   }

   public function display ($p_bug, $p_columns_target)
   {
      plugin_push_current ('RelationshipColumnView');

      $p_bug_id = $p_bug->id;

      echo GetRelationshipContent ($p_bug_id, plugin_config_get ('ShowRelationshipsColorful'));
      
      plugin_pop_current ();
   }
}
