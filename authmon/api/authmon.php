<?php

require_once __DIR__ . '/../vendor/autoload.php';

	use Lcobucci\JWT\Builder;
	use Lcobucci\JWT\Parser;
	use Lcobucci\JWT\ValidationData;
	use Lcobucci\JWT\Signer\Hmac\Sha256;
	//logger
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;
	use Monolog\Handler\RotatingFileHandler;

require_once __DIR__ . '/config.php';

$monologOptions = array (
	//'path' => __DIR__.'/logs/run_'.date('Ymd').'.log',
	'path' => __DIR__.'/logs/run.log',
	'maxfiles' => 30,
	'level' => Logger::INFO
);

class authmonAdmin extends authmon {
    
    /**
     * Get the groups
     * 
     * @param Boolean $onlyEnabled set true to return only the enabled groups
     * @return resultset.  False if error. Null if not authorized
     */
    public function getGroups($onlyEnabled=false) {
        global $JWTQueries;
        $rs = null;
        
        try{
            //do common checks (isAdmin included)
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
                
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries[($onlyEnabled?"groupsEnabled":"groupsAll")]["query"]);
    		$query->execute();
    		$rs=$query->fetchAll(PDO::FETCH_ASSOC);
    		//check if query was run ok
    		if (!$this->commonChecks("isQueryOk", __FUNCTION__,$rs)) return false;
        	return $rs;
            
        } catch(exception $e) {
            return $this->commonChecks("isError", __FUNCTION__,$e);
        }
    }
    
    /**
     * Get the users
     * 
     * @return resultset.  False if error. Null if not authorized
     */
    public function getUsers() {
        global $JWTQueries;
        $rs = null;
        
        try{
            //do common checks (isAdmin included)
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
                
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["usersAll"]["query"]);
    		$query->execute();
    		$rs=$query->fetchAll(PDO::FETCH_ASSOC);
    		//check if query was run ok
    		if (!$this->commonChecks("isQueryOk", __FUNCTION__,$rs)) return false;
        	return $rs;
            
        } catch(exception $e) {
            return $this->commonChecks("isError", __FUNCTION__,$e);
        }
    }
    
    /**
     * Get group by id
     * 
     * @param array $formDataIn the input data
     * @return resultset.  False if error. Null if not authorized
     */
    public function getGroupById($formDataIn) {
        global $JWTQueries;
        $rs = null;
        
        try{
            //do common checks (isAdmin included)
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
                
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["groupById"]["query"]);
    		//$this->log->addInfo(__FUNCTION__.' DATA: '. var_dump($formDataIn),array ('token' => $this->token));
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$query->execute();
    		$rs=$query->fetchAll(PDO::FETCH_ASSOC);
    		//check if query was run ok
    		if (!$this->commonChecks("isQueryOk", __FUNCTION__,$rs)) return false;
        	return $rs;
            
        } catch(exception $e) {
            return $this->commonChecks("isError", __FUNCTION__,$e);
        }
    }
    
    /**
     * Get the group rights by group id. 
     * 
     * Returns all the possible rights with a column has_right
     * 
     * @param array $formDataIn the input data
     * @return resultset.  False if error. Null if not authorized
     */
    public function getGroupRightsById($formDataIn) {
        global $JWTQueries;
        $rs = null;
        
        try{
            //do common checks (isAdmin included)
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
                
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["groupRights"]["query"]);
    		
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$query->execute();
    		$rs=$query->fetchAll(PDO::FETCH_ASSOC);
    		//check if query was run ok
    		if (!$this->commonChecks("isQueryOk", __FUNCTION__,$rs)) return false;
        	return $rs;
            
        } catch(exception $e) {
            return $this->commonChecks("isError", __FUNCTION__,$e);
        }
    }
    
    /**
     * Get user by id
     * 
     * @param array $formDataIn the input data
     * @return resultset.  False if error. Null if not authorized
     */
    public function getUserById($formDataIn) {
        global $JWTQueries;
        $rs = null;
        
        try{
            //do common checks (isAdmin included)
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
                
            
            //prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["groupsAll"]["query"]);
    		$query->execute();
    		$rs1=$query->fetchAll(PDO::FETCH_ASSOC);
    		if (!$this->commonChecks("isQueryOk", __FUNCTION__,$rs1)) return false;
    		
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["userById"]["query"]);
    		//$this->log->addInfo(__FUNCTION__.' DATA: '. var_dump($formDataIn),array ('token' => $this->token));
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$query->execute();
    		$rs2=$query->fetchAll(PDO::FETCH_ASSOC);
    		//check if query was run ok
    		if (!$this->commonChecks("isQueryOk", __FUNCTION__,$rs2)) return false;
        	
        	return array (
            	//'path' => __DIR__.'/logs/run_'.date('Ymd').'.log',
            	'user' => $rs2[0],
            	'groups' => $rs1
            );
            
        } catch(exception $e) {
            return $this->commonChecks("isError", __FUNCTION__,$e);
        }
    }
    
    /**
     * Add New user 
     *
     * @param array $formDataIn the input data
     * @return object true if all ok. False if error. Null if not logged in
     */ 
    public function addNewUser($formDataIn){
        global $JWTQueries;
        try {
            //do common checks
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
            
            $login_token="";
			$user_email="";
			$user_name="";
            
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["addNewUser"]["query"]);
    		
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
			    // taking case of login_token for registration 
			    if ($fieldData->name == 'user_name') {
			        //add random login_token adding user_name
        		    $login_token= str_replace('=','',strtr(base64_encode(openssl_random_pseudo_bytes(64)), "+/=", "XXX").$fieldData->value);
        		    $query->bindParam(':login_token',$login_token);
        		    $user_name=$fieldData->value;
			    }
				//set user_email
				if ($fieldData->name == 'user_email') {
					$user_email=$fieldData->value;
				}
		    }
		    
    		$rs=$query->execute();
    		
    		if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
    		    $this->log->addInfo(__FUNCTION__. ' - Details changed.',array ('token' => $this->token,'formdata' => $formDataIn));
            	$this->feedback = "Success";
				//Send reset password email
				$this->sendEmail($this->getResetPasswordEmailHTML($login_token),$user_email,$user_name);
            	return true;
            } else {
                return false;
            }

        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
    
    /**
     * Updates the details of a user by id
     *
     * @param array $formDataIn the input data
     * @return object true if all ok. False if error. Null if not logged in
     */ 
    public function changeUserById($formDataIn){
        global $JWTQueries;
        try {
            //do common checks
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
            
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["changeUserById"]["query"]);
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$rs=$query->execute();
    		
    		if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
    		    $this->log->addInfo(__FUNCTION__. ' - Details changed.',array ('token' => $this->token,'formdata' => $formDataIn));
            	$this->feedback = "Success";
            	return true;
            } else {
                return false;
            }

        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
    
    /**
     * Delete a user by id
     *
     * @param array $formDataIn the input data
     * @return object true if all ok. False if error. Null if not logged in
     */ 
    public function deleteUserById($formDataIn){
        global $JWTQueries;
        try {
            //do common checks
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
            
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["deleteUserById"]["query"]);
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$rs=$query->execute();
    		
    		if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
    		    $this->log->addInfo(__FUNCTION__. ' - Details changed.',array ('token' => $this->token,'formdata' => $formDataIn));
            	$this->feedback = "Success";
            	return true;
            } else {
                return false;
            }

        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
    
	/**
     * Reset user password 
     *
     * @param array $formDataIn the input data
     * @return object true if all ok. False if error. Null if not logged in
     */ 
    public function resetPasswordFromAdmin($formDataIn){
        global $JWTQueries;
		global $JWTOptions; 
		
        try {
            //do common checks
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
            $login_token="";
			$user_email="";
			$user_name="";
			
			//get user email
			//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["userEmailById"]["query"]);
    		
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$query->execute();
    		$rs1=$query->fetchAll(PDO::FETCH_ASSOC);
			if (!$this->commonChecks("isQueryOk", __FUNCTION__,$rs1)) return false;
			
			$user_email= $rs1[0]['user_email'];
			
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["resetPasswordFromAdmin"]["query"]);
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
				//add random login_token adding user_name
				$login_token= str_replace('=','',strtr(base64_encode(openssl_random_pseudo_bytes(64)), "+/=", "XXX").$fieldData->value);
				$user_name=$fieldData->value;
				$query->bindParam(':login_token',$login_token);
		    }
    		$rs=$query->execute();
    		
    		if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
    		    $this->log->addInfo(__FUNCTION__. ' - Details changed.',array ('token' => $this->token,'formdata' => $formDataIn));
            	$this->feedback = "Success";
				//Send reset password email
				$this->sendEmail($this->getResetPasswordEmailHTML($login_token),$user_email,$user_name);
            	return true;
            } else {
                return false;
            }

        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
	
    /**
     * Add New group 
     *
     * @param array $formDataIn the input data
     * @return object true if all ok. False if error. Null if not logged in
     */ 
    public function addNewGroup($formDataIn){
        global $JWTQueries;
        try {
            //do common checks
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
            
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["addNewGroup"]["query"]);
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$rs=$query->execute();
    		
    		if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
    		    $this->log->addInfo(__FUNCTION__. ' - Details changed.',array ('token' => $this->token,'formdata' => $formDataIn));
            	$this->feedback = "Success";
            	return true;
            } else {
                return false;
            }

        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
    
    /**
     * Updates group by id
     *
     * @param array $formDataIn the input data
     * @return object true if all ok. False if error. Null if not logged in
     */ 
    public function changeGroupById($formDataIn){
        global $JWTQueries;
        try {
            //do common checks
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
            
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["changeGroupById"]["query"]);
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$rs=$query->execute();
    		
    		if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
    		    $this->log->addInfo(__FUNCTION__. ' - Details changed.',array ('token' => $this->token,'formdata' => $formDataIn));
            	$this->feedback = "Success";
            	return true;
            } else {
                return false;
            }

        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
    
     /**
     * Delete a group by id
     *
     * @param array $formDataIn the input data
     * @return object true if all ok. False if error. Null if not logged in
     */ 
    public function deleteGroupById($formDataIn){
        global $JWTQueries;
        try {
            //do common checks
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
            
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["deleteGroupById"]["query"]);
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$rs=$query->execute();
    		
    		if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
    		    $this->log->addInfo(__FUNCTION__. ' - Details changed.',array ('token' => $this->token,'formdata' => $formDataIn));
            	$this->feedback = "Success";
            	return true;
            } else {
                return false;
            }

        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
    
    /**
     * Update the group rights.
     * 
     * It deletes the previous group rights and adds new depending on the input array
     *
     * @param array $formDataIn the input data. in array "name" is the group_id and "value" is the result_id
     * @param string $group_id is the group_id we are updating
     * @return object true if all ok. False if error. Null if not logged in
     */ 
    public function updateGroupRights($formDataIn, $group_id){
        global $JWTQueries;
        try {
            //do common checks
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            if (!$this->commonChecks("isAdmin", __FUNCTION__)) return null;
            
        	//do delete
    		$query = $this->dbConnection->prepare($JWTQueries["deleteGroupRights"]["query"]);
    		$query->bindParam(':uid',$group_id);
    		$rs=$query->execute();
    		
    		if (!$this->commonChecks("isQueryOk", __FUNCTION__ . ' - Delete',$rs)) return false;
    		
    		//do inserts
    		foreach($formDataIn as $fieldData) {
    		    $query = $this->dbConnection->prepare($JWTQueries["addGroupRights"]["query"]);
			    $query->bindParam(':group_id',$group_id);
			    $query->bindParam(':result_id',$fieldData->value);
			    $rs=$query->execute();
			    if (!$this->commonChecks("isQueryOk", __FUNCTION__. ' - Insert Group_id:' . $group_id . ', result_id:' . $fieldData->value,$rs)) return false;
		    }
		    
		    $this->log->addInfo(__FUNCTION__. ' - Details changed.',array ('token' => $this->token,'formdata' => $formDataIn));
        	$this->feedback = "Success";
        	return true;

        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
}

class authmonSelfService extends authmon {
    /**
     * Updates the details of the current user based on the token in hand
     *
     * @param array $formDataIn the input data
     * @return object true if all ok. False if error. Null if not logged in
     */ 
    public function changeDetails($formDataIn){
        global $JWTQueries;
        try {
            //do common checks
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            
            //get the userid
            $userid=$this->tokenObj->getClaim("id");
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["changeDetails"]["query"]);
    		//bind username
    		$query->bindValue(":user_name", strtolower($userid));
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$rs=$query->execute();
    		
    		if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
    		    $this->log->addInfo(__FUNCTION__. ' - Details changed.',array ('token' => $this->token,'formdata' => $formDataIn));
            	$this->feedback = "Success";
            	return true;
            } else {
                return false;
            }

        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
    
    /**
     * Updates the password of the current user based on the token in hand
     *
     * @param string $oldPass the input data old password
     * @param string $newPass the input data new password
     * @param string $verifyPass the input data verify password
     * @return object true if all ok. False if error. Null if not logged in
     */ 
    public function changePassword($oldPass, $newPass, $verifyPass){
        global $JWTQueries;
        global $JWTOptions;
        try {
            //do common checks 
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
            
            //get the userid
            $userid=$this->tokenObj->getClaim("id");
            
        	$rs=$this->getTokenDetailsFromDb($userid);
        	// verify old password
        	if (!password_verify($oldPass, $rs['user_password_hash'])) {
        	    $this->log->addError(__FUNCTION__. ' - Old password does not match.',array ('token' => $this->token));
                $this->feedback = "Old password does not match";
                return false;
        	} 
    	    //verify two passwords are the same
    	    if ($newPass != $verifyPass) {
    	        $this->log->addError(__FUNCTION__. ' - New password and verify password do not match.',array ('token' => $this->token));
                $this->feedback = "New password and verify password do not match";
                return false;
    	    }
	        //check the structure of the new password is complient with password policy
	        if (!preg_match($JWTOptions['passwordPolicy'],$newPass)) {
	            //$JWTOptions['passwordRegexpMessage']
	            $this->log->addError(__FUNCTION__. $JWTOptions['passwordRegexpMessage'],array ('token' => $this->token));
                $this->feedback = $JWTOptions['passwordRegexpMessage'];
                return false;
	        }
	        //prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["changePassword"]["query"]);
    		//bind username
    		$query->bindValue(":user_name", strtolower($userid));
    		//bind hashed password
    		$query->bindValue(":password",password_hash( $newPass, PASSWORD_DEFAULT));

            $rs=$query->execute();
            
            if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
    		    $this->log->addInfo(__FUNCTION__. ' - Password changed.',array ('token' => $this->token));
            	$this->feedback = "Success";
            	return true;
            } else {
                return false;
            }
            
        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
    
    /**
     * Returns an object of the user details
     * 
     * @return object User details. False if error. Null if not logged in
     */ 
    public function getDetails(){
        global $JWTQueries;
        $rs = null;
        
        try{
            if (!$this->commonChecks("isNull", __FUNCTION__)) return null;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return null;
                $userid=$this->tokenObj->getClaim("id");
            	//prepare SQL bind and execure
        		$query = $this->dbConnection->prepare($JWTQueries["userDetails"]["query"]);
        		$query->bindValue(":user_name", strtolower($userid));
        		$query->execute();
        		
        		$rs=$query->fetch(PDO::FETCH_ASSOC);
        		
        		//check if query was run ok
        		if (!$this->commonChecks("isQueryOk", __FUNCTION__,$rs)) return false;
            	return $rs;
        } catch(exception $e) {
            return $this->commonChecks("isError", __FUNCTION__,$e);
        }
    }
    
}

class authmon {
    
    /**
    * The JWT token string
    *
    * @var string stores the token
    */
    public $token = "";
    
    /**
    * The JWT token object
    *
    * @var token stores the token object
    */
    public $tokenObj = null;
    
    /**
    * The log object
    *
    * @var Logger  
    */
    protected $log = null;
    
    /**
    * The feedback string
    * 
    * @var string stores the feedback
    */
    public $feedback = "";
    
    /**
    * The refresh in period as defined by config
    */
    public $refreshin ="0";
	
	/**
	*Shows if user is an admin
	*
	* @var Boolean 
	*/
	public $isAdmin=false;
    
	/**
	* The user id (username)
	*
	* @var String
	*/
	public $id="";
	
	/**
	*The name of the user
	*
	* @var String
	*/
	public $name="";	
	
    /**
     * @var object Database connection
     */
    protected $dbConnection=null;
    /**
    * Sets the $token. If 2 arguments have been passed performs login. 
    * If only 1 then the argument is passed as a token
    *
    * @param string $arg1 either username or token
    * @param string $arg2 password or null 
    * @return void
    */
    public function __construct($arg1,$arg2 = null)
    {
        
        //use global $monologOptions 
        global $monologOptions ;
        global $JWTOptions;
        
        
        $this->refreshin = $JWTOptions["refreshin"];
        // create a log channel
        $this->log = new Logger(__CLASS__);
        //$this->log->pushHandler(new StreamHandler($monologOptions['path'], $monologOptions['level']));
        $this->log->pushHandler(new RotatingFileHandler ($monologOptions['path'],$monologOptions['maxfiles'], $monologOptions['level']));
        
        try {
            //create database connection object
            $this->getOpenPDOConnection();
            //if intanciated with 1 argument is instantiated with a toke
            if (is_null($arg2)) {
                $this->token=$arg1;
                $this->tokenObj = (new Parser())->parse($arg1);
				$this->id=$this->tokenObj->getClaim('id');
				$this->name=$this->tokenObj->getClaim('name');
				$this->isAdmin=$this->tokenObj->getClaim('isAdmin');
            //if 2 arguments then perform login
            } else {
                $this->tokenObj=$this->signIn($arg1,$arg2);
                if (!is_null($this->tokenObj)) {
                    $this->token=$this->tokenObj->__toString();
                }
            }
            
        } catch(exception $e) { 
            $this->token="";
            $this->tokenObj = null;
			$this->id="";
			$this->isAdmin=false;
			$this->name="";
            $this->log->addError(__FUNCTION__ . ' - ' . $e->getMessage(),array('arg1'=>$arg1));
            $this->feedback = "Error while initializing authmon";
            return null;
        } finally {
            // add records to the log
    	    $this->log->addDebug(__FUNCTION__ . ' - Class instantiated. ',array ('token' => $this->token));
        }
    }
    
    
    /**
    * Renew the token based on id and name claims. 
    * 
    * Uses the getToken function so uses the univesal key and current date. 
    *
    * @return string The new token string
    */
    public function renewToken () {
        try {
            //do common checks 
            if (!$this->commonChecks("isNull", __FUNCTION__)) return "";
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return "";
            $userid=$this->tokenObj->getClaim("id");
            //get details from database 
            $rs=$this->getTokenDetailsFromDb($userid);
            if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
                $name=$rs['name'];
                $isAdmin=$rs['is_admin'];
                
                //renew based on data from database
        	    $renewTokenStr=$this->getToken($userid,$name,$isAdmin)->__toString();
        	    $this->log->addInfo(__FUNCTION__. ' - Renewed token, new token is '  . $renewTokenStr,array ('token' => $this->token));
        	    $this->feedback = "Success";
        	    return $renewTokenStr;
            } else {
                return "";
            }
            
        } catch(exception $e) { 
            $this->log->addError(__FUNCTION__. ' - '  .$e->getMessage(),array ('token' => $this->token));
            $this->feedback = "Error while renewing token.";
            return "";
        } 
    }
    
    
    /**
    * validates the token in terms of issuer, audience and exparation
    * 
    * Mostly checks if the token is expired
    * 
    * @return bool True if validated. 
    */
    public function validateToken () {
        if (is_null($this->tokenObj)) {
            $this->log->addError(__FUNCTION__. ' - Trying to validate an empty token.',array ('token' => $this->token));
            //$this->feedback = "Trying to validate an empty token";
            return false;
        }
        //use global $JWTOptions 
        global $JWTOptions ;
        
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer($JWTOptions['issuer']);
        $data->setAudience($JWTOptions['audience']);
        	
        return $this->tokenObj->validate($data);
    }

    /**
    * verifies the token in terms server key
    * 
    * @return bool True if verified. 
    */
    public function verifyToken() {
        if (is_null($this->tokenObj)) {
            $this->log->addError(__FUNCTION__. ' - Trying to verify an empty token.',array ('token' => $this->token));
            //$this->feedback = "Trying to verify an empty token";
            return false;
        }
        
        //use global $JWTOptions 
        global $JWTOptions ;
        
        $signer = new Sha256();
        return $this->tokenObj->verify($signer, $JWTOptions['key'] ); 
    }
    
    /**
    * checks if key is verified and validated
    * 
    * @return bool True if logged in . 
    */
    public function isLoggedIn(){
        try{
            return ($this->validateToken() && $this->verifyToken());   
        } catch(exception $e) {
            $this->log->addError(__FUNCTION__. ' - '  .$e->getMessage(),array ('token' => $this->token));
            return false;
        }
    }
    
	/**
     * Returns if a user is authorized for a service based on the logged in user
     * 
     * @param string $servicename The service to check if authorised
	 *
     * @return boolean True if is authorized, False if not (or error or not logged )
     */ 
    public function isAuthorized($servicename=""){
        global $JWTQueries;
        $rs = null;
        
        try{
            if (!$this->commonChecks("isNull", __FUNCTION__)) return false;
            if (!$this->commonChecks("isLogged", __FUNCTION__)) return false;
			if ($this->isAdmin) return true; 
                $userid=$this->tokenObj->getClaim("id");
            	//prepare SQL bind and execure
        		$query = $this->dbConnection->prepare($JWTQueries["checkUserAuth"]["query"]);
        		$query->bindValue(":user_name", strtolower($userid));
				$query->bindValue(":service_name", strtolower($servicename));
        		$query->execute();
        		
        		$rs=$query->fetch(PDO::FETCH_ASSOC);
        		
        		//check if query was run ok
        		if (!$this->commonChecks("isQueryOk", __FUNCTION__,$rs)) return false;
            	if ($rs['count_auth'] > 0) {
					return true;
				} else {
					return false;
				}
        } catch(exception $e) {
            return $this->commonChecks("isError", __FUNCTION__,$e);
        }
    }
    
    /**
    * Login using the credentials. 
    * 
    * Options of login depend on the type of user
    *
    * @param string $username The Username
    * @param string $password The password
    * @return string The token string
     */
    
    protected function signIn($username=null, $password=null) {
    	/**
    	* Notes on ldap:
    	* 	For PHP to work with ldap
    	* 	
    	* 	copy libsasl.dll to apache bin
    	* 	uncomment extension=php_ldap.dll in php.ini
    	* 	
    	* 	sample data:
    	* 		'ldapServer'=>'ldap://10.10.10.10'
    	* 		'id'=>'domain\\user'
    	*	
    	*/
    	
    	//define custom Users
    	/*$customUsers = array(
    		'admin'=> array('id'=>'1',
    						'username'=>'admin',
    						'ldapuser'=> false,
    						'password'=>'$2y$10$OJjQx/rMQdb1SWQbgIuWc.epSNqHDWhDSXIfrbxNqUvpxsnEWekvC',				
    						'ldapServer'=>'ldap://10.144.12.41',
    						'name'=>'Administrator',
    						'usergroup'=>'admin',
    						'isAdmin'=>true),
    		'user1'=> array('id'=>'2',
    						'username'=>'user1',
    						'ldapuser'=> false,
    						'password'=>'$2y$10$OJjQx/rMQdb1SWQbgIuWc.epSNqHDWhDSXIfrbxNqUvpxsnEWekvC',				
    						'ldapServer'=>'ldap://10.144.12.41',
    						'name'=>'User 1 no admin',
    						'usergroup'=>'users',
    						'isAdmin'=>false),
    		'pnevma\\test'=> array('id'=>'3',
    						'username'=>'pnevma\\test',
    						'ldapuser'=> true,
    						'password'=>'',
    						'ldapServer'=>'ldap://10.144.32.1',						
    						'name'=>'Test on PEVMA',
    						'usergroup'=>'admin',
    						'isAdmin'=>true),
    		'drcor\\administrator'=> array('id'=>'4',
    						'username'=>'drcor\\administrator',
    						'ldapuser'=> true,	
    						'password'=>'',					
    						'ldapServer'=>'ldap://10.144.12.41',						
    						'name'=>'administrator on DRCOR',
    						'usergroup'=>'admin',
    						'isAdmin'=>true),
    		'drcor\\cevangelouasdf'=> array('id'=>'5',
    						'username'=>'drcor\\cevangelouasdf',
    						'ldapuser'=> true,	
    						'password'=>'',					
    						'ldapServer'=>'ldap://10.144.12.41',						
    						'name'=>'Test on DRCOR',
    						'usergroup'=>'admin',
    						'isAdmin'=>true),
    		'10.144.12.145\\user'=> array('id'=>'6',
    						'username'=>'10.144.12.145\\user',
    						'ldapuser'=> true,	
    						'password'=>'',					
    						'ldapServer'=>'ldap://10.144.12.145',						
    						'name'=>'User on 10.144.12.145',
    						'usergroup'=>'admin',
    						'isAdmin'=>true)
    	);*/
    	
    	global $JWTQueries;
    	global $JWTOptions;
    	
    	$isLogged = false;
    	$userObj = null;
    	
    	$messagestr="";
    	
    	//check that username && password were passed	
    	if ($username && $password) {
    		//check if is in Users 
    		
    		$rs=$this->getTokenDetailsFromDb($username);
    		
    		if ($rs) {
    			
    			$userObj=$rs;
    			
                //check if user is locked 
                if (($userObj['lock_tries'] >= $JWTOptions["lockTriesNumber"]) && ($userObj['lock_diff']<$JWTOptions["lockTriesInterval"])) {
                    $this->log->addError(__FUNCTION__ . ' - User locked "'.$username.'". Error Message: '.$messagestr,array('token'=>"NO TOKEN"));
                    $this->feedback = "Locked";
                    return null;
                }
    			
    			//--- Non LDAP user ----
    			if (!$userObj['is_ldap']) {
    				//check customUser credentials
    				if ((password_verify($password, $userObj['user_password_hash'])) && ($userObj['user_password_hash'] != null)){
    				//if ($userObj['password'] == $password) {
    					$isLogged = true;
    					//update lock tries and login date
    					//prepare SQL bind and execure
                		$query = $this->dbConnection->prepare($JWTQueries["resertLockTries"]["query"]);
                		$query->bindValue(":user_name", strtolower($username));
                        $rs=$query->execute();
    				} else {
    					$messagestr='** Not logged in (custom)';
    					//update lock tries
    					//prepare SQL bind and execure
                		$query = $this->dbConnection->prepare($JWTQueries["incrementLockTries"]["query"]);
                		$query->bindValue(":user_name", strtolower($username));
                        $rs=$query->execute();
    				}
    			//--- LDAP user ----
    			} else { 				
    				// set ldap options
    				$ldap = ldap_connect($userObj['ldap_server']);
    				ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    				ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
    				// bind ldap with server username (including domain) and password 
    				$bind = @ldap_bind( $ldap, $username, $password);
    				// logged in 
    				if ($bind) {
    					$isLogged = true;					
    					@ldap_close($ldap);
    					//update lock tries and login date
    					//prepare SQL bind and execure
                		$query = $this->dbConnection->prepare($JWTQueries["resertLockTries"]["query"]);
                		$query->bindValue(":user_name", strtolower($username));
                        $rs=$query->execute();
    				// not logged in
    				} else {
    					$messagestr='** Not logged in (ldap)';
    					//update lock tries
    					//prepare SQL bind and execure
                		$query = $this->dbConnection->prepare($JWTQueries["incrementLockTries"]["query"]);
                		$query->bindValue(":user_name", strtolower($username));
                        $rs=$query->execute();
    				}
    			}			
    		// not in registered users
    		} else {
    			$messagestr='** Not a registered user';
    		}
    	// no username or password passed
    	} else {
    		$messagestr='** NO Username or Password';
    	}
    	
    	
    	//----- LOGGED IN NOW --------
    	if ($isLogged && $userObj) {
    		$token=$this->getToken($userObj['user_name'],$userObj['name'],$userObj['is_admin']);
    		$this->log->addInfo(__FUNCTION__ . ' - Logged in with userid '.$userObj['user_name'],array ('token'=>$token->__toString()));
    		$this->feedback = "Success";
    		return $token;
    	} else {
    		$this->log->addError(__FUNCTION__ . ' - Logged in failed for user "'.$username.'". Error Message: '.$messagestr,array('token'=>"NO TOKEN"));
    		$this->feedback = "Error while logging in. - " .$username.". Error Message: ".$messagestr;
    		//echo $messagestr;
    		return null;
    	}	
    }
    
    /**
     * Does common checks and writes on log accordingly
     * 
     * @param string $checkName The check name
     * @param string $function The name of the function
     * @return Boolean True if passed check, false if not
     */
    protected function commonChecks ($checkName, $function,$rs=false) {
    	switch ($checkName) {
    	//check if logged in
    	case "isLogged":		
    		if ($this->validateToken() && $this->verifyToken()) {
    			return true;
    		} else {
    			$this->log->addWarning($function. ' - Either not valid or verified.',array ('token' => $this->token));
    			$this->feedback = "Either not valid or verified";
    			return false;
    		}
    		break;
    	//check if is admin
    	case "isAdmin":		
    		if ($this->isAdmin) {
    			return true;
    		} else {
    			//echo var_dump($this->authmonObj);
    			$this->log->addError($function. ' - Not an admin.',array ('token' => $this->token));
    			$this->feedback = "Not an admin.";
    			return false;
    		}
    		break;
    	//check if token is null
    	case "isNull":				
    		if (is_null($this->tokenObj)) {
    			$this->log->addError($function. ' - Empty token.',array ('token' => $this->token));
    			$this->feedback = "Empty token";
    			return false;
    		} else {
    			return true; 
    		}
    		break;
    	//check if query run ok
    	case "isQueryOk":
    		if ($rs===false) {
    			$this->log->addError($function.  ' - Error while running query on database.',array ('token' => $this->token));
    			$this->feedback = "Error while running query on database.";
    			return false;
    		} else {
    			$this->log->addDebug($function. ' - Database query successful',array ('token' => $this->token));
    			$this->feedback = "Success.";
    			return true;
    		}
    		break;
    	case "isError":
    	    $this->log->addError($function. ' - '  .$rs->getMessage(),array ('token' => $this->token));
            $this->feedback = "An Error has occured.";
            return false;
    	    break;
    		
    	}
    }
    
    /**
     * Execute the checkUser query.
     * 
     * @param string $username The Username
     * @return resultset
     */
    protected function getTokenDetailsFromDb($username){
        global $JWTQueries;
        
        //prepare SQL bind and execure
		$query = $this->dbConnection->prepare($JWTQueries["checkUser"]["query"]);
		$query->bindValue(":user_name", strtolower($username));
		$query->execute();
		
		return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
    * Creates a new token and returns the token string. 
    * 
    * Uses the userid and name to pass as claims. The exparation period is set on the $JWTOptions. 
    * The token is signed with Sha256.The key is defined in $JWTOptions
    *
    * @param string $userid The user id used in as a claim
    * @param string $name The name of the user used in as a claim
    * @return Token 
    */
    protected function getToken($userid=null,$name="",$isAdmin=false) {	
    	//use global $JWTOptions 
    	global $JWTOptions ;
    
    	$tokenstr	= "";
    	$issuedAt   = time();
        $expire     = $issuedAt + ($JWTOptions['expire'] * 60);            // Adding 60 seconds    
        	
    	$signer = new Sha256();
    	
    	$token = (new Builder())->setIssuer($JWTOptions['issuer'])
          ->setAudience($JWTOptions['audience'])
          ->setIssuedAt($issuedAt)
          ->setExpiration($expire)
    	  ->set('id', $userid) // Configures a new claim
    	  ->set('isAdmin', $isAdmin) // Configures a new claim
    	  ->set('name', $name) // Configures a new claim
    	  ->set('refreshin', $JWTOptions['refreshin']) // Configures a new claim
    	  ->sign($signer, $JWTOptions['key'] ) // creates a signature using a key
          ->getToken();
    	
		$this->id=$userid;
    	$this->isAdmin=$isAdmin;
		$this->name=$name;
    	// to string
    	//$tokenstr=$token->__toString();
    	
    	return $token;
    }
    
    
    /**
     * Creates and sets the connection depending on the connection details in configuration
     * 
     * @return PDO connection
     */ 
    protected function getOpenPDOConnection() {
    	global $JWTOptions;
    	
    	$connection = $JWTOptions["monitralldb"];
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
    	$this->dbConnection = $conn;
    }
    
     /**
    * Sends an email 
    * 
    * @param string $body the main body of the email
    * @param string $to the bcc emails separated by ,
    */
    protected function sendEmail($body="",$to=null, $user_name=""){
        global $JWTOptions;
        // Create the Transport is_null
        if (!is_null($JWTOptions ['email']['username']) && !is_null($JWTOptions ['email']['password'])){
            $transport = Swift_SmtpTransport::newInstance($JWTOptions ['email']['server'], $JWTOptions ['email']['port'])
                ->setUsername($JWTOptions ['email']['username'])
                ->setPassword($JWTOptions ['email']['password']);
        } else {
            $transport = Swift_SmtpTransport::newInstance($JWTOptions ['email']['server'], $JWTOptions ['email']['port']);
        }
        
        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);
        
        // Create a message
        $message = Swift_Message::newInstance($JWTOptions ['email']['subject'])
          ->setFrom($JWTOptions ['email']['from'])
          ->setBody(str_replace('__USERNAME__',$user_name, $JWTOptions ['email']['bodytop'].$body.$JWTOptions ['email']['bodybottom']), 'text/html');
        
        if ($to) {
    		$message->setTo(explode(",",$to));
    	} else {
    		$message->setBcc($JWTOptions["email"]["to"]);
    	}
        
        $failedRecipients = array();
        
        // Send the message
        $result = $mailer->send($message,$failedRecipients);
        //TODO if $failedRecipients is not empty array write on file
    }
	
	/**
     * Genarates the reset password String
     * 
     * @param string $loginToken The login token string
     *
	 * @return reset Password email html stting
     */ 
	protected function getResetPasswordEmailHTML($loginToken) {
		global $JWTOptions;
		return "<br> Click <a href='" . $JWTOptions["webaddress"] . $JWTOptions["resetPasswordAddress"] . "?t=" . $loginToken . "' >here</a> to reset your password.<br><br>";
	}
	
	/**
     * Get reset password token from database
     * 
     * @param array $formDataIn the input data
     * @return resultset.  False if error.
     */
    public function checkResetPassToken($formDataIn) {
        global $JWTQueries;
        $rs = null;
        
        try{
                
        	//prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["checkResetPassToken"]["query"]);
    		//bind form data
    		foreach($formDataIn as $fieldData) {			
			    $query->bindParam(':'.$fieldData->name,$fieldData->value);
		    }
    		$query->execute();
    		$rs=$query->fetchAll(PDO::FETCH_ASSOC);
    		//check if query was run ok
    		if (!$this->commonChecks("isQueryOk", __FUNCTION__,$rs)) return false;
        	return $rs;
            
        } catch(exception $e) {
            return $this->commonChecks("isError", __FUNCTION__,$e);
        }
    }
	
	/**
     * Updates the password of a user using the reset password token (send by email)
     *
     * @param string $newPass the input data new password
     * @param string $verifyPass the input data verify password
     * @param string $loginToken the reset password token
	 * @return object true if all ok. False if error.
     */ 
    public function resetPassword($newPass, $verifyPass, $loginToken){
        global $JWTQueries;
        global $JWTOptions;
        try { 
    	    //verify two passwords are the same
    	    if ($newPass != $verifyPass) {
    	        $this->log->addError(__FUNCTION__. ' - New password and verify password do not match.',array ('token' => $this->token));
                $this->feedback = "New password and verify password do not match";
                return false;
    	    }
	        //check the structure of the new password is complient with password policy
	        if (!preg_match($JWTOptions['passwordPolicy'],$newPass)) {
	            //$JWTOptions['passwordRegexpMessage']
	            $this->log->addError(__FUNCTION__. $JWTOptions['passwordRegexpMessage'],array ('token' => $this->token));
                $this->feedback = $JWTOptions['passwordRegexpMessage'];
                return false;
	        }
	        //prepare SQL bind and execure
    		$query = $this->dbConnection->prepare($JWTQueries["resetPassword"]["query"]);
    		//bind username
    		$query->bindValue(":loginToken", $loginToken);
    		//bind hashed password
    		$query->bindValue(":password",password_hash( $newPass, PASSWORD_DEFAULT));

            $rs=$query->execute();
            
            if ($this->commonChecks("isQueryOk", __FUNCTION__,$rs)) {
    		    $this->log->addInfo(__FUNCTION__. ' - Password changed.',array ('token' => $this->token));
            	$this->feedback = "Success";
            	return true;
            } else {
                return false;
            }
            
        } catch(exception $e) { 
            return $this->commonChecks("isError", __FUNCTION__,$e);
        } 
    }
    
}

//-----------------------Common Functions-----------------------
/**
 * Gets the common data from a request. 
 * 
 * @param Slim::getInstance() $slimInstance The Slim instance 
 * @param SlimRequest &$request The request object to be returned 
 * @param SlimResponse &$response The response object to be returned 
 * @param object &$requestData The data passed in the body
 * @param String &$token The token passed in the authorization bearer header
 * @return void
 */ 
function commonRequest($slimInstance, &$request,&$response,&$requestData,&$token) {
    try{
        $request = $slimInstance->request();
        $response = $slimInstance->response();
    	//get the response data
    	$requestData = json_decode($request->getBody());
    	//get authorization bearer header
    	$token=explode(" ",$request->headers('authorization'))[1];
    	
    }  catch(exception $e) {
        $token = '';
    }
	
}
//---------------------------------------------------------------
function feedbackResponse ($feedback='An error has occurred!') {
    return array('feedback' => $feedback); 
}

?>  