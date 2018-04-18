<?php

namespace GEXFSNA\XML;

class Attributes {

	private static $_nextID = 0;
	private $_static = array();
	private $_dynamic = array();

	public function addAttribute($title, $type, $default = null, $dynamicMode = false){

		$id = $this->_nextID;

		$attribute = array(
				'id' => $id,
				'title' => $title,
				'type' => $type,
				'default' => $default,
			     );

		if(!$dynamicMode){

			array_push($this->_static, $attribute);
		}else{

			array_push($this->_dynamic, $attribute);
		}

		$this->_nextID ++;

		return intval($id);

	}

	private function attributes($attributes){

		ob_start();

		foreach($attributes as $attr){
		
			$slash = '';
			if($attr['default'] == null){
				$slash = '/';
			}

			echo "\t".'<attribute id="'.intval($attr['id']).'" title="'.$attr['title'].'" type="'.$attr['type'].'"'.$slash.'>'.PHP_EOL;

			if($attr['default'] != null){

					echo "\t\t".'<default>'.$attr['default'].'</default>'.PHP_EOL;
   				echo "\t".'</attribute>'.PHP_EOL;
			}
		}

		return ob_get_clean();
	}


	public function __toString(){

		ob_start();

		if(count($this->_static) > 0){

			echo '<attributes class="node" mode="static">'.PHP_EOL;
			echo $this->attributes($this->_static);
			echo '</attributes>'.PHP_EOL;
		}

		if(count($this->_dynamic) > 0){

			echo '<attributes class="node" mode="dynamic">'.PHP_EOL;
			echo $this->attributes($this->_dynamic);
			echo '</attributes>'.PHP_EOL;
		}

		return ob_get_clean();
	}

}
?>
