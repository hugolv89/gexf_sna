<?php
/**
 * gexf_sna Plugin
 */

namespace HLV\gexf_sna;

const PLUGIN_ID = 'gexf_sna';
const BASEDIR = __DIR__.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR;

//register the plugin hook handler
elgg_register_event_handler('init', 'system', __NAMESPACE__.'\\init');

/**
 * plugin init function
 */
function init() {

	elgg_register_admin_menu_item('administer', 'gexf_sna', 'administer_utilities');

	// Actions
	elgg_register_action(PLUGIN_ID."/generate", __DIR__ . "/actions/gexf_sna/generate.php");
	elgg_register_action(PLUGIN_ID."/delete", __DIR__ . "/actions/gexf_sna/delete.php");

}
