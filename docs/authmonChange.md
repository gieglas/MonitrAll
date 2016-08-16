Changes made to include authmon.

api/.htaccess
=========

added rule to allow http authentication 

api/common.php
==========

_getGroupData
--------------

if admin show all else show what is allowed. (dashboard)

_getMonitrallGroupsFromDB
-------------------------

if admin show all else show what is allowed. (Groups)

_getMonitrallResultsFromDB
-------------------------

if admin show all else show what is allowed. (Results)

_getMonitrallFormsFromDB
------------------------

if admin show all else show what is allowed. (Forms)

_getMonitrallDashboardsFromDB
-----------------------------

if admin show all else show what is allowed. (Dashboards)

_getMonitrallObjects
--------------------

pass user_id and isAdmin information in functions

api/config/field_types.json
============================

added password field

api/config/monitrallQueries.php
===============================

added queries for getting MonitrAll objects based on user information 

- MonitrallGroupsUser
- MonitrallResultsUser
- MonitrallFormsUser
- MonitrallDashboardsUser
- MonitrallDashResultsByDashIdUser

api/index.php
=============

Changed to check if user is logged in and authorized

Changes made in:

- syncServices($name)
- getResultsGroupList()
- getResults($name)
- processForm()

index.php
==========
removed the previous session based authentication

webapp/tmpl/globalHead.tmpl
===========================

added js scripts for authentication (authmoninapp.js)

webapp/tmpl/globalTop.tmpl
==========================

changed logged in link with new authentication 

webapp/tmpl/tmplForms.tmpl
==========================

added support for password field

webapp/js/appMonitor.js
=======================

changes to:

- go to new login page when needed `window.location.replace('authmon/?r=../');`
- added `headers: {"Authorization": "Bearer "+ localStorage.token},` in the ajax calls
- on ajax error show the following message : `authmonInApp.ajaxError(jqXHR, textStatus, errorThrown);`
- added the `authmonInApp.renewTokenCommon();` before any ajax call
- changed the syncServices:function to include the id of the result 
- added support for password field
- change the user name on the screen `$('#loggedInAs').html(tokenobj.name); ` 



