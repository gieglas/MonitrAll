<?php
function GetXMLAttributeValue ($url,$note,$attrname) {
//from the URL get the value based on note and attribute name
	try {
			ini_set('default_socket_timeout', 5); // 900 Seconds = 15 Minutes
			$fileContents= @file_get_contents($url);
			//check if file could open 
			if($fileContents === FALSE) { 
				return 'ERROR';
			}
			$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
			$fileContents = trim(str_replace('"', "'", $fileContents));			
			$simpleXml = simplexml_load_string($fileContents);			
			if ($note == null) {
				return $simpleXml->attributes()->$attrname;
			} else {
				//split with ,
				$noteArr=  explode(',',$note);
				//get nested note within using the note argument
				foreach($noteArr as $noteArrObj) {
					$simpleXml = $simpleXml->{$noteArrObj};
				}
				//return $simpleXml->$note->attributes()->$attrname;
				//DesignTransactionBody,TransactionContentDetails,TransactionData,DesignDetails,Design,DesignIdentifier
				return $simpleXml;
			}
			
	} catch (Exception $e) {
		echo "ERROR";
	}
}

//get the name
if ((isset($_GET["name"])) && (!empty($_GET["name"]))){
	$name = htmlspecialchars(str_replace(array("\n", "\r", "\t", '"'), '',$_GET["name"]));
} else {
	$name = "";
}	
//get the url
if ((isset($_GET["url"])) && (!empty($_GET["url"]))){
	$url = $_GET["url"];
} else {
	$url = "";
}	
//get the note
if ((isset($_GET["note"])) && (!empty($_GET["note"]))){
	$note = $_GET["note"];
} else {
	$note = null;
}	
//get the attrname
if ((isset($_GET["attrname"])) && (!empty($_GET["attrname"]))){
	$attrname = $_GET["attrname"];
} else {
	$attrname = "";
}	
//get the value
$value=htmlspecialchars(str_replace(array("\n", "\r", "\t", '"'), '',GetXMLAttributeValue($url,$note,$attrname)) );

//http://localhostgit:8080/MonitrAll/api/xmltojson.php?url=http://10.144.72.23:9080/wsi/FNCEWS40MTOM/&note=&attrname=name&name=Internal%20Filenet%20Web%20Service%20Name
//echo the JSON
echo '[{"name":"'.$name.'","value":"'. $value .'"}]';

?>