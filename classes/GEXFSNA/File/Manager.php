<?php

namespace GEXFSNA\File;

class Manager {

	public static function dumpGEXF($data, $info = null){

		if($info != null){
			$type = '('.$info.')';
		}

		$file = fopen(\HLV\gexf_sna\BASEDIR.'SNA'.$type.'_'.time().'.gexf', 'w') or die('Unable to open file!');

		fwrite($file, $data);

		fclose($file);
	}

	public static function deleteGEXF($fileName){

		unlink(\HLV\gexf_sna\BASEDIR.$fileName);
	}

	public static function getUrlFiles(){

		$baseURL = rtrim(\elgg_get_site_url(),'/').'/mod/gexf_sna/files/';
		$allFiles = scandir(\HLV\gexf_sna\BASEDIR,1);

		$urlList = array();

		for($i = 0; $i < count($allFiles)-2; $i++){

			$urlList[] = $baseURL.$allFiles[$i];
		}

		return $urlList;
	}

	public static function isWritable(){

		return is_writable(\HLV\gexf_sna\BASEDIR);
	}

}
?>
