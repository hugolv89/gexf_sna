<?php

namespace GEXFSNA\XML;

class GEXF {

	private $_meta = null;
	private $_options = '';
	private $_attributes;
	private $_viz = null;
	private $_nodes = array();
	private $_edges;

	public function __construct($meta){

		$this->_meta = $meta;
		$this->setOptions();
	}

	private function meta(){

		ob_start();

		foreach ($this->_meta as $key => $value) {
			echo "\t\t".'<'.$key.'>'.$value.'</'.$key.'>'.PHP_EOL;
		}

		return ob_get_clean();
	}

	public function setOptions($mode = null, $defaultedgetype = 'directed', $timeformat = null){

		if($mode != null){
			$mode = 'mode="'.$mode.'" ';
		}

		if($timeformat != null){
			$timeformat = ' timeformat="'.$timeformat.'"';
		}

		$this->_options = $mode.'defaultedgetype="directed"'.$timeformat;
	}

	public function setAttributes($attributes){

		$this->_attributes = $attributes;
	}

	public function addNode($node){

		if($this->_viz == null){

			if($node->hasVisualization()){
				$this->_viz = 'xmlns:viz="http://www.gexf.net/1.1draft/viz" ';
			}
		}

		array_push($this->_nodes, $node);
	}

	private function nodes(){

		ob_start();

		foreach($this->_nodes as $node){
	
			echo $node;
		}

		return ob_get_clean();
	}

	public function setEdges($edge){

		$this->_edges = $edge;
	}

	public function __toString(){

		ob_start();

		echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
		echo '<gexf xmlns="http://www.gexf.net/1.2draft" '.$this->_viz.'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.gexf.net/1.2draft http://www.gexf.net/1.2draft/gexf.xsd" version="1.2">'.PHP_EOL;
			echo "\t".'<meta lastmodifieddate="'.date('Y-m-d H:i:s').'">'.PHP_EOL;
				echo $this->meta();
			echo "\t".'</meta>'.PHP_EOL;
			echo "\t".'<graph '.$this->_options.'>'.PHP_EOL;
				echo rtrim("\t\t".preg_replace("/[".PHP_EOL."]+/", PHP_EOL."\t\t", $this->_attributes),"\t\t");
				echo "\t\t".'<nodes>'.PHP_EOL;
					echo rtrim("\t\t\t".preg_replace("/[".PHP_EOL."]+/", PHP_EOL."\t\t\t", $this->nodes()),"\t\t\t");
				echo "\t\t".'</nodes>'.PHP_EOL;
				echo rtrim("\t\t".preg_replace("/[".PHP_EOL."]+/", PHP_EOL."\t\t", $this->_edges),"\t\t");
			echo "\t".'</graph>'.PHP_EOL;
		echo '</gexf>'.PHP_EOL;

		return ob_get_clean();

	}

}
?>
