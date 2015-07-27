<?php
// Load RelationshipColumnView configuration
require_once (RELATIONSHIPCOLUMNVIEW_CORE_URI . 'constant_api.php');
require_once (RELATIONSHIPCOLUMNVIEW_CORE_URI . 'RelationshipColumn.php');

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

   public function display (BugData $p_bug, $p_columns_target)
   {
      plugin_push_current ('RelationshipColumnView');

      $p_bug_id = $p_bug->id;

      echo GetRelationshipContent ($p_bug_id, plugin_config_get ('ShowRelationshipsColorful'));
      
      plugin_pop_current ();
   }
}