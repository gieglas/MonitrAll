purpose to create login page 

authmon.php
============

1. asdas
2. 

main.js
=======


login.php
=========

changeUserDetails.php
=====================


resetPassword.php
=================


adminUsers
    adminUserDetails
    
adminGroups
    adminGroupDetails
    
    
use monitralldbbare;

CREATE TABLE `sec_users` (
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The User name',
  `is_ldap` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to set as LDAP user',
  `ldap_server` varchar(255) COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'The Ldap Server i.e. ldap://10.10.10.10',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT 'The User password',
  `group_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The group id',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The Real name',
  `user_email` varchar(255) COLLATE utf8_unicode_ci  NOT NULL COMMENT 'The User email',
  `user_phone` varchar(255) COLLATE utf8_unicode_ci  NULL COMMENT 'The User telephone',
  `is_admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to set as administrator',
  `comments` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Any other comments',  
  `login_token` varchar(255) COLLATE utf8_unicode_ci  NULL DEFAULT NULL COMMENT 'The login tocken',
  `last_login_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Latest Login date time',
  `lock_tries` int(2) NOT NULL DEFAULT '0' COMMENT 'Number of incorrect password tries',
  `lock_date` timestamp NULL COMMENT 'Latest Locked date time',
  `last_pwd_update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Latest Password Update date time',
  `enabled` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to enable',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Insert date time',
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
  PRIMARY KEY (`user_name`),
  UNIQUE KEY `user_email_UNIQUE` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='The Security Users Table ';

CREATE TABLE `sec_groups` (
  `group_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The group id',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The Security Group name',
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The Security Group Description',
  `enabled` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to enable',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Insert date time',
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='The Security Groups Table ';

ALTER TABLE `sec_users`
  ADD CONSTRAINT `sec_users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `sec_groups` (`group_id`);
  
CREATE TABLE `sec_groupsresults` (    
    `group_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The group id',
    `result_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Result Id',
    `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
    PRIMARY KEY (`group_id`, `result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Connects Security Groups table with the Results table';

ALTER TABLE `sec_groupsresults`    
  ADD CONSTRAINT `sec_groupsresults_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `sec_groups` (`group_id`),
  ADD CONSTRAINT `sec_groupsresults_ibfk_2` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`);

-------
-- add group
INSERT INTO `monitralldbbare`.`groups` (`id`, `name`, `index_num`, `description`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES ('useradmin', 'User Admin', NULL, 'User Administration.', '1001', '1', '2013-09-06 09:25:39', '2013-09-06 10:21:27');

-- add user groups admin result
INSERT INTO `monitralldbbare`.`results` (`id`, `name`, `index_num`, `group_index_num`, `description`, `group_id`, `ui_type`, `frontpage`, `display`, `connection`, `condition_green_operator`, `condition_green_value`, `condition_orange_operator`, `condition_orange_value`, `condition_red_operator`, `condition_red_value`, `query`, `filter_query`, `datafile`, `display_order`, `notify_enable`, `notify_freq`, `notify_interval`, `start_notify_date`, `next_notify_date`, `enabled`, `insert_date`, `update_date`) VALUES ('userAdminGroupsModule', 'User Groups', NULL, NULL, 'Edit the User Groups.', 'useradmin', 'Table', '0', '1', 'monitralldb', '', '', '', '', '', '', 'SELECT `group_id` as lineid, `name`, `description`,`enabled`, 
(select count(*) from sec_users c where c.group_id= a.group_id) as users,
(select count(*) from sec_groupsresults c where c.group_id= a.group_id) as results
FROM `sec_groups` a order by name asc', NULL, '', '0', '0', '', '0', '0000-00-00 00:00:00', NULL, '1', '2013-09-11 12:23:17', '2015-07-15 06:16:50');

INSERT INTO `monitralldbbare`.`results` (`id`, `name`, `index_num`, `group_index_num`, `description`, `group_id`, `ui_type`, `frontpage`, `display`, `connection`, `condition_green_operator`, `condition_green_value`, `condition_orange_operator`, `condition_orange_value`, `condition_red_operator`, `condition_red_value`, `query`, `filter_query`, `datafile`, `display_order`, `notify_enable`, `notify_freq`, `notify_interval`, `start_notify_date`, `next_notify_date`, `enabled`, `insert_date`, `update_date`) VALUES ('userAdminGroupsLine', 'User Groups Line', NULL, NULL, 'Used when editing a line', 'useradmin', 'Table', '0', '0', 'monitralldb', '', '', '', '', '', '', 'SELECT group_id as group_idIn, name as nameIn, description as descriptionIn, enabled as enabledIn 
from sec_groups 
where group_id = :lineid
order by name asc', NULL, '', '1', '0', NULL, NULL, NULL, NULL, '1', '2013-09-11 12:24:32', '2013-09-11 12:33:48');

INSERT INTO `monitralldbbare`.`results` (`id`, `name`, `index_num`, `group_index_num`, `description`, `group_id`, `ui_type`, `frontpage`, `display`, `connection`, `condition_green_operator`, `condition_green_value`, `condition_orange_operator`, `condition_orange_value`, `condition_red_operator`, `condition_red_value`, `query`, `filter_query`, `datafile`, `display_order`, `notify_enable`, `notify_freq`, `notify_interval`, `start_notify_date`, `next_notify_date`, `enabled`, `insert_date`, `update_date`) VALUES ('userAdminGroupsSelect', 'User Groups Select', NULL, NULL, 'Used in select inputs ', 'useradmin', 'Table', '0', '0', 'monitralldb', '', '', '', '', '', '', 'SELECT group_id as value, name
from sec_groups 
order by name asc', NULL, '', '2', '0', NULL, NULL, NULL, NULL, '1', '2013-09-11 12:26:06', '2013-09-11 12:33:55');

-- add user groups admin forms
INSERT INTO `monitralldbbare`.`forms` (`id`, `parent_id`, `icon`, `name`, `form_index_num`, `description`, `scope`, `type`, `filter_auto`, `connection`, `default_values_url`, `query`, `target`, `datafile`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES ('userAdminAddGroups', 'userAdminGroupsModule', 'icon-plus', 'Add User Group', NULL, 'Enter the user group details below to add a new group of results.', 'results', 'form', '0', 'monitralldb', '', '
INSERT INTO sec_groups (group_id, name, description, enabled, update_date) VALUES (
:group_idIn, 
:nameIn, 
:descriptionIn, 
:enabledIn, 
CURRENT_TIMESTAMP);', '', NULL, '0', '1', '2013-09-13 05:14:32', '2013-09-13 05:14:32');
-- edit user groups admin form 
INSERT INTO `monitralldbbare`.`forms` (`id`, `parent_id`, `icon`, `name`, `form_index_num`, `description`, `scope`, `type`, `filter_auto`, `connection`, `default_values_url`, `query`, `target`, `datafile`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES ('userAdminEditGroups', 'userAdminGroupsModule', 'icon-pencil', '', NULL, 'Edit the user group details.', 'line', 'form', '0', 'monitralldb', 'api/getResults/userAdminGroupsLine', 'UPDATE sec_groups set group_id=:group_idIn, name=:nameIn, description=:descriptionIn, enabled=:enabledIn , update_date=CURRENT_TIMESTAMP where group_id=:lineid;', '', NULL, '1', '1', '2013-09-13 06:12:36', '2013-09-13 06:20:10');

-- add delete form
INSERT INTO `monitralldbbare`.`forms` (`id`, `parent_id`, `icon`, `name`, `form_index_num`, `description`, `scope`, `type`, `filter_auto`, `connection`, `default_values_url`, `query`, `target`, `datafile`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES ('userAdminDeleteGroups', 'userAdminGroupsModule', 'icon-remove', '', NULL, 'Delete the specific group.', 'line', 'form', '0', 'monitralldb', '', 'delete from sec_groups where group_id = :lineid;', '', NULL, '2', '1', '2013-09-13 06:20:00', '2013-09-13 06:20:00');

-- fields for userAdminAddGroups
INSERT INTO `monitralldbbare`.`fields` (`fieldid`, `id`, `form_id`, `title`, `placeholder`, `type`, `default_value`, `option_url`, `required`, `valid_test`, `valid_minlength`, `valid_maxlength`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES (NULL, 'group_idIn', 'userAdminAddGroups', 'User Group Id', 'Enter user group id number.', 'text', '', '', '1', 'alphanum', '0', '255', '0', '1', '2013-09-13 05:15:41', '2013-09-13 05:15:41');
INSERT INTO `monitralldbbare`.`fields` (`fieldid`, `id`, `form_id`, `title`, `placeholder`, `type`, `default_value`, `option_url`, `required`, `valid_test`, `valid_minlength`, `valid_maxlength`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES (NULL, 'nameIn', 'userAdminAddGroups', 'User Group Name', 'Enter the user group name.', 'text', '', '', '1', '', '0', '255', '1', '1', '2013-09-13 05:16:24', '2016-04-19 10:44:55');
INSERT INTO `monitralldbbare`.`fields` (`fieldid`, `id`, `form_id`, `title`, `placeholder`, `type`, `default_value`, `option_url`, `required`, `valid_test`, `valid_minlength`, `valid_maxlength`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES (NULL, 'descriptionIn', 'userAdminAddGroups', 'User Group Description', 'Enter the user group description.', 'textarea', '', '', '1', '', '1', '6000', '2', '1', '2013-09-13 05:17:25', '2013-09-13 05:17:25');
INSERT INTO `monitralldbbare`.`fields` (`fieldid`, `id`, `form_id`, `title`, `placeholder`, `type`, `default_value`, `option_url`, `required`, `valid_test`, `valid_minlength`, `valid_maxlength`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES (NULL, 'enabledIn', 'userAdminAddGroups', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', '1', 'digits', '0', '1', '3', '1', '2013-09-13 05:19:36', '2013-09-13 05:19:36');

-- fields for userAdminEditGroups
INSERT INTO `monitralldbbare`.`fields` (`fieldid`, `id`, `form_id`, `title`, `placeholder`, `type`, `default_value`, `option_url`, `required`, `valid_test`, `valid_minlength`, `valid_maxlength`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES (NULL, 'group_idIn', 'userAdminEditGroups', 'User Group Id', 'Enter user group id number.', 'text', '', '', '1', 'alphanum', '0', '255', '0', '1', '2013-09-13 05:15:41', '2013-09-13 05:15:41');
INSERT INTO `monitralldbbare`.`fields` (`fieldid`, `id`, `form_id`, `title`, `placeholder`, `type`, `default_value`, `option_url`, `required`, `valid_test`, `valid_minlength`, `valid_maxlength`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES (NULL, 'nameIn', 'userAdminEditGroups', 'User Group Name', 'Enter the user group name.', 'text', '', '', '1', '', '0', '255', '1', '1', '2013-09-13 05:16:24', '2016-04-19 10:44:55');
INSERT INTO `monitralldbbare`.`fields` (`fieldid`, `id`, `form_id`, `title`, `placeholder`, `type`, `default_value`, `option_url`, `required`, `valid_test`, `valid_minlength`, `valid_maxlength`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES (NULL, 'descriptionIn', 'userAdminEditGroups', 'User Group Description', 'Enter the user group description.', 'textarea', '', '', '1', '', '1', '6000', '2', '1', '2013-09-13 05:17:25', '2013-09-13 05:17:25');
INSERT INTO `monitralldbbare`.`fields` (`fieldid`, `id`, `form_id`, `title`, `placeholder`, `type`, `default_value`, `option_url`, `required`, `valid_test`, `valid_minlength`, `valid_maxlength`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES (NULL, 'enabledIn', 'userAdminEditGroups', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', '1', 'digits', '0', '1', '3', '1', '2013-09-13 05:19:36', '2013-09-13 05:19:36');
--------------------------------------------------------------------------------------------
--selects for useradmin groups
--userAdminGroupsModule

--AdminGroupsSelect
--SELECT group_id as value, name
--FROM `sec_groups` 
--order by name asc

--Results SELECT
--select a.id , CONCAT(b.name , ' - ' , a.name) as name 
--from results a
--inner join groups b on a.group_id=b.id
--order by b.display_order, a.display_order asc

-- display rights
select a.id, a.name, a.group_id, 
	(select count(*) from sec_groupsresults b
    where a.id = b.result_id and b.group_id='none') as has_right
	from results a
	order by a.group_id, a.display_order
	
------
added in HTML Header 
  <script src="authmon/js/authmoninapp.js"></script>
  <script>
  authmonInApp.init();
  </script>

AJAX in Monitrall

//in all ajax calls functions have added 
//login: renew token
authmonInApp.renewTokenCommon();
//and in the ajax calls
headers: {"Authorization": "Bearer "+ localStorage.token},

getServiceData
	Used to load options  (No authentication)
			Default options (No authentication)
getResultsGroupList url:api/getResultsGroupList
	Used to get the data (groups, dashboards, results, forms, fields)  DONE (YES Authentication)
		common.php function _getGroupData (need to change sql for Dashboards (query 'MonitrallDashResultsByDashId') )

------------------ DONE ---------------------
SELECT a.dash_id, a.result_id, a.display_order, b.name FROM dashresults a 
			INNER JOIN results b ON a.result_id = b.id
			INNER JOIN dashboards c ON a.dash_id = c.id
			INNER JOIN sec_groupsresults d ON a.result_id = d.result_id
			INNER JOIN sec_users e ON e.group_id=d.group_id
			WHERE a.dash_id=:dash_id 
			AND b.display = 1
			and LOWER(e.user_name) = LOWER(:user_name)
			AND b.enabled = 1 
			AND c.enabled = 1
			ORDER BY a.display_order
---------------------------------------------
		
					_getMonitrallObjects("Groups"), _getMonitrallGroupsFromDB(null) (query 'MonitrallGroups')

------------------ DONE ---------------------
SELECT distinct a.id, a.name, a.index_num, a.description 
			from groups a
			inner join results b on b.group_id =a.id 
			inner join sec_groupsresults c on b.id =c.result_id
			inner join sec_users d on d.group_id=c.group_id
			where a.enabled = 1 
			and LOWER(d.user_name) = LOWER('User1')
			order by a.display_order asc
-----------------------------------------------
					
					_getMonitrallObjects("Results"), _getMonitrallResultsFromDB(null) (query 'MonitrallResults')
------------------ DONE ---------------------
SELECT  a.id ,  a.name ,  a.index_num ,  a.group_index_num ,  a.description ,  a.group_id ,  a.ui_type ,  a.frontpage ,  a.display ,  a.connection ,  a.condition_green_operator ,  a.condition_green_value , a.condition_orange_operator ,  a.condition_orange_value ,  a.condition_red_operator ,  a.condition_red_value ,  a.query ,  a.datafile ,  a.display_order 
		FROM  results a
		inner join sec_groupsresults b on a.id =b.result_id
		inner join sec_users c on c.group_id=b.group_id
		where a.enabled = 1
			and LOWER(d.user_name) = LOWER('User1')
			order by a.display_order asc
---------------------------------------------
					
					_getMonitrallObjects("Forms"), _getMonitrallFormsFromDB(null,'id') (query 'MonitrallForms')

------------------ DONE ---------------------
SELECT a.id, a.parent_id, a.icon, a.name,a.form_index_num, a.description, a.scope, a.type, a.filter_auto, a.connection, a.default_values_url, a.query, a.target, a.datafile, a.display_order 
		FROM forms a
		INNER JOIN sec_groupsresults b on a.parent_id = b.result_id
		INNER JOIN sec_users c on c.group_id=b.group_id
		WHERE a.enabled = 1
		and LOWER(c.user_name) = LOWER(:user_name)
		order by a.display_order asc
----------------------------------------------

					_getMonitrallObjects("Dashboards") _getMonitrallDashboardsFromDB(null) (query 'MonitrallDashboards')
					
------------------ DONE ---------------------
SELECT distinct a.id, a.name, a.description, a.display_order 
	FROM dashboards a 
	INNER JOIN dashresults b ON b.dash_id = a.id
	INNER JOIN sec_groupsresults c ON b.result_id=c.result_id 
	INNER JOIN sec_users d on d.group_id=c.group_id
	WHERE a.enabled = 1
	and LOWER(d.user_name) = LOWER(:user_name)
	ORDER BY a.display_order
-----------------------------------------------
	
getResults url:api/getResults/	
	Used to get the results data DONE (YES Authentication)
syncServices url:api/syncServices
	Used with the following options:
		getResults: To get results (when processing a form) DONE (YES Authentication)
		processForm: To process a form DONE (YES Authentication)