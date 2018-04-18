<?php

namespace GEXFSNA\XML;

class Edges {

	private $_nextID = 0;
	private $_edges = array();
	private $_hasViz = false; 

	public function addEdge($source, $target, $viz = null, $start = null, $end = null){

		$id = $this->_nextID;

		if($start != null){
			$start = ' start="'.$start.'"';
		}

		if($end != null){
			$end = ' end="'.$end.'"';
		}


		$slash = '/';
		if($viz != null){

			if(!$this->_hasViz){
				$this->_hasViz = true;
			}
			
			$slash = '';

			foreach($viz as $type => $data){

				$edgeViz .= "\t\t".'<viz:'.$type.' '.$data.'/>'.PHP_EOL;
			}
		}

		$edge = "\t".'<edge id="'.intval($id).'" source="'.intval($source).'" target="'.intval($target).'"'.$start.$end.$slash.'>'.PHP_EOL;

		if($edgeViz != ''){

			$edge .= $edgeViz;
			$edge .= "\t".'</edge>'.PHP_EOL;
		}

		array_push($this->_edges, $edge);

		$this->_nextID ++;

		return $id;
	}

	public function hasVisualization(){

		return $this->_hasViz;
	}

	public function __toString(){

		ob_start();

		if(count($this->_edges) > 0){

			echo '<edges>'.PHP_EOL;

				foreach($this->_edges as $edge){
					echo $edge;
				}

			echo '</edges>'.PHP_EOL;
		}

		return ob_get_clean();

	}

}
?>
