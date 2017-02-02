<?php

// This module for Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This module for Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Settings and configuration for Audit Assignments. Responsible for loading the page
 * into the menu under 'Site configuration'
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 defined('MOODLE_INTERNAL') || die();

// this will load it into 'Site Administration'. Functions in lib.php load it into category/course contexts

$ADMIN->add(
 	'reports',
	new admin_externalpage(
		'reportassignaudit',
		get_string('pluginname', 'report_assignaudit'),
		"{$CFG->wwwroot}/report/assignaudit/index.php",
		'report/assignaudit:audit'
	)
);

 $settings = null;
 
