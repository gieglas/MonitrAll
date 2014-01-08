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
 * Notifications
 *
 * ________________________________________________________
 *
 * @package 
 * @author  Constantinos Evangelou <gieglas@gmail.com>
 * @since   Version 1.0
 */


/*must use some kind of scheduler e.g. windows schedule tasks 
e.g. C:\php\php.exe  -f C:\Code\htdocs\monitrall\api\notifications.php
working dir  C:\Code\htdocs\monitrall\api\*/

require_once 'common.php';
require_once '../lib/swift/swift_required.php';

function _getNotifications(){

	// freq: "SECONDLY" / "MINUTELY" / "HOURLY" / "DAILY" / "WEEKLY" / "MONTHLY" / "YEARLY"
	// interval: 1 / 2 / 3 etc	
	//get the set of result definitions to be checked for notifications
	$notifyResults = _getMonitrallObjects("NotificationResults");
	$reportRes = array();	
	foreach($notifyResults as $res) {
		$isRed = false;
		$isGreen = false;
		$isOrange = false;
		$freqIn = $res["notify_freq"];
		$interval = $res["notify_interval"];
		
		//if no last_notify_time then calculate next time else just run... after all get next run time
		$start_date = new DateTime(	($res["next_notify_date"]?$res["next_notify_date"]:$res["start_notify_date"] )	);	
		$end_date = new DateTime($res["now"]);
		
		$next_date_obj= _getNextNotifyDate($freqIn,$interval,$start_date->format('Y-m-d H:i:s'),$end_date->format('Y-m-d H:i:s'));	

		//check notification must be executed
		if ($next_date_obj['count'] > 0) {
		//check if condition and value exist
			if (($res["condition_red_operator"] != "") && ($res["condition_red_value"]!= "")) {				
				//get compare data
				 $resultDataArrObj=_getResultCompareData($res["id"]);
				 if ($resultDataArrObj->hasRed) {
				 	array_push($reportRes, $resultDataArrObj);
				 }				
			}
			// update thr notification next date
			$updateRtrn = _updateNotificationsNextDate($res["id"],$next_date_obj['next_date']->format('Y-m-d H:i:s'));			

		}				
	}
	// Send notifications via email	
	if (count($reportRes) > 0) {
		_sendNotificationEmail($reportRes);		
	}
}

function _getNextNotifyDate($freq,$interval,$start_date_str,$end_date_str){
	
	$start_date = new DateTime($start_date_str);
	$next_date = new DateTime($start_date_str);	
	$end_date = new DateTime($end_date_str);

	$returnObject = array();
	$iCount = 0;
	while ($next_date < $end_date) {
		/*if ($iCount > 0) {
			$next_date = new DateTime($end_date_str);
		}*/
		$iCount ++;
		switch ($freq) {
			case 'MINUTELY':
				$next_date->modify("+".$interval." minute");
				break;
			case 'HOURLY':
				$next_date->modify("+".$interval." hour");
				break;
			case 'DAILY':
				$next_date->modify("+".$interval." day");
				break;
			case 'WEEKLY':
				$next_date->modify("+".$interval." week");
				break;
			case 'MONTHLY':
				$next_date->modify("+".$interval." month");
				break;
			case 'YEARLY':
				$next_date->modify("+".$interval." year");
				break;
			default:
				$next_date->modify("+".$interval." hour");		
				break;
		}
	}

	$returnObject["next_date"]=$next_date;
	$returnObject["count"]=$iCount;
	return $returnObject;
}

//check that this is run from te command line
if (!_is_cli()) {
	echo "This script can only be run from the command line";
} else {
	_getNotifications();
}

?>