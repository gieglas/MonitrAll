<?php
/**
 * MonitrAll - Monitor anything 
 *
 * @author      Constantinos Evangelou <gieglas@gmail.com>
 * @copyright   2013,2014 Constantinos Evangelou
 * @link        http://_________
 * @license     The MIT License (MIT)
 * @version     2.0
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
 * Index
 *
 * ________________________________________________________
 *
 * @package 
 * @author  Constantinos Evangelou <gieglas@gmail.com>
 * @since   Version 1.0
 * @since Version 2.0 Added support for authmon.
 */

/*TODO: Restrict depending on access level all functions
dependency : slim

				extension=php_pdo_sqlsrv_53_ts.dll in php.ini and Microsoft SQL Server 2008 R2 Native Client http://craigballinger.com/blog/2011/08/usin-php-5-3-with-mssql-pdo-on-windows/
				FOR oci ORACLE, need instantclient_12_1 and add its path to PATH in SYSTEM Enviromental Variables. Note Oracle supports 2 versions down so select your client version properly
				FOR Sybase the PDO_ODBC is used. In order to work must have Sybase ASE ODBC Driver which comes with the SDK. 
*/
require_once 'common.php';
require 'Slim/Slim.php';
require_once '../authmon/api/authmon.php';

$app = new Slim();
$app->post('/syncServices/:name','syncServices');
$app->post('/getResults/:name', 'getResults');
$app->get('/getResultsGroupList', 'getResultsGroupList');
$app->post('/getConnectionsList', 'getConnectionsList');
/*$app->post('/processForm', 'processForm');
$app->get('/test','doTest');*/
$app->run();

//---------------------------------------------------------------
function getConnectionsList() {
	
	$arrColumns = array(); 
	//loop through the array to find the desired string
	foreach(_getMonitrallObjects("Connections") as $res) {
		array_push($arrColumns,array("name"=>$res["id"], "value"=>$res["id"]));				
	}

	echo json_encode($arrColumns). '  ';
}

//---------------------------------------------------------------
function syncServices($name) {
	//the request data must be of the format:
	// [{'name':'PROCESSNAME','data':'PROCESSDATA'},{'name':'PROCESSNAME','data':PROCESSDATA}]
	//	PROCESSNAME = 'getResultsGroupList' | 'getResults' | 'processForm'
	//	PROCESSDATA Depends on the process. 
	//				For 'getResults' which normally is processed by get
	//				the PROCESSDATA is a string with the id of the result e.g. 'TestPercent'
	//				for 'processForm' is an object of type {'name':'FORMNAME','data':FORMDATA}
	
	$request = null;
    $response = null;
	$requestData = null;
	$token='';
	$authmonLogin=null;
	
    //get token etc
    commonRequest(Slim::getInstance(),$request,$response,$requestData,$token);
	
	//check if is authorized
    // login 
    $authmonLogin = new authmon($token);
    if (!$authmonLogin->isAuthorized($name)) {
		//login response object
        $responseObj = feedbackResponse('Not Authorized.');
        //response status = 401 Unauthorized
        echo json_encode($responseObj) . '  ';
        $response->status(401);
        return false;		
	}
	
	$responseStr = "[";
	$i = 0;
	foreach($requestData as $res) {
		//get the name of the process
		$name = $res->name;
		switch ($name) {
			/*case 'getResultsGroupList':
				$groups=array();				
				$responseStr = $responseStr . ($i==0?'':',') . '{"name":"' . $name . '","data":' . _getGroupData(_getMonitrallObjects("Groups"),_getMonitrallObjects("Results"),_getMonitrallObjects("Forms"),_getMonitrallObjects("Dashboards")) . "}";
				break;*/
			case 'getResults':
				$resultName = $res->data->name;
				$dataIn = $res->data->data;
				$responseStr = $responseStr . ($i==0?'':',') . '{"name":"' . $name . '","data":' . _getData($resultName,_getMonitrallObjects("Results",$resultName),_getMonitrallObjects("FormsByResultId",$resultName),_getMonitrallObjects("Connections"),$dataIn) . "}";
				break;
			case 'processForm':				
				$dataIn = $res->data;
				$responseStr = $responseStr . ($i==0?'':',') . '{"name":"' . $name . '","data":' . _doForm($dataIn,_getMonitrallObjects("Forms",$dataIn->name),_getMonitrallObjects("Connections")) . "}";
				break;
		}
		$i++;
	}
	$responseStr = $responseStr . ']';
	echo $responseStr . '  ';
}
//---------------------------------------------------------------
function getResultsGroupList() {
    $request = null;
    $response = null;
	$requestData = null;
	$token='';
	$authmonLogin=null;
	
    //get token etc
    commonRequest(Slim::getInstance(),$request,$response,$requestData,$token);
    //check if is logged
    // login 
    $authmonLogin = new authmon($token);
    if (!$authmonLogin->isLoggedIn()) {
        //login response object
        $responseObj = feedbackResponse('Not Authorized.');
        //response status = 401 Unauthorized
        echo json_encode($responseObj) . '  ';
        $response->status(401);
        return false;
    }
    //TODO: HERE: isLoggedIn OR isAuthorized
	echo _getGroupData(_getMonitrallObjects("Groups",null, $authmonLogin->id, $authmonLogin->isAdmin),_getMonitrallObjects("Results",null, $authmonLogin->id, $authmonLogin->isAdmin),_getMonitrallObjects("Forms", null, $authmonLogin->id, $authmonLogin->isAdmin),_getMonitrallObjects("Dashboards", null, $authmonLogin->id, $authmonLogin->isAdmin),$authmonLogin->id, $authmonLogin->isAdmin). '  ';
}


//---------------------------------------------------------------
function getResults($name) {	
	$request = null;
    $response = null;
	$requestData = null;
	$token='';
	$authmonLogin=null;
	
    //get token etc
    commonRequest(Slim::getInstance(),$request,$response,$requestData,$token);
    //check if is authorized
    // login 
    $authmonLogin = new authmon($token);
    if (!$authmonLogin->isAuthorized($name)) {
		//login response object
        $responseObj = feedbackResponse('Not Authorized.');
        //response status = 401 Unauthorized
        echo json_encode($responseObj) . '  ';
        $response->status(401);
        return false;		
	}
    
	//get the response data
	$parameters = $requestData;

	echo _getData($name,_getMonitrallObjects("Results",$name),_getMonitrallObjects("FormsByResultId",$name),_getMonitrallObjects("Connections"),$parameters). '  ';
}

//---------------------------------------------------------------
/*function processForm() {
	$request = Slim::getInstance()->request();

	//get the response data
	$requestData = json_decode($request->getBody());
	
	echo _doForm($requestData,_getMonitrallObjects("Form",$requestData->name),_getMonitrallObjects("Connections"));
}



function doTest(){

	//_getNotifications();
	
	//echo json_encode(_getMonitrallObjects("Results"));
	echo _printCompareResult(array(_getResultCompareData("TestPercent")));
	//print_r(_getResultCompareData("PingTest"));
	
}*/

?>