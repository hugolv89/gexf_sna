<?php

namespace GEXFSNA\XML;

class Node {

	private $_childs = array();
	private $_id;
	private $_label;
	private $_attvalues;
	private $_startDate;
	private $_viz;

	public function __construct($id ,$label = null , $attvalues = null, $startDate = null, $viz = null){

		$this->_id = $id;
		$this->_label = $label;
		$this->_attvalues = $attvalues;
		$this->_startDate = $startDate;
		$this->_viz = $viz;

		if($this->_label == ''){

			$this->_label = null;
		}
	}

	public function getGUID(){

		return $this->_id;
	}

	public function hasChilds(){

		if(count($this->_childs) > 0){
			return true;
		}

		return false;
	}

	public function hasVisualization(){

		if($this->_viz != null){
			return true;
		}

		return false;
	}

	private function attvalues(){

		ob_start();

		if(count($this->_attvalues) > 0){

			echo "\t".'<attvalues>'.PHP_EOL;

			foreach ($this->_attvalues as $id => $value) {

				echo "\t\t".'<attvalue for="'.intval($id).'" value="'.$value.'"/>'.PHP_EOL;
			}
				 
			echo "\t".'</attvalues>'.PHP_EOL;
		}

		return ob_get_clean();
	}

	private function visualization(){

		ob_start();

		foreach($this->_viz as $type => $data){

			echo "\t".'<viz:'.$type.' '.$data.'/>'.PHP_EOL;
		}

		return ob_get_clean();

	}

	public function addChild($node){

		array_push($this->_childs, $node);

	}

	private function childs(){

		ob_start();

		if(count($this->_childs) > 0){

			echo "\t".'<nodes>'.PHP_EOL."\t\t";

			ob_start();

			foreach($this->_childs as $child){

				echo preg_replace("/[".PHP_EOL."]+/", PHP_EOL."\t\t", $child);
			}

			echo rtrim(ob_get_clean(),"\t\t");

			echo "\t".'</nodes>'.PHP_EOL;

		}

		return ob_get_clean();

	}

	public function __toString(){

		ob_start();

		if($this->_label != null){
	
			$label = ' label="'.$this->_label.'"';
		}

		if($this->_startDate != null){
	
			$startDate = ' start="'.$this->_startDate.'"';
		}

		$slash = '/';
		if($this->_attvalues != null || $this->_viz != null || $this->_childs != null){
			$slash = '';
		}

		echo '<node id="'.intval($this->_id).'"'.$label.$startDate.$slash.'>'.PHP_EOL;

		if($this->_attvalues != null || $this->_viz != null || $this->_childs != null){
			echo $this->attvalues();
			echo $this->visualization();
			echo $this->childs();
			echo '</node>'.PHP_EOL;
		}

		return ob_get_clean();
	}

}
?>
