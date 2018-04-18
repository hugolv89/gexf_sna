<?php
// Delete GEXF file

$filename = (string)get_input('filename');

\GEXFSNA\File\Manager::deleteGEXF($filename);

forward(REFERRER);

?>
