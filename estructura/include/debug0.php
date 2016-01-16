<?php
	$_dc = $_SERVER["DOCUMENT_ROOT"];
	if(file_exists($_dc . "/include/debug.php"))
		include $_dc . "/include/debug.php";
	else
	{
		if(realpath(".") == $_dc)
			define("root", "/");
		else
		{
			for($temp='./'; true; $temp = $temp == './' ? '../': '../'.$temp)
				if(is_dir($temp . 'include'))
				{
					define('root', $temp);
					unset($temp);
					break;
				}
				elseif(realpath($temp) == realpath($_SERVER['DOCUMENT_ROOT']))
				{
					define('root', '/');
					break;
				}
		}
		ini_set("display_errors",0);
	}
	unset($_dc);

	function Root($txt='',$mode=0) {
		if($mode === 0)
			echo constant('root') . $txt;
		elseif($mode === 1)
			echo $_SERVER['DOCUMENT_ROOT'] . "/$txt";
		else
			echo constant('root') . $txt;
	}