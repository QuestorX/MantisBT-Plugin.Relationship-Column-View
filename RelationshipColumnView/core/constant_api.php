<?php

// URL to RelationshipColumnView plugin
define ('RELATIONSHIPCOLUMNVIEW_PLUGIN_URL', config_get_global ('path') . 'plugins/' . plugin_get_current () . '/');

// Path to RelationshipColumnView plugin folder
define ('RELATIONSHIPCOLUMNVIEW_PLUGIN_URI', config_get_global ('plugin_path') . plugin_get_current () . DIRECTORY_SEPARATOR);

// Path to RelationshipColumnView core folder
define ('RELATIONSHIPCOLUMNVIEW_CORE_URI', RELATIONSHIPCOLUMNVIEW_PLUGIN_URI . 'core' . DIRECTORY_SEPARATOR);

// Default treshold level
define ('PLUGINS_RELATIONSHIPCOLUMNVIEW_THRESHOLD_LEVEL_DEFAULT', ADMINISTRATOR);

?>