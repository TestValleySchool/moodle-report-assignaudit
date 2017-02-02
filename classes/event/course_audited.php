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
 * An event fired when a particular course has been audited for the creation
 * of assigns.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_assignaudit\event;

defined('MOODLE_INTERNAL') || die();

/**
 * An event fired when a particular course has been audited for the creation
 * of assigns.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_audited extends \core\event\base {
	
	/**
	 * Initialize some basic event data
	 *
	 * @return void
	 */
	protected function init() {
		global $DB;

		$this->data['crud'] = 'r';
		$this->data['edulevel'] = self::LEVEL_OTHER;
	}

	/**
	 * Create this event with the provided $course metadata (from get_course)
	 */
	public static function create_from_course($course, $access_granted = true) {
		$data = array(
			'other' =>
				array(
					'course_id'         => $course->id,
					'course_shortname'  => $course->shortname,
					'access'            => $access_granted
				),
			'context' => \context_course::instance($course->id)
		);

		$event = self::create($data);

		return $event;
	}

	/**
	 * Return localised event name
	 *
	 * @return string
	 */
	public static function get_name() {
		return get_string('eventcourseaudited', 'report_assignaudit');
	}

	/**
	 * Returns description of the event.
	 * 
	 * @return string
	 */
	public function get_description() {
		return sprintf(get_string('eventcourseauditeddescription', 'report_assignaudit'),
			$this->userid,
			$this->get_data()['other']['course_id'],
			$this->get_data()['other']['course_shortname'],
			($this->get_data()['other']['access']) ? 'yes': 'no'
			);
	}

	/**
	 * Returns the URL to the report module with this course as the argument.
	 *
	 * @return \moodle_url
	 */
	public function get_url() {
		return new \moodle_url('/report/assignaudit/index.php', array('courses[]' => $this->get_data()['other']['course_id']));
	}

	public static function get_other_mapping() {
		return false;
	}

};
