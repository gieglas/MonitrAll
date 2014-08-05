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
 * customStats
 *
 * ________________________________________________________
 *
 * @package 
 * @author  Constantinos Evangelou <gieglas@gmail.com>
 * @since   Version 1.0
 */

/*must use some kind of scheduler e.g. windows schedule tasks 
e.g. C:\php\php.exe  -f C:\Code\htdocs\monitrall\api\customStats.php resultName1,resultName2,resultName3
working dir  C:\Code\htdocs\monitrall\api\

C:\Code\xampp\php\php.exe - f C:\Users\cevangelou\Dropbox\Gov\htdocs\monitrall\api\customStats.php PingTest,TestPercent 

*/

require_once 'common.php';
require_once '../lib/swift/swift_required.php';
//check that this is run from te command line
if (!_is_cli()) {
	echo "This script can only be run from the command line";
} else {
	if ($argc != 2) {
		echo "This is a command line PHP script with 2 arguments.";
	} else {
		//get the result names from the arguments
		$resultNames = explode(",",$argv[1]);    
		foreach($resultNames as $resultName) {
			//get compare data
			$compareData = _getResultCompareData($resultName);
			print_r($compareData);
									
			// Insert into stats
			//use global $results_config
			global $monitrall_results_config;				
			//get maxid
			$maxId=0;
			$maxIdArr = _getData("MonitrallMaxStatId",$monitrall_results_config,array(),_getMonitrallObjects("Connections"),array($parameterObj),"ARRAY");									
			$maxId=$maxIdArr[0]['Max_id'];
			//for each result in the data returned
			foreach ($compareData->data as $dataObj ) {				
				$requestData=new stdClass();
				$params = array();	
				$requestData->name = "MonitrallInsertStats";	
				//prepare parameters array of objects
				$parameterObj=new stdClass();
				$parameterObj->name = "stats_id";
				$parameterObj->value = $maxId;
				array_push($params,$parameterObj);
				$parameterObj=new stdClass();
				$parameterObj->name = "result_id";
				$parameterObj->value = $resultName;
				array_push($params,$parameterObj);
				$parameterObj=new stdClass();
				$parameterObj->name = "name";
				$parameterObj->value = $dataObj['name'];
				array_push($params,$parameterObj);
				$parameterObj=new stdClass();
				$parameterObj->name = "value";
				$parameterObj->value = $dataObj['value'];
				array_push($params,$parameterObj);
				$requestData->data = $params;
				//run sql command
				$returnObject = _doForm($requestData,$monitrall_results_config,_getMonitrallObjects("Connections"),$format="ARRAY")	;
				print_r($returnObject);
			}								

		}			
	}
}

?>