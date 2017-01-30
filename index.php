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
 * Loader for Audit Assignments page
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(dirname(__FILE__).'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once(dirname(__FILE__).'/classes/local/course_assign_data.php');

admin_externalpage_setup('reportassignaudit', '', null, '', array());
// admin_externalpage_setup does access validation checks for us

$title = get_string('pluginname', 'report_assignaudit');
$pagetitle = $title;
$url = new \moodle_url('/report/assignaudit/index.php');
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);

$output = $PAGE->get_renderer('report_assignaudit');

echo $output->header();
echo $output->heading($pagetitle);

$auditable_courses = report_assignaudit\local\course_assign_data::get_auditable_courses($USER);

// create renderable
$renderable = new report_assignaudit\output\index_page($auditable_courses);

echo $output->render($renderable);

echo $output->footer();
