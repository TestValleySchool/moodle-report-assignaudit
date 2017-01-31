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
 * A class for a configurable date range form element.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_assignaudit\local;

global $CFG;

require_once("$CFG->libdir/formslib.php");

use moodleform;


/**
 * A class for a configurable form to select a date filter and course filter.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class assignrange_form extends moodleform {

	/**
	 * An array of stdClass() objects describing the courses that should be
	 * displayed as checkboxes on the form. Objects should have id, shortname,
	 * fullname properties.
	 */
	protected $course_list = null;

	/**
	 * Set up the form
	 */
	public function definition() {
		global $CFG;
		
		// validate course list
		if (!is_array($this->_customdata->courses)) {
			throw new \coding_exception(get_string('nocoursesinlist', 'report_assignaudit'));
		}

		foreach($this->_customdata->courses as $course) {
			if (!($course instanceof \stdClass)) {
				throw new \coding_exception(get_string('coursesinlistmustbestdclass', 'report_assignaudit'), $course);
			}
			if (!property_exists($course, 'id')) {
				throw new \coding_exception(get_string('coursemissingid', 'report_assignaudit'), $course);
			}
			if (!property_exists($course, 'shortname')) {
				throw new \coding_exception(get_string('coursemissingshortname', 'report_assignaudit'), $course);
			}
			if (!property_exists($course, 'fullname')) {
				throw new \coding_exception(get_string('coursemissingfullname', 'report_assignaudit'), $course);
			}
		}

		$this->course_list = $this->_customdata->courses;

		$mform = $this->_form;

		$mform->addElement('header', 'find_assignments', get_string('findassignments', 'report_assignaudit'));

		$date_sel_options = array(
			'startyear'      => 2012,
			'stopyear'       => (int) date('Y'),
		);

		$mform->setExpanded('find_assignments');

		$date_selectors[] =& $mform->createElement('date_selector', 'datefrom', get_string('createdbetween', 'report_assignaudit'), $date_sel_options);
		$date_selectors[] =& $mform->createElement('date_selector', 'dateto', get_string('conjuctiveand', 'report_assignaudit'), $date_sel_options);

		foreach($date_selectors as $element) {
			$mform->addElement($element);
		}

		$mform->setDefault('datefrom', strtotime('now - 2 weeks'));
		$mform->setDefault('dateto', strtotime('tomorrow'));

		$mform->addElement('header', 'in_courses', get_string('incourses', 'report_assignaudit'));

		/*

		fallback
		if (count($this->course_list) > 0) {
			foreach($this->course_list as $course) {
				$mform->addElement('advcheckbox', 'course_' . $course->id, $course->shortname, '', array( 'group' => 1 ), array(0, 1) );
			}
			$this->add_checkbox_controller(1, get_string('allcourses', 'report_assignaudit'));
		}
		else {
			$mform->addElement('html', get_string('nocourses', 'report_assignaudit'));
		}*/

		$autocomplete_options = array(
			'multiple'         => true,
			'includefrontpage' => false
		);

		$mform->addElement('course', 'mappedcourses', get_string('courses'), $autocomplete_options);

		$this->add_action_buttons(/* $cancel */ false, get_string('showbutton', 'report_assignaudit'));

	}

	/**
	 * Wrapper to call setDefault on the form object.
	 */
	public function setDefault($element, $default) {
		$this->_form->setDefault($element, $default);
	}

	/**
	 * 
	 */
	public function validation($data, $files) {
		return array();
	}

};
