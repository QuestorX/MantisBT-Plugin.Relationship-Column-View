<?php

define ('RELATIONSHIPCOLUMNVIEW_CORE_FOLDER', 'core');

// URL to RelationshipColumnView plugin
define ('RELATIONSHIPCOLUMNVIEW_PLUGIN_URL', config_get_global ('path') . 'plugins' . DIRECTORY_SEPARATOR . plugin_get_current () . DIRECTORY_SEPARATOR);

// URL to RelationshipColumnView plugin/core
define ('RELATIONSHIPCOLUMNVIEW_CORE_RELATIVE_URL', 'plugins' . DIRECTORY_SEPARATOR . plugin_get_current () . DIRECTORY_SEPARATOR . RELATIONSHIPCOLUMNVIEW_CORE_FOLDER . DIRECTORY_SEPARATOR);

// Path to RelationshipColumnView plugin folder
define ('RELATIONSHIPCOLUMNVIEW_PLUGIN_URI', config_get_global ('plugin_path') . plugin_get_current () . DIRECTORY_SEPARATOR);

// Path to RelationshipColumnView core folder
define ('RELATIONSHIPCOLUMNVIEW_CORE_URI', RELATIONSHIPCOLUMNVIEW_PLUGIN_URI . RELATIONSHIPCOLUMNVIEW_CORE_FOLDER . DIRECTORY_SEPARATOR);

// Default treshold level
define ('PLUGINS_RELATIONSHIPCOLUMNVIEW_THRESHOLD_LEVEL_DEFAULT', ADMINISTRATOR);

define("MAX_TOOLTIP_CONTENT_LENGTH", 160);

?>
