authmon.php
===========
1. authmon
---------------------
Is the base class. Holds all the necessary information for authentication and authorization, such as token, id, name, isAdmin. Also responsible for basic functions such as connect to database, sign in, create token,  renewToken , is authorized, send email and so on.

2. authmonSelfService
--------------------------------------
Extends authmon and is able to change personal details and password. 

3. authmonAdmin
-----------------------------
Extends authmon and is able to do administrator tasks. such as add new user or group, change group rules, reset passwords etc.

config.php
=========
The options of the authmon module
```PHP
$JWTOptions = array(
	'key' => 'ljkahsdlkasjkjakjkjSVCKsck;JKVCXJKsdjkvc',    // Key for signing the JWT's, I suggest generate it with base64_encode(openssl_random_pseudo_bytes(64))
	'issuer' => 'MonotrAll_api', // Issuer for JWT token
	'audience' => 'MonitrAll_clients', // Audience for JWT toke
	'refreshin' => '10', // Adding 10 minutes to refresh
	'expire' => 30, // Adding 30 minutes to expire 900
	'passwordPolicy' => '/^\\S*(?=\\S{6,})(?=\\S*[a-zα-ω])(?=\\S*[A-ZΑ-Ω])(?=\\S*[\\d])\\S*$/m',
	// /^: anchored to beginning of string
    // \\S*: any set of characters
    // (?=\\S{6,}): of at least length 6
    // (?=\\S*[a-zα-ω]): containing at least one lowercase letter
    // (?=\\S*[A-ZΑ-Ω]): and at least one uppercase letter
    // (?=\\S*[\d]): and at least one number
    // $: anchored to the end of the string
	'passwordRegexpMessage' => 'Wrong Password structure. Must be at least 6 characters, containing at least one lowercase letter, at least one uppercase letter, and at least one number. No Spaces.',
	'lockTriesNumber' => 5,   // How many wrong password tries locks  the user
	'lockTriesInterval' => 5, //Interval to stay locked 
	"monitralldb" => array (
		"id" => "monitralldb",
		"server" => "localhost",     // Server IP/name		
		"port" => "", //port (if not default)
		"user" => "monitralldbbare", // database user name
		"pass" => "xxxxxxxx",  // database password 
		"name" => "monitralldbbare",   // database name 
		"provider" => "mysql" // database provider
	),
	"email" => array (
	    "server" => "mailtrap.io", // email server
	    "port" => 2525, // email server port
	    "username" => "b12bd8614bb0e8", //email username, if not used set to null
	    "password" => "ec8ecaf96a3e7e", //email password, if not used set to null
		"subject" => "Monitrall User", //email subject
		"bodytop" => "<html>This email was produced automatically from MonitrAll's Security module.<br>", //email body top 
		"bodybottom" => "For more details visit Monitrall.</html>", // email body bottom
		"to" => "test@test.com", //not really used
		"from" => array('noreply@monitrall.com' => 'MonitraAll Admin') //from address
	),
	//"webaddress" => "http://localhost:8080/git/monitrall/",
	"webaddress" => "http://db.gieglas.koding.io/MonitrAll/authmon/", //web address of the authmon root (used in emails)
	"resetPasswordAddress" => "resetPass.php" // reset password php page
); 
```
JWTQueries are the sql queries used in this module:

```
$JWTQueries = array(
	"checkUser" => array(
		"id" => "checkUser",		
		"connection" => "monitralldb",
		"query" => "SELECT a.user_name, a.user_password_hash, a.is_ldap, a.name, a.is_admin, a.lock_tries, a.lock_date, 
		    IFNULL(TIME_TO_SEC(TIMEDIFF(now(),a.lock_date)) /60,1000) as lock_diff
                FROM sec_users a, sec_groups b
                WHERE a.group_id = b.group_id
                AND LOWER(a.user_name) = LOWER(:user_name) 
                AND a.enabled =1
                AND b.enabled =1
                LIMIT 1"
	),
	"checkUserAuth" => array(
		"id" => "checkUserAuth",		
		"connection" => "monitralldb",
		"query" => "SELECT count(*) as count_auth
			FROM sec_users a, sec_groups b, sec_groupsresults c
			WHERE a.group_id = b.group_id
			AND LOWER(a.user_name) = LOWER(:user_name) 
			AND a.enabled =1
			AND b.enabled =1
			AND c.result_id = :service_name
			LIMIT 1"
	),
	"userDetails" => array(
		"id" => "userDetails",		
		"connection" => "monitralldb",
		"query" => "SELECT user_name, name, user_email, user_phone
            FROM sec_users
            WHERE LOWER(user_name) = LOWER(:user_name) 
            AND enabled =1
            LIMIT 1"
	), 
	"changeDetails" => array(
		"id" => "changeDetails",		
		"connection" => "monitralldb",
		"query" => "UPDATE sec_users SET name=:name, user_email=:user_email, user_phone=:user_phone, update_date=CURRENT_TIMESTAMP
            WHERE LOWER(user_name) = LOWER(:user_name)"
    ), 
	"changePassword" => array(
		"id" => "changePassword",		
		"connection" => "monitralldb",
		"query" => "UPDATE sec_users SET user_password_hash=:password , last_pwd_update_date=now()
            WHERE LOWER(user_name) = LOWER(:user_name)"
    ),
    "groupsAll"=> array(
		"id" => "groupsAll",
		"connection" => "monitralldb",
		"query" => "SELECT * FROM  `sec_groups`"
    ),
    "groupsEnabled"=> array(
		"id" => "groupsEnabled",
		"connection" => "monitralldb",
		"query" => "SELECT * FROM  `sec_groups` where enabled=1"
    ),
    "groupById"=> array(
		"id" => "groupById",
		"connection" => "monitralldb",
		"query" => "SELECT * FROM  `sec_groups` where group_id=:uid"
    ), 
	"changeGroupById" => array(
		"id" => "changeGroupById",		
		"connection" => "monitralldb",
		"query" => "UPDATE sec_groups 
		    SET name=:name, description=:description,enabled=:enabled, update_date=CURRENT_TIMESTAMP
            WHERE LOWER(group_id) = LOWER(:group_id)"
    ), 
	"addNewGroup" => array(
		"id" => "addNewGroup",
		"connection" => "monitralldb",
		"query" => "INSERT INTO sec_groups 
		     (group_id, name, description,enabled, update_date)
		     values (:group_id, :name, :description,:enabled, CURRENT_TIMESTAMP)"
    ), 
	"deleteGroupById" => array(
		"id" => "deleteGroupById",
		"connection" => "monitralldb",
		"query" => "DELETE FROM sec_groups where group_id=:uid"
    ),
    "usersAll"=> array(
		"id" => "usersAll",
		"connection" => "monitralldb",
		"query" => "SELECT user_name,is_ldap,name,is_admin, group_id, insert_date, 
		        IF(login_token IS NULL, 1, 0) as registered, enabled
		        FROM  `sec_users`"
    ),
    "userById"=> array(
		"id" => "userById",
		"connection" => "monitralldb",
		"query" => "SELECT user_name,is_ldap,ldap_server,group_id, name, user_email
		    	,user_phone, is_admin, comments, enabled FROM  `sec_users` where user_name=:uid"
    ),
    "userEmailById"=> array(
		"id" => "userEmailById",
		"connection" => "monitralldb",
		"query" => "SELECT user_email
		    	FROM `sec_users` where user_name=:uid"
    ), 
	"changeUserById" => array(
		"id" => "changeUserById",		
		"connection" => "monitralldb",
		"query" => "UPDATE sec_users 
		    SET is_ldap=:is_ldap, ldap_server=:ldap_server, group_id=:group_id,
		    name=:name, user_email=:user_email, user_phone=:user_phone, is_admin=:is_admin, comments=:comments, 
		    enabled=:enabled, update_date=CURRENT_TIMESTAMP
            WHERE LOWER(user_name) = LOWER(:user_name)"
    ), 
	"addNewUser" => array(
		"id" => "addNewUser",		
		"connection" => "monitralldb",
		"query" => "INSERT INTO sec_users 
		    (user_name, is_ldap, ldap_server, group_id, name, user_email, user_phone, is_admin, 
		        comments, enabled, update_date, login_token )
            values (:user_name, :is_ldap, :ldap_server, :group_id, :name, :user_email, :user_phone, :is_admin, 
                :comments, :enabled, CURRENT_TIMESTAMP, :login_token)"
    ), 
	"deleteUserById" //delete user by id
	"resetPasswordFromAdmin" //reset the password from the admin. This removes the old password and sets the resetToken to a random value
    "incrementLockTries" // update and increment by 1 the lock tries
    "resertLockTries" //update to 0 the lock tries
    "groupRights"// returns the group rights
	"deleteGroupRights" // delete group rights
	"addGroupRights" // add a group right
	"checkResetPassToken" // check if reset token exists in the database
	"resetPassword" // reset password based on tokken 
);
```
authmoninapp.js
===============
Mini version of main.js to be used within an application. ????