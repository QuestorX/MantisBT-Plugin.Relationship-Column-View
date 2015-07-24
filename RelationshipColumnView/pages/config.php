<?php
// Load RelationshipColumnView configuration
require_once (RELATIONSHIPCOLUMNVIEW_CORE_URI . 'constant_api.php');

auth_reauthenticate ();
access_ensure_global_level (config_get ('manage_plugin_threshold'));

html_page_top (plugin_lang_get ('config_title'));

print_manage_menu ();

?>

<br/>
<form action="<?php echo plugin_page ('config_edit')?>" method="post">
<?php echo form_security_field ('plugin_RelationshipColumnView_config_edit') ?>
<table align="center" class="width75" cellspacing="1">

<tr>
	<td class="form-title" colspan="3">
		<?php echo plugin_lang_get ('config_caption'); ?>
	</td>
</tr>


<tr <?php echo helper_alternate_class ()?>>
	<td class="category">
		<?php echo plugin_lang_get ('show_plugin_info_footer'); ?>
	</td>
	<td width="200px">
		<label><input type="radio" name="ShowInFooter" value="1" <?php echo (ON == plugin_config_get ('ShowInFooter')) ? 'checked="checked" ' : ''?>/>Yes</label>
		<label><input type="radio" name="ShowInFooter" value="0" <?php echo (OFF == plugin_config_get ('ShowInFooter')) ? 'checked="checked" ' : ''?>/>No</label>
	</td>
</tr>

<!-- spacer -->
<tr>
  <td class="spacer" colspan="2">&nbsp;</td>
</tr>

<tr <?php echo helper_alternate_class ()?>>
	<td class="category">
		<?php echo plugin_lang_get ('show_relationship_information'); ?>
	</td>
	<td width="200px">
		<label><input type="radio" name="ShowRelationshipColumn" value="1" <?php echo (ON == plugin_config_get ('ShowRelationshipColumn')) ? 'checked="checked" ' : ''?>/>Yes</label>
		<label><input type="radio" name="ShowRelationshipColumn" value="0" <?php echo (OFF == plugin_config_get ('ShowRelationshipColumn')) ? 'checked="checked" ' : ''?>/>No</label>
	</td>
</tr>
<tr <?php echo helper_alternate_class( )?>>
	<td class="category">
		<?php echo plugin_lang_get ('show_relationships_colorful'); ?>
	</td>
	<td width="200px">
		<label><input type="radio" name="ShowRelationshipsColorful" value="1" <?php echo (ON == plugin_config_get ('ShowRelationshipsColorful')) ? 'checked="checked" ' : ''?>/>Yes</label>
		<label><input type="radio" name="ShowRelationshipsColorful" value="0" <?php echo (OFF == plugin_config_get ('ShowRelationshipsColorful')) ? 'checked="checked" ' : ''?>/>No</label>
	</td>
</tr>

<!-- Upload access level -->
<tr <?php echo helper_alternate_class() ?>>
  <td class="category" width="30%">
    <span class="required">*</span><?php echo plugin_lang_get ('relationship_column_access_level'); ?>
  </td>
  <td width="200px">
    <select name="relationship_column_access_level">
      <?php print_enum_string_option_list ('access_levels', plugin_config_get ('ThresholdLevel', PLUGINS_RELATIONSHIPCOLUMNVIEW_THRESHOLD_LEVEL_DEFAULT)); ?>
    </select>
  </td>
</tr>

<!-- spacer -->
<tr>
  <td class="spacer" colspan="2">&nbsp;</td>
</tr>



<tr>
	<td class="center" colspan="3">
		<input type="submit" class="button" value="<?php echo lang_get ('change_configuration')?>" />
	</td>
</tr>

</table>
<form>

<?php
html_page_bottom ();
