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
 * Common
 *
 * ________________________________________________________
 *
 * @package 
 * @author  Constantinos Evangelou <gieglas@gmail.com>
 * @since   Version 1.0
 */

require_once 'config/monitrallQueries.php';
require_once 'config/config.php';

//---------------------------------------------------------------
//-------PRIVATE
function _getData($name,$itemsData,$formData,$connections,$parameters = array(),$format="JSON") {
	//run code depending on provider ... e.g. handle differently mySQL with SQL Server and execute
	switch ($connections[$itemsData[$name]["connection"]]["provider"])
	{		
	case "mysql":
	case "sqlsrv":
	case "oci":
	case "SYBASE" :
	//----------------------- PDO SERVERS ------------------------
		//declare the SQL statement that will query the database
		// if the paramters are passed and the first parameter is filterName then use the forms query		
		if ((count($parameters)>0) && ($parameters[0] != null)  && ($parameters[0]->name == "filterName")) {
			//form			
			$query = $formData[$parameters[0]->value]["query"];
		} else {			
			$query = $itemsData[$name]["query"];
		}
		try {
			//get connection
			$conn = _getOpenPDOConnection($connections[$itemsData[$name]["connection"]]);
			//execute the SQL statement and return records
			$st = $conn->prepare($query);

			//add parameters
			foreach($parameters as $parameterData) {			
				//return ':'.$parameterData->name . ' ' . $parameterData->value;
				if ($parameterData->name != "filterName") {
					$st->bindParam(':'.$parameterData->name,$parameterData->value);				
				}				
			}
			
			$st->execute();
			$rs=$st->fetchAll(PDO::FETCH_ASSOC);
			
			//depending on the format return the appropriate type
			if ($format=="JSON") {
				return json_encode($rs);	
			}
			else {
				return $rs;
			}
			
			$rs = null;
			$conn = null;
		} catch(exception $e) { 
			return '{"error":{"text":"'. $e->getMessage() .'"}}'; 
		} 
		break;
	//----------------------- PDO SERVERS ------------------------
	case "WEBSERVICE":
	//----------------------- WEB SERVICE ------------------------
		try {
			//declare the SQL statement that will query the database
			// if the paramters are passed and the first parameter is filterName then use the forms query		
			if ((count($parameters)>0) && ($parameters[0] != null)  && ($parameters[0]->name == "filterName")) {
				//form
				$query = $formData[$parameters[0]->value]["query"];
			} else {
				$query = $itemsData[$name]["query"];
			}
			$i=0;
			//add parameters
			foreach($parameters as $parameterData) {
				if ($parameterData->name != "filterName") {
					$query = $query . ($i==0?'?':'&');			
					$query = $query . urlencode($parameterData->name). '=' . urlencode($parameterData->value);
					$i++;
					//echo ':'.$parameterData->name . ' ' . $parameterData->value;
				}				
			}
			//use global $monitrall_options
			global $monitrall_options;
			$aContext = array();

			$out = "";
			if ($monitrall_options["proxy"]) {
				// Define a context for HTTP.
				$aContext = array(
				    'http' => array(
				        'proxy' => $monitrall_options["proxy"], // This needs to be the server and the port of the NTLM Authentication Proxy Server.
				        'request_fulluri' => True,
				        ),
				    );
				$cxContext = stream_context_create($aContext);
				//get file contents
				$out = file_get_contents($query,False, $cxContext);			
			} else {
				$out = file_get_contents($query);			
			}

			//depending on the format return the appropriate type
			if ($format=="JSON") {
				return $out;
			}
			else {				
				return json_decode($out,true);	
			}

		} catch(exception $e) { 
			return '{"error":{"text":"'. $e->getMessage() .'"}}'; 
		} 
	break;
	//----------------------- END WEB SERVICE --------------------
	case "EXECUTE":
	//----------------------- EXECUTE ------------------------
		try {
			//declare the SQL statement that will query the database
			// if the paramters are passed and the first parameter is filterName then use the forms query		
			if ((count($parameters)>0) && ($parameters[0] != null)  && ($parameters[0]->name == "filterName")) {
				//form
				$query = $formData[$parameters[0]->value]["query"];
			} else {
				$query = $itemsData[$name]["query"];
			}			
			$result = "";
			
			//add parameters
			foreach($parameters as $parameterData) {	
				if ($parameterData->name != "filterName") {
					$query = $query . ' ' . urlencode($parameterData->name). '=' . urlencode($parameterData->value);
				}			
			}	
			//execute query
			exec($query,$result);	

			// read result array and get the result
			// input for MonitrAll is anything that comes after "<MonitrAll>"
			$returnStr = "";
			$isReturnLine=false;
			foreach($result as $resultLine) {
				if ($isReturnLine){
					$returnStr = $returnStr.$resultLine;
				}
				if ( $resultLine == "<MonitrAll>") {
					$isReturnLine=true;
				}				
			}
			
			//depending on the format return the appropriate type
			if ($format=="JSON") {
				return $returnStr;	
			}
			else {				
				return json_decode($returnStr,true);	
			}

		} catch(exception $e) { 
			return '{"error":{"text":"'. $e->getMessage() .'"}}'; 
		} 
	break;
	//----------------------- END EXECUTE --------------------
	}	
}
//---------------------------------------------------------------
//-------PRIVATE
function _doForm($requestData,$formData,$connections,$format="JSON") {
	//get the response data
	$formDataIn = $requestData;
	
	
	//echo '{"success":{"text":"'.json_encode($formData) .'"}}'; 
	//get the id of the form
	$name = $formDataIn->name;
	//echo '{"success":{"text":"'.json_encode($formDataIn) .'"}}'; 

	//run code depending on provider ... e.g. handle differently mySQL with SQL Server
	switch ($connections[$formData[$name]["connection"]]["provider"]) {
	case "mysql":
	case "sqlsrv":
	case "oci":
	case "SYBASE" :
	//----------------------- PDO SERVERS ------------------------
		//declare the SQL statement that will query the database		
		$query = $formData[$name]["query"];
		try {
			//get connection
			$conn = _getOpenPDOConnection($connections[$formData[$name]["connection"]]);
			//execute the SQL statement and return records
			$st = $conn->prepare($query);
						
			//add parameters
			foreach($formDataIn->data as $fieldData) {			
				$st->bindParam(':'.$fieldData->name,$fieldData->value);
				//echo ':'.$fieldData->name . ' ' . $fieldData->value;
			}			
			$st->execute();							

			$rs = null;
			$conn = null;
			
			//if no error return success
			//depending on the format return the appropriate type
			if ($format=="JSON") {
				return '{"success":{"text":"Success"}}'; 
			} else {
				return array("success" => array ("text" => "success"));
			}
			
			
		} catch(exception $e) { 
			//depending on the format return the appropriate type
			if ($format=="JSON") {
				return '{"error":{"text":"'. $e->getMessage() .'"}}'; 
			} else {
				return array("error" => array ("text" => $e->getMessage()));
			}	
		} 
		break;
	//----------------------- PDO SERVERS ------------------------
	case "WEBSERVICE":
	//----------------------- WEB SERVICE ------------------------
		try {
			//declare the SQL statement that will query the database		
			$query = $formData[$name]["query"];
			$i=0;
			//add parameters
			foreach($formDataIn->data as $fieldData) {
				$query = $query . ($i==0?'?':'&');			
				$query = $query . urlencode($fieldData->name). '=' . urlencode($fieldData->value);
				$i++;
				//echo ':'.$fieldData->name . ' ' . $fieldData->value;
			}

			//use global $monitrall_options
			global $monitrall_options;
			$aContext = array();

			if ($monitrall_options["proxy"]) {
				// Define a context for HTTP.
				$aContext = array(
				    'http' => array(
				        'proxy' => $monitrall_options["proxy"], // This needs to be the server and the port of the NTLM Authentication Proxy Server.
				        'request_fulluri' => True,
				        ),
				    );
				$cxContext = stream_context_create($aContext);
				//get file contents
				return file_get_contents($query,False, $cxContext);			
			} else {
				return file_get_contents($query);			
			}

		} catch(exception $e) { 
			return '{"error":{"text":"'. $e->getMessage() .'"}}'; 
		} 
	break;
	//----------------------- END WEB SERVICE --------------------
	case "EXECUTE":
	//----------------------- EXECUTE ------------------------
		try {
			//declare the SQL statement that will query the database		
			$query = $formData[$name]["query"];	
			$result = "";
				
			//add parameters
			foreach($formDataIn->data as $fieldData) {				
				$query = $query . ' ' . urlencode($fieldData->name). '=' . urlencode($fieldData->value);
				//echo ':'.$fieldData->name . ' ' . $fieldData->value;
			}
			//execute query
			exec($query,$result);			
			
			// read result array and get the result
			// input for MonitrAll is anything that comes after "<MonitrAll>"
			$returnStr = "";
			$isReturnLine=false;
			foreach($result as $resultLine) {
				if ($isReturnLine){
					$returnStr = $returnStr.$resultLine;
				}
				if ( $resultLine == "<MonitrAll>") {
					$isReturnLine=true;
				}				
			}

			return $returnStr;			

		} catch(exception $e) { 
			return '{"error":{"text":"'. $e->getMessage() .'"}}'; 
		} 
	break;
	//----------------------- END EXECUTE --------------------
	}
}
//--------------------------------------------------------------
//-------PRIVATE
function _getOpenPDOConnection($connection) {
	
	$myProvider = $connection["provider"];
	$myServer = $connection["server"];
	$myUser = $connection["user"];
	$myPass = $connection["pass"];
	$myDB = $connection["name"]; 
	$myPort = $connection["port"]; 
	
	//define connection string, specify database driver
	switch ($myProvider) {
	case "mysql":
		$connStr = "mysql:host=".$myServer.";dbname=".$myDB; 
		$conn = new PDO($connStr,$myUser,$myPass);			
		break;
	case "sqlsrv":
		$connStr = "sqlsrv:Server=".$myServer.";Database=".$myDB; 
		$conn = new PDO($connStr,$myUser,$myPass);	
		break;
	case "oci":
		$tns = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$myServer.")(PORT = ".$myPort.")))(CONNECT_DATA=(SID=".$myDB.")))"; 
		$connStr = "oci:dbname=".$tns.";charset=utf8"; 		
		$conn = new PDO($connStr,$myUser,$myPass);	
		$conn->setAttribute(PDO::ATTR_AUTOCOMMIT,TRUE);		
		break;
	case "SYBASE":
		$connStr = "odbc:Driver={Adaptive Server Enterprise};server=".$myServer.";port=".$myPort.";db=".$myDB;
		$conn = new PDO($connStr,$myUser,$myPass);	
		break;
	}
	
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $conn;
}
//--------------------------------------------------------------
//-------PRIVATE
function _getGroupData($groupData,$itemsData,$formsData) {
	$arrColumns = array(); 
	$i = 0;
	foreach($groupData as $res) {
		//set the array index num
		$res["index_num"] = $i;		
		$arrColumns[$i] = $res;
		//add items in the Group from groupData
		$arrColumns[$i]["items"] = _getGroupItemsArray($itemsData,$formsData,$res["id"],$i);
		$i++;
	}
	return json_encode($arrColumns);	
}

//--------------------------------------------------------------
//-------PRIVATE
function _getGroupItemsArray($data,$formsData,$id,$groupIndexNum) {
	$arrColumns = array(); 
	$i = 0;	
	//loop through the array to find the desired string
	foreach($data as $res) {		
		if ((strtolower($res["group_id"]) == strtolower($id)) && ($res["display"] == 1) ) {
			$res["connection"] = "";
			$res["query"] = "";
			$res["group_index_num"] = $groupIndexNum;
			//set the array index num
			$res["index_num"] = $i;
			//add forms in these items 
			$res["forms"] = _getItemsFormsArray($formsData,$res["id"]);
			$res["lineForms"] = _getItemsLinesFormsArray($formsData,$res["id"]);
			$arrColumns[$i] = $res;
			$i++;
		}		
	}
	return $arrColumns;
}

//--------------------------------------------------------------
//-------PRIVATE
function _getItemsFormsArray($formsData,$id) {
	$arrColumns = array(); 
	$i = 0;	
	//loop through the array to find the desired string
	foreach($formsData as $res) {		
		if ((strtolower($res["parent_id"]) == strtolower($id)) && ($res["scope"] == "results")){
			$res["connection"] = "";
			$res["query"] = "";		
			//set the array index num
			$res["form_index_num"] = $i;	
			$arrColumns[$i] = $res;
			$i++;
		}		
	}
	return $arrColumns;
}
//--------------------------------------------------------------
//-------PRIVATE
function _getItemsLinesFormsArray($formsData,$id) {
	$arrColumns = array(); 
	$i = 0;	
	//loop through the array to find the desired string
	foreach($formsData as $res) {		
		if ((strtolower($res["parent_id"]) == strtolower($id)) && ($res["scope"] == "line")){
			$res["connection"] = "";
			$res["query"] = "";		
			//set the array index num
			$res["form_index_num"] = $i;	
			$arrColumns[$i] = $res;
			$i++;
		}		
	}
	return $arrColumns;
}
//--------------------------------------------------------------
//-------PRIVATE
function _getMonitrallGroupsFromDB($name = null) {
	//use global $results_config
	global $monitrall_results_config;		
	//check if a name has been passed 
	if ($name != null) {
		$parameterObj=new stdClass();
		$parameterObj->name="id";
		$parameterObj->value=$name;
		//return the groups array using name in parameters 
		return _getData("MonitrallGroupsById",$monitrall_results_config,array(),_getMonitrallObjects("Connections"),array($parameterObj),"ARRAY");	
	} else {
		//return the groups array
		return _getData("MonitrallGroups",$monitrall_results_config,array(),_getMonitrallObjects("Connections"),array(),"ARRAY");	
	}	
}
//--------------------------------------------------------------
//-------PRIVATE
function _getMonitrallResultsFromDB($name = null) {
	//use global $results_config
	global $monitrall_results_config;		
	$returnObject = array();
	$i = 0;
	//check if a name has been passed 
	if ($name != null) {
		$parameterObj=new stdClass();
		$parameterObj->name="id";
		$parameterObj->value=$name;
		//return the results array using name in parameters 
		$dbObject = _getData("MonitrallResultsById",$monitrall_results_config,array(),_getMonitrallObjects("Connections"),array($parameterObj),"ARRAY");	
	} else {
		//return the results array
		$dbObject = _getData("MonitrallResults",$monitrall_results_config,array(),_getMonitrallObjects("Connections"),array(),"ARRAY");	
	}	
	foreach($dbObject as $res) {
		$returnObject[$res["id"]] = $res;
	}
	
	return $returnObject;
}
//--------------------------------------------------------------
//-------PRIVATE
function _getMonitrallNotificationResults() {
	//use global $results_config
	global $monitrall_results_config;		
	$returnObject = array();
	$i = 0;

	//return the results array
	$dbObject = _getData("MonitrallNotificationResults",$monitrall_results_config,array(),_getMonitrallObjects("Connections"),array(),"ARRAY");	
	
	foreach($dbObject as $res) {
		$returnObject[$res["id"]] = $res;
	}
	
	return $returnObject;
}
//--------------------------------------------------------------
//-------PRIVATE
function _updateNotificationsNextDate($idIn,$nextDateIn) {
	//use global $results_config
	global $monitrall_results_config;	
	$requestData=new stdClass();
	$params = array();	

	$requestData->name = "MonitrallUpdateNotifications";	

	$parameterObj=new stdClass();
	$parameterObj->name = "idIn";
	$parameterObj->value = $idIn;
	array_push($params,$parameterObj);
	$parameterObj=new stdClass();
	$parameterObj->name = "nextDateIn";
	$parameterObj->value = $nextDateIn;
	array_push($params,$parameterObj);
	$requestData->data = $params;
	
	$returnObject = _doForm($requestData,$monitrall_results_config,_getMonitrallObjects("Connections"),$format="ARRAY")	;	

	return $returnObject;
}


//--------------------------------------------------------------
//-------PRIVATE
function _getMonitrallFormsFromDB($name = null,$by = "id") {
	//use global $results_config
	global $monitrall_results_config;		
	$returnObject = array();
	$i = 0;
	//check if a name has been passed 
	if ($name != null) {
		$parameterObj=new stdClass();
		$parameterObj->name="id";
		$parameterObj->value=$name;
		$resultname = "";
		if ($by == "resultid") {
			$resultname = "MonitrallFormsByResultId";
		} else {
			$resultname = "MonitrallFormsById";
		}
		//return the forms array using name in parameters 
		$dbObject = _getData($resultname,$monitrall_results_config,array(),_getMonitrallObjects("Connections"),array($parameterObj),"ARRAY");	
	} else {
		//return the forms array
		$dbObject = _getData("MonitrallForms",$monitrall_results_config,array(),_getMonitrallObjects("Connections"),array(),"ARRAY");	
	}	
	foreach($dbObject as $res) {
		$returnObject[$res["id"]] = $res;
		$parameterObj=new stdClass();
		$parameterObj->name="formid";
		$parameterObj->value=$res["id"];
		$returnObject[$res["id"]]["fields"]=_getData("MonitrallFieldsByForm",$monitrall_results_config,array(),_getMonitrallObjects("Connections"),array($parameterObj),"ARRAY");	
	}
	
	return $returnObject;
}
//-------------------------------------------------------------
//-------PRIVATE
function _getMonitrallObjects($objectType,$name = null){
	//use global $monitrall_options
	global $monitrall_options;

	$returnObject = array();
		//get from database
		switch ($objectType) {
			case "Groups":
				$returnObject=_getMonitrallGroupsFromDB($name);
			break;
			case "Results":				
				$returnObject = _getMonitrallResultsFromDB($name);
			break;
			case "Forms":
				$returnObject = _getMonitrallFormsFromDB($name,"id");
			break;
			case "FormsByResultId":
				$returnObject = _getMonitrallFormsFromDB($name,"resultid");
			break;
			case "NotificationResults":
				$returnObject = _getMonitrallNotificationResults();
			break;
			case "Connections":
				//use global $db_connections
				global $db_connections;
				$returnObject = $db_connections;	
			break;
		}			
	return $returnObject;
}
//-------------------------------------------------------------
//-------PRIVATE
function _compare ($post, $operator, $value) {
	switch ($operator) {
	case '>':   return $post > $value; break;
	case '<':   return $post < $value;break;
	case '>=':  return $post >= $value;break;
	case '<=':  return $post <= $value;break;
	case '==':  return $post == $value;break;
	case '!=':  return $post != $value;break;
	case '===': return $post === $value;break;
	case '!==': return $post !== $value;break;
	case '><': 
		$splitValue = explode (" ",$value);
		return $post > $splitValue[0] && $post < $splitValue[1] ;
		break;
	}
}
//-------------------------------------------------------------
//-------PRIVATE
function _getResultCompareData($name) {
	$res = _getMonitrallObjects("Results",$name);
	//get Data
	$resultDataArr = _getData($name,$res,array(),_getMonitrallObjects("Connections"),array(),"array");
	$hasRed=false;
	$hasGreen=false;
	$hasOrange=false;
	// for each row in the result data
	for ($i = 0; $i < count($resultDataArr); $i++) {
		$resultDataArr[$i]["isRed"] =false;
		//check red if exists	
		if (($res[$name]["condition_red_operator"] != "") && ($res[$name]["condition_red_value"]!= "")) {
			//compare to see if condition is met
			if (_compare($resultDataArr[$i]["value"],$res[$name]["condition_red_operator"],$res[$name]["condition_red_value"]) == 1){						
				$hasRed = true;
				$resultDataArr[$i]["isRed"] =true;
			} else {
				$resultDataArr[$i]["isRed"] =false;
			}
		}
		$resultDataArr[$i]["isGreen"] =false;
		//check green if exists					
		if (($res[$name]["condition_green_operator"] != "") && ($res[$name]["condition_green_value"]!= "")) {						
			//compare to see if condition is met
			if (_compare($resultDataArr[$i]["value"],$res[$name]["condition_green_operator"],$res[$name]["condition_green_value"]) == 1){		
				$hasGreen = true;
				$resultDataArr[$i]["isGreen"] =true;
			} else {
				$resultDataArr[$i]["isGreen"] =false;
			}	
		}
		$resultDataArr[$i]["isOrange"] =false;
		//check orange if exists
		if (($res[$name]["condition_orange_operator"] != "") && ($res[$name]["condition_orange_value"]!= "")) {						
			//compare to see if condition is met
			if (_compare($resultDataArr[$i]["value"],$res[$name]["condition_orange_operator"],$res[$name]["condition_orange_value"]) == 1){
				$hasOrange=true;
				$resultDataArr[$i]["isOrange"] =true;
			} else {
				$resultDataArr[$i]["isOrange"] =false;
			}	
		}
	}

	//create result obj
	$resultDataArrObj=new stdClass();
	$resultDataArrObj->name=$res[$name]["name"];
	$resultDataArrObj->id=$name;
	$resultDataArrObj->description=$res[$name]["description"];
	$resultDataArrObj->hasRed=$hasRed;
	$resultDataArrObj->hasGreen=$hasGreen;
	$resultDataArrObj->hasOrange=$hasOrange;
	$resultDataArrObj->data=$resultDataArr;

	return $resultDataArrObj;
}
//-------------------------------------------------------------
//-------PRIVATE
function _printCompareResult($reportRes,$bodyTop ="",$bodyBottom=""){
	//TODO: Use mustage
	global $monitrall_options;

	$htmlOut="";
	
	$htmlOut.= "<!DOCTYPE html>";
	$htmlOut.= "<head>";
	$htmlOut.= "<style>";
	$htmlOut.= ' body {font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 14px;line-height: 20px;color: #333;}';
	$htmlOut.= ' h4 {font-size: 17.5px;margin: 10px 0;font-family: inherit;font-weight: bold;line-height: 20px;}
		   .box-error-clrs {background: #d24726; color: #ffffff; border-color: #d24726;}
		   .box-success-clrs {background: #82ba00; color: #ffffff; border-color: #82ba00;}		   
		   .table {width: 100%;}		   
		   .table td {padding: 8px; line-height: 20px; text-align: left; vertical-align: top; border-top: 1px solid #dddddd;}
		   ';

	$htmlOut.= "</style>";
	$htmlOut.= "</head>";
	$htmlOut.= "<body>";
	$htmlOut.= "<body style='font-family: \"Helvetica Neue\",Helvetica,Arial,sans-serif;font-size: 14px;line-height: 20px;color: #333;'>";
	$htmlOut.= $bodyTop;
	//print results 
	foreach ($reportRes as $obj ) {
		$htmlOut.= ("<h4 style='font-size: 17.5px;margin: 10px 0;font-family: inherit;font-weight: bold;line-height: 20px;'><a href='".$monitrall_options["webaddress"]."/#results/".$obj->id."'>".$obj->name."</a></h4>");
		$htmlOut.= ("<div>".$obj->description."</div>");
		$htmlOut.= ("<br><table style='width: 100%;' cellpadding='0' cellspacing='0' border='0'>");
		$htmlOut.= ("<thead><tr><th>Value</th><th>Name</th></tr></thead>");
		$htmlOut.= ("<tbody>");
		foreach ($obj->data as $dataObj ) {
			//background: #82ba00; color: #ffffff; border-color: #82ba00;
			$htmlOut.=("  <tr><td style='padding: 8px; line-height: 20px; text-align: left; vertical-align: top; border-top: 1px solid #dddddd; "
				.($dataObj['isGreen']?"background: #82ba00; color: #ffffff; border-color: #82ba00;":"")
				.($dataObj['isRed']?"background: #d24726; color: #ffffff; border-color: #d24726;":"")								
				.($dataObj['isOrange']?"background: #ff8f32;color: #ffffff; border-color: #ff8f32;":"")
				."'>".$dataObj['value']."<td style='padding: 8px; line-height: 20px; text-align: left; vertical-align: top; border-top: 1px solid #dddddd;'>".$dataObj['name']."</td></tr>");
		}		
		$htmlOut.= ('</tbody></table><hr>');
	}	
	$htmlOut.= $bodyBottom;
	$htmlOut.="<br><a href='".$monitrall_options["webaddress"]."'>MonitrAll<a/>";
	$htmlOut.= "</body>";
	return $htmlOut;

}
//-------------------------------------------------------------
//-------PRIVATE
function _sendNotificationEmail($reportRes,$eMails=null){
	global $monitrall_options;
	global $monitrall_notifications_options;
	// Create the SMTP configuration
	$transport = Swift_SmtpTransport::newInstance($monitrall_options["mailserveraddress"], $monitrall_options["mailserverport"]);
	
	// Create the message
	$message = Swift_Message::newInstance();
	//$message->setTo();
	//$message->setCc();
	$message->setContentType("text/html");
	//if eMails are set on command prompt then send to those else to default	
	if ($eMails) {
		$message->setBcc(explode(",",$eMails));
	} else {
		$message->setBcc($monitrall_notifications_options["email"]["to"]);
	}
	$message->setSubject(_replaceSpecialTags($monitrall_notifications_options["email"]["subject"]));
	$message->setBody(_printCompareResult($reportRes,$monitrall_notifications_options["email"]["bodytop"],$monitrall_notifications_options["email"]["bodybottom"]));
	$message->setFrom($monitrall_notifications_options["email"]["from"]);	
	 
	// Send the email
	$mailer = Swift_Mailer::newInstance($transport);
	$mailer->send($message, $failedRecipients);
	 
	// Show failed recipients	
	print_r($failedRecipients);
}
//-------------------------------------------------------------
//-------PRIVATE
function _replaceSpecialTags($strIn) {
	$now = new DateTime();
	$strOut = $strIn;
	$strOut = str_replace("#dd#", $now->format("d"),$strOut);
	$strOut = str_replace("#mm#", $now->format("m"),$strOut);
	$strOut = str_replace("#yyyy#", $now->format("Y"), $strOut);

	return $strOut;
}
//-------------------------------------------------------------
//-------PRIVATE
/*Check if it is run on commandline*/
function _is_cli()
{	
	echo  php_sapi_name() . "<br>";
    return php_sapi_name() === 'cli';
}
?>