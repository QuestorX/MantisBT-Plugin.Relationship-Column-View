<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" >

<form action="<?php echo plugin_page ('config_edit')?>" method="post">
<?php echo form_security_field ('plugin_RelationshipColumnView_config_edit') ?>

<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo plugin_lang_get( 'config_title' ) . ': ' . plugin_lang_get( 'config_caption' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive">

<table class="table table-bordered table-condensed table-striped">

<!-- Upload access level -->
<tr>
   <td class="category width-40" width="30%">
    <?php echo plugin_lang_get ('relationship_column_access_level'); ?>
   </td>
   <td width="200px">
      <select name="RelationshipColumnAccessLevel">
         <?php print_enum_string_option_list ('access_levels', plugin_config_get ('RelationshipColumnAccessLevel', PLUGINS_RELATIONSHIPCOLUMNVIEW_THRESHOLD_LEVEL_DEFAULT)); ?>
      </select>
   </td>
</tr>

<tr>
   <td class="category width-40">
      <?php echo plugin_lang_get ('show_relationship_information'); ?><br/>
      <span class="small"><?php echo plugin_lang_get ('show_relationship_information_info'); ?></span>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowRelationshipColumn" value="1" <?php echo (ON == plugin_config_get ('ShowRelationshipColumn')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_yes' ) ?> </span></label>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowRelationshipColumn" value="0" <?php echo (OFF == plugin_config_get ('ShowRelationshipColumn')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_no' ) ?> </span></label>
   </td>
</tr>

<tr>
   <td class="category width-40">
      <?php echo plugin_lang_get ('show_plugin_info_footer'); ?>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowInFooter" value="1" <?php echo (ON == plugin_config_get ('ShowInFooter')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_yes' ) ?> </span></label>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowInFooter" value="0" <?php echo (OFF == plugin_config_get ('ShowInFooter')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_no' ) ?> </span></label>
   </td>
</tr>

<!-- spacer -->
<tr>
  <td class="spacer" colspan="2">&nbsp;</td>
</tr>

<tr>
   <td class="category width-40">
      <?php echo plugin_lang_get ('show_relationships'); ?>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowRelationships" value="1" <?php echo (ON == plugin_config_get ('ShowRelationships')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_yes' ) ?> </span></label>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowRelationships" value="0" <?php echo (OFF == plugin_config_get ('ShowRelationships')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_no' ) ?> </span></label>
   </td>
</tr>

<tr>
   <td class="category width-40">
      <?php echo plugin_lang_get ('show_relationships_colorful'); ?>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowRelationshipsColorful" value="1" <?php echo (ON == plugin_config_get ('ShowRelationshipsColorful')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_yes' ) ?> </span></label>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowRelationshipsColorful" value="0" <?php echo (OFF == plugin_config_get ('ShowRelationshipsColorful')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_no' ) ?> </span></label>
   </td>
</tr>

<tr>
   <td class="category width-40">
      <?php echo plugin_lang_get ('show_relationships_control'); ?><br/>
      <span class="small"><?php echo plugin_lang_get ('show_relationships_control_info'); ?></span>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowRelationshipsControl" value="1" <?php echo (ON == plugin_config_get ('ShowRelationshipsControl')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_yes' ) ?> </span></label>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowRelationshipsControl" value="0" <?php echo (OFF == plugin_config_get ('ShowRelationshipsControl')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_no' ) ?> </span></label>
   </td>
</tr>

<!-- spacer -->
<tr>
  <td class="spacer" colspan="2">&nbsp;</td>
</tr>

<tr>
   <td class="category width-40">
      <?php echo plugin_lang_get ('show_relationship_icons'); ?>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowRelationshipIcons" value="1" <?php echo (ON == plugin_config_get ('ShowRelationshipIcons')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_yes' ) ?> </span></label>
	</td>
	<td class="center" width="20%">
      <label><input type="radio" class="ace" name="ShowRelationshipIcons" value="0" <?php echo (OFF == plugin_config_get ('ShowRelationshipIcons')) ? 'checked="checked" ' : ''?>/>
      <span class="lbl"> <?php echo plugin_lang_get( 'config_no' ) ?> </span></label>
   </td>
</tr>

</table>

</div>
</div>
<div class="widget-toolbox padding-8 clearfix">
	<input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo lang_get( 'change_configuration' )?>" />
</div>
</div>
</div>

</form>

</div>
</div>
