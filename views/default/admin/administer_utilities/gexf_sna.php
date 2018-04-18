<?php

	echo '<a style="float:right;clear:both;" href="'.elgg_get_site_url().'admin/plugin_settings/gexf_sna">'.elgg_echo('settings').'</a>';	

	if(\GEXFSNA\File\Manager::isWritable()){

		echo elgg_view('output/url', array(
		   	'text' => elgg_echo('gexf_sna:generate:ug'),
		   	'href' => "action/gexf_sna/generate?users=1&groups=1",
	  		'is_action' => true,
		));

		echo '<br>';

		echo elgg_view('output/url', array(
		   	'text' => elgg_echo('gexf_sna:generate:u'),
		   	'href' => "action/gexf_sna/generate?users=1&groups=0",
	  		'is_action' => true,
		));

		echo '<br>';

		echo elgg_view('output/url', array(
		   	'text' => elgg_echo('gexf_sna:generate:g'),
		   	'href' => "action/gexf_sna/generate?users=0&groups=1",
	  		'is_action' => true,
		));

	}else{

		echo elgg_echo('gexf_sna:directory:nowritable',[\HLV\gexf_sna\BASEDIR]);
	}
	
	$files = \GEXFSNA\File\Manager::getUrlFiles();

	if(count($files) > 0){

		echo '<br><br>';
		echo '<label>'.elgg_echo('gexf_sna:files').'</label>';

		foreach($files as $url){

			$split = explode('files/',$url);

			$delete = elgg_view('output/url', array(
			   	'text' => elgg_echo('delete'),
			   	'href' => 'action/gexf_sna/delete?filename='.$split[1],
		  		'is_action' => true,
			));

			echo '&nbsp;<br><a href="'.$url.'" download>'.$split[1].'</a> ('.$delete.')';
		}
	}

	echo '<br><br>';
	echo elgg_echo("gexf_sna:more:info").' <a target="_blank" href="https://gephi.org/gexf/format/index.html">'.elgg_echo("gexf_sna:more:info:linkname").'</a>.';
?>
