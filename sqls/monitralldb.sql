-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2014 at 01:30 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `monitralldbbare`
--

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE IF NOT EXISTS `fields` (
  `fieldid` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Field internal id',
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Field id',
  `form_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Form id',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Field title',
  `placeholder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Field placeholder',
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Field type text, textarea, select, radio, checklist',
  `default_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Field default value',
  `option_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Web service url to fill the options',
  `required` tinyint(4) DEFAULT '0' COMMENT 'Define if field is required',
  `valid_test` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Define the validation test',
  `valid_minlength` bigint(20) DEFAULT NULL COMMENT 'Define the validation min length',
  `valid_maxlength` bigint(20) DEFAULT NULL COMMENT 'Define the validation max length',
  `display_order` bigint(20) NOT NULL DEFAULT '0' COMMENT 'The order to be displayed',
  `enabled` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to enable',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Insert date time',
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
  PRIMARY KEY (`fieldid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Defines Form Fields' AUTO_INCREMENT=153 ;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`fieldid`, `id`, `form_id`, `title`, `placeholder`, `type`, `default_value`, `option_url`, `required`, `valid_test`, `valid_minlength`, `valid_maxlength`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES
(6, 'idIn', 'AdminAddGroups', 'Group Id', 'Enter group id number.', 'text', '', '', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 05:15:41', '2013-09-13 05:15:41'),
(7, 'nameIn', 'AdminAddGroups', 'Group Name', 'Enter the group name.', 'text', '', '', 1, '', 0, 255, 1, 1, '2013-09-13 05:16:24', '2013-09-13 05:16:24'),
(8, 'descriptionIn', 'AdminAddGroups', 'Group Description', 'Enter the group description.', 'textarea', '', '', 0, '', 0, 6000, 2, 1, '2013-09-13 05:17:25', '2013-09-13 05:17:25'),
(9, 'display_orderIn', 'AdminAddGroups', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 3, 1, '2013-09-13 05:18:22', '2013-09-13 05:20:10'),
(10, 'enabledIn', 'AdminAddGroups', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 4, 1, '2013-09-13 05:19:36', '2013-09-13 05:19:36'),
(11, 'idIn', 'AdminEditGroups', 'Group Id', 'Enter group id number.', 'text', '', '', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 06:13:29', '2013-09-13 06:13:29'),
(12, 'nameIn', 'AdminEditGroups', 'Group Name', 'Enter the group name.', 'text', '', '', 1, '', 0, 255, 1, 1, '2013-09-13 06:15:35', '2013-09-13 06:15:35'),
(13, 'descriptionIn', 'AdminEditGroups', 'Group Description', 'Enter the group description.', 'textarea', '', '', 0, '', 0, 6000, 2, 1, '2013-09-13 06:16:27', '2013-09-13 06:16:27'),
(14, 'display_orderIn', 'AdminEditGroups', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 3, 1, '2013-09-13 06:17:30', '2013-09-13 06:17:30'),
(15, 'enabledIn', 'AdminEditGroups', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 4, 1, '2013-09-13 06:18:18', '2013-09-13 06:18:18'),
(16, 'idIn', 'AdminAddResults', 'Result Id', 'Enter result id number.', 'text', '', '', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 06:47:49', '2013-09-13 06:47:49'),
(17, 'nameIn', 'AdminAddResults', 'Result Name', 'Enter the result name.', 'text', '', '', 1, '', 0, 255, 1, 1, '2013-09-13 06:48:32', '2013-09-26 09:59:51'),
(18, 'descriptionIn', 'AdminAddResults', 'Result Description', 'Enter the result description.', 'textarea', '', '', 0, '', 0, 6000, 2, 1, '2013-09-13 06:49:22', '2013-09-13 06:49:22'),
(19, 'groupIn', 'AdminAddResults', 'Select Group', 'Select Group.', 'select', '', 'api/getResults/AdminGroupsSelect', 1, 'alphanum', 0, 100, 3, 1, '2013-09-13 06:50:44', '2013-09-13 06:50:44'),
(20, 'ui_typeIn', 'AdminAddResults', 'Select UI Type', 'Select UI Type.', 'select', '', 'api/config/ui_types.json', 1, 'alphanum', 0, 1, 4, 1, '2013-09-13 06:51:34', '2013-09-13 06:51:34'),
(21, 'frontpageIn', 'AdminAddResults', 'Display in front page?', 'Display in front page?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 100, 5, 1, '2013-09-13 06:52:30', '2013-09-13 06:53:17'),
(22, 'displayIn', 'AdminAddResults', 'Display module or only WebService?', 'Display module?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 100, 6, 1, '2013-09-13 06:54:22', '2013-09-13 06:55:39'),
(23, 'connectionIn', 'AdminAddResults', 'Select Predefined Connection', 'Select Connection Type.', 'select', '', 'api/getConnectionsList', 1, 'alphanum', 0, 100, 7, 1, '2013-09-13 06:55:28', '2013-09-13 06:55:28'),
(24, 'condition_green_operatorIn', 'AdminAddResults', 'Select Condition operator for GREEN', 'Select Condition operator for GREEN.', 'select', '', 'api/config/logical_operators.json', 0, '', 0, 10, 8, 1, '2013-09-13 06:56:48', '2013-09-13 06:56:48'),
(25, 'condition_green_valueIn', 'AdminAddResults', 'Condition value for GREEN', 'Enter Condition value for GREEN.', 'text', '', '', 0, '', 0, 255, 9, 1, '2013-09-13 06:57:24', '2013-09-13 06:57:24'),
(26, 'condition_orange_operatorIn', 'AdminAddResults', 'Select Condition operator for ORANGE', 'Select Condition operator for ORANGE.', 'select', '', 'api/config/logical_operators.json', 0, '', 0, 10, 10, 1, '2013-09-13 06:58:27', '2013-09-13 06:58:27'),
(27, 'condition_orange_valueIn', 'AdminAddResults', 'Condition value for ORANGE', 'Enter Condition value for ORANGE.', 'text', '', '', 0, '', 0, 255, 11, 1, '2013-09-13 06:59:26', '2013-09-13 06:59:26'),
(28, 'condition_red_operatorIn', 'AdminAddResults', 'Select Condition operator for RED', 'Select Condition operator for RED.', 'select', '', 'api/config/logical_operators.json', 0, '', 0, 10, 12, 1, '2013-09-13 07:00:11', '2013-09-13 07:00:11'),
(29, 'condition_red_valueIn', 'AdminAddResults', 'Condition value for RED', 'Condition value for RED.', 'text', '', '', 0, '', 0, 255, 13, 1, '2013-09-13 07:00:45', '2013-09-13 07:00:45'),
(30, 'queryIn', 'AdminAddResults', 'Result Query', 'Enter query to be used to get the results.', 'textarea', '', '', 1, '', 0, 6000, 14, 1, '2013-09-13 07:01:27', '2013-09-13 07:01:27'),
(31, 'datafileIn', 'AdminAddResults', 'Data File', 'Enter the path of the datafile in case of EXECUTE', 'textarea', '', '', 0, '', 0, 6000, 15, 1, '2013-09-13 07:02:19', '2013-09-13 07:02:19'),
(32, 'display_orderIn', 'AdminAddResults', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 16, 1, '2013-09-13 07:03:09', '2013-09-13 07:03:09'),
(33, 'enabledIn', 'AdminAddResults', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 0, 'digits', 0, 1, 21, 1, '2013-09-13 07:04:03', '2013-09-26 11:12:27'),
(34, 'idIn', 'AdminEditResults', 'Result Id', 'Enter result id number.', 'text', '', '', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 07:20:17', '2013-09-13 07:20:17'),
(35, 'nameIn', 'AdminEditResults', 'Result Name', 'Enter the result name.', 'text', '', '', 1, '', 0, 255, 1, 1, '2013-09-13 07:21:03', '2013-09-13 07:21:03'),
(36, 'descriptionIn', 'AdminEditResults', 'Result Description', 'Enter the result description.', 'textarea', '', '', 0, '', 0, 6000, 2, 1, '2013-09-13 07:21:52', '2013-09-13 07:21:52'),
(37, 'groupIn', 'AdminEditResults', 'Select Group', 'Select Group.', 'select', '', 'api/getResults/AdminGroupsSelect', 1, 'alphanum', 0, 100, 3, 1, '2013-09-13 07:22:56', '2013-09-13 07:22:56'),
(38, 'ui_typeIn', 'AdminEditResults', 'Select UI Type', 'Select UI Type.', 'select', '', 'api/config/ui_types.json', 1, 'alphanum', 0, 100, 4, 1, '2013-09-13 07:29:47', '2013-09-13 07:29:47'),
(39, 'frontpageIn', 'AdminEditResults', 'Display in front page?', 'Display in front page?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 100, 5, 1, '2013-09-13 07:30:55', '2013-09-13 07:30:55'),
(40, 'displayIn', 'AdminEditResults', 'Display module or only WebService?', 'Display module?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 100, 6, 1, '2013-09-13 07:31:53', '2013-09-13 07:31:53'),
(41, 'connectionIn', 'AdminEditResults', 'Select Predefined Connection', 'Select Predefined Connection.', 'select', '', 'api/getConnectionsList', 1, 'alphanum', 0, 100, 7, 1, '2013-09-13 07:33:28', '2013-09-13 07:52:25'),
(42, 'condition_green_valueIn', 'AdminEditResults', 'Condition value for GREEN', 'Condition value for GREEN.', 'text', '', '', 0, '', 0, 255, 9, 1, '2013-09-13 07:33:57', '2013-09-13 07:43:47'),
(43, 'condition_orange_operatorIn', 'AdminEditResults', 'Select Condition operator for ORANGE', 'Select Condition operator for ORANGE.', 'select', '', 'api/config/logical_operators.json', 0, '', 0, 10, 10, 1, '2013-09-13 07:34:38', '2013-09-13 07:44:00'),
(44, 'condition_orange_valueIn', 'AdminEditResults', 'Condition value for ORANGE', 'Condition value for ORANGE.', 'text', '', '', 0, '', 0, 255, 11, 1, '2013-09-13 07:35:25', '2013-09-13 07:44:12'),
(45, 'condition_red_operatorIn', 'AdminEditResults', 'Select Condition operator for RED', 'Select Condition operator for RED.', 'select', '', 'api/config/logical_operators.json', 0, '', 0, 10, 12, 1, '2013-09-13 07:36:59', '2013-09-13 07:44:24'),
(46, 'condition_red_valueIn', 'AdminEditResults', 'Condition value for RED', 'Condition value for RED.', 'text', '', '', 0, '', 0, 255, 13, 1, '2013-09-13 07:37:33', '2013-09-13 07:44:36'),
(47, 'queryIn', 'AdminEditResults', 'Result Query', 'Enter query to be used to get the results.', 'textarea', '', '', 1, '', 0, 6000, 14, 1, '2013-09-13 07:38:06', '2013-09-13 07:44:44'),
(48, 'datafileIn', 'AdminEditResults', 'Data File', 'Enter the path of the datafile in case of EXECUTE', 'textarea', '', '', 0, '', 0, 6000, 15, 1, '2013-09-13 07:38:56', '2013-09-13 07:44:53'),
(49, 'display_orderIn', 'AdminEditResults', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 16, 1, '2013-09-13 07:39:38', '2013-09-13 07:45:01'),
(50, 'enabledIn', 'AdminEditResults', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 21, 1, '2013-09-13 07:40:35', '2013-09-26 11:05:10'),
(51, 'condition_green_operatorIn', 'AdminEditResults', 'Select Condition operator for GREEN', 'Select Condition operator for GREEN.', 'select', '', 'api/config/logical_operators.json', 0, '', 0, 10, 8, 1, '2013-09-13 07:43:30', '2013-09-13 07:43:30'),
(52, 'groupid', 'AdminFilterResultsByGroup', 'Select Group', 'Select Group.', 'select', '', 'api/getResults/AdminGroupsSelect', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 07:59:46', '2013-09-13 07:59:46'),
(53, 'idIn', 'AdminAddForms', 'Form Id', 'Enter form id number.', 'text', '', '', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 08:15:42', '2013-09-13 08:15:42'),
(54, 'nameIn', 'AdminAddForms', 'Form Name', 'Enter the form name.', 'text', '', '', 0, '', 0, 255, 1, 1, '2013-09-13 08:16:23', '2013-09-13 08:16:23'),
(55, 'parent_idIn', 'AdminAddForms', 'Select Parent Results View Id', 'Select Parent Results View Id.', 'select', '', 'api/getResults/AdminResultsSelect', 1, 'alphanum', 0, 100, 2, 1, '2013-09-13 08:17:08', '2013-09-13 08:17:08'),
(56, 'iconIn', 'AdminAddForms', 'Form Icon (Icons by Glyphicons as defined at http://getbootstrap.com/2.3.2/base-css.html#icons)', 'Enter the form icon.', 'text', '', '', 0, '', 0, 255, 3, 1, '2013-09-13 08:17:41', '2013-09-13 08:17:41'),
(57, 'descriptionIn', 'AdminAddForms', 'Form Description', 'Enter the form description.', 'textarea', '', '', 0, '', 0, 6000, 4, 1, '2013-09-13 08:18:16', '2013-09-13 08:18:16'),
(58, 'scopeIn', 'AdminAddForms', 'Select Scope', 'Select Scope.', 'select', '', 'api/config/form_scopes.json', 1, 'alphanum', 0, 100, 5, 1, '2013-09-13 08:19:11', '2013-09-13 08:19:11'),
(59, 'typeIn', 'AdminAddForms', 'Select Form Type', 'Select Form Type.', 'select', '', 'api/config/form_types.json', 1, 'alphanum', 0, 100, 6, 1, '2013-09-13 08:19:49', '2013-09-13 08:19:49'),
(60, 'filter_autoIn', 'AdminAddForms', 'Automatically filter using the lineid or display form?', 'Automatically filter?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 100, 7, 1, '2013-09-13 08:20:31', '2013-09-13 08:20:31'),
(61, 'connectionIn', 'AdminAddForms', 'Select Predefined Connection', 'Select Connection Type.', 'select', '', 'api/getConnectionsList', 1, 'alphanum', 0, 100, 8, 1, '2013-09-13 08:21:21', '2013-09-13 08:21:21'),
(62, 'default_values_urlIn', 'AdminAddForms', 'Enter the default values web service URL', 'e.g. api/getResults/webServiceName', 'text', '', '', 0, '', 0, 255, 9, 1, '2013-09-13 08:22:10', '2013-09-13 08:22:10'),
(63, 'queryIn', 'AdminAddForms', 'Result Query', 'Enter query to be used to get the results.', 'textarea', '', '', 1, '', 0, 6000, 10, 1, '2013-09-13 08:22:45', '2013-09-13 08:22:45'),
(64, 'targetIn', 'AdminAddForms', 'In case of Filter select Results View Id to perorm filter', 'Select Target Results View Id.', 'select', '', 'api/getResults/AdminResultsSelect', 0, 'alphanum', 0, 100, 11, 1, '2013-09-13 08:23:30', '2013-09-13 08:23:30'),
(65, 'display_orderIn', 'AdminAddForms', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 13, 1, '2013-09-13 08:24:17', '2013-09-13 09:49:51'),
(66, 'enabledIn', 'AdminAddForms', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 14, 1, '2013-09-13 08:25:01', '2013-09-13 09:50:00'),
(67, 'idIn', 'AdminEditForms', 'Form Id', 'Enter form id number.', 'text', '', '', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 08:32:30', '2013-09-13 08:32:51'),
(68, 'nameIn', 'AdminEditForms', 'Form Name', 'Enter the form name.', 'text', '', '', 0, '', 0, 255, 1, 1, '2013-09-13 08:33:41', '2013-09-13 08:33:41'),
(69, 'parent_idIn', 'AdminEditForms', 'Select Parent Results View Id', 'Select Parent Results View Id.', 'select', '', 'api/getResults/AdminResultsSelect', 1, 'alphanum', 0, 100, 2, 1, '2013-09-13 08:34:25', '2013-09-13 08:34:25'),
(70, 'iconIn', 'AdminEditForms', 'Form Icon (Icons by Glyphicons as defined at http://getbootstrap.com/2.3.2/base-css.html#icons)', 'Enter the form icon.', 'text', '', '', 0, '', 0, 255, 3, 1, '2013-09-13 08:35:06', '2013-09-13 08:35:06'),
(71, 'descriptionIn', 'AdminEditForms', 'Form Description', 'Enter the form description.', 'textarea', '', '', 0, '', 0, 6000, 4, 1, '2013-09-13 08:35:41', '2013-09-13 08:35:41'),
(72, 'scopeIn', 'AdminEditForms', 'Select Scope', 'Select Scope', 'select', '', 'api/config/form_scopes.json', 1, 'alphanum', 0, 100, 5, 1, '2013-09-13 08:36:23', '2013-09-13 08:36:23'),
(73, 'typeIn', 'AdminEditForms', 'Select Form Type', 'Select Form Type.', 'select', '', 'api/config/form_types.json', 1, 'alphanum', 0, 100, 6, 1, '2013-09-13 08:37:14', '2013-09-13 08:37:14'),
(74, 'filter_autoIn', 'AdminEditForms', 'Automatically filter using the lineid or display form?', 'Automatically filter?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 100, 7, 1, '2013-09-13 08:38:13', '2013-09-13 08:38:13'),
(75, 'connectionIn', 'AdminEditForms', 'Select Predefined Connection', 'Select Connection Type.', 'select', '', 'api/getConnectionsList', 1, 'alphanum', 0, 100, 8, 1, '2013-09-13 08:39:01', '2013-09-13 08:39:01'),
(76, 'default_values_urlIn', 'AdminEditForms', 'Enter the default values web service URL', 'e.g. api/getResults/webServiceName', 'text', '', '', 0, '', 0, 255, 9, 1, '2013-09-13 08:39:45', '2013-09-13 08:39:45'),
(77, 'queryIn', 'AdminEditForms', 'Result Query', 'Enter query to be used to get the results.', 'textarea', '', '', 1, '', 0, 6000, 10, 1, '2013-09-13 08:40:21', '2013-09-13 08:40:21'),
(78, 'targetIn', 'AdminEditForms', 'In case of Filter select Results View Id to perorm filter', 'Select Target Results View Id.', 'select', '', 'api/getResults/AdminResultsSelect', 0, 'alphanum', 0, 100, 11, 1, '2013-09-13 08:41:11', '2013-09-13 08:41:11'),
(79, 'display_orderIn', 'AdminEditForms', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 13, 1, '2013-09-13 08:41:59', '2013-09-13 09:52:53'),
(80, 'enabledIn', 'AdminEditForms', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 14, 1, '2013-09-13 08:42:43', '2013-09-13 09:53:00'),
(81, 'parentid', 'AdminFilterFormsByResult', 'Select Parent Result', 'Select Parent Result.', 'select', '', 'api/getResults/AdminResultsSelectNoEmpty', 0, 'alphanum', 0, 100, 0, 1, '2013-09-13 08:49:49', '2013-09-13 08:49:49'),
(82, 'idIn', 'AdminAddFields', 'Field Id (This name will be used as parameters when processing the form)', 'Enter Field id.', 'text', '', '', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 09:03:06', '2013-09-13 09:03:06'),
(83, 'titleIn', 'AdminAddFields', 'Field title', 'Enter the field title.', 'text', '', '', 1, '', 0, 255, 1, 1, '2013-09-13 09:03:43', '2013-09-13 09:03:43'),
(84, 'form_idIn', 'AdminAddFields', 'Select Form that the field will be used', 'Select Form that the field will be used.', 'select', '', 'api/getResults/AdminFormsSelect', 1, 'alphanum', 0, 100, 2, 1, '2013-09-13 09:04:32', '2013-09-13 09:04:32'),
(85, 'placeholderIn', 'AdminAddFields', 'Field placeholder (in text,textarea appears within the field).', 'Field placeholder.', 'text', '', '', 0, '', 0, 255, 3, 1, '2013-09-13 09:05:22', '2013-09-13 09:05:22'),
(86, 'typeIn', 'AdminAddFields', 'Select Field Type', 'Select Field Type.', 'select', '', 'api/config/field_types.json', 1, 'alphanum', 0, 100, 4, 1, '2013-09-13 09:06:09', '2013-09-13 09:06:09'),
(87, 'default_valueIn', 'AdminAddFields', 'Enter the default value if any', 'Enter the default value .', 'text', '', '', 0, '', 0, 255, 5, 1, '2013-09-13 09:06:39', '2013-09-13 09:06:39'),
(88, 'option_urlIn', 'AdminAddFields', 'Enter the options URL web service.', 'Enter the options URL.', 'text', '', '', 0, '', 0, 255, 6, 1, '2013-09-13 09:07:18', '2013-09-13 09:07:18'),
(89, 'requiredIn', 'AdminAddFields', 'Is this field required?', 'Required?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 100, 7, 1, '2013-09-13 09:08:12', '2013-09-13 09:08:12'),
(90, 'valid_testIn', 'AdminAddFields', 'Select Validation Type.', 'Select Validation Type.', 'select', '', 'api/config/field_validation_types.json', 0, 'alphanum', 0, 100, 8, 1, '2013-09-13 09:08:59', '2013-09-13 09:08:59'),
(91, 'valid_minlengthIn', 'AdminAddFields', 'Enter minimum accepted length of the field.', 'Enter the minimum length.', 'text', '', '', 0, 'digits', 0, 20, 9, 1, '2013-09-13 09:09:43', '2013-09-13 09:09:43'),
(92, 'valid_maxlengthIn', 'AdminAddFields', 'Enter maximum accepted length of the field.', 'Enter the maximum length.', 'text', '', '', 0, 'digits', 0, 20, 10, 1, '2013-09-13 09:10:23', '2013-09-13 09:10:23'),
(93, 'display_orderIn', 'AdminAddFields', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 11, 1, '2013-09-13 09:11:06', '2013-09-13 09:11:06'),
(94, 'enabledIn', 'AdminAddFields', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 12, 1, '2013-09-13 09:11:54', '2013-09-13 09:11:54'),
(97, 'idIn', 'AdminEditFields', 'Field Id (This name will be used as parameters when processing the form)', 'Enter Field id number.', 'text', '', '', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 09:19:00', '2013-09-13 09:37:45'),
(98, 'titleIn', 'AdminEditFields', 'Field title', 'Enter the field title.', 'text', '', '', 1, '', 0, 255, 1, 1, '2013-09-13 09:19:49', '2013-09-13 09:19:49'),
(99, 'form_idIn', 'AdminEditFields', 'Select Form that the field will be used', 'Select Form that the field will be used.', 'select', '', 'api/getResults/AdminFormsSelect', 1, 'alphanum', 0, 100, 2, 1, '2013-09-13 09:20:42', '2013-09-13 09:20:42'),
(100, 'placeholderIn', 'AdminEditFields', 'Field placeholder (in text,textarea appears within the field).', 'Field placeholder.', 'text', '', '', 0, '', 0, 255, 3, 1, '2013-09-13 09:21:28', '2013-09-13 09:21:28'),
(101, 'typeIn', 'AdminEditFields', 'Select Field Type', 'Select Field Type.', 'select', '', 'api/config/field_types.json', 1, 'alphanum', 0, 100, 4, 1, '2013-09-13 09:22:09', '2013-09-13 09:22:09'),
(102, 'default_valueIn', 'AdminEditFields', 'Enter the default value if any', 'Enter the default value .', 'text', '', '', 0, '', 0, 255, 5, 1, '2013-09-13 09:22:46', '2013-09-13 09:22:46'),
(103, 'option_urlIn', 'AdminEditFields', 'Enter the options URL web service.', 'Enter the options URL.', 'text', '', '', 0, '', 0, 255, 6, 1, '2013-09-13 09:23:38', '2013-09-13 09:23:38'),
(104, 'requiredIn', 'AdminEditFields', 'Is this field required?', 'Required?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 100, 7, 1, '2013-09-13 09:24:27', '2013-09-13 09:24:27'),
(105, 'valid_testIn', 'AdminEditFields', 'Select Validation Type.', 'Select Validation Type.', 'select', '', 'api/config/field_validation_types.json', 0, 'alphanum', 0, 100, 8, 1, '2013-09-13 09:25:21', '2013-09-13 09:25:21'),
(106, 'valid_minlengthIn', 'AdminEditFields', 'Enter minimum accepted length of the field.', 'Enter the minimum length.', 'text', '', '', 0, 'digits', 0, 20, 9, 1, '2013-09-13 09:26:10', '2013-09-13 09:26:10'),
(107, 'valid_maxlengthIn', 'AdminEditFields', 'Enter maximum accepted length of the field.', 'Enter the maximum length.', 'text', '', '', 0, 'digits', 0, 20, 10, 1, '2013-09-13 09:27:07', '2013-09-13 09:27:07'),
(108, 'display_orderIn', 'AdminEditFields', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 11, 1, '2013-09-13 09:27:58', '2013-09-13 09:27:58'),
(109, 'enabledIn', 'AdminEditFields', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 12, 1, '2013-09-13 09:28:49', '2013-09-13 09:28:49'),
(110, 'formid', 'AdminFilterFieldsByForm', 'Select Form', 'Select Form.', 'select', '', 'api/getResults/AdminFormsSelect', 0, 'alphanum', 0, 100, 0, 1, '2013-09-13 09:36:00', '2013-09-13 09:36:00'),
(111, 'datafileIn', 'AdminAddForms', 'Data File', 'Enter the path of the datafile in case of EXECUTE', 'textarea', '', '', 0, '', 0, 6000, 12, 1, '2013-09-13 09:49:39', '2013-09-13 09:49:39'),
(112, 'datafileIn', 'AdminEditForms', 'Data File', 'Enter the path of the datafile in case of EXECUTE', 'textarea', '', '', 0, '', 0, 6000, 12, 1, '2013-09-13 09:52:44', '2013-09-13 09:52:44'),
(115, 'listId', 'mySQLEditListItem', 'List Id', 'Enter list id number.', 'select', '', 'api/getResults/mySQLListsList', 1, '', 0, 8, 0, 1, '2013-09-13 10:54:51', '2013-09-13 10:54:51'),
(116, 'itemTitle', 'mySQLEditListItem', 'Item Value', 'Enter the value.', 'text', '', '', 1, '', 0, 100, 1, 1, '2013-09-13 10:56:05', '2013-09-13 10:56:05'),
(117, 'itemMarked', 'mySQLEditListItem', 'Marked?', 'Marked?', 'radio', '0', 'api/config/true_false_bit.json', 0, 'digits', 0, 1, 2, 1, '2013-09-13 10:57:34', '2013-09-13 10:57:34'),
(118, 'itemTitle', 'mySQLAddList', 'Item value', 'Enter the value.', 'text', '', '', 1, '', 0, 100, 0, 1, '2013-09-13 11:01:36', '2013-09-13 11:01:36'),
(119, 'itemTitle', 'mySQLEditList', 'Item value', 'Enter the value.', 'text', '', '', 1, '', 0, 100, 0, 1, '2013-09-13 11:03:44', '2013-09-13 11:03:44'),
(120, 'itemMarked', 'mySQLMarkedFilter', 'Marked?', 'Marked?', 'radio', '0', 'api/config/true_false_bit.json', 1, '', 0, 100, 0, 1, '2013-09-13 11:08:35', '2013-09-13 11:08:35'),
(121, 'lineid', 'mySQLListMarkedFilter', 'List Id', 'Enter list id number.', 'select', '', 'api/getResults/mySQLListsList', 1, '', 0, 8, 0, 1, '2013-09-13 11:11:35', '2013-09-13 11:11:35'),
(122, 'itemMarked', 'mySQLListMarkedFilter', 'Marked?', 'Marked?', 'radio', '', 'api/config/true_false_bit.json', 1, '', 0, 100, 1, 1, '2013-09-13 11:13:16', '2013-09-13 11:13:16'),
(123, 'lineid', 'mySQLListFilter', 'List Id', 'Enter list id number.', 'select', '', 'api/getResults/mySQLListsList', 0, '', 0, 8, 0, 1, '2013-09-13 11:15:46', '2013-09-13 11:15:46'),
(124, 'listId', 'mySQLAddListItem', 'List Id', 'Enter list id number.', 'select', '', 'api/getResults/mySQLListsList', 1, '', 0, 8, 0, 1, '2013-09-13 11:28:37', '2013-09-13 11:28:37'),
(125, 'itemTitle', 'mySQLAddListItem', 'Item value', 'Enter the value.', 'text', '', '', 1, '', 0, 100, 1, 1, '2013-09-13 11:30:27', '2013-09-13 11:30:27'),
(126, 'itemMarked', 'mySQLAddListItem', 'Marked?', 'Marked?', 'radio', '0', 'api/config/true_false_bit.json', 0, 'digits', 0, 1, 2, 1, '2013-09-13 11:31:32', '2013-09-13 11:31:32'),
(134, 'connectionFIN', 'AdminFilterFormsByConnection', 'Connection', 'Select connection', 'select', '', 'api/getConnectionsList', 1, 'alphanum', 0, 100, 0, 1, '2013-09-16 07:51:39', '2013-09-16 07:51:39'),
(135, 'connectionFIN', 'AdminFilterResultsByConnection', 'Connection', 'Select connection', 'select', '', 'api/getConnectionsList', 1, 'alphanum', 0, 100, 0, 1, '2013-09-16 07:55:22', '2013-09-16 07:55:22'),
(136, 'notify_enableIn', 'AdminAddResults', 'Notifications Enabled?', 'Notifications Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 17, 1, '2013-09-26 08:04:06', '2013-09-26 08:04:21'),
(137, 'notify_freqIn', 'AdminAddResults', 'Notification Frequency', 'Notification Frequency', 'select', '', 'api/config/freq_types.json', 0, 'alphanum', 0, 100, 18, 1, '2013-09-26 08:05:43', '2013-09-26 08:05:43'),
(138, 'notify_intervalIn', 'AdminAddResults', 'Notification Interval in respect to frequency', 'Notification Interval', 'text', '', '', 0, 'digits', 0, 10, 19, 1, '2013-09-26 08:06:48', '2013-09-26 08:11:21'),
(139, 'notify_enableIn', 'AdminEditResults', 'Notifications Enabled?', 'Notifications Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 17, 1, '2013-09-26 08:13:17', '2013-09-26 08:13:25'),
(140, 'notify_freqIn', 'AdminEditResults', 'Notification Frequency', 'Notification Frequency', 'select', '', 'api/config/freq_types.json', 0, 'alphanum', 0, 100, 18, 1, '2013-09-26 08:14:26', '2013-09-26 08:14:26'),
(141, 'notify_intervalIn', 'AdminEditResults', 'Notification Interval in respect to frequency', 'Notification Interval', 'text', '', '', 0, 'digits', 0, 10, 19, 1, '2013-09-26 08:15:10', '2013-09-26 08:15:10'),
(142, 'start_notify_dateIn', 'AdminEditResults', 'Start Notification Date Time', 'YYYY-MM-DD HH:MI:SS', 'text', '', '', 0, 'dateTimeIso', 0, 40, 20, 1, '2013-09-26 11:04:50', '2013-09-26 11:05:04'),
(143, 'start_notify_dateIn', 'AdminAddResults', 'Start Notification Date Time', 'YYYY-MM-DD HH:MI:SS', 'text', '', '', 0, 'dateTimeIso', 0, 40, 20, 1, '2013-09-26 11:12:17', '2013-09-26 11:12:17'),
(144, 'notify_freqIn', 'AdminNotifyAdd', 'Notification Frequency', 'Notification Frequency', 'select', '', 'api/config/freq_types.json', 1, 'alphanum', 0, 100, 1, 1, '2013-10-02 10:26:32', '2013-10-02 10:29:38'),
(145, 'notify_intervalIn', 'AdminNotifyAdd', 'Notification Interval in respect to frequency', 'Notification Interval', 'text', '', '', 1, 'digits', 0, 10, 2, 1, '2013-10-02 10:27:22', '2013-10-02 10:29:35'),
(146, 'start_notify_dateIn', 'AdminNotifyAdd', 'Start Notification Date Time', 'YYYY-MM-DD HH:MI:SS', 'text', '', '', 1, 'dateTimeIso', 0, 40, 3, 1, '2013-10-02 10:29:13', '2013-10-02 10:29:28'),
(147, 'idIn', 'AdminNotifyAdd', 'Results Module', 'Results Module', 'select', '', 'api/getResults/AdminNotifyResultsDisabledSelect', 1, 'alphanum', 0, 100, 0, 1, '2013-10-02 10:31:05', '2013-10-02 10:38:08'),
(148, 'notify_enableIn', 'AdminNotifyEdit', 'Notifications Enabled?', 'Notifications Enabled?', 'radio', '', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 0, 1, '2013-10-02 11:31:50', '2013-10-02 11:31:50'),
(149, 'notify_freqIn', 'AdminNotifyEdit', 'Notification Frequency', 'Notification Frequency', 'select', '', 'api/config/freq_types.json', 1, 'alphanum', 0, 100, 1, 1, '2013-10-02 11:32:51', '2013-10-02 11:32:51'),
(150, 'notify_intervalIn', 'AdminNotifyEdit', 'Notification Interval in respect to frequency', 'Notification Interval', 'text', '', '', 1, 'digits', 0, 10, 2, 1, '2013-10-02 11:36:40', '2013-10-02 11:36:40'),
(151, 'start_notify_dateIn', 'AdminNotifyEdit', 'Start Notification Date Time', 'YYYY-MM-DD HH:MI:SS', 'text', '', '', 1, 'dateTimeIso', 0, 40, 3, 1, '2013-10-02 11:40:58', '2013-10-02 11:40:58'),
(152, 'next_notify_dateIn', 'AdminNotifyEdit', 'Next Notification Date Time', 'YYYY-MM-DD HH:MI:SS', 'text', '', '', 0, 'dateTimeIso', 0, 40, 4, 1, '2013-10-02 11:42:08', '2013-10-02 11:44:56');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Form Id',
  `parent_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Result id',
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Icon class to be used on button',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Form display name',
  `form_index_num` bigint(20) DEFAULT NULL COMMENT 'Form index number',
  `description` text COLLATE utf8_unicode_ci COMMENT 'Form description',
  `scope` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'results' COMMENT 'Form scope line or results',
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'form' COMMENT 'Form type form or filter',
  `filter_auto` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'On filter type if 1 loads automatically',
  `connection` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Connection id',
  `default_values_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Default values web service url',
  `query` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Query to process the form inputs',
  `target` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Filter target result id',
  `datafile` text COLLATE utf8_unicode_ci COMMENT 'Datafile only to be used on execute provider',
  `display_order` bigint(20) NOT NULL DEFAULT '0' COMMENT 'The order to be displayed',
  `enabled` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to enable',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Insert date time',
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Defines Forms';

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `parent_id`, `icon`, `name`, `form_index_num`, `description`, `scope`, `type`, `filter_auto`, `connection`, `default_values_url`, `query`, `target`, `datafile`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES
('AdminAddFields', 'AdminFieldsModule', 'icon-plus', 'Add Fields', NULL, 'Enter the field details below to add a new field on the specified form.', 'results', 'form', 0, 'monitralldb', '', 'INSERT INTO monitralldb.fields (id, form_id, title, placeholder, type, default_value, option_url, required, valid_test, valid_minlength, valid_maxlength, display_order, enabled, update_date) VALUES (:idIn, :form_idIn, :titleIn, :placeholderIn, :typeIn, :default_valueIn, :option_urlIn, :requiredIn, :valid_testIn, :valid_minlengthIn, :valid_maxlengthIn, :display_orderIn, :enabledIn, CURRENT_TIMESTAMP);', '', NULL, 0, 1, '2013-09-13 08:55:45', '2013-09-13 08:55:45'),
('AdminAddForms', 'AdminFormsModule', 'icon-plus', 'Add Form', NULL, 'Enter the form details below to add a new form.', 'results', 'form', 0, 'monitralldb', '', 'INSERT INTO forms (id, parent_id, icon, name, description, scope, type, filter_auto, connection, default_values_url, query, target, datafile, display_order, enabled, update_date) \r\n		VALUES (:idIn, :parent_idIn, :iconIn, :nameIn, :descriptionIn, :scopeIn, :typeIn, :filter_autoIn, :connectionIn, :default_values_urlIn, :queryIn, :targetIn, :datafileIn, :display_orderIn, :enabledIn,CURRENT_TIMESTAMP)', '', '', 0, 1, '2013-09-13 08:15:05', '2013-09-13 09:53:24'),
('AdminAddGroups', 'AdminGroupsModule', 'icon-plus', 'Add Group', NULL, 'Enter the group details below to add a new group of results.', 'results', 'form', 0, 'monitralldb', '', 'INSERT INTO groups (id, name, description, enabled, display_order, update_date) VALUES (:idIn, :nameIn, :descriptionIn, :enabledIn, :display_orderIn, CURRENT_TIMESTAMP);', '', NULL, 0, 1, '2013-09-13 05:14:32', '2013-09-13 05:14:32'),
('AdminAddResults', 'AdminResultsModule', 'icon-plus', 'Add Result', NULL, 'Enter the result details below to add a new result module.', 'results', 'form', 0, 'monitralldb', '', 'INSERT INTO  results (id,\r\nname,\r\ndescription,\r\ngroup_id,\r\nui_type,\r\nfrontpage,\r\ndisplay,\r\nconnection,\r\ncondition_green_operator,\r\ncondition_green_value,\r\ncondition_orange_operator,\r\ncondition_orange_value ,\r\ncondition_red_operator ,\r\ncondition_red_value ,\r\nquery ,\r\ndatafile ,\r\ndisplay_order ,	\r\nnotify_enable ,\r\nnotify_freq ,\r\nnotify_interval ,\r\nstart_notify_date,\r\nenabled ,\r\nupdate_date)\r\nVALUES (:idIn ,	\r\n:nameIn ,\r\n:descriptionIn ,\r\n:groupIn ,\r\n:ui_typeIn ,\r\n:frontpageIn ,\r\n:displayIn ,\r\n:connectionIn ,\r\n:condition_green_operatorIn ,\r\n:condition_green_valueIn ,\r\n:condition_orange_operatorIn ,\r\n:condition_orange_valueIn ,\r\n:condition_red_operatorIn ,\r\n:condition_red_valueIn ,\r\n:queryIn ,\r\n:datafileIn ,\r\n:display_orderIn ,\r\n:notify_enableIn ,\r\n:notify_freqIn ,\r\n:notify_intervalIn ,\r\n:start_notify_dateIn,\r\n:enabledIn ,\r\nCURRENT_TIMESTAMP )', '', '', 0, 1, '2013-09-13 06:39:18', '2013-09-26 11:13:23'),
('AdminDeleteFields', 'AdminFieldsModule', 'icon-remove', '', NULL, 'Delete the specific field.', 'line', 'form', 0, 'monitralldb', '', 'delete from fields where fieldid = :lineid;', '', NULL, 2, 1, '2013-09-13 09:30:39', '2013-09-13 09:30:39'),
('AdminDeleteForms', 'AdminFormsModule', 'icon-remove', '', NULL, 'Delete the specific form.', 'line', 'form', 0, 'monitralldb', '', 'delete from forms where id = :lineid;', '', NULL, 2, 1, '2013-09-13 08:46:42', '2013-09-13 08:46:42'),
('AdminDeleteGroups', 'AdminGroupsModule', 'icon-remove', '', NULL, 'Delete the specific group.', 'line', 'form', 0, 'monitralldb', '', 'delete from groups where id = :lineid;', '', NULL, 2, 1, '2013-09-13 06:20:00', '2013-09-13 06:20:00'),
('AdminDeleteResuts', 'AdminResultsModule', 'icon-remove', '', NULL, 'Delete the specific results module.', 'line', 'form', 0, 'monitralldb', '', 'delete from results where id = :lineid;', '', NULL, 2, 1, '2013-09-13 07:57:18', '2013-09-13 07:57:18'),
('AdminEditFields', 'AdminFieldsModule', 'icon-pencil', '', NULL, 'Edit the Form Field details.', 'line', 'form', 0, 'monitralldb', 'api/getResults/AdminFieldsLine', 'UPDATE fields \r\n			set id=:idIn, form_id=:form_idIn, title=:titleIn, placeholder=:placeholderIn, type=:typeIn, default_value=:default_valueIn, option_url=:option_urlIn\r\n			, required=:requiredIn, valid_test=:valid_testIn, valid_minlength=:valid_minlengthIn, valid_maxlength=:valid_maxlengthIn\r\n			, display_order =:display_orderIn, enabled =:enabledIn,update_date=CURRENT_TIMESTAMP where fieldid=:lineid;	', '', NULL, 1, 1, '2013-09-13 09:15:32', '2013-09-13 09:15:32'),
('AdminEditForms', 'AdminFormsModule', 'icon-pencil', '', NULL, 'Edit the form details.', 'line', 'form', 0, 'monitralldb', 'api/getResults/AdminFormsLine', 'UPDATE forms \r\nset id =:idIn, parent_id =:parent_idIn, icon =:iconIn, name =:nameIn, description =:descriptionIn, scope =:scopeIn, type =:typeIn, \r\nfilter_auto =:filter_autoIn, connection =:connectionIn, default_values_url =:default_values_urlIn, query =:queryIn, target =:targetIn, \r\ndatafile=:datafileIn, display_order =:display_orderIn, enabled =:enabledIn,update_date=CURRENT_TIMESTAMP where id=:lineid;	', '', NULL, 1, 1, '2013-09-13 08:31:25', '2013-09-13 09:51:55'),
('AdminEditGroups', 'AdminGroupsModule', 'icon-pencil', '', NULL, 'Edit the group details.', 'line', 'form', 0, 'monitralldb', 'api/getResults/AdminGroupsLine', 'UPDATE groups set id=:idIn, name=:nameIn, description=:descriptionIn, display_order= :display_orderIn, enabled=:enabledIn , update_date=CURRENT_TIMESTAMP where id=:lineid;', '', NULL, 1, 1, '2013-09-13 06:12:36', '2013-09-13 06:20:10'),
('AdminEditResults', 'AdminResultsModule', 'icon-pencil', '', NULL, 'Edit the result module details.', 'line', 'form', 0, 'monitralldb', 'api/getResults/AdminResultsLine', 'UPDATE results \r\nset id=:idIn,name=:nameIn,description=:descriptionIn,group_id=:groupIn,ui_type=:ui_typeIn,frontpage=:frontpageIn,display=:displayIn\r\n,connection=:connectionIn ,condition_green_operator=:condition_green_operatorIn,condition_green_value=:condition_green_valueIn\r\n,condition_orange_operator=:condition_orange_operatorIn,condition_orange_value=:condition_orange_valueIn ,condition_red_operator=:condition_red_operatorIn\r\n,condition_red_value=:condition_red_valueIn ,query=:queryIn ,datafile=:datafileIn,display_order=:display_orderIn\r\n,notify_enable=:notify_enableIn ,notify_freq=:notify_freqIn ,notify_interval=:notify_intervalIn , start_notify_date=:start_notify_dateIn\r\n,enabled=:enabledIn,update_date=CURRENT_TIMESTAMP where id=:lineid;', '', '', 1, 1, '2013-09-13 07:19:09', '2013-09-26 11:06:36'),
('AdminFilterFieldsByForm', 'AdminFieldsModule', 'icon-filter', 'Filter By Forms', NULL, 'Filter Fields by Form.', 'results', 'filter', 0, 'monitralldb', '', 'SELECT display_order, fieldid as lineid, id, form_id, title, type, required, enabled \r\nfrom fields\r\nwhere form_id=:formid\r\norder by display_order asc', 'AdminFieldsModule', NULL, 3, 1, '2013-09-13 09:34:43', '2013-09-13 09:34:43'),
('AdminFilterFieldsByFormLine', 'AdminFormsModule', 'icon-search', 'Fields', NULL, 'Filter Fields by Form.', 'line', 'filter', 1, 'monitralldb', '', 'SELECT display_order, fieldid as lineid, id, form_id, title, type, required, enabled \r\nfrom fields\r\nwhere form_id=:lineid\r\norder by display_order asc', 'AdminFieldsModule', NULL, 4, 1, '2013-09-13 08:51:24', '2013-09-13 08:51:24'),
('AdminFilterFormsByConnection', 'AdminFormsModule', 'icon-filter', 'Filter By Connection', NULL, 'Filter forms by Connection.', 'results', 'filter', 0, 'monitralldb', '', 'SELECT display_order, id as lineid, name, parent_id, description, type, enabled \r\n			from forms\r\n			where connection=:connectionFIN\r\n			order by display_order asc', 'AdminFormsModule', '', 5, 1, '2013-09-16 07:44:24', '2013-09-16 07:50:40'),
('AdminFilterFormsByResult', 'AdminFormsModule', 'icon-filter', 'Filter By Results', NULL, 'Filter Forms by Results.', 'results', 'filter', 0, 'monitralldb', '', 'SELECT display_order, id as lineid, name, parent_id, description, type, enabled \r\n			from forms\r\n			where parent_id=:parentid\r\norder by display_order asc', 'AdminFormsModule', NULL, 3, 1, '2013-09-13 08:48:56', '2013-09-13 08:48:56'),
('AdminFilterFormsByResultLine', 'AdminResultsModule', 'icon-search', 'Forms', NULL, 'Filter Forms by Result.', 'line', 'filter', 1, 'monitralldb', '', 'SELECT display_order, id as lineid, name, parent_id, description, type, enabled \r\n			from forms\r\n			where parent_id=:lineid\r\n			order by display_order asc', 'AdminFormsModule', NULL, 4, 1, '2013-09-13 08:00:54', '2013-09-13 08:00:54'),
('AdminFilterResultsByConnection', 'AdminResultsModule', 'icon-filter', 'Filter By Connection', NULL, 'Filter results by connection', 'results', 'filter', 0, 'monitralldb', '', 'SELECT display_order, id as lineid, name, group_id, description, ui_type, enabled,notify_enable \r\n			from results \r\n			where connection=:connectionFIN\r\n			order by display_order asc', 'AdminResultsModule', '', 5, 1, '2013-09-16 07:54:32', '2013-09-26 06:37:10'),
('AdminFilterResultsByGroup', 'AdminResultsModule', 'icon-filter', 'Filter By Group', NULL, 'Filter Results by Group.', 'results', 'filter', 0, 'monitralldb', '', 'SELECT display_order, id as lineid, name, group_id, description, ui_type, enabled,notify_enable \r\n			from results \r\n			where group_id=:groupid\r\n			order by display_order asc', 'AdminResultsModule', '', 3, 1, '2013-09-13 07:58:48', '2013-09-26 06:36:50'),
('AdminFilterResultsByGroupLine', 'AdminGroupsModule', 'icon-search', 'Results', NULL, 'Filter Results by Group.', 'line', 'filter', 1, 'WebService', '', 'SELECT display_order, id as lineid, name, group_id, description, ui_type, enabled,notify_enable \r\nfrom results \r\nwhere group_id=:lineid\r\norder by display_order asc', 'AdminResultsModule', '', 3, 1, '2013-09-13 06:34:29', '2013-09-26 06:37:35'),
('AdminNotifyAdd', 'AdminNotifyResultsView', 'icon-plus', 'Add Notification', NULL, 'Enter the details for new notification below to add a notification. Please note a notification is setup on existing Result modules. Each Result module can have 1 notification setup.', 'results', 'form', 0, 'monitralldb', '', 'update results set \r\nnotify_enable = 1, \r\nnotify_freq=:notify_freqIn, \r\nnotify_interval=:notify_intervalIn, \r\nstart_notify_date=:start_notify_dateIn, \r\nnext_notify_date=NULL \r\nwhere id=:idIn', '', '', 0, 1, '2013-10-02 10:22:05', '2013-10-02 11:53:59'),
('AdminNotifyEdit', 'AdminNotifyResultsView', 'icon-pencil', '', NULL, 'Edit the Notification details.', 'line', 'form', 0, 'monitralldb', 'api/getResults/AdminNotifyResultsLine', 'update results SET \r\nnotify_enable=:notify_enableIn, \r\nnotify_freq=:notify_freqIn, \r\nnotify_interval=:notify_intervalIn, \r\nstart_notify_date=:start_notify_dateIn, \r\nnext_notify_date=:next_notify_dateIn \r\nwhere id=:lineid', '', '', 1, 1, '2013-10-02 11:06:26', '2013-10-02 11:48:07'),
('mySQLAddList', 'mySQLLists', 'icon-plus', 'Add list', NULL, 'Will insert a row on Lists', 'results', 'form', 0, 'mySQLLocal', '', 'INSERT INTO list (name) VALUES (:itemTitle)', '', '', 0, 1, '2013-09-13 11:00:41', '2013-09-13 11:00:41'),
('mySQLAddListItem', 'mySQLItems', 'icon-plus', 'Add list Item', NULL, 'Will insert a row on items with specific list Id and value', 'results', 'form', 0, 'mySQLLocal', '', 'INSERT INTO item (title, list_id, marked) VALUES (:itemTitle, :listId, :itemMarked)', '', '', 0, 1, '2013-09-13 11:27:45', '2013-09-13 11:27:45'),
('mySQLEditList', 'mySQLLists', 'icon-pencil', '', NULL, 'Edit specific row', 'line', 'form', 0, 'mySQLLocal', 'api/getResults/mySQLDefaultsListName', 'UPDATE list set name=:itemTitle where id = :lineid', '', '', 2, 1, '2013-09-13 11:02:57', '2013-09-13 11:05:41'),
('mySQLEditListItem', 'mySQLItems', 'icon-pencil', '', NULL, 'Edit specific row', 'line', 'form', 0, 'mySQLLocal', 'api/getResults/mySQLDefaultsItemList', 'UPDATE item set title=:itemTitle, list_id=:listId, marked=:itemMarked where id = :lineid', '', '', 3, 1, '2013-09-13 10:53:51', '2013-09-13 10:53:51'),
('mySQLListFilter', 'mySQLItems', 'icon-filter', 'Filter By List', NULL, 'Filter Items by List.', 'results', 'filter', 0, 'mySQLLocal', '', 'SELECT id as lineid, title as name, list_id, marked as value from item where list_id=:lineid', 'mySQLItems', '', 5, 1, '2013-09-13 11:14:41', '2013-09-13 11:16:39'),
('mySQLListLineFilter', 'mySQLLists', 'icon-filter', 'Find Items', NULL, 'Filter items by list.', 'line', 'filter', 1, 'mySQLLocal', '', 'SELECT id as lineid, title as name, list_id, marked as value from item where list_id=:lineid', 'mySQLItems', '', 1, 1, '2013-09-13 11:05:13', '2013-09-13 11:05:36'),
('mySQLListMarkedFilter', 'mySQLItems', 'icon-filter', 'Filter By List,Marked', NULL, 'Filter Items by List and Marked.', 'results', 'filter', 0, 'mySQLLocal', '', 'SELECT id as lineid, title as name, list_id, marked as value from item where list_id=:lineid and marked=:itemMarked', 'mySQLItems', '', 6, 1, '2013-09-13 11:10:27', '2013-09-13 11:16:49'),
('mySQLMarkedFilter', 'mySQLItems', 'icon-filter', 'Filter By Marked', NULL, 'Filter Items by Marked.', 'results', 'filter', 0, 'mySQLLocal', '', 'SELECT id as lineid, title as name, list_id, marked as value from item where marked=:itemMarked', 'mySQLItems', '', 7, 1, '2013-09-13 11:07:26', '2013-09-13 11:09:29'),
('mySQLRemoveList', 'mySQLLists', 'icon-remove', '', NULL, 'Will delete the specified row of List.', 'line', 'form', 0, 'mySQLLocal', '', 'delete from list where id = :lineid', '', '', 3, 1, '2013-09-13 10:59:45', '2013-09-13 11:05:52'),
('mySQLRemoveListItem', 'mySQLItems', 'icon-remove', '', NULL, 'Will delete the specified row of item.', 'line', 'form', 0, 'mySQLLocal', '', 'delete from item where id = :lineid', '', '', 4, 1, '2013-09-13 10:51:56', '2013-09-13 10:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `index_num` bigint(20) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `display_order` bigint(20) NOT NULL DEFAULT '0' COMMENT 'The order to be displayed',
  `enabled` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to enable',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Insert date time',
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Defines the groups';

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `index_num`, `description`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES
('administration', 'Administration', NULL, 'Monitrall Administration.', 1000, 1, '2013-09-06 09:25:39', '2013-09-06 10:21:27'),
('mySQLTestProgram', 'TODO Demo', NULL, 'Test.', 2, 1, '2013-09-06 09:25:20', '2013-09-20 09:16:17'),
('Test', 'Test Modules', NULL, 'Test.', 0, 1, '2013-09-06 09:23:37', '2013-10-10 08:55:46'),
('TestChart', 'Test Chart', NULL, 'Test Chart.', 1, 1, '2013-09-06 09:23:54', '2013-09-20 09:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Results ID',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Results display name',
  `index_num` bigint(20) DEFAULT NULL COMMENT 'Result index number',
  `group_index_num` bigint(20) DEFAULT NULL COMMENT 'Group index number',
  `description` text COLLATE utf8_unicode_ci COMMENT 'Result description',
  `group_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Group Id',
  `ui_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Boxes' COMMENT 'UI type',
  `frontpage` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'If it appears in the frontpage',
  `display` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'If it will be displayed or used only as web service',
  `connection` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Connection ID',
  `condition_green_operator` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Condition Green Operator',
  `condition_green_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Condition Green Value',
  `condition_orange_operator` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Condition Orange Operator',
  `condition_orange_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Condition Orange Value',
  `condition_red_operator` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Condition Red Operator',
  `condition_red_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Condition Red Value',
  `query` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Query to get the results depending on the connection',
  `filter_query` text COLLATE utf8_unicode_ci COMMENT 'Query to filter the results depending on the connection',
  `datafile` text COLLATE utf8_unicode_ci COMMENT 'Datafile only to be used on execute provider',
  `display_order` bigint(20) NOT NULL DEFAULT '0' COMMENT 'The order to be displayed',
  `notify_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Notifications enabled',
  `notify_freq` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Notification frequency',
  `notify_interval` int(10) DEFAULT NULL COMMENT 'Notification Interval in respect to frequency',
  `start_notify_date` timestamp NULL DEFAULT NULL COMMENT 'Notifications start date',
  `next_notify_date` datetime DEFAULT NULL COMMENT 'Notification next date',
  `enabled` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to enable',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Insert date time',
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Defines Results';

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `name`, `index_num`, `group_index_num`, `description`, `group_id`, `ui_type`, `frontpage`, `display`, `connection`, `condition_green_operator`, `condition_green_value`, `condition_orange_operator`, `condition_orange_value`, `condition_red_operator`, `condition_red_value`, `query`, `filter_query`, `datafile`, `display_order`, `notify_enable`, `notify_freq`, `notify_interval`, `start_notify_date`, `next_notify_date`, `enabled`, `insert_date`, `update_date`) VALUES
('AdminFieldsLine', 'Fields Line', NULL, NULL, 'Used when editing a line', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'SELECT\r\n  id as idIn, form_id as form_idIn, title as titleIn, placeholder as placeholderIn, type as typeIn, default_value as default_valueIn, option_url as option_urlIn\r\n, required as requiredIn, valid_test as valid_testIn, valid_minlength as valid_minlengthIn, valid_maxlength as valid_maxlengthIn\r\n, display_order  as display_orderIn, enabled  as enabledIn \r\nFROM fields\r\nwhere fieldid = :lineid\r\norder by display_order asc', NULL, '', 12, 0, NULL, NULL, NULL, NULL, 1, '2013-09-12 05:26:21', '2013-09-26 06:32:30'),
('AdminFieldsModule', 'Fields', NULL, NULL, 'Edit the Forms Fields.', 'administration', 'Table', 0, 1, 'monitralldb', '', '', '', '', '', '', 'SELECT display_order, fieldid as lineid, id, form_id, title, type, required, enabled \r\nfrom fields\r\norder by display_order asc', NULL, '', 11, 0, NULL, NULL, NULL, NULL, 1, '2013-09-12 05:25:07', '2013-09-13 07:27:44'),
('AdminFormsLine', 'Forms Line', NULL, NULL, 'Used when editing a line', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'SELECT\r\nid as idIn, parent_id as parent_idIn, icon as iconIn, name as nameIn, description as descriptionIn, scope as scopeIn, type as typeIn, \r\nfilter_auto as filter_autoIn, connection as connectionIn, default_values_url as default_values_urlIn, query as queryIn, target as targetIn, datafile as datafileIn,\r\ndisplay_order as display_orderIn, enabled as enabledIn\r\nFROM forms\r\nwhere id = :lineid\r\norder by display_order asc', NULL, '', 9, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-09-12 05:23:00', '2013-10-09 05:42:23'),
('AdminFormsModule', 'Forms', NULL, NULL, 'Edit the Forms.', 'administration', 'Table', 0, 1, 'monitralldb', '', '', '', '', '', '', 'SELECT display_order, id as lineid, name, parent_id, description, type, enabled \r\nfrom forms\r\norder by display_order asc', NULL, '', 8, 0, NULL, NULL, NULL, NULL, 1, '2013-09-12 05:21:40', '2013-09-13 07:27:25'),
('AdminFormsSelect', 'Forms Select', NULL, NULL, 'Used in select inputs', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'SELECT id AS value, CONCAT( id,  '' ('', id,'')'' ) AS name\r\nFROM forms\r\nORDER BY parent_id, display_order ASC ', NULL, '', 10, 0, NULL, NULL, NULL, NULL, 1, '2013-09-12 05:24:02', '2013-09-13 11:36:47'),
('AdminGroupsLine', 'Groups Line', NULL, NULL, 'Used when editing a line', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'SELECT id as idIn, name as nameIn, description as descriptionIn, display_order as display_orderIn, enabled as enabledIn \r\nfrom groups \r\nwhere id = :lineid\r\norder by display_order asc', NULL, '', 1, 0, NULL, NULL, NULL, NULL, 1, '2013-09-11 12:24:32', '2013-09-11 12:33:48'),
('AdminGroupsModule', 'Groups', NULL, NULL, 'Edit the Groups Modules.', 'administration', 'Table', 0, 1, 'monitralldb', '', '', '', '', '', '', 'SELECT a.display_order,a.id as lineid, a.name, a.description, a.enabled, (select count(*) from results c where c.group_id= a.id) as results \r\nfrom groups a\r\norder by display_order asc', NULL, '', 0, 0, NULL, NULL, NULL, NULL, 1, '2013-09-11 12:23:17', '2013-09-11 12:23:17'),
('AdminGroupsSelect', 'Groups Select', NULL, NULL, 'Used in select inputs ', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'SELECT id as value, name\r\nfrom groups \r\norder by display_order asc', NULL, '', 2, 0, NULL, NULL, NULL, NULL, 1, '2013-09-11 12:26:06', '2013-09-11 12:33:55'),
('AdminNotifyResultsDisabledSelect', 'Notifications Disabled Select', NULL, NULL, 'Used in select inputs', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'select '''' as value ,'''' as name \r\nunion\r\nSELECT id as value, CONCAT(name,'' ('',group_id,'' - '',id,'')'')\r\nfrom results \r\nwhere notify_enable = 0 \r\nand not ((condition_red_operator = '''') or (condition_red_operator is null))\r\nand not ((condition_red_value = '''') or (condition_red_value is null))\r\nand enabled=1', NULL, '', 14, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-10-02 10:05:23', '2013-10-07 07:23:38'),
('AdminNotifyResultsLine', 'Notifications Line', NULL, NULL, 'Used when editing a line', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'select id as idIn, notify_enable as notify_enableIn, notify_freq as notify_freqIn, notify_interval as notify_intervalIn, start_notify_date as start_notify_dateIn, next_notify_date as next_notify_dateIn \r\nfrom results\r\nwhere id=:lineid', NULL, '', 15, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-10-02 10:54:34', '2013-10-02 10:55:56'),
('AdminNotifyResultsView', 'Notifications', NULL, NULL, 'All active notification views information', 'administration', 'Table', 0, 1, 'monitralldb', '', '', '', '', '', '', 'SELECT DATE_FORMAT(now(), ''%Y-%m-%d %H:%i:%s'') as now , id as lineid, notify_freq,notify_interval,start_notify_date,next_notify_date FROM results \r\nWHERE notify_enable=1 \r\nand enabled = 1\r\norder by next_notify_date,group_id, display_order asc', NULL, '', 13, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-09-26 11:16:37', '2013-10-07 10:16:15'),
('AdminResultsLine', 'Results Line', NULL, NULL, 'Used when editing a line', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'SELECT\nid as idIn,name as nameIn,description as descriptionIn,group_id as groupIn,ui_type as ui_typeIn,frontpage as frontpageIn,display as displayIn\n,connection as connectionIn ,condition_green_operator as condition_green_operatorIn,condition_green_value as condition_green_valueIn\n,condition_orange_operator as condition_orange_operatorIn,condition_orange_value as condition_orange_valueIn ,condition_red_operator as condition_red_operatorIn\n,condition_red_value as condition_red_valueIn ,query as queryIn ,datafile as datafileIn,display_order as display_orderIn\n,notify_enable as notify_enableIn ,notify_freq as notify_freqIn ,notify_interval as notify_intervalIn, start_notify_date as start_notify_dateIn, enabled as enabledIn\nFROM results\nwhere id = :lineid\norder by display_order asc', NULL, '', 4, 0, NULL, NULL, '2013-09-26 11:10:12', NULL, 1, '2013-09-11 12:28:41', '2013-09-26 06:40:22'),
('AdminResultsModule', 'Results', NULL, NULL, 'Edit the Result Modules.', 'administration', 'Table', 0, 1, 'monitralldb', '', '', '', '', '', '', 'SELECT display_order, id as lineid, name, group_id, description, ui_type, enabled, notify_enable \r\nfrom results \r\norder by group_id, display_order asc', NULL, '', 3, 0, NULL, NULL, NULL, NULL, 1, '2013-09-06 10:42:06', '2013-09-26 06:36:14'),
('AdminResultsSelect', 'Results Select', NULL, NULL, 'Used in select inputs (with extra null row)', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'select '''' as value ,'''' as name \r\nunion\r\nSELECT id as value, CONCAT(name,'' ('',group_id,'' - '',id,'')'')\r\nfrom results ', NULL, '', 5, 0, NULL, NULL, NULL, NULL, 1, '2013-09-11 12:31:11', '2013-09-13 11:35:14'),
('AdminResultsSelectNoEmpty', 'Results Select no Empty', NULL, NULL, 'Used in select inputs', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'SELECT id as value, name\r\nfrom results order by display_order asc', NULL, '', 7, 0, NULL, NULL, NULL, NULL, 1, '2013-09-11 12:32:50', '2013-09-11 12:34:16'),
('BarChartTest', 'Test Bar Chart', NULL, NULL, 'Test BarChart Ui module', 'TestChart', 'BarChart', 1, 1, 'WebService', '', '', '', '', '', '', '../data/testPercent.json', NULL, '', 0, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-09-12 08:14:11', '2014-01-07 12:26:44'),
('BoxesTest', 'Test Boxes', NULL, NULL, 'Test boxes Ui module', 'Test', 'Boxes', 1, 1, 'WebService', '<=', '69', '><', '69 99', '==', '100', '../data/testPercent.json', NULL, '', 4, 0, 'YEARLY', 1, '2012-01-01 10:00:00', '2012-01-01 12:00:00', 1, '2013-09-12 08:06:48', '2014-01-07 12:28:34'),
('ConditionTableTest', 'Test Condition Table', NULL, NULL, 'Test On Off Table Ui module', 'Test', 'ConditionTable', 1, 1, 'WebService', '==', '100', '><', '50 100', '<=', '50', '../data/testPercent.json', NULL, '', 5, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-09-12 08:07:59', '2014-01-07 12:29:06'),
('CSScriptTest', 'Cross Site Script Test', NULL, NULL, 'Checks if the <b>system</b> is vaulenrable to Cross Site Scripting.', 'Test', 'Simple', 0, 1, 'WebService', '', '', '', '', '', '', '../data/ccstest.json', NULL, '', 6, 0, '', 0, '0000-00-00 00:00:00', NULL, 0, '2013-09-12 08:09:58', '2013-10-08 09:28:00'),
('EmptyTest', 'Test empty JSON', NULL, NULL, 'Test empty JSON array', 'Test', 'Simple', 0, 1, 'WebService', '==', '0', '>', '1', '==', '1', '../data/testEmpty.json', NULL, '', 3, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-09-12 08:05:20', '2014-01-07 12:24:37'),
('FillChartTest', 'Test Fill Chart', NULL, NULL, 'Test FillChart Ui module', 'TestChart', 'FillChart', 0, 1, 'WebService', '', '', '', '', '', '', '../data/testPercent.json', NULL, '', 2, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-09-12 08:16:04', '2014-01-07 12:25:28'),
('LineChartTest', 'Test Line Chart', NULL, NULL, 'Test LineChart Ui module', 'TestChart', 'LineChart', 1, 1, 'WebService', '', '', '', '', '', '', '../data/testPercent.json', NULL, '', 1, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-09-12 08:15:20', '2014-01-07 12:29:35'),
('mySQLDefaultsItemList', 'mySQLDefaultsItemList', NULL, NULL, 'Used for default line value ', 'mySQLTestProgram', 'Table', 0, 0, 'mySQLLocal', '', '', '', '', '', '', 'SELECT list_id as listId, title as itemTitle, marked as itemMarked from item where id=:lineid', NULL, '', 3, 0, NULL, NULL, NULL, NULL, 1, '2013-09-12 08:24:02', '2013-09-12 08:24:02'),
('mySQLDefaultsListName', 'mySQLDefaultsListName', NULL, NULL, 'Used as default line value', 'mySQLTestProgram', 'Table', 0, 0, 'mySQLLocal', '', '', '', '', '', '', 'SELECT name as itemTitle from list where id=:lineid', NULL, '', 4, 0, NULL, NULL, NULL, NULL, 1, '2013-09-12 08:25:02', '2013-09-12 08:25:02'),
('mySQLItems', 'Items', NULL, NULL, 'Check connection with mySQL', 'mySQLTestProgram', 'Todo', 0, 1, 'mySQLLocal', '==', '1', '', '', '==', '0', 'SELECT id as lineid, title as name, list_id, marked as value from item', NULL, '', 1, 0, NULL, NULL, NULL, NULL, 1, '2013-09-12 08:20:44', '2013-09-12 08:20:44'),
('mySQLLists', 'Lists', NULL, NULL, 'Check connection with mySQL. Edit the lists', 'mySQLTestProgram', 'Todo', 0, 1, 'mySQLLocal', '==', '0', '', '', '>', '0', 'SELECT a.id as lineid, CONCAT(a.name,'' - ('',(select count(*) from item c where c.list_id= a.id),'' items)'') as name, (select count(*) from item b where b.list_id= a.id and marked=0) as value from list a', NULL, '', 0, 0, NULL, NULL, NULL, NULL, 1, '2013-09-12 08:19:27', '2013-09-12 08:19:27'),
('mySQLListsList', 'mySQLListsList', NULL, NULL, 'Used in select', 'mySQLTestProgram', 'Table', 0, 0, 'mySQLLocal', '', '', '', '', '', '', 'SELECT name, id as value from list', NULL, '', 2, 0, NULL, NULL, NULL, NULL, 1, '2013-09-12 08:22:52', '2013-09-12 08:22:52'),
('PieChartTest', 'Test Pie Chart', NULL, NULL, 'Test PieChart Ui module', 'TestChart', 'PieChart', 0, 1, 'WebService', '', '', '', '', '', '', '../data/testPercent.json', NULL, '', 3, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-09-12 08:16:59', '2014-01-07 12:25:32'),
('PingTest45', 'Ping Test 10.144.12.45', NULL, NULL, 'Ping Test on 10.144.12.45', 'Test', 'Boxes', 0, 0, 'Execute', '===', 'YES', '', '', '===', 'NO', '..\\\\scripts\\\\pingTest.bat 10.144.12.45', NULL, '', 3, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-10-11 11:03:27', '2013-10-11 11:09:02'),
('TestPercent', 'Test Percent', NULL, NULL, 'Test how the Percent modules would look like.', 'Test', 'Percent', 1, 1, 'WebService', '==', '100', '><', '50 100', '<=', '50', '../data/testPercent.json', NULL, '', 1, 0, 'DAILY', 1, '2013-10-10 04:29:55', '2013-10-11 07:29:55', 1, '2013-09-12 08:02:22', '2014-01-07 12:26:03'),
('TestSimple', 'Test Simple', NULL, NULL, 'Test Simple data.', 'Test', 'Simple', 0, 1, 'WebService', '==', '0', '>', '1', '==', '1', '../data/testdata.json', NULL, '', 2, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-09-12 08:03:58', '2014-01-07 12:24:33'),
('TestTable', 'Test Table', NULL, NULL, 'Test full table', 'Test', 'Table', 0, 1, 'WebService', '==', '0', '>', '1', '==', '1', '../data/testdata.json', NULL, '', 0, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2013-09-12 08:00:58', '2014-01-07 11:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique id',
  `stat_id` bigint(20) NOT NULL COMMENT 'Statistics id',
  `result_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Result id',
  `result_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Result date time ',
  `name` varchar(3000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name from result',
  `value` varchar(3000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Value from result',
  PRIMARY KEY (`id`),
  KEY `stat_id` (`stat_id`,`result_id`,`result_date`,`name`(255),`value`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Statistics are saved' AUTO_INCREMENT=1 ;


CREATE TABLE `checks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `check_id` bigint(20) NOT NULL COMMENT 'Check Id',
  `result_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Result Id',
  `check_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Check date',
  `has_red` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Has red in conditions met',
  `has_orange` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Has green in conditions met',
  `has_green` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Has orange in conditions met',
  `has_no_values` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Has no values returned',
  PRIMARY KEY (`id`),
  KEY `check_id` (`check_id`,`result_id`,`check_date`),
  KEY `has_red` (`has_red`,`has_orange`,`has_green`,`has_no_values`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table where automated checks are kept';


CREATE TABLE `dashboards` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `index_num` bigint(20) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `display_order` bigint(20) NOT NULL DEFAULT '0' COMMENT 'The order to be displayed',
  `enabled` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to enable',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Insert date time',
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Defines the Dashboards';

CREATE TABLE `dashresults` (
	`dash_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Dashboard Id',
    `result_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Result Id',
	`display_order` bigint(20) NOT NULL DEFAULT '0' COMMENT 'The order to be displayed',
    `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
    PRIMARY KEY (`dash_id`,`result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Connects Dashboards with result id';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dashresults`;
--
ALTER TABLE `dashresults`
  ADD CONSTRAINT `dashresults_ibfk_2` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`),
  ADD CONSTRAINT `dashresults_ibfk_1` FOREIGN KEY (`dash_id`) REFERENCES `dashboards` (`id`);

-- administration ammendement for dashboards

INSERT INTO `results` (`id`, `name`, `index_num`, `group_index_num`, `description`, `group_id`, `ui_type`, `frontpage`, `display`, `connection`, `condition_green_operator`, `condition_green_value`, `condition_orange_operator`, `condition_orange_value`, `condition_red_operator`, `condition_red_value`, `query`, `filter_query`, `datafile`, `display_order`, `notify_enable`, `notify_freq`, `notify_interval`, `start_notify_date`, `next_notify_date`, `enabled`, `insert_date`, `update_date`) VALUES
('AdminDashModule', 'Dashboards', NULL, NULL, 'Edit the Dashboard Modules.', 'administration', 'Table', 0, 1, 'monitralldb', '', '', '', '', '', '', 'SELECT a.display_order, a.name, a.id as lineid, a.description, a.enabled \r\n, (select count(*) from dashresults c where c.dash_id = a.id) as results \r\n FROM dashboards a;', NULL, '', 18, 0, NULL, NULL, NULL, NULL, 1, '2013-09-11 12:23:17', '2013-09-11 12:23:17'),
('AdminDashLine', 'Dashboard Line', NULL, NULL, 'Used when editing a line', 'administration', 'Table', 0, 0, 'monitralldb', '', '', '', '', '', '', 'SELECT id as idIn, name as nameIn, description as descriptionIn, display_order as display_orderIn, enabled as enabledIn \r\nfrom dashboards \r\nwhere id = :lineid\r\norder by display_order asc', NULL, '', 19, 0, NULL, NULL, NULL, NULL, 1, '2013-09-11 12:24:32', '2013-09-11 12:33:48'),
('AdminDashResultsModule', 'Dash Results', NULL, NULL, 'Edit the Dashboard Results Modules.', 'administration', 'Table', 0, 1, 'monitralldb', '', '', '', '', '', '', 'select a.display_order, concat(a.dash_id,\'---->\',a.result_id) lineid from dashresults a order by dash_id, display_order;', NULL, '', 19, 0, NULL, NULL, NULL, NULL, 1, '2013-09-11 12:23:17', '2013-09-11 12:23:17');

INSERT INTO `forms` (`id`, `parent_id`, `icon`, `name`, `form_index_num`, `description`, `scope`, `type`, `filter_auto`, `connection`, `default_values_url`, `query`, `target`, `datafile`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES
('AdminAddDash', 'AdminDashModule', 'icon-plus', 'Add Dashboard', NULL, 'Enter the dashboard details below to add a new dashboard of results.', 'results', 'form', 0, 'monitralldb', '', 'INSERT INTO dashboards (id, name, description, enabled, display_order, update_date) VALUES (:idIn, :nameIn, :descriptionIn, :enabledIn, :display_orderIn, CURRENT_TIMESTAMP);', '', NULL, 0, 1, '2013-09-13 05:14:32', '2013-09-13 05:14:32'),
('AdminEditDash', 'AdminDashModule', 'icon-pencil', '', NULL, 'Edit the dashboard details.', 'line', 'form', 0, 'monitralldb', 'api/getResults/AdminDashLine', 'UPDATE dashboards set id=:idIn, name=:nameIn, description=:descriptionIn, display_order= :display_orderIn, enabled=:enabledIn , update_date=CURRENT_TIMESTAMP where id=:lineid;', '', NULL, 1, 1, '2013-09-13 06:12:36', '2013-09-13 06:20:10'),
('AdminDeleteDash', 'AdminDashModule', 'icon-remove', '', NULL, 'Delete the specific dashboard.', 'line', 'form', 0, 'monitralldb', '', 'delete from dashboards where id = :lineid;', '', NULL, 2, 1, '2013-09-13 06:20:00', '2013-09-13 06:20:00'),
('AdminAddDashModuleFromDash', 'AdminDashModule', 'icon-plus', '', NULL, 'Add new module to dashboard.', 'line', 'form', 0, 'monitralldb', '', 'INSERT INTO dashresults (dash_id,result_id,update_date, display_order) VALUES (:lineid,:rersultIdIn,CURRENT_TIMESTAMP, :display_orderIn);', '', NULL, 3, 1, '2013-09-13 06:12:36', '2013-09-13 06:20:10'),
('AdminFilterResultsByDashLine', 'AdminDashModule', 'icon-list', 'Results', NULL, 'Filter Results by Dashboard.', 'line', 'filter', 1, 'monitralldb', '', 'select a.display_order, concat(a.dash_id,\'---->\',a.result_id) lineid from dashresults a where dash_id=:lineid order by a.dash_id, a.display_order;', 'AdminDashResultsModule', '', 4, 1, '2013-09-13 06:34:29', '2013-09-26 06:37:35'),
('AdminEditDashResult', 'AdminDashResultsModule', 'icon-pencil', '', NULL, 'Edit the dashboard result order.', 'line', 'form', 0, 'monitralldb', '', 'UPDATE dashresults set display_order=:display_orderIn where dash_id = SUBSTRING(:lineid, 1, LOCATE(\'---->\', :lineid) - 1) and result_id=SUBSTRING(:lineid, LOCATE(\'---->\', :lineid) + 5);', '', NULL, 0, 1, '2013-09-13 06:12:36', '2013-09-13 06:20:10'),
('AdminDeleteDashResult', 'AdminDashResultsModule', 'icon-remove', '', NULL, 'Delete the specific dashboard result.', 'line', 'form', 0, 'monitralldb', '', 'delete from dashresults where dash_id = SUBSTRING(:lineid, 1, LOCATE(\'---->\', :lineid) - 1) and result_id=SUBSTRING(:lineid, LOCATE(\'---->\', :lineid) + 5);', '', NULL, 1, 1, '2013-09-13 06:20:00', '2013-09-13 06:20:00');

INSERT INTO `fields` (`fieldid`, `id`, `form_id`, `title`, `placeholder`, `type`, `default_value`, `option_url`, `required`, `valid_test`, `valid_minlength`, `valid_maxlength`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES
(10006, 'idIn', 'AdminAddDash', 'Dashboard Id', 'Enter dashboard id number.', 'text', '', '', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 05:15:41', '2013-09-13 05:15:41'),
(10007, 'nameIn', 'AdminAddDash', 'Dashboard Name', 'Enter the dashboard name.', 'text', '', '', 1, '', 0, 255, 1, 1, '2013-09-13 05:16:24', '2013-09-13 05:16:24'),
(10008, 'descriptionIn', 'AdminAddDash', 'Dashboard Description', 'Enter the dashboard description.', 'textarea', '', '', 0, '', 0, 6000, 2, 1, '2013-09-13 05:17:25', '2013-09-13 05:17:25'),
(10009, 'display_orderIn', 'AdminAddDash', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 3, 1, '2013-09-13 05:18:22', '2013-09-13 05:20:10'),
(10010, 'enabledIn', 'AdminAddDash', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 4, 1, '2013-09-13 05:19:36', '2013-09-13 05:19:36'),
(10011, 'idIn', 'AdminEditDash', 'Dashboard Id', 'Enter dashboard id number.', 'text', '', '', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 06:13:29', '2013-09-13 06:13:29'),
(10012, 'nameIn', 'AdminEditDash', 'Dashboard Name', 'Enter the dashboard name.', 'text', '', '', 1, '', 0, 255, 1, 1, '2013-09-13 06:15:35', '2013-09-13 06:15:35'),
(10013, 'descriptionIn', 'AdminEditDash', 'Dashboard Description', 'Enter the dashboard description.', 'textarea', '', '', 0, '', 0, 6000, 2, 1, '2013-09-13 06:16:27', '2013-09-13 06:16:27'),
(10014, 'display_orderIn', 'AdminEditDash', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 3, 1, '2013-09-13 06:17:30', '2013-09-13 06:17:30'),
(10015, 'enabledIn', 'AdminEditDash', 'Enabled?', 'Enabled?', 'radio', '0', 'api/config/true_false_bit.json', 1, 'digits', 0, 1, 4, 1, '2013-09-13 06:18:18', '2013-09-13 06:18:18'),
(10017, 'rersultIdIn', 'AdminAddDashModuleFromDash', 'Select Results View Id', 'Select Results View Id.', 'select', '', 'api/getResults/AdminResultsSelectNoEmpty', 1, 'alphanum', 0, 100, 0, 1, '2013-09-13 08:17:08', '2013-09-13 08:17:08'),
(10016, 'display_orderIn', 'AdminAddDashModuleFromDash', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 1, 1, '2013-09-13 06:17:30', '2013-09-13 06:17:30'),
(10018, 'display_orderIn', 'AdminEditDashResult', 'Display order', 'Enter the order of module.', 'text', '0', '', 1, 'digits', 0, 10, 0, 1, '2013-09-13 06:17:30', '2013-09-13 06:17:30');

-- demo data for dashboards

INSERT INTO `dashboards` (`id`, `name`, `index_num`, `description`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES
('TestDash', 'Test DashBoard 1', NULL, '```Test Dashboard```', 0, 1, '2015-11-12 06:17:13', '2015-11-12 09:49:09'),
('TestDash2', 'Test Dashboard', NULL, '', 0, 1, '2015-11-12 06:19:06', '2015-11-12 09:49:13');

INSERT INTO `dashresults` (`dash_id`, `result_id`, `update_date`, `display_order`) VALUES
('TestDash', 'BoxesTest', '2015-11-12 06:18:18', 3),
('TestDash', 'FillChartTest', '2015-11-12 06:18:04', 0),
('TestDash', 'TestPercent', '2015-11-12 09:41:41', 6),
('TestDash2', 'BoxesTest', '2015-11-12 06:19:58', 3),
('TestDash2', 'PieChartTest', '2015-11-12 06:19:37', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Authmon -----------------------------------
----------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `sec_groups`
--

CREATE TABLE IF NOT EXISTS `sec_groups` (
  `group_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The group id',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The Security Group name',
  `description` text COLLATE utf8_unicode_ci COMMENT 'The Security Group Description',
  `enabled` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to enable',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Insert date time',
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='The Security Groups Table ';

--
-- Dumping data for table `sec_groups`
--

INSERT INTO `sec_groups` (`group_id`, `name`, `description`, `enabled`, `insert_date`, `update_date`) VALUES
('none', 'None', 'Dummy Group', 1, '2016-04-22 09:16:39', '2016-06-01 11:09:41');

-- --------------------------------------------------------

--
-- Table structure for table `sec_groupsresults`
--

CREATE TABLE IF NOT EXISTS `sec_groupsresults` (
  `group_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The group id',
  `result_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Result Id',
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
  PRIMARY KEY (`group_id`,`result_id`),
  KEY `sec_groupsresults_ibfk_2` (`result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Connects Security Groups table with the Results table';

-- --------------------------------------------------------

--
-- Table structure for table `sec_users`
--

CREATE TABLE IF NOT EXISTS `sec_users` (
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The User name',
  `is_ldap` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to set as LDAP user',
  `ldap_server` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The Ldap Server i.e. ldap://10.10.10.10',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The User password',
  `group_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The group id',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The Real name',
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The User email',
  `user_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The User telephone',
  `is_admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to set as administrator',
  `comments` text COLLATE utf8_unicode_ci COMMENT 'Any other comments',
  `login_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The login tocken',
  `last_login_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Latest Login date time',
  `lock_tries` int(2) NOT NULL DEFAULT '0' COMMENT 'Number of incorrect password tries',
  `lock_date` timestamp NULL DEFAULT NULL COMMENT 'Latest Locked date time',
  `last_pwd_update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Latest Password Update date time',
  `enabled` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Set 1 to enable',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Insert date time',
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Update date time',
  PRIMARY KEY (`user_name`),
  UNIQUE KEY `user_email_UNIQUE` (`user_email`),
  KEY `sec_users_ibfk_1` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='The Security Users Table ';

--
-- Dumping data for table `sec_users`
--

INSERT INTO `sec_users` (`user_name`, `is_ldap`, `ldap_server`, `user_password_hash`, `group_id`, `name`, `user_email`, `user_phone`, `is_admin`, `comments`, `login_token`, `last_login_date`, `lock_tries`, `lock_date`, `last_pwd_update_date`, `enabled`, `insert_date`, `update_date`) VALUES
('admin', 0, '', '$2y$10$647Y19pxo2rwBODB6QkoN.oHQQu6IFgeWOvX.JVC4KyENimLQk486', 'none', 'MonitrAll Administrator', 'gieglas@gmail.com', '2200000', 1, 'The administrator', NULL, '2016-07-31 19:27:39', 1, '2016-08-16 06:21:17', '2016-06-13 07:08:30', 1, '2016-04-22 09:16:56', '2016-06-10 10:49:18');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sec_groupsresults`
--
ALTER TABLE `sec_groupsresults`
  ADD CONSTRAINT `sec_groupsresults_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `sec_groups` (`group_id`),
  ADD CONSTRAINT `sec_groupsresults_ibfk_2` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`);

--
-- Constraints for table `sec_users`
--
ALTER TABLE `sec_users`
  ADD CONSTRAINT `sec_users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `sec_groups` (`group_id`);
  
-- Extra views for documentation --------------------------
----------------------------------------------

-- --------------------------------------------------------
INSERT INTO `results` (`id`, `name`, `index_num`, `group_index_num`, `description`, `group_id`, `ui_type`, `frontpage`, `display`, `connection`, `condition_green_operator`, `condition_green_value`, `condition_orange_operator`, `condition_orange_value`, `condition_red_operator`, `condition_red_value`, `query`, `filter_query`, `datafile`, `display_order`, `notify_enable`, `notify_freq`, `notify_interval`, `start_notify_date`, `next_notify_date`, `enabled`, `insert_date`, `update_date`) VALUES
('AdminDocs', 'Documentation', NULL, NULL, '', 'administration', 'Details', 0, 1, 'monitralldb', '', '', '', '', '', '', 'select ''To view documentation go to the desired Results, Forms or Fields page and click on the `Doc` button.'' as Instructions', NULL, '', 20, 0, '', 0, '0000-00-00 00:00:00', NULL, 1, '2017-07-18 09:22:39', '2017-07-18 09:59:02');

INSERT INTO `forms` (`id`, `parent_id`, `icon`, `name`, `form_index_num`, `description`, `scope`, `type`, `filter_auto`, `connection`, `default_values_url`, `query`, `target`, `datafile`, `display_order`, `enabled`, `insert_date`, `update_date`) VALUES
('AdminFormFieldsDoc', 'AdminFormsModule', 'icon-print', 'Doc Fields', NULL, 'Form Fields Documentation', 'line', 'filter', 1, 'monitralldb', '', 'select \r\nCONCAT( "####" ,title) as title, fieldid,\r\nid as lineid, placeholder, CONCAT( "**" ,form_id, ''**'') form_id, required, type, valid_test, option_url \r\nfrom fields where enabled =1 and form_id = :lineid', 'AdminDocs', '', 7, 1, '2017-07-18 09:57:32', '2017-07-18 09:57:32'),
('AdminFormsDoc', 'AdminFormsModule', 'icon-print', 'Doc Form', NULL, 'Form Documentation', 'line', 'filter', 1, 'monitralldb', '', '	\r\nselect \r\nCONCAT( "####" ,id) as lineid,\r\nname, description, CONCAT( "**" ,parent_id, ''**'') parent_id, connection,\r\nscope, target, type, filter_auto,\r\nCONCAT_WS(''\\n'',''```sql '', query , ''```'') as ''query''\r\nfrom forms where enabled =1 and id= :lineid', 'AdminDocs', '', 6, 1, '2017-07-18 09:54:37', '2017-07-18 09:55:37'),
('AdminResultsDoc', 'AdminResultsModule', 'icon-print', 'Doc Result', NULL, 'Link for Documentation', 'line', 'filter', 1, 'monitralldb', '', 'select \r\nCONCAT( "####" ,name) as name,\r\nid as lineid, description, group_id, connection,\r\nCONCAT(condition_green_operator, " " ,condition_green_value) as green,\r\nCONCAT(condition_orange_operator, " " ,condition_orange_value) as orange,\r\nCONCAT(condition_red_operator, " " ,condition_red_value) as red,\r\nCONCAT_WS(''\\n'',''```sql '', query , ''```'') as ''query''\r\nfrom results where enabled =1 and id = :lineid', 'AdminDocs', '', 6, 1, '2017-07-18 09:24:16', '2017-07-18 09:49:22'),
('AdminResultsFormsDoc', 'AdminResultsModule', 'icon-print', 'Doc Forms', NULL, 'Result''s forms documentation', 'line', 'filter', 1, 'monitralldb', '', 'select \r\nCONCAT( "####" ,id) as lineid,\r\nname, description, CONCAT( "**" ,parent_id, ''**'') parent_id, connection,\r\nscope, target, type, filter_auto,\r\nCONCAT_WS(''\\n'',''```sql '', query , ''```'') as ''query''\r\nfrom forms where enabled =1 and parent_id = :lineid', 'AdminDocs', '', 7, 1, '2017-07-18 09:27:51', '2017-07-18 09:50:10');