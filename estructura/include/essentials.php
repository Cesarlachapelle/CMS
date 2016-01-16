<?php include 'debug0.php';

//Incluir los scripts especificados por cada pagina
foreach($INCL as $a)
	if($a !== '')
		include $a;

include 'temp/template.php';

define('chars', "/['!^*?.~,`&\/:=%$#@+;<>\[\](){}|\"\\\-]/");

function validate($str,$esp_chr=0)
{
	$str = trim($str);
	$str = stripslashes($str);
	$str = htmlspecialchars($str);
	if($esp_chr)
		$str = filter_var($str,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

	return $str;
}

function validateSql($str,$pass=0)
{
	if(!$pass)
	{
		$str = strtolower($str);
		$str = trim($str);
		$str = filter_var($str,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
		$str = preg_replace(constant('chars'), '', $str);
	}
	else
		$str = htmlentities($str);
	
	return $str;
}