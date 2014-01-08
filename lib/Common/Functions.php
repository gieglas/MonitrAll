<?php
/*
_____ Version: _._._
http://____________._____
*/

//Functions that do not interact with DB
//------------------------------------------------------------------------------
//namespace Gieglas\Common;
class Functions
{
	//Completely sanitizes text
	public static function sanitize($str)
	{
		return strtolower(strip_tags(trim(($str))));
	}

	//@ Thanks to - http://phpsec.org
	public static function generateHash($plainText, $salt = null)
	{
		if ($salt === null)
		{
			$salt = substr(md5(uniqid(rand(), true)), 0, 25);
		}
		else
		{
			$salt = substr($salt, 0, 25);
		}
		
		return $salt . sha1($salt . $plainText);
	}

	//Generate an activation key
	public static function generateActivationToken($gen = null)
	{
		//do
		//{
			$gen = md5(uniqid(mt_rand(), false));
		//}
		//while(validateActivationToken($gen));
		return $gen;
	}

}
?>
