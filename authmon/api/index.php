<?php
require_once '../libraries/Slim/Slim.php';
require_once 'authmon.php';

$app = new Slim();
$app->post('/login','AuthDoLogin');
$app->post('/isLoggedIn','AuthIsLoggedIn');
$app->post('/renewToken','AuthDoRenewToken');
$app->post('/AuthCheckResetPassToken','AuthCheckResetPassToken');
$app->post('/AuthResetPassword','AuthResetPassword');
//do 
$app->post('/do/:action','AuthDoRequests');
//get
$app->post('/get/:action','AuthGetRequests');

//$app->get('/test','doTest');
$app->run();

//---------------------------------------------------------------
function doTest() {
    //sendTestEmail('<br>This is a test email<br><br>','gieglas@gmail.com,cevangeloudits@gmail.com');
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
    if ($authmonLogin->isAuthorized('TestTable')) {
		echo 'True';
	} else {
		echo 'False';
	}
        //$obj = new stdClass;
        //$obj->name="uid";
        //$obj->value="admin";
        //echo var_dump(array($obj));
        
        //$authmonLogin = new authmonAdmin('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJNb25vdHJBbGxfYXBpIiwiYXVkIjoiTW9uaXRyQWxsX2NsaWVudHMiLCJpYXQiOjE0NjI3NzQ2NDcsImV4cCI6MTQ2Mjc3NjQ0NywiaWQiOiJhZG1pbiIsImlzQWRtaW4iOiIxIiwibmFtZSI6IkFkbWluaXN0cmF0b3IiLCJyZWZyZXNoaW4iOiI1In0.dnFp7wsZdnOtwTBmQpSsXz2X23bCDbyuOWMqdVF4wZM');
        
        //$rs=$authmonLogin->getUserById(array($obj));
        
        //echo var_dump($rs);
}
/**
 * Handles the is loggin action 
 * 
 * Response Status codes:
 *      200 = All ok is Logged in 
 *      401 = Not Logged in 
 * Response Body: No body 
 * 
 * @return void
 */
function AuthDoLogin() {
    $request = null;
    $response = null;
	$requestData = null;
	$token='';
	commonRequest(Slim::getInstance(),$request,$response,$requestData,$token);
	
	// login 
    $authmonLogin = new authmon($requestData->username,$requestData->password);
    
    if ($authmonLogin->isLoggedIn()) {
        //login response object
        $responseObj = array(
    	    'token' => $authmonLogin->token,
    	    'feedback' => $authmonLogin->feedback,
    	    'refreshin' => $authmonLogin->refreshin,
    		'id' =>  $authmonLogin->id,
    		'name' =>  $authmonLogin->name,
    		'isAdmin' => $authmonLogin->isAdmin		
        ); 
        
        echo json_encode($responseObj) . '  ';
        //response status = 200 OK
        $response->status(200);
    } else {
        //response status = 401 Unauthorized
        $responseObj = feedbackResponse();
		if ($authmonLogin->feedback == 'Locked') {
			$responseObj['feedback'] = $authmonLogin->feedback;
        }
        
        echo json_encode($responseObj) . '  ';
        $response->status(401);
    }
}
/**
 * Handles the is logged in action
 * 
 * Response Status codes:
 *      200 = All ok is Logged in 
 *      401 = Not Logged in 
 *      400 = An error has occurred in the server
 * Response Body:
 *      On status 200: {"token":"","feedback":"","refreshin":"","id":"","name":"","isAdmin":""}  
 *      On status 401,400 : {"feedback":"Error Message"}  
 * 
 * @return void
 */
function AuthIsLoggedIn() {
    try{
        $request = null;
        $response = null;
    	$token='';
	    commonRequest(Slim::getInstance(),$request,$response,$requestData,$token);
    	//check token
    	if (!commonChecks ("checkToken", $token, $response)) return false;
    	
    	// login 
        $authmonLogin = new authmon($token);
        
        if ($authmonLogin->isLoggedIn()) {
            //login response object
            $responseObj = array(
        	    'token' => $authmonLogin->token,
        	    'feedback' => $authmonLogin->feedback,
        	    'refreshin' => $authmonLogin->refreshin,
    			'id' =>  $authmonLogin->id,
    			'name' =>  $authmonLogin->name,
    			'isAdmin' => $authmonLogin->isAdmin		
            ); 
            
            echo json_encode($responseObj) . '  ';
            //response status = 200 OK
            $response->status(200);
        } else {
            $responseObj = feedbackResponse();
            
            echo json_encode($responseObj) . '  ';
            //response status = 401 Unauthorized
            $response->status(401);
        }
    } catch(exception $e) {
        $responseObj = feedbackResponse();
        
        echo json_encode($responseObj) . '  ';
        $response = Slim::getInstance()->response();
    	$response->status(400);
    }
}

/**
 * Handles the renew token action 
 * 
 * Response Status codes:
 *      200 = All ok 
 *      401 = Not authorized (either not logged in or not allowed)
 *      400 = An error has occurred in the server
 * Response Body:
 *      On status 200: {"token":"","feedback":"","refreshin":"","id":"","name":"","isAdmin":""}  
 *      On status 401,400 : {"feedback":"Error Message"}  
 * 
 * @return void
 */
function AuthDoRenewToken() {
    try{
        $request = null;
        $response = null;
    	$requestData = null;
    	$token='';
	    commonRequest(Slim::getInstance(),$request,$response,$requestData,$token);
    	
    	//check token
    	if (!commonChecks ("checkToken", $token, $response)) return false;
    	
    	// login 
        $authmonLogin = new authmon($token);
        
        if ($authmonLogin->isLoggedIn()) {
            //login response object
            $responseObj = emptyResponse(); 
            $responseObj['token']=$authmonLogin->renewToken();
            $responseObj['feedback'] = $authmonLogin->feedback;
        	$responseObj['refreshin'] = $authmonLogin->refreshin;
    	    $responseObj['id'] =  $authmonLogin->id;
            $responseObj['name']=$authmonLogin->name;
            $responseObj['isAdmin']=$authmonLogin->isAdmin;
            //response status = 200 OK
            echo json_encode($responseObj) . '  ';
            $response->status(200);
        } else {
            //login response object
            $responseObj = feedbackResponse();
            //response status = 401 Unauthorized
            echo json_encode($responseObj) . '  ';
            $response->status(401);
        }
    } catch(exception $e) {
        //login response object
        $responseObj = feedbackResponse();
        
        echo json_encode($responseObj) . '  ';
        $response = Slim::getInstance()->response();
    	$response->status(400);
    }
    
}
/**
 * Handles requests that requre an update/insert/delete action from the API
 * 
 * Action options: changeDetails, changePassword, changeUserById, changeGroupById, 
 *      addNewGroup, deleteGroupById, addNewUser, deleteUserById
 * 
 * Response Status codes:
 *      200 = All ok 
 *      401 = Not authorized (either not logged in or not allowed)
 *      400 = An error has occurred in the server OR validation rule 
 * Response Body:
 *        {"feedback":"Success"||"Error Message"}
 * 
 * @param string $action the action to be perfomed as defined in the URL
 * @return void
 */
function AuthDoRequests($action) {
    try {
        //do common stuff for do requests
        $request = null;
        $response = null;
    	$requestData = null;
    	$token='';
    	$rs=false;
    	$authmonLogin=null;
	    commonRequest(Slim::getInstance(),$request,$response,$requestData,$token);
    	
    	//check token
    	if (!commonChecks ("checkToken", $token, $response)) return false;
        
        //depending on the action call separate 
        switch ($action) {
        	case "changeDetails":
        	    // login 
                $authmonLogin = new authmonSelfService($token);
        	    $rs=$authmonLogin->changeDetails($requestData);
        	    break;
            case "changePassword":
                // login 
                $authmonLogin = new authmonSelfService($token);
                $rs=$authmonLogin->changePassword($requestData[0]->value,$requestData[1]->value,$requestData[2]->value);
                break;
            case "changeUserById":
                // login 
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->changeUserById($requestData);
                break;
            case "changeGroupById":
                // login 
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->changeGroupById($requestData);
                break;
            case "addNewGroup":
                // login 
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->addNewGroup($requestData);
                break;
            case "deleteGroupById":
                // login 
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->deleteGroupById($requestData);
                break;
            case "addNewUser":
                // login 
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->addNewUser($requestData);
                break;
            case "deleteUserById":
                // login 
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->deleteUserById($requestData);
                break;
            case "updateGroupRights":
                // login 
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->updateGroupRights($requestData[0],$requestData[1]);
                break;
			case "resetPassword":
                // login 
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->resetPasswordFromAdmin($requestData);
                break;
        }
        
        $responseObj = feedbackResponse($authmonLogin->feedback);
    	
    	echo json_encode($responseObj) . '  ';
    	//if logged in
        if ($rs === null) {
            $response->status(401);
        } elseif ($rs) {
            $response->status(200);
        } else {
            $response->status(400);
        }
        
    } catch(exception $e) {
        echo  json_encode(feedbackResponse());
        $response = Slim::getInstance()->response();
    	$response->status(400);
    }
    
}
/**
 * Handles requests that requre get action from the API
 * 
 * Action options: getUsers, getGroups, getDetails, getGroupById, getUserById, getGroupRightsById
 * 
 * Response Status codes:
 *      200 = All ok 
 *      401 = Not authorized (either not logged in or not allowed)
 *      400 = An error has occurred in the server OR validation rule 
 * Response Body: Array example:
 *       [{"user_name":"admin","is_ldap":"0","name":"Administrator","is_admin":"1"}
 *          ,{"user_name":"user1","is_ldap":"0","name":"User","is_admin":"0"}]  
 * 
 * @param string $action the action to be perfomed as defined in the URL
 * @return void
 */
function AuthGetRequests($action){
    try{
        $request = null;
        $response = null;
    	$requestData = null;
    	$token='';
    	$re=false;
    	$authmonLogin=null;
	    commonRequest(Slim::getInstance(),$request,$response,$requestData,$token);
    	
    	//check token
    	if (!commonChecks ("checkToken", $token, $response)) return false;
    	
    	//depending on the action call separate 
        switch ($action) {
        	case "getUsers":
        	    $authmonLogin = new authmonAdmin($token);
        	    $rs=$authmonLogin->getUsers();
        	    break;
            case "getGroups":
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->getGroups(false);
                break;
            case "getDetails":
                $authmonLogin = new authmonSelfService($token);
                $rs=$authmonLogin->getDetails();
                break;
            case "getGroupById":
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->getGroupById($requestData);
                break;
            case "getUserById":
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->getUserById($requestData);
                break;
            case "getGroupRightsById":
                $authmonLogin = new authmonAdmin($token);
                $rs=$authmonLogin->getGroupRightsById($requestData);
                break;
        }
        
        //if not authorazed 
        if ($rs === null) {
            echo  '{}  ';
            $response->status(401);
        //if All ok
        } elseif (($rs) || ($rs===[])) {
            echo json_encode($rs) . '  ';
            $response->status(200);
        //if error occurred
        } else {
            echo  '{}  ';
            $response->status(400);
        }
    } catch(exception $e) {
        echo  '{}  ';
        $response = Slim::getInstance()->response();
    	$response->status(400);
    }
}

 /**
 * Checks if a reset password token exists
 *
 * Response Status codes:
 *      200 = All ok 
 *      400 = An error has occurred in the server OR token does not exist 
 * Response Body: Array example:
 *       [{"login_token":"dasddsad3dfs1das1dxa"}]  
 * 
 * @return void
 */
function AuthCheckResetPassToken(){
	try {
		$request = null;
        $response = null;
    	$requestData = null;
    	$token='';
    	$re=false;
		$authmonLogin=null;
	    commonRequest(Slim::getInstance(),$request,$response,$requestData,$token);
		
		$authmonLogin = new authmon("");
		$rs=$authmonLogin->checkResetPassToken($requestData);
		
		if ($rs) {
            echo json_encode($rs) . '  ';
            $response->status(200);
        //if error occurred
        } else {
            echo  '{}  ';
            $response->status(400);
        }
	
	} catch(exception $e) {
        echo  '{}  ';
        $response = Slim::getInstance()->response();
    	$response->status(400);
    }
}

/**
 * Handles requests to reset password
 * 
 * Response Status codes:
 *      200 = All ok 
 * 		400 = An error has occurred in the server OR validation rule 
 * Response Body:
 *        {"feedback":"Success"||"Error Message"}
 * 
 * @return void
 */
function AuthResetPassword() {
    try {
        //do common stuff for do requests
        $request = null;
        $response = null;
    	$requestData = null;
    	$token='';
    	$rs=false;
    	$authmonLogin=null;
	    commonRequest(Slim::getInstance(),$request,$response,$requestData,$token);
    	
        $authmonLogin = new authmon("");
        $rs=$authmonLogin->resetPassword($requestData[0]->value,$requestData[1]->value,$requestData[2]->value);
        
        $responseObj = feedbackResponse($authmonLogin->feedback);
    	
    	echo json_encode($responseObj) . '  ';
    	//if logged in
        if ($rs) {
            $response->status(200);
        } else {
            $response->status(400);
        }
        
    } catch(exception $e) {
        echo  json_encode(feedbackResponse());
        $response = Slim::getInstance()->response();
    	$response->status(400);
    }
    
}

//-----------------------Common Functions-----------------------

function commonChecks ($checkName, $data, $response) {
    switch ($checkName) {
    	//check if logged in
    	case "checkToken":
    	        if ($data=='') {
                    echo 'Bad token or authorization header.  ';
                    $response->status(400);
                	return false;
                } else {
                    return true;
                }
        break;
    }
} 
//---------------------------------------------------------------
function emptyResponse () {
    return array(
    	    'token' => '',
    	    'feedback' => 'An error has occurred.',
    	    'refreshin' => 0,
			'id' =>  '',
			'name' =>  '',
			'isAdmin' => false		
        ); 
}





?>