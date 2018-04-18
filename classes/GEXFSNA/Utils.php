<?php

namespace GEXFSNA;

class Utils {

	public static function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
	    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
	    $rgbArray = array();
	    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
		$colorVal = hexdec($hexStr);
		$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
		$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
		$rgbArray['blue'] = 0xFF & $colorVal;
	    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
		$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
		$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
		$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
	    } else {
		return false; //Invalid hex color code
	    }
	    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
	}

	public static function uShape(){

		$shape = elgg_get_plugin_setting('users_shape', \HLV\gexf_sna\PLUGIN_ID);

		if($shape == ''){

			return 'disc';
		}
	
		return $shape;
	}

	public static function uColor($admin = false){

		$id = 'users_color';
		if($subgroup){
			$id = 'adminusers_color';
		}

		$color = elgg_get_plugin_setting($id, \HLV\gexf_sna\PLUGIN_ID);

		if($color == ''){

			if($admin){
				return Utils::hex2RGB('#eff931');
			}

			return Utils::hex2RGB('#43def9');
		}
	
		return Utils::hex2RGB($color);
	}

	public static function gShape(){

		$shape = elgg_get_plugin_setting('groups_shape', \HLV\gexf_sna\PLUGIN_ID);

		if($shape == ''){

			return 'square';
		}
	
		return $shape;
	}

	public static function gColor($subgroup = false){

		$id = 'groups_color';
		if($subgroup){
			$id = 'subgroups_color';
		}

		$color = elgg_get_plugin_setting($id, \HLV\gexf_sna\PLUGIN_ID);

		if($color == ''){

			if($subgroup){
				return Utils::hex2RGB('#43f96e');
			}

			return Utils::hex2RGB('#43f96e');
		}
	
		return Utils::hex2RGB($color);
	}

	public static function uLabel(){

		$label = elgg_get_plugin_setting('users_label', \HLV\gexf_sna\PLUGIN_ID);

		if($label == 'no'){

			return false;
		}
	
		return true;
	}

	public static function gLabel(){

		$label = elgg_get_plugin_setting('groups_label', \HLV\gexf_sna\PLUGIN_ID);

		if($label == 'no'){

			return false;
		}
	
		return true;
	}

	public static function ownerColor(){

		$color = elgg_get_plugin_setting('owner_color', \HLV\gexf_sna\PLUGIN_ID);

		if($color == ''){

			return Utils::hex2RGB('#eff931');
		}
	
		return Utils::hex2RGB($color);

	}

}
?>
