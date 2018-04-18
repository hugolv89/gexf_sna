<?php

namespace GEXFSNA\Generator;

class Data {

	private $_gexf;

	private $_attributes;
	private $_attIDObjects = null;
	private $_attIDType = null;
	private $_attIDAdmin = null;
	private $_attIDParent = null;
	private $_attIDMembers = null;
	private $_attIDPublic = null;

	private $_uNodes = array();
	private $_gIDs = array();
	private $_gNodes = array();
	private $_edges;

	private $_showUsers = true;
	private $_showGroups = true;

	public function __construct(){

		$meta = array(
			'creator' => elgg_echo('gexf_sna:meta:creator'),
			'description' =>  elgg_echo('gexf_sna:meta:description'),
		);

		$this->_gexf = new \GEXFSNA\XML\GEXF($meta);

		$this->_attributes = new \GEXFSNA\XML\Attributes();
		$this->_edges = new \GEXFSNA\XML\Edges();

		$this->_gexf->setAttributes($this->_attributes);
		$this->_gexf->setEdges($this->_edges);

		$this->_attIDObjects = $this->_attributes->addAttribute('Objects','integer');
		$this->_attIDType = $this->_attributes->addAttribute('Type','string','User');

		if($this->_showUsers){
			$this->_attIDAdmin = $this->_attributes->addAttribute('Administrator','boolean');
		}

		if($this->_showGroups){
			$this->_attIDParent = $this->_attributes->addAttribute('Parent','integer', null);
			$this->_attIDMembers = $this->_attributes->addAttribute('Members','integer');
			$this->_attIDPublic = $this->_attributes->addAttribute('PublicMembership','boolean');
		}

		$this->_gexf->setOptions('dynamic','directed', 'dateTime');
	}

	private function userCallBack($entity){

		$uEntity = get_entity($entity->guid);

		$attvalues = array(
			intval($this->_attIDObjects) => $uEntity->countObjects(),
			intval($this->_attIDAdmin) => $uEntity->isAdmin() ? 'true':'false',
		);

		$epoch = $uEntity->getTimeCreated();
		$startDate = date('Y-m-d\Th:m:s', $epoch);

		$color = \GEXFSNA\Utils::uColor($uEntity->isAdmin());

		$viz = array(
			'color' => 'r="'.$color["red"].'" g="'.$color["green"].'" b="'.$color["blue"].'" a="1.0"',
			'shape' => 'value="'.\GEXFSNA\Utils::uShape().'"',
		);

		if(\GEXFSNA\Utils::uLabel()){

			$label = $entity->name;
		}else{

			$label = null;
		}

		$node = new \GEXFSNA\XML\Node($uEntity->getGUID(), $label, $attvalues, $startDate, $viz);

		// Friends Edges

		$friends = $uEntity->getFriends();

		foreach($friends as $friend){

			$this->_edges->addEdge($uEntity->getGUID(), $friend->guid);
		}

		// Add uNode

		array_push($this->_uNodes, $node);
	}

	private function groupCallBack($entity){

		$gEntity = get_entity($entity->guid);

		$parentEntity = elgg_get_entities_from_relationship(array(
			'relationship' => 'au_subgroup_of',
			'relationship_guid' => $gEntity->getGUID(),
			'types' => 'group',
			'inverse_relationship' => false,
			'limit' => 1,
		));

		$isSubgroup = false;
		if(count($parentEntity) > 0){
	
			$isSubgroup = true;
			$parentGUID = $parentEntity[0]->getGUID();

			// Parent Edge

			$color = \GEXFSNA\Utils::gColor($isSubgroup);

			$viz = array(
				'color' => 'r="'.$color["red"].'" g="'.$color["green"].'" b="'.$color["blue"].'" a="1.0"',
			);

			$this->_edges->addEdge($parentGUID, $gEntity->getGUID(),$viz);
		}

		$attvalues = array(
			intval($this->_attIDObjects) => $gEntity->countObjects(),
			intval($this->_attIDType) => 'Group',
			intval($this->_attIDParent) => $parentGUID,
			intval($this->_attIDMembers) => count($gEntity->getMembers()),
			intval($this->_attIDPublic) => $gEntity->isPublicMembership() ? 'true':'false',
		);

		$epoch = $gEntity->getTimeCreated();
		$startDate = date('Y-m-d\Th:m:s', $epoch);

		$color = \GEXFSNA\Utils::gColor($isSubgroup);

		$viz = array(
			'color' => 'r="'.$color["red"].'" g="'.$color["green"].'" b="'.$color["blue"].'" a="1.0"',
			'shape' => 'value="'.\GEXFSNA\Utils::gShape().'"',
		);

		if(\GEXFSNA\Utils::gLabel()){

			$label = $entity->name;
		}else{

			$label = null;
		}

		$node = new \GEXFSNA\XML\Node($gEntity->getGUID(), $label, $attvalues, $startDate, $viz);

		// Owner Edge

		$color = \GEXFSNA\Utils::ownerColor();

		$viz = array(
			'color' => 'r="'.$color["red"].'" g="'.$color["green"].'" b="'.$color["blue"].'" a="1.0"',
		);

		$this->_edges->addEdge($entity->owner_guid, $gEntity->getGUID(),$viz);

		// Members Edges

		$members = $gEntity->getMembers();

		foreach($members as $member){

			$this->_edges->addEdge($gEntity->getGUID(), $member->guid);
		}

		// Add gNode

		array_push($this->_gIDs, intval($gEntity->getGUID()));
		array_push($this->_gNodes, $node);

	}

	private function getUserNodes(){

		return $this->_uNodes;
	}

	private function getGroupNodes(){

		foreach($this->_gIDs as $key => $id){

			if($id != null){
				if($this->_gNodes[$key]->hasChilds()){
					
					continue;
				}else{

					$subgroups = elgg_get_entities_from_relationship(array(
						'relationship' => 'au_subgroup_of',
						'relationship_guid' => $this->_gNodes[$key]->getGUID(),
						'types' => 'group',
						'inverse_relationship' => true,
						'limit' => false,
					));

					if(count($subgroups) > 0){
		
						foreach($subgroups as $e){
							$childArrayID = array_search($e->guid,$this->_gIDs);
							$this->_gIDs[$childArrayID] = null;
							$this->_gNodes[$key]->addChild($this->_gNodes[$childArrayID]);
						}
						
					}
				}
			}
		}

		$nodes = array();
		
		foreach($this->_gIDs as $key => $id){

			if($id != null){
				array_push($nodes, $this->_gNodes[$key]);
			}
		}

		return $nodes;
	}

	public function showUsers($show = true){

		$this->_showUsers = $show;
	}

	public function showGroups($show = true){

		$this->_showGroups = $show;
	}

	public function getGEXF(){

		if($this->_showUsers){

			$uArray = elgg_get_entities(array(
				'types'=> 'user',
				'limit' => false,
			));

			foreach($uArray as $user){

				$this->userCallBack($user);
			}

			foreach($this->getUserNodes() as $node){
				$this->_gexf->addNode($node);
			}

		}

		if($this->_showGroups){

			$gArray = elgg_get_entities(array(
				'types'=> 'group',
				'limit' => false,
			));

			foreach($gArray as $group){

				$this->groupCallBack($group);
			}

			foreach($this->getGroupNodes() as $node){
				$this->_gexf->addNode($node);
			}

		}

		return $this->_gexf;
	}

}
?>
