<?php
 
class RelationshipColumnViewPlugin extends MantisPlugin
{
   function register() 
   {
      $this->name          = 'Relationship Column View';
      $this->description   = 'A simple column extender for relationships of issues';
      $this->page          = 'config';

      $this->version       = '1.0.1';
      $this->requires      = array
      (
         'MantisCore'   => '1.2.0, <= 1.3.1'
      );

      $this->author      = 'Rainer Dierck';
      $this->contact     = 'rainer.dierck@friends-at-net.de';
      $this->url         = '';
   }
 
   function hooks( )
   {
      $hooks = array
      (  'EVENT_LAYOUT_PAGE_FOOTER'          => 'footer',
         'EVENT_REPORT_BUG_FORM'             => 'report_bug_form',
         'EVENT_REPORT_BUG'                  => 'report_bug',
         'EVENT_UPDATE_BUG_FORM'             => 'update_bug_form',
         'EVENT_UPDATE_BUG'                  => 'update_bug',

         'EVENT_VIEW_BUG_DETAILS'            => 'view_bug',
         'EVENT_VIEW_BUG_EXTRA'              => 'view_bug_extra',
         'EVENT_VIEW_BUGNOTES_START'         => 'view_bugnotes_start',
         'EVENT_VIEW_BUGNOTE'                => 'view_bugnote',

         'EVENT_BUGNOTE_ADD_FORM'            => 'bugnote_add_form',
         'EVENT_BUGNOTE_ADD'                 => 'bugnote_add',
         'EVENT_BUGNOTE_EDIT_FORM'           => 'bugnote_edit_form',
         'EVENT_BUGNOTE_EDIT'                => 'bugnote_edit',

         'EVENT_MANAGE_PROJECT_CREATE_FORM'  => 'project_create_form',
         'EVENT_MANAGE_PROJECT_CREATE'       => 'project_update',
         'EVENT_MANAGE_PROJECT_UPDATE_FORM'  => 'project_update_form',
         'EVENT_MANAGE_PROJECT_UPDATE'       => 'project_update',
         
         'EVENT_LAYOUT_RESOURCES'            =>   'event_layout_resources',
         'EVENT_FILTER_COLUMNS'              => 'add_columns'
      );
      return $hooks;
   }
   
   function init ()
   {
      // Get path to core folder
      $t_core_path   =  config_get_global ('plugin_path')
                     .  plugin_get_current ()
                     .  DIRECTORY_SEPARATOR
                     .  'core'
                     .  DIRECTORY_SEPARATOR;
      
      // Include constants
      require_once ($t_core_path . 'constant_api.php');
   }
   
   function config() 
   {
      return   
         array
         (
            'ShowInFooter'                   => ON,
            'ShowRelationshipColumn'         => ON,
            'ShowRelationshipsColorful'      => ON,
            'RelationshipColumnAccessLevel'  => ADMINISTRATOR
         );
   }
   
   // --- hooks ---------------------------------------------------------------
   
   function footer ()
   {
      $t_project_id = helper_get_current_project ();
      $t_user_id = auth_get_current_user_id ();
      $t_user_has_level = user_get_access_level ($t_user_id, $t_project_id) >= plugin_config_get ('RelationshipColumnAccessLevel', PLUGINS_RELATIONSHIPCOLUMNVIEW_THRESHOLD_LEVEL_DEFAULT);

      if (  plugin_config_get ('ShowInFooter') == 1
         && $t_user_has_level
         )
      {
         return   '<address>' . $this->name . ' ' . $this->version . ' by <a href="mailto://' . $this->contact . '">' . $this->author . '</a></address>';
      }
      return "";
   }

   function event_layout_resources ()
   {
      echo '<link rel="stylesheet" href="' . RELATIONSHIPCOLUMNVIEW_PLUGIN_URL . 'css/RelationshipColumnView.css">' . "\n";
   }
   
   function add_columns ()
   {
      $t_project_id = helper_get_current_project ();
      $t_user_id = auth_get_current_user_id ();
      $t_user_has_level = user_get_access_level ($t_user_id, $t_project_id) >= plugin_config_get ('RelationshipColumnAccessLevel', PLUGINS_RELATIONSHIPCOLUMNVIEW_THRESHOLD_LEVEL_DEFAULT);
      $t_result = array ();

      if (  plugin_config_get ('ShowRelationshipColumn') == gpc_get_int ('ShowRelationshipColumn', ON)
         && $t_user_has_level
         )
      {
         if ('1.2.' == substr (MANTIS_VERSION, 0, 4))
            require_once ('classes/RelationshipColumn.class.1.2.0.php');
         else
            require_once ('classes/RelationshipColumn.class.1.3.0.php');
         $t_result[] = 'RelationshipColumn';
      }
      return $t_result;
   }
}
