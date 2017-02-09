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

		$mform->addElement('checkbox', 'includehidden', get_string('hiddenassignments', 'report_assignaudit'), get_string('includehidden', 'report_assignaudit'));

		$mform->addElement('header', 'in_courses', get_string('incourses', 'report_assignaudit'));

		/* the autocomplete 'course' element takes an option for 'requiredcapabilities'. We can
		simply pass in the audit capability and it will determine all possible valid courses that the user
		can select. Beautiful! */

		$autocomplete_options = array(
			'multiple'             => true,
			'includefrontpage'     => false,
			'requiredcapabilities' => array(
					'report/assignaudit:audit'
			),
			'placeholder'          => get_string('coursestosearch', 'report_assignaudit') 
		);

		$mapped_courses = $mform->addElement('course', 'mappedcourses', get_string('courses'), $autocomplete_options);

		$mform->addElement('checkbox', 'auditallcourses', get_string('auditallcoursesorellipsis', 'report_assignaudit'), get_string('auditallcourses', 'report_assignaudit'));


		if (isset($this->_customdata->selected_courses)) {
			$mapped_courses->setValue($this->_customdata->selected_courses);
		}

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
