<?php
/**
 * MonitrAll - Monitor anything 
 *
 * @author      Constantinos Evangelou <gieglas@gmail.com>
 * @copyright   2013,2014 Constantinos Evangelou
 * @link        http://_________
 * @license     The MIT License (MIT)
 * @version     1.2.2
 *
 * MIT LICENSE
 *
 * The MIT License (MIT)
 * 
 * Copyright (c) 2013 Constantinos Evangelou
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *  
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * customNotifications
 *
 * ________________________________________________________
 *
 * @package 
 * @author  Constantinos Evangelou <gieglas@gmail.com>
 * @since   Version 1.0
 */

/*must use some kind of scheduler e.g. windows schedule tasks 
e.g. C:\php\php.exe  -f C:\Code\htdocs\monitrall\api\customMotifications.php resultName1,resultName2,resultName3 red|orange|green|all [email@company.com,other@company.com]
working dir  C:\Code\htdocs\monitrall\api\

C:\Code\xampp\php\php.exe 
-f C:\Users\cevangelou\Dropbox\Gov\htdocs\monitrall\api\customNotifications.php PingTest,TestPercent Red email@company.com,other@company.com

*/

require_once 'common.php';
require_once '../lib/swift/swift_required.php';
//check that this is run from te command line
if (!_is_cli()) {
	echo "This script can only be run from the command line";
} else {
	if ($argc < 3) {
		echo "This is a command line PHP script with 3 arguments.";
	} else {
		//get the result names from the arguments
		$resultNames = explode(",",$argv[1]);    
		$compareDataArr = array();
		foreach($resultNames as $resultName) {
			//get compare data
			$compareData = _getResultCompareData($resultName);
			print_r($compareData);
			switch ($argv[2]) {
				case 'red':
					if ($compareData->hasRed) {
						array_push($compareDataArr,$compareData);
					}
					break;
				case 'orange':
					if ($compareData->hasOrange) {
						array_push($compareDataArr,$compareData);
					}
					break;
				case 'green':
					if ($compareData->hasGreen) {
						array_push($compareDataArr,$compareData);
					}
					break;
				default:
					array_push($compareDataArr,$compareData);
					break;
			}		
		}
		// Send notifications via email	
		echo count($compareDataArr);
		if (count($compareDataArr) > 0) {
			_sendNotificationEmail($compareDataArr,$argv[3]);
		}
	}
}

?>