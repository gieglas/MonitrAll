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
	"MonitrallResults" => array(
		"id" => "MonitrallResults",		
		"connection" => "monitralldb",
		"query" => "SELECT  id ,  name ,  index_num ,  group_index_num ,  description ,  group_id ,  ui_type ,  frontpage ,  display ,  connection ,  condition_green_operator ,  condition_green_value , condition_orange_operator ,  condition_orange_value ,  condition_red_operator ,  condition_red_value ,  query ,  datafile ,  display_order 
		FROM  results 
		where enabled = 1
			order by display_order asc"
	),
	"MonitrallForms" => array(
		"id" => "MonitrallForms",		
		"connection" => "monitralldb",
		"query" => "SELECT id, parent_id, icon, name,form_index_num, description, scope, type, filter_auto, connection, default_values_url, query, target, datafile, display_order 
		FROM forms 
		WHERE enabled = 1
		order by display_order asc"		
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
	)
	

);

?>