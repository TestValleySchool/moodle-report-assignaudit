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
 * Class for accessing data about courses and their assign modules.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_assignaudit\local;

/**
 * Class for accessing data about courses and their assign modules.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_assign_data {

	/**
	 * Return an array of stdClass objects describing the courses which the specified
	 * user has permission to audit.
	 */
	public static function get_auditable_courses($user) {

		global $DB;

		$courses = enrol_get_users_courses($user->id, true);

		$auditable_courses = array();

		if (is_array($courses) && count($courses) > 0) {
			foreach($courses as $course) {
				// get context id for this course
				$context = \context_course::instance($course->id);

				if (has_capability('report/assignaudit:audit', $context)) {
					$auditable_courses[] = $course;
				}
			}
		}

		return $auditable_courses;		

	}

	/** 
	 * Given the returned $data from a moodleform, determine which of the course checkboxes
	 * were checked and return a list of those IDs.
	 */
	public static function form_data_to_course_id_list($formdata) {

		$courselist = array();
	
		$formdata = (array)$formdata;
		if (is_array($formdata) && count($formdata) > 0) {
			foreach($formdata as $key => $item) {
				if (!$item) {
					// advcheckbox disabled, so skip
					continue;
				}

				$course_detail_index = strpos($key, 'course_');
				if ($course_detail_index !== null && $course_detail_index !== false && $course_detail_index !== -1) {
					$courseid = substr($key, $course_detail_index + strlen('course_'));
					$courselist[] = $courseid;
				}

				// if the key is 'mappedcourses', we will use this autocomplete form to populate our course list
				if ('mappedcourses' == $key && is_array($item) && count($item) > 0) {
					foreach($item as $mapped_course) {
						$courselist[] = $mapped_course;
					}
				}

			}
		}


		return $courselist;

	}

	/** 
	 * Get all the assigns that are in the specified course and were created between the startdate
	 * and enddate specified.
	 */
	public static function get_assigns_in_date_range($course, $startdate, $enddate) {
		global $DB;
		$output = array();

		$records = $DB->get_records_sql(
			'SELECT
				{course_modules}.id AS instance_id,
				{assign}.id AS id,
				{assign}.course AS course,
				{assign}.name AS name,
				intro,
				introformat,
				duedate,
				allowsubmissionsfromdate,
				timemodified,
				added
			FROM {assign} 
			INNER JOIN {course_modules} ON {assign}.id = {course_modules}.instance
			INNER JOIN {modules} ON {course_modules}.module = {modules}.id
			WHERE {assign}.course = :course
				AND timemodified >= :startdate
				AND timemodified <= :enddate
				AND {course_modules}.visible = :visible1
				AND {modules}.visible = :visible2
				AND {modules}.name = :modulename',
			array(
				'course'    => $course,
				'startdate' => $startdate,
				'enddate'   => $enddate,
				'visible1'  => 1,
				'visible2'  => 1,
				'modulename'=> 'assign'
			)
		);

		if (count($records) > 0) {
			$output = $records;
		}

		return $output;
	}
};
