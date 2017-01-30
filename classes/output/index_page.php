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
 * Output renderable (handler to set up data) for index page mustache template.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_assignaudit\output;

use renderable;
use renderer_base;
use templatable;
use stdClass;

/**
 * Output renderable (handler to set up data) for index page mustache template.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class index_page implements renderable, templatable {

	/**
	 * An array of objects detailing the courses this user can audit.
	 */
	protected $auditable_courses = array();

	/**
	 * The class constructor should receive any information that needs to be passed to the template at rendertime.
	 */
	public function __construct($auditable_courses) {
		$this->auditable_courses = $auditable_courses;
	}

	/**
	 * Export the data for use in the Mustache template.
	 */
	public function export_for_template(renderer_base $output) {
		$data = new stdClass();

		require_once( dirname(__FILE__) . ' /../local/assignrange_form.php');

		$form_setup_data = new stdClass();
		$form_setup_data->courses = $this->auditable_courses;

		$form = new \report_assignaudit\local\assignrange_form(null, $form_setup_data, 'post');
		$data->assignrange_form = $form->render();

		return $data;
	}

};

