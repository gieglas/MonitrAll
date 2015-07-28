appMonitor.js
=============

resultsGroupsModel
---------------------
Object Literal. The model of data. Main data are contained in the groupsData propety. Not Instantiated. No Initialization. 

**Properies**

- *groupsData*
- *frontPageData*
- *tempServiceData*
    
**Methods**

- *getItemByIndex(itemIndex)*
  function to return a specific item object using the index
- *getGroupByIndex(itemIndex)*
  function to return a specific item object using the index
- *getGroupIndexById(group_id)*
  get the index of the group in the listsGroup array
- *getItemById(item_id)*
  get the item object in the groupsData array
- *getGroupById(group_id)*
  get the group object in the groupsData array
- *getFrontPageItems*
  get the front page items

**groupsData sample**

```json

[   {
        "id": "groupId",
        "name": "Group Name",
        "index_num": 0,
        "description": "Group Description .",
        "items": [
            {
                "id": "resultId",
                "name": "Result Name",
                "index_num": 0,
                "group_index_num": 0,
                "description": "Result Description. Can Have *markdown* ",
                "group_id": "groupId",
                "ui_type": "Table",
                "frontpage": "0",
                "display": "1",
                "connection": "",
                "condition_green_operator": "=",
                "condition_green_value": "0",
                "condition_orange_operator": "",
                "condition_orange_value": "",
                "condition_red_operator": ">0",
                "condition_red_value": "1",
                "query": "",
                "datafile": "",
                "display_order": "0",
                "forms": [
                    {
                        "id": "formId",
                        "parent_id": "resultId",
                        "icon": "icon-remove-sign",
                        "name": "Form Name",
                        "form_index_num": 0,
                        "description": "Form Description. Can have *markdown*",
                        "scope": "results",
                        "type": "form",
                        "filter_auto": "0",
                        "connection": "",
                        "default_values_url": "",
                        "query": "",
                        "target": "",
                        "datafile": "",
                        "display_order": "0",
                        "fields": [
                            {
                                "id": "fieldId",
                                "form_id": "formId",
                                "title": "Field Title",
                                "placeholder": "Field Placeholder",
                                "type": "text",
                                "default_value": "",
                                "option_url": "",
                                "required": "1",
                                "valid_test": "digits",
                                "valid_minlength": "0",
                                "valid_maxlength": "8",
                                "display_order": "0"
                            }
                        ]
                    }
                ],
                "lineForms": []
            }
		]
	}
]

```

appRouter
-------------
Object Literal. Works as a router of the application. Uses sammy.js for use of hashed urls. Not Instantiated. 
Initialization by `init` method which also handles the **URL requests**.
With the `do` methods it handles the **actions**
With the `get`, `process` and `sync` methods it handles the **AJAX requests** to the server 
The `responseResponse` method handles all the **AJAX responses** from the server

**URL requests Methods**

- *init*
  all things needed to initialize the views. With Sammy it handles the following url requests. 
  - *#home*
    Home page
  - *#login*
    For login
  - *#results/:iteminid*
    Results by id
  - *#results/:groupIndexId/:itemIndexId*
    Results by groupIndexId and itemIndexId
  - *#results/:groupIndexId/:itemIndexId/:filterName*
    Results being filered 
  - *#about*
    About view
  - *NONE*
    Root

**Action Methods**

- *doHome* 
  Handles the `#home` url requests
  Also called from `resultsView.refreshFrontModuleClick`
- *doResults*
  Handles the `#results` url requests
  Also called from `resultsView.refreshModuleClick`
- *doForm*
  Handles the form requests 
  Called from `resultsView.loadLineForm` and `resultsView.loadLineForm`
- *doFilter*
  Handles the filter requests 
  called from `doForm` and `resultsView.okForm`

**AJAX requests Methods**

- *getServiceData*
  Get data from a Url. Used to complete data on a form that requre getting data from a result
  Requests made usually on `api/getResults` (see `api/index.php`)
  called from `doForm` when constructing a form
- *getResultsGroupList*
  Gets the data for the group list and results and assignes them to the model data
  Requests made to `api/getResultsGroupList` (see `api/index.php`)
  see `resultsGroupsModel.groupsData`
  called from `doHome` and `doResults`
- *getResults*
  Gets the data for the results. 
  Requests made to `api/getResults/` (see `api/index.php`)
  called from `doHome` and `doResults`
- *processForm*
  Processes the form on the server with the dataIn passed (NOT USED)
- *syncServices*
  Calles the sync process on the server. Can process mutliple AJAX requests in a serial way.
  Requests made to `api/syncServices` (see `api/index.php`)
  called from `resultsView.okForm`

**AJAX responses Methods**

- *responseResponse*
  Handles all the AJAX responses from the above Ajax requests

resultsViews
------------
Object Literal. The view object. Not Instantiated. Initialization with `init` method. 
It also handles the UI interaction from the users defined in the `bindEvents` method and other.
With the `render` methods it handles rendering to the page with `mustache.js` template engine. 

**Initialization**

- *init*
  Initializes the binding. 

**UI Interaction**

- *bindEvents*
  Binds the client (on the browser) events. 
- *showMenu*
  Shows or hides the menu. This method is binded in `bindEvents` method.
- *refreshModuleClick*
  Refreshes a module.  This method is binded in `bindEvents` method.
- *csvDownloadClick*
  Download csv. This method is binded in `bindEvents` method.
- *jsonDownloadClick*
  Download JSON. This method is binded in `bindEvents` method.
- *refreshFrontModuleClick*
  Refreshes the from page. This method is binded in `bindEvents` method.
- *loadForm*
  Loads the page scope forms.  This method is binded in `bindEvents` method.
- *loadLineForm*
  Loads the line scope forms. This method is binded in `bindEvents` method.
- *formKeyUp*
  Handles the ENTER and ESC keys on forms. This method is binded in `renderForm` method.
- *closeForm*
  Closes the forms. This method is binded in `renderForm` method.
- *okForm*
  Submits the forms. This method is binded in `renderForm` method.

**Render methods**

- *renderForm*
  Renders the Form using the form definition. 
- *renderResultsSideBar*
  Renders Side Bar using the groups and results definition. 
- *renderBreadcrumbs*
  Renders the BreadCrumbs.
- *renderModuleCommon*
  Renders the commons (top part) of the results view, when a result is viewed in detail. 
- *renderModuleFrontCommon*
  Renders the commons (top part) of the results view, when a result is viewed in the front page. 
- *renderModuleDataTable*
  Renders the data part (bottom part) of the results view, for the table type views. 
- *renderModuleDataDetails*
  Renders the data part (bottom part) of the results view, for the details type views. 
- *renderModuleDataSimple*
  Renders the data part (bottom part) of the results view, for the simple type views. 
- *renderModuleDataConditionals*
  Renders the data part (bottom part) of the results view, for the all the conditionals type views. These types show the red orange green. 
- *renderModuleDataCharts*
  Renders the data part (bottom part) of the results view, for the chart type views. 

------------------------------------------

api/index.php
==========
Works as a controler or router for the API of MonitrAll. All the REST requests come through here and nowhere else.

Dependencies
----------------

- *api/common.php*
- *api/Slim/Slim.php*

HTTP Requests and methods
----------------------------

- *HTTP Method*:`post` *URL*:`syncServices` *PHP Method*:`syncServices`
  Returns any of the services described below when requested in sequence (an array is used)
  The request data must be of the format:

  ```
	[{'name':'PROCESSNAME','data':'PROCESSDATA'},{'name':'PROCESSNAME','data':PROCESSDATA}]
  ```
  - PROCESSNAME = 'getResultsGroupList' | 'getResults' | 'processForm'
  - PROCESSDATA Depends on the process. 
     - For 'getResults' which normally is processed by get
     - the PROCESSDATA is a string with the id of the result e.g. `TestPercent`
     - for `processForm` is an object of type `{'name':'FORMNAME','data':FORMDATA}`
  
- *HTTP Method*:`post` *URL*:`/getResults/:name` *PHP Method*:`getResults`
  Returns the data for the results. Accepts an argument `name` and adittional parameters 
- *HTTP Method*:`get` *URL*:`/getResultsGroupList` *PHP Method*:`getResultsGroupList`
  Returns the data for the group list and results to be used on the client side
- *HTTP Method*:`post` *URL*:`/getConnectionsList` *PHP Method*:`getConnectionsList`
  Returns the connections' list.
- *HTTP Method*:`post` *URL*:`/processForm` *PHP Method*:`processForm`
  Processes the form on the server with the dataIn passed (NOT USED).
- *HTTP Method*:`get` *URL*:`/test` *PHP Method*:`doTest`
  Fort testing and debuging purposes.

------------------------------------------

api/common.php
==========
Contains all the common methods for MonitrAll's API, including the methods for retrieving data for resuts and executing forms. 

Dependencies
-----------------

- *config/monitrallQueries.php*
- *config/config.php*
- *../lib/swift/swift_required.php*

Methods
-----------

###_getData###

Gets the data from any source defined in connections in `config/config.php`. 
It can get data from (*Provider Types*) :

- *Database* using `PDO` (see `_getOpenPDOConnection`). Available providers:
  - *mysql* : Provider for mysql
  - *sqlsrv* : Provider for Microsoft Sql Server
  - *oci* : Provider for Oracle
  - *SYBASE*: Provider for Sybase
- *WebService* or local file using the `file_get_contents` function. The web service response is expected to be in `JSON` format.
- *Execute* using `exec` function. To get the results, the function reads everything that is followed by `<MonitrAll>`. The results are expected to be in `JSON` format

```php
 _getData($name,$itemsData,$formData,$connections,$parameters = array(),$format="JSON")
```

The results are returned in the format defined in the `$format` argument.

###_doForm###

Executes commands on any source defined in connections in `config/config.php`. 
It can execute with (*Provider Types*) :

- *Database* using `PDO` (see `_getOpenPDOConnection`). Available providers:
  - *mysql* : Provider for mysql
  - *sqlsrv* : Provider for Microsoft Sql Server
  - *oci* : Provider for Oracle
  - *SYBASE*: Provider for Sybase
- *WebService* or local file using the `file_get_contents` function. The web service response is expected to be in `JSON` format.
- *Execute* using `exec` function. To get the results, the function reads everything that is followed by `<MonitrAll>`. The results are expected to be in `JSON` format

```php
_doForm($requestData,$formData,$connections,$format="JSON") 
```

Example of `$requestData` in JSON:

```JSON
{
    "name":"formName",
    "data": [
        {"name":"lineid", "value":"1233212"},
        {"name":"otherField","value":"Some value"}
    ]
}
```

Example of `$requestData` in PHP:

```PHP
stdClass Object (
    [name] => "formName",
    [data] => Array (
            stdClass Object (
                [name] => "lineid",
                [value] => "1233212"
            ),
            stdClass Object (
                [name] => "otherField",
                [value] => "Some value"
            )
        )
    )
```

The results are returned in the format defined in the `$format` argument. The return can be:

```json
{"success":{"text":"Success"}}
{"error":{"text":"error message"}}
```

###_getOpenPDOConnection###

Creates the PDO Connection object depending on the provider name. Currently it supports the following providers:

- **mysql** : Provider for mysql using the `PDO_MYSQL` extension
- **sqlsrv** : Provider for Microsoft Sql Server using the `PDO_SQLSRV` extension
- **oci** : Provider for Oracle using the `PDO_OCI` extension 
- **SYBASE**: Provider for Sybase using the `PDO_ODBC` extension

Please find below instractions on using these extensions (on windows)

**MySQL** using **PDO_MYSQL** extension seemed to be installed on xampp by default didn’t have to do much work. Here is the code I used for the connection:

```
$connStr = "mysql:host=".$myServer.";dbname=".$myDB; 
$conn = new PDO($connStr,$myUser,$myPass);  
```

**Microsoft SQL Server** using **PDO_SQLSRV** followed the instructions on http://craigballinger.com/blog/2011/08/usin-php-5-3-with-mssql-pdo-on-windows/. Here is the code I used:

```
$connStr = "sqlsrv:Server=".$myServer.";Database=".$myDB; 
$conn = new PDO($connStr,$myUser,$myPass);
```

**Oracle** with **PDO_OCI**. Download and install the proper Oracle Instant Client on your windows machine for example instantclient_12_1 and add its path to PATH in SYSTEM Environmental Variables. Note Oracle supports only 2 versions down so select your client version properly. Do that and then restart your Apache. Here is the code I used:

```
$tns = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$myServer.")(PORT = 1521)))(CONNECT_DATA=(SID=".$myDB.")))"; 
$connStr = "oci:dbname=".$tns;      
$conn = new PDO($connStr,$myUser,$myPass);  
```

**Sybase** with **PDO_ODBC** Must have Sybase ASE ODBC Driver which comes with the SDK. Here is the code I used:

```
$connStr = "odbc:Driver={Adaptive Server Enterprise};server=".$myServer.";port=".$myPort.";db=".$myDB;
$conn = new PDO($connStr,$myUser,$myPass);  
```

###_getGroupData###

Returns an array of Group Objects (with the repsected Result objects for each group). It uses `_getGroupItemsArray` to complete the results objects. 

```php
_getGroupData($groupData,$itemsData,$formsData)
```

*NOTE*
The `$groupData`,`$itemsData`,`$formsData` must already be retreived from the DB

###_getGroupItemsArray###

Returns an array of results objects for a group (defined by `$id`). It also includes all forms which gets with `_getItemsFormsArray` and `_getItemsLinesFormsArray`.
For security reasons the `connection` and `query` values are not copied.
```php
_getGroupItemsArray($data,$formsData,$id,$groupIndexNum)
```

*NOTE*
The `$groupData`,`$itemsData`,`$formsData` must already be retreived from the DB


###_getItemsFormsArray###

Returns an array of Forms specific to a Result. 
For security reasons the `connection` and `query` values are not copied.

```php
_getItemsFormsArray($formsData,$id)
```

*NOTE*
The `$groupData`,`$itemsData`,`$formsData` must already be retreived from the DB

###_getItemsLinesFormsArray###

Returns an array of Line Forms specific to a Result. 
For security reasons the `connection` and `query` values are not copied.

```php
_getItemsLinesFormsArray($formsData,$id)
```

*NOTE*
The `$groupData`,`$itemsData`,`$formsData` must already be retreived from the DB

###_getMonitrallGroupsFromDB###

Returns an array of Groups from the DB. Uses the `_getData` method with the  `MonitrallGroupsById` or `MonitrallGroups` query which can be found at `api/config/monitrallQueries.php` 

```php
_getMonitrallGroupsFromDB($name = null)
```

###_getMonitrallResultsFromDB###

Returns an array of Results from the DB. Uses the `_getData` method with the  `MonitrallResultsById` or `MonitrallResults` query which can be found at `api/config/monitrallQueries.php` 

```php
_getMonitrallResultsFromDB($name = null)
```

###_getMonitrallNotificationResults###

Returns an array of Notifications from the DB. Uses the `_getData` method with the  `MonitrallNotificationResults` query which can be found at `api/config/monitrallQueries.php` 

```php
_getMonitrallNotificationResults()
```


###_updateNotificationsNextDate###

Updates the next date in the Notifications table. Uses `_doForm` method with the `MonitrallUpdateNotifications` query which can be found at `api/config/monitrallQueries.php` 

```php
_updateNotificationsNextDate($idIn,$nextDateIn)
```

###_getMonitrallFormsFromDB###

Returns an array of Forms from the DB. Uses the `_getData` method with the  `MonitrallFormsById` or `MonitrallFormsByResultId` query which can be found at `api/config/monitrallQueries.php` 

```php
_getMonitrallFormsFromDB($name = null,$by = "id")
```

###_getMonitrallObjects###

Uses the getMonitrall____db methods (see above) to return Monitrall objects (Arrays) from the database. It can return one of the following:

- *Groups*
- *Results*
- *Forms*
- *FormsByResultId*
- *NotificationResults*
- *Connections*

```php
_getMonitrallObjects($objectType,$name = null)
```

###_compare###

Compares `$post` with `$value` using an `$operator` and returns a `boolean` value. This function is used mainly for server side comparisons such as email notifications. 
It can compare using the following operators:

- *>*
- *<*
- *>=*
- *<=*
- *==*
- *!=*
- *===*
- *!==*
- *><*

```php
 _compare($post, $operator, $value)
```

###_getResultCompareData###

Gets the details of a result, executes the query and gets the data, and performs the comparisons. 
Note that in order for the comparison the data that are returned from the query must contain at least one column named `value` for each row. 
Example of the object ir returns:

```php
stdClass Object (
    [name] => "resultName",
    [description] => "result description",
    [hasRed] => true,
    [hasGreen] => false,
    [hasOrange] => false,
    [data] => Array (
            stdClass Object (
                [name] => "lineid",
                [value] => "1233212"
            ),
            stdClass Object (
                [name] => "otherField",
                [value] => "Some value"
            )
        )
    )
```

```php
_getResultCompareData($name)
```

###_printCompareResult###

Uses an array of objects described in `_getResultCompareData` and returns HTML code to with a table of the results, with the indication of `RED|GREEN|ORANGE`.
Note that this method only prints the columns `name` and `value` for each row. 

```php
_printCompareResult($reportRes,$bodyTop ="",$bodyBottom="")
```

###_sendNotificationEmail###

Sends an email using the `_printCompareResult` method described above. 
It uses the `Swift` library to send the email

```php
_sendNotificationEmail($reportRes,$eMails=null)
```

###_replaceSpecialTags###

Replaces `#dd#` with the current number of day, `#mm#` the current month number and `#yyyy#` with he current year number. 

```php
_replaceSpecialTags($strIn)
```

###_is_cli###

Checks if it is run on commandline. 

Data
------

The following data types/objects are used throughout the file. 

###$groupData###

is the array of objects that represent a group. i.e. 

```php
Array ( 
    "Test" => Array ( 
        "id" => "Test"
        "name" => "Test Modules"
        "index_num" => 
        "description" => "Test." 
    ), 
    "TestChart" => Array ( 
        "id" => "TestChart "
        "name" => "Test Chart "
        "index_num" => 
        "description" => "Test Chart. "
    )
)
```

###$itemsData###

is the array of objects that represent items (results). i.e.

```php
Array ( 
    "TestTable" => Array ( 
        "id" => "TestTable",
        "name" => "Test Table",
        "index_num" => ,
        "group_index_num" => ,
        "description" => "Test full table",
        "group_id" => "Test",
        "ui_type" => "Table",
        "frontpage" => 0, 
        "display" => 1, 
        "connection" => "WebService",
        "condition_green_operator" => "==",
        "condition_green_value" => "0",
        "condition_orange_operator" => ">",
        "condition_orange_value" => "1", 
        "condition_red_operator" => "==" ,
        "condition_red_value" => "1", 
        "query" => "../data/testdata.json",
        "datafile" =>, 
        "display_order" => "0" 
    ),
    "MonitrallResults" => Array ( 
        "id" => "MonitrallResults",
        "name" => "Results",
        "index_num" => ,
        "group_index_num" => ,
        "description" => "Table of MonitrAll Results",
        "group_id" => "Admin",
        "ui_type" => "Table",
        "frontpage" => 0, 
        "display" => 1, 
        "connection" => "monitralldb",
        "condition_green_operator" => ,
        "condition_green_value" => ,
        "condition_orange_operator" => ,
        "condition_orange_value" => , 
        "condition_red_operator" =>  ,
        "condition_red_value" => , 
        "query" => "SELECT  * FROM  results 
		    where enabled = 1
			order by display_order asc",
        "datafile" =>, 
        "display_order" => "0" 
    )
)

```

###$formData###

is the array of objects that represent forms. i.e.

```php
Array ( 
    "mySQLAddList" => Array ( 
        "id" => "mySQLAddList",
        "parent_id" => "mySQLLists",
        "icon" => "icon-plus",
        "name" => "Add list",
        "form_index_num" => ,
        "description" => "Will insert a row on Lists",
        "scope" => "results",
        "type" => "form",
        "filter_auto" => 0 
        "connection" => "mySQLLocal",
        "default_values_url" => ,
        "query" => "INSERT INTO list (name) VALUES (:itemTitle)",
        "target" => ,
        "datafile" => ,
        "display_order" => 0 ,
        "fields" => Array ( 
            "0" => Array ( 
                "id" => "itemTitle",
                "form_id" => "mySQLAddList", 
                "title" => "Item value", 
                "placeholder" => "Enter the value. ",
                "type" => "text",
                "default_value" => ,
                "option_url" => ,
                "required" => 1 ,
                "valid_test" => ,
                "valid_minlength" => 0 ,
                "valid_maxlength" => 100, 
                "display_order" => 0 
                ) 
            ) 
        ) 
    )
```

###$connections###

the array of objects that represent the connections. i.e.

```php
array (
	"mySQLLocal" => array (
		"id" => "mySQLLocal",
		"server" => "localhost",		
		"port" => "",
		"user" => "listes",
		"pass" => "*********",
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
	"monitrallusersdb" => array (
		"id" => "monitrallusersdb",
		"server" => "localhost",		
		"port" => "",
		"user" => "phploginonefile",
		"pass" => "********",
		"name" => "phploginonefile", 
		"provider" => "mysql"
	), 
	"monitralldb" => array (
		"id" => "monitralldb",
		"server" => "localhost",		
		"port" => "",
		"user" => "monitralldbbare",
		"pass" => "*******",
		"name" => "monitralldbbare", 
		"provider" => "mysql"
	)
)
```
  
###$parameters###

An array of variable parameters to be passed in a query. 

###$format###

the input or output format. Can be either `ARRAY` or `JSON`

------------------------------------------

api/customChecks.php
===============

CustomChecks works only from the command line and performs the checks on the results defined in the parameters. 
The program will get the results from the specified results and insert a record in the `checks` table for each result, as defined in the `MonitrallInsertChecks` query in the `config/monitrallQueries.php`.
The record that will be saved will contain the `check_id`,`result_id`,`has_red`,`has_orange`,`has_green`,`has_no_values`. 
Can be called with some kind of scheduler e.g. windows schedule tasks.
The program uses the `_getResultCompareData` defined in `api/common.php`

Dependencies
----------------

- *api/common.php*

How to call
-----------

```
C:\php\php.exe -f C:\Code\htdocs\monitrall\api\customChecks.php resultName1,resultName2,resultName3
```

------------------------------------------

api/customNotifications.php
==========================
customNotifications works only from the command line and performs the checks on the results defined in the parameters and sends an email with the results. 
When calling the program the user can define which results to check, on what occasion to send an email (red|orange|green|all) and on which emails to send. If no email is defined the email from `config.php` is used. 
Can be called with some kind of scheduler e.g. windows schedule tasks.
The program uses the `_getResultCompareData` and `_sendNotificationEmail` defined in `api/common.php`

Dependencies
------------
- *api/common.php*
- *../lib/swift/swift_required.php*

How to call:
------------

```
C:\php\php.exe -f C:\Code\htdocs\monitrall\api\customMotifications.php resultName1,resultName2,resultName3 red|orange|green|all [email@company.com,other@company.com]
```

------------------------------------------

api/customStats.php
===================
customStats works only from the command line and gets the values on the results defined in the parameters. 
The program will get the results from the specified results and insert a record in the `stats` table for each result, as defined in the `MonitrallInsertStats` query in the `config/monitrallQueries.php`.
The record that will be saved will contain the `stat_id`,`result_id`,`name`,`value` . 
Can be called with some kind of scheduler e.g. windows schedule tasks.
The program uses the `_getResultCompareData` defined in `api/common.php`

Dependencies
----------------

- *api/common.php*

How to call
-----------

```
C:\php\php.exe -f C:\Code\htdocs\monitrall\api\customStats.php resultName1,resultName2,resultName3
```

------------------------------------------

api/notifications.php
==========================
notifications works only from the command line and performs the checks on the results defined in the `notification` table and sends an email with the results. 
Can be called with some kind of scheduler e.g. windows schedule tasks. The program checks if the next notify time has passed when called and performs the check on that result. 
For more detailed notifications options the `api/commonNotifications.php` is preferred.


Dependencies
------------
- *api/common.php*
- *../lib/swift/swift_required.php*

How to call:
------------

```
C:\php\php.exe -f C:\Code\htdocs\monitrall\api\notifications.php
```

------------------------------------------

.htaccess
=========

Required by `Slim` framework. 

```
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]
```

------------------------------------------

config/config.php
=================
Defines the general options, connections and notifications options of the system.

**monitrall_options**

- *useDb* Not used
- *monitrallConnection* define the connection id for executing MonitrAll's queries
- *proxy* define the proxy can have values like `null` or  `//tcp://proxyIp:8080`
- *mailserveraddress* define the SMTP mail server address
- *mailserverport* define the SMTP mail server port
- *webaddress* define the base URL of the web application. It is used in the email links.

**db_connections**
see `api/common.php`

**monitrall_notifications_options**

- *subject* the subject of the email
- *bodytop* the top part of the email 
- *bodybottom* the bottom part of the email 
- *to* the default email address to send 
- *from* the from part of the email 

------------------------------------------

config/monitrallQueries.php
===========================
Defines all the queries used by the MonitrAll system.

**Queries**

- *MonitrallGroups* Gets all of the groups details
- *MonitrallResults* Gets all of the results details
- *MonitrallForms* Gets all of the forms details
- *MonitrallFieldsByForm* Get the form fields details by form id
- *MonitrallGroupsById* Gets the group details by group id
- *MonitrallResultsById* Gets the result details by result id
- *MonitrallFormsById* Gets the form details by form id 
- *MonitrallFormsByResultId* Gets the forms detals by result id 
- *MonitrallNotificationResults* Gets the next notifications
- *MonitrallUpdateNotifications* Updates the next notify date of a notification
- *MonitrallInsertStats* Inserts a statistic record
- *MonitrallMaxStatId* Gets the maximum statistic Id
- *MonitrallInsertChecks* Inserts a checks record
- *MonitrallMaxCheckId* Gets the maximum check Id
