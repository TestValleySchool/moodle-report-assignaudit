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
 * Public API for Audit Assignments 
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Extend the navigation to include this report.
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $course The course object for the report
 * @param stdClass $context The context of the course.
 */
function report_assignaudit_extend_navigation_course($navigation, $course, $context) {
	if (has_capability('report/assignaudit:audit', $context)) {
		$url = new \moodle_url('/report/assignaudit/index.php', array('id' => $course->id));
		$name = get_string('pluginname', 'report_assignaudit');
		$navigation->add($name, $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));
	}
}

/**
 * Extend the navigation to include this report.
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $context The context of the category.
 */
function report_assignaudit_extend_navigation_category_settings($navigation, $context) {
	if (has_capability('report/assignaudit:audit', $context)) {
		$url = new \moodle_url('/report/assignaudit/index.php');
		$name = get_string('pluginname', 'report_assignaudit');
		$navigation->add($name, $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));
	}
}
