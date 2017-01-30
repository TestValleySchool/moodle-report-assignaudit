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

};
