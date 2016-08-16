<?php

$JWTOptions = array(
	'key' => 'c7QIOPcceGPgZNhAR1itBkOk6CIYeUfn80jk6G9YzNvuOWM0GfpYQ8Jd4z1dIv+xLlPwua2gJJBvsaubnRJruA==',    // Key for signing the JWT's, I suggest generate it with base64_encode(openssl_random_pseudo_bytes(64))
	'issuer' => 'MonotrAll_api',
	'audience' => 'MonitrAll_clients',
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
		"server" => "localhost",		
		"port" => "",
		"user" => "monitralldbbare",
		"pass" => "Passw0rd",
		"name" => "monitralldbbare", 
		"provider" => "mysql"
	),
	"email" => array (
	    "server" => "mailtrap.io",
	    "port" => 2525,
	    "username" => "b12bd8614bb0e8", //if not used set to null
	    "password" => "ec8ecaf96a3e7e", //if not used set to null
		"subject" => "Monitrall User",
		"bodytop" => "<html>This email was produced automatically from MonitrAll's Security module.<br>",
		"bodybottom" => "For more details visit Monitrall.</html>",
		"to" => "test@test.com",
		"from" => array('noreply@monitrall.com' => 'MonitraAll Admin')
	),
	//"webaddress" => "http://localhost:8080/git/monitrall/",
	"webaddress" => "http://db.gieglas.koding.io/MonitrAll/authmon/",
	"resetPasswordAddress" => "resetPass.php"
); 

$JWTQueries = array(
	"checkUser" => array(
		"id" => "checkUser",		
		"connection" => "monitralldb",
		"query" => "SELECT a.ldap_server, a.user_name, a.user_password_hash, a.is_ldap, a.name, a.is_admin, a.lock_tries, a.lock_date, 
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
	"deleteUserById" => array(
		"id" => "deleteUserById",
		"connection" => "monitralldb",
		"query" => "DELETE FROM sec_users where user_name=:uid"
    ), 
	"resetPasswordFromAdmin" => array(
		"id" => "resetPasswordFromAdmin",		
		"connection" => "monitralldb",
		"query" => "UPDATE sec_users 
		    SET user_password_hash=null, login_token=:login_token, update_date=CURRENT_TIMESTAMP
            WHERE LOWER(user_name) = LOWER(:uid)"
    ),
    "incrementLockTries"=> array(
		"id" => "incrementLockTries",
		"connection" => "monitralldb",
		"query" => "UPDATE sec_users SET lock_tries=lock_tries+1 
		        ,lock_date = now()
            WHERE LOWER(user_name) = LOWER(:user_name)"
    ),
    "resertLockTries"=> array(
		"id" => "incrementLockTries",
		"connection" => "monitralldb",
		"query" => "UPDATE sec_users SET lock_tries=0 
		        , lock_date = NULL, last_login_date=now()
            WHERE LOWER(user_name) = LOWER(:user_name)"
    ),
    "groupRights"=> array(
		"id" => "groupRights",
		"connection" => "monitralldb",
		"query" => "SELECT a.id, CONCAT(a.group_id, ' - ' , a.name) as name, group_id,
        	(SELECT count(*) FROM sec_groupsresults b
            WHERE a.id = b.result_id AND b.group_id=:uid) AS has_right
        	FROM results a
        	ORDER BY a.group_id, a.display_order"
    ), 
	"deleteGroupRights" => array(
		"id" => "deleteGroupRights",
		"connection" => "monitralldb",
		"query" => "DELETE FROM sec_groupsresults where group_id=:uid"
    ), 
	"addGroupRights" => array(
		"id" => "addGroupRights",
		"connection" => "monitralldb",
		"query" => "INSERT INTO sec_groupsresults 
		    (group_id, result_id, update_date)
		    values (:group_id,:result_id, CURRENT_TIMESTAMP) "
    ), 
	"checkResetPassToken" => array(
		"id" => "checkResetPassToken",		
		"connection" => "monitralldb",
		"query" => "SELECT login_token FROM sec_users 
           WHERE login_token = :loginToken"
    ), 
	"resetPassword" => array(
		"id" => "resetPassword",		
		"connection" => "monitralldb",
		"query" => "UPDATE sec_users 
			SET user_password_hash=:password , login_token=NULL, last_pwd_update_date=now()
            WHERE login_token = :loginToken"
    )
);

?>