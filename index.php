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
require_once(dirname(__FILE__).'/classes/local/assign_table.php');

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



$form_setup_data = new stdClass();
$form_setup_data->courses = $auditable_courses;
// if the form has been submitted, get the relevant data for displaying in the table
$form = new \report_assignaudit\local\assignrange_form(null, $form_setup_data, 'post');

// data we will pass to mustache template
$template_data = array();

if ($data = $form->get_data()) {

	$course_ids = \report_assignaudit\local\course_assign_data::form_data_to_course_id_list($data);

	if (count($course_ids) > 0) {
		foreach($course_ids as $course_id) {
			$course = get_course($course_id);

			// get assigns from this course
			$assigns = \report_assignaudit\local\course_assign_data::get_assigns_in_date_range($course_id, $data->datefrom, strtotime( date('Y-m-d', $data->dateto) . ' 23:59:00'));

			$course->assigns = array_values($assigns);
			/* we must array_values this to avoid the array keys being non-sequential. Moodle makes
			   the array key equal to the assign ID. Mustache does not accept non-sequentially indexed
			   arrays
			*/

			// make a table from these assigns
			$table = new \report_assignaudit\local\assign_table($USER->id . $course_id, '/report/assignaudit/index.php');

			ob_get_clean();
			ob_start();
			$table->setup();
			$table->fill_with_data($course->assigns);
			$table->finish_output();
			$course->assigns_table = ob_get_clean();

			// get course link for display
			$course->courselink = new \moodle_url('/course/view.php', array('id' => $course_id));

			$template_data[] = $course;
		}
	}
}

// create renderable
$renderable = new report_assignaudit\output\index_page($auditable_courses, $template_data);

echo $output->render($renderable);

echo $output->footer();
