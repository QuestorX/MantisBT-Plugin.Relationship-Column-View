<?php

form_security_validate ('plugin_RelationshipColumnView_config_edit');

auth_reauthenticate ();
access_ensure_global_level (config_get ('manage_plugin_threshold'));

$ShowInFooter = gpc_get_int ('ShowInFooter', ON);
if (plugin_config_get ('ShowInFooter') != $ShowInFooter)
{
	plugin_config_set ('ShowInFooter', $ShowInFooter);
}

$ShowRelationshipColumn = gpc_get_int ('ShowRelationshipColumn', ON);
if (plugin_config_get ('ShowRelationshipColumn') != $ShowRelationshipColumn)
{
	plugin_config_set ('ShowRelationshipColumn', $ShowRelationshipColumn);
}

$ShowRelationshipsColorful = gpc_get_int ('ShowRelationshipsColorful', ON);
if (plugin_config_get ('ShowRelationshipsColorful') != $ShowRelationshipsColorful)
{
	plugin_config_set ('ShowRelationshipsColorful', $ShowRelationshipsColorful);
}

$t_project_id = helper_get_current_project ();
$t_relationship_column_access_level = gpc_get_int ('relationship_column_access_level');
if (plugin_config_get ('ThresholdLevel') != $t_relationship_column_access_level)
{
	plugin_config_set ('ThresholdLevel', $t_relationship_column_access_level, NO_USER, $t_project_id);
}

form_security_purge ('plugin_RelationshipColumnView_config_edit');

print_successful_redirect (plugin_page ('config', true));
