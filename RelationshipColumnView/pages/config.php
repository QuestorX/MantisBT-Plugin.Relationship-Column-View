<?php
// Load RelationshipColumnView configuration
require_once (RELATIONSHIPCOLUMNVIEW_CORE_URI . 'constant_api.php');

auth_reauthenticate ();
access_ensure_global_level (config_get ('manage_plugin_threshold'));

if ('1.' == substr (MANTIS_VERSION, 0, 2))
{  // 1.2.x - 1.3.x
   html_page_top (plugin_lang_get ('config_title'));
   print_manage_menu ();

   require (RELATIONSHIPCOLUMNVIEW_PAGES_URI . 'config.1.php');

   html_page_bottom ();
}
else
{  // 2.x
   layout_page_header (plugin_lang_get ('config_title'));
   layout_page_begin( 'manage_overview_page.php' );
   print_manage_menu ();

   require (RELATIONSHIPCOLUMNVIEW_PAGES_URI . 'config.2.php');

   layout_page_end ();
}

