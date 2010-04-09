<?php
if(!defined('_IN'))
	exit();
	
interface Validator
{
	function __construct();
	function check($what);
	function errorText();
}

?>