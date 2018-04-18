<?php
// Generate GEXF File

$users = (boolean)get_input('users');
$groups = (boolean)get_input('groups');

$opt = '';
if($users) { $opt = 'U'; }
if($groups){ $opt = $opt.'G'; }

$data = new \GEXFSNA\Generator\Data();

$data->showUsers($users);
$data->showGroups($groups);

\GEXFSNA\File\Manager::dumpGEXF($data->getGEXF(),$opt);

forward(REFERRER);

?>
