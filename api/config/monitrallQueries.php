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
 * MonitrallQueries
 *
 * ________________________________________________________
 *
 * @package 
 * @author  Constantinos Evangelou <gieglas@gmail.com>
 * @since   Version 1.0
 */

$monitrall_results_config = array(
	"MonitrallGroups" => array(
		"id" => "MonitrallGroups",		
		"connection" => "monitralldb",
		"query" => "SELECT id, name, index_num, description 
			from groups 
			where enabled = 1
			order by display_order asc"
	),
	"MonitrallGroupsUser" => array(
		"id" => "MonitrallGroupsUser",		
		"connection" => "monitralldb",
		"query" => "SELECT distinct a.id, a.name, a.index_num, a.description 
			from groups a
			inner join results b on b.group_id =a.id 
			inner join sec_groupsresults c on b.id =c.result_id
			inner join sec_users d on d.group_id=c.group_id
			where a.enabled = 1 
			and LOWER(d.user_name) = LOWER(:user_name)
			order by a.display_order asc"
	),
	"MonitrallResults" => array(
		"id" => "MonitrallResults",		
		"connection" => "monitralldb",
		"query" => "SELECT  id ,  name ,  index_num ,  group_index_num ,  description ,  group_id ,  ui_type ,  frontpage ,  display ,  connection ,  condition_green_operator ,  condition_green_value , condition_orange_operator ,  condition_orange_value ,  condition_red_operator ,  condition_red_value ,  query ,  datafile ,  display_order 
		FROM  results 
		where enabled = 1
			order by display_order asc"
	),
	"MonitrallResultsUser" => array(
		"id" => "MonitrallResultsUser",		
		"connection" => "monitralldb",
		"query" => "SELECT  a.id ,  a.name ,  a.index_num ,  a.group_index_num ,  a.description ,  a.group_id ,  a.ui_type ,  a.frontpage ,  a.display ,  a.connection ,  a.condition_green_operator ,  a.condition_green_value , a.condition_orange_operator ,  a.condition_orange_value ,  a.condition_red_operator ,  a.condition_red_value ,  a.query ,  a.datafile ,  a.display_order 
		FROM  results a
		inner join sec_groupsresults b on a.id =b.result_id
		inner join sec_users c on c.group_id=b.group_id
		where a.enabled = 1
			and LOWER(c.user_name) = LOWER(:user_name)
			order by a.display_order asc"
	),
	"MonitrallForms" => array(
		"id" => "MonitrallForms",		
		"connection" => "monitralldb",
		"query" => "SELECT id, parent_id, icon, name,form_index_num, description, scope, type, filter_auto, connection, default_values_url, query, target, datafile, display_order 
		FROM forms 
		WHERE enabled = 1
		order by display_order asc"		
	),
	"MonitrallFormsUser" => array(
		"id" => "MonitrallFormsUser",		
		"connection" => "monitralldb",
		"query" => "SELECT a.id, a.parent_id, a.icon, a.name,a.form_index_num, a.description, a.scope, a.type, a.filter_auto, a.connection, a.default_values_url, a.query, a.target, a.datafile, a.display_order 
		FROM forms a
		INNER JOIN sec_groupsresults b on a.parent_id = b.result_id
		INNER JOIN sec_users c on c.group_id=b.group_id
		WHERE a.enabled = 1
		and LOWER(c.user_name) = LOWER(:user_name)
		order by a.display_order asc"		
	),
	"MonitrallFieldsByForm" => array(
		"id" => "MonitrallFieldsByForm",		
		"connection" => "monitralldb",
		"query" => "SELECT id, form_id, title, placeholder, type , default_value, option_url, required, valid_test, valid_minlength, valid_maxlength, display_order
FROM fields 
WHERE form_id = :formid
AND enabled =1
ORDER BY display_order ASC"		
	),
	"MonitrallGroupsById" => array(
		"id" => "MonitrallGroups",		
		"connection" => "monitralldb",
		"query" => "SELECT id, name, index_num, description 
			from groups 
			where enabled = 1
				and id = :id
				order by display_order asc"
	),
	"MonitrallResultsById" => array(
		"id" => "MonitrallResults",		
		"connection" => "monitralldb",
		"query" => "SELECT  id ,  name ,  index_num ,  group_index_num ,  description ,  group_id ,  ui_type ,  frontpage ,  display ,  connection ,  condition_green_operator ,  condition_green_value , condition_orange_operator ,  condition_orange_value ,  condition_red_operator ,  condition_red_value ,  query ,  datafile ,  display_order 
		FROM  results 
		where enabled = 1
			and id = :id
			order by display_order asc"
	),
	"MonitrallFormsById" => array(
		"id" => "MonitrallForms",		
		"connection" => "monitralldb",
		"query" => "SELECT id, parent_id, icon, name,form_index_num, description, scope, type, filter_auto, connection, default_values_url, query, target, datafile, display_order 
		FROM forms 
		WHERE enabled = 1
			and id = :id
			order by display_order asc"		
	),
	"MonitrallFormsByResultId" => array(
		"id" => "MonitrallForms",		
		"connection" => "monitralldb",
		"query" => "SELECT id, parent_id, icon, name,form_index_num, description, scope, type, filter_auto, connection, default_values_url, query, target, datafile, display_order 
		FROM forms 
		WHERE enabled = 1
			and (parent_id = :id OR target = :id)
			order by display_order asc"		
	),
	"MonitrallNotificationResults" => array(
		"id" => "MonitrallNotificationResults",		
		"connection" => "monitralldb",
		"query" => "SELECT DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s') as now , name, description, id, condition_red_operator, condition_red_value, condition_green_operator, condition_green_value,  condition_orange_operator, condition_orange_value, notify_freq,notify_interval,DATE_FORMAT(start_notify_date, '%Y-%m-%d %H:%i:%s') as start_notify_date, DATE_FORMAT(next_notify_date , '%Y-%m-%d %H:%i:%s') as next_notify_date  FROM results 
		WHERE notify_enable=1 
		AND (notify_freq is not null or notify_freq !='') 
		AND notify_interval is not null 
		AND start_notify_date is not null
		AND (next_notify_date < now() OR next_notify_date is null)
		AND enabled = 1
		order by group_id, display_order asc"
	),
	"MonitrallUpdateNotifications" => array(
		"id" => "MonitrallUpdateNotifications",		
		"connection" => "monitralldb",
		"query" => "UPDATE results SET next_notify_date = :nextDateIn WHERE id = :idIn"
	),
	"MonitrallInsertStats" => array(
		"id" => "MonitrallInsertStats",		
		"connection" => "monitralldb",
		"query" => "INSERT INTO stats (stat_id,result_id,name,value) VALUES (:stats_id,:result_id,:name,:value)"
	),
	"MonitrallMaxStatId" => array(
		"id" => "MonitrallMaxStatId",		
		"connection" => "monitralldb",
		"query" => "SELECT IFNULL(MAX( stat_id ) +1,0) as Max_id FROM  stats"
	),
	"MonitrallInsertChecks" => array(
		"id" => "MonitrallInsertChecks",		
		"connection" => "monitralldb",
		"query" => "INSERT INTO checks (check_id,result_id,has_red,has_orange,has_green,has_no_values) VALUES (:check_id,:result_id,:has_red,:has_orange,:has_green,:has_no_values)"
	),
	"MonitrallMaxCheckId" => array(
		"id" => "MonitrallMaxCheckId",		
		"connection" => "monitralldb",
		"query" => "SELECT IFNULL(MAX( check_id ) +1,0) as Max_id FROM  checks"
	),
	"MonitrallDashboards" => array(
		"id" => "MonitrallDashboards",		
		"connection" => "monitralldb",
		"query" => "SELECT a.id, a.name, a.description, a.display_order FROM dashboards a WHERE a.enabled = 1"
	),
	"MonitrallDashboardsUser" => array(
		"id" => "MonitrallDashboardsUser",		
		"connection" => "monitralldb",
		"query" => "SELECT distinct a.id, a.name, a.description, a.display_order 
        	FROM dashboards a 
        	INNER JOIN dashresults b ON b.dash_id = a.id
        	INNER JOIN sec_groupsresults c ON b.result_id=c.result_id 
        	INNER JOIN sec_users d on d.group_id=c.group_id
        	WHERE a.enabled = 1
        	and LOWER(d.user_name) = LOWER(:user_name)
        	ORDER BY a.display_order"
	),
	"MonitrallDashResultsByDashId" => array(
		"id" => "MonitrallDashResultsByDashId",		
		"connection" => "monitralldb",
		"query" => "SELECT a.dash_id, a.result_id, a.display_order, b.name FROM dashresults a 
			INNER JOIN results b ON a.result_id = b.id
			INNER JOIN dashboards c ON a.dash_id = c.id
			WHERE a.dash_id=:dash_id 
			AND b.display = 1
			AND b.enabled = 1 
			AND c.enabled = 1
			ORDER BY a.display_order"
	),
	"MonitrallDashResultsByDashIdUser" => array(
		"id" => "MonitrallDashResultsByDashIdUser",		
		"connection" => "monitralldb",
		"query" => "SELECT a.dash_id, a.result_id, a.display_order, b.name FROM dashresults a 
			INNER JOIN results b ON a.result_id = b.id
			INNER JOIN dashboards c ON a.dash_id = c.id
			INNER JOIN sec_groupsresults d ON a.result_id = d.result_id
			INNER JOIN sec_users e ON e.group_id=d.group_id
			WHERE a.dash_id=:dash_id 
			AND b.display = 1
			and LOWER(e.user_name) = LOWER(:user_name)
			AND b.enabled = 1 
			AND c.enabled = 1
			ORDER BY a.display_order"
	)
);

?>