<?php

$handle=opendir(".");
$projectContents = '';
while ($file = readdir($handle)) 
{
	if (strpos('.test.php',$file)) 
	{		
		$projectContents .= '<li><a href="'.$file.'">'.$file.'</a></li>';
	}
}
echo $projectContents;
closedir($handle);
?>