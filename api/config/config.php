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
 * Config
 *
 * ________________________________________________________
 *
 * @package 
 * @author  Constantinos Evangelou <gieglas@gmail.com>
 * @since   Version 1.0
 */

$monitrall_options = array(
	"useDb" => true,
	"monitrallConnection" => "monitralldb",
	"proxy" => null, //tcp://proxyIp:8080
	"mailserveraddress" => "10.10.10.10",
	"mailserverport" => "25", 
	"webaddress" => "http://localhost:8080/git/monitrall/"
);

/*provider options
mysql
sqlsrv
SYBASE
oci
WEBSERVICE
EXECUTE*/


$db_connections = array (
	"mySQLLocal" => array (
		"id" => "mySQLLocal",
		"server" => "localhost",		
		"port" => "",
		"user" => "listes",
		"pass" => "manager1",
		"name" => "listes", 
		"provider" => "mysql"
	), 
	"WebService" => array (
		"id" => "WebService",
		"server" => "",				
		"port" => "",
		"user" => "",
		"pass" => "",
		"name" => "", 
		"provider" => "WEBSERVICE"
	),
	"Execute" => array (
		"id" => "Execute",
		"server" => "",		
		"port" => "",
		"user" => "",
		"pass" => "",
		"name" => "", 
		"provider" => "EXECUTE"
	), 
	"monitralldb" => array (
		"id" => "monitralldb",
		"server" => "localhost",		
		"port" => "",
		"user" => "monitralldbbare",
		"pass" => "Passw0rd",
		"name" => "monitralldbbare", 
		"provider" => "mysql"
	)
);

$monitrall_notifications_options = array (
	"email" => array (
		"subject" => "Monitrall Notifications #dd#-#mm#-#yyyy#",
		"bodytop" => "The following results have been triggered for notification.<br>",
		"bodybottom" => "For more details visit Monitrall.",
		"to" => array("admin@test.com"),
		"from" => "admin@test.com"
	)
);

?>