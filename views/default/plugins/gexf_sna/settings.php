<?php

	//\GEXFSNA\Utils::hex2RGB();

// set default value
if (!isset($vars['entity']->users_label)) {
	$vars['entity']->users_label = 'yes';
}
if (!isset($vars['entity']->users_shape)) {
	$vars['entity']->users_shape = 'disc';
}
if (!isset($vars['entity']->users_color)) {
	$vars['entity']->users_color = '#43def9';
}
if (!isset($vars['entity']->adminusers_color)) {
	$vars['entity']->adminusers_color = '#eff931';
}
if (!isset($vars['entity']->owner_color)) {
	$vars['entity']->owner_color = '#eff931';
}

if (!isset($vars['entity']->groups_label)) {
	$vars['entity']->groups_label = 'yes';
}
if (!isset($vars['entity']->groups_shape)) {
	$vars['entity']->groups_shape = 'square';
}
if (!isset($vars['entity']->groups_color)) {
	$vars['entity']->groups_color = '#43f96e';
}
if (!isset($vars['entity']->subgroups_color)) {
	$vars['entity']->subgroups_color = '#43f96e';
}

echo '<a style="float:right;clear:both;" href="'.elgg_get_site_url().'admin/administer_utilities/gexf_sna">'.elgg_echo('gexf_sna:settings:generate').'</a>';	

echo elgg_echo('gexf_sna:settings:users:label').'<br>';
echo elgg_view('input/select', array(
	'name' => 'params[users_label]',
	'options_values' => array(
		'yes' => elgg_echo('show'),
		'no' => elgg_echo('hide'),
	),
	'value' => $vars['entity']->users_label,
));

echo '<br><br>';

echo elgg_echo('gexf_sna:settings:groups:label').'<br>';
echo elgg_view('input/select', array(
	'name' => 'params[groups_label]',
	'options_values' => array(
		'yes' => elgg_echo('show'),
		'no' => elgg_echo('hide'),
	),
	'value' => $vars['entity']->groups_label,
));

echo '<br><br>';

echo elgg_echo('gexf_sna:settings:users:owner:color').'<br>';
echo '<input type="text" class="elgg-input-text" name="params[owner_color]" value="'.$vars['entity']->owner_color.'"/>';

echo '<br><br>';

echo elgg_echo('gexf_sna:settings:users:shape').'<br>';
echo elgg_view('input/select', array(
	'name' => 'params[users_shape]',
	'options_values' => array(
		'disc' => elgg_echo('gexf_sna:settings:disc'),
		'square' => elgg_echo('gexf_sna:settings:square'),
		'triangle' => elgg_echo('gexf_sna:settings:triangle'),
		'diamond' => elgg_echo('gexf_sna:settings:diamond'),
	),
	'value' => $vars['entity']->users_shape,
));

echo '<br><br>';
echo elgg_echo('gexf_sna:settings:users:color').'<br>';
echo '<input type="text" class="elgg-input-text" name="params[users_color]" value="'.$vars['entity']->users_color.'"/>';

echo '<br><br>';

echo elgg_echo('gexf_sna:settings:users:admin:color').'<br>';
echo '<input type="text" class="elgg-input-text" name="params[adminusers_color]" value="'.$vars['entity']->adminusers_color.'"/>';

echo '<br><br>';

echo elgg_echo('gexf_sna:settings:groups:shape').'<br>';
echo elgg_view('input/select', array(
	'name' => 'params[groups_shape]',
	'options_values' => array(
		'disc' => elgg_echo('gexf_sna:settings:disc'),
		'square' => elgg_echo('gexf_sna:settings:square'),
		'triangle' => elgg_echo('gexf_sna:settings:triangle'),
		'diamond' => elgg_echo('gexf_sna:settings:diamond'),
	),
	'value' => $vars['entity']->groups_shape,
));

echo '<br><br>';
echo elgg_echo('gexf_sna:settings:groups:color').'<br>';
echo '<input type="text" class="elgg-input-text" name="params[groups_color]" value="'.$vars['entity']->groups_color.'"/>';

echo '<br><br>';

echo elgg_echo('gexf_sna:settings:subgroups:color').'<br>';
echo '<input type="text" class="elgg-input-text" name="params[subgroups_color]" value="'.$vars['entity']->subgroups_color.'"/>';

echo '<br><br>';
?>
