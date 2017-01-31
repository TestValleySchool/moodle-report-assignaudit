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
 * Class for a renderable web page table for showing the assign plugin instances in a given course.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_assignaudit\local;
require_once(dirname(__FILE__) . '/../../../../lib/tablelib.php');

/**
 * Class for a renderable web page table for showing the assign plugin instances in a given course.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 class assign_table extends \flexible_table {

	/**
	 * Constructor
	 * @param int $uniqueid Tables must have a unique ID used as a key when storing table properties in the session.
	 * @param string $baseurl The URL of the page that produces this instance of this table. As a string, not a moodle_url.
	 */
	 public function __construct($uniqueid, $baseurl) {
		parent::__construct($uniqueid);

		$this->define_baseurl($baseurl);
	
		$this->define_columns(array(
			'allowsubmissionsfromdate',
			'duedate',
			'details',
		));

		$this->define_headers(array(
			get_string('allowsubmissionsfromdate', 'mod_assign'),
			get_string('duedate', 'mod_assign'),
			get_string('details', 'report_assignaudit'),
		));

	 }

	 /**
	  * Given an array of objects representing assign instances, fill this table with rows
	  * of data.
	  */
	 public function fill_with_data($data) {
	 var_dump($data);
		if (is_array($data) && count($data) > 0) {
			foreach($data as $key => $item) {

				$row = array();

				if (property_exists($item, 'allowsubmissionsfromdate')) {
					$row[0] = \userdate($item->allowsubmissionsfromdate, get_string('strftimedateshort', 'langconfig'));
				}

				if (property_exists($item, 'duedate')) {
					$row[1] = \userdate($item->duedate, get_string('strftimedateshort', 'langconfig'));
				}

				if (property_exists($item, 'name') && property_exists($item, 'intro')) {
					$row[2] = '<strong>' . \format_text($item->name) . '</strong><br/>' . \format_text($item->intro);
				}

				if (count($row) == 3) {
					$this->add_data($row);
				}

			}
		}
	 }

 };
