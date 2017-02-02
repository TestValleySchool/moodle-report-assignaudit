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
 * An event fired when the audit assignments report is viewed.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_assignaudit\event;

defined('MOODLE_INTERNAL') || die();

/**
 * An event fired when the audit assignments report is viewed.
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class report_viewed extends \core\event\base {

	/**
	 * Initialize some basic event data
	 *
	 * @return void
	 */
	protected function init() {
		$this->data['crud'] = 'r';
		$this->data['edulevel'] = self::LEVEL_OTHER;
		$this->context = \context_system::instance();
	}

	/**
	 * Return localised event name
	 * 
	 * @return string
	 */
	public static function get_name() {
		return get_string('eventauditpageviewed', 'report_assignaudit');
	}

	/**
	 * Return description of the event.
	 */
	public function get_description() {
		return sprintf(get_string('eventauditpagevieweddescription', 'report_assignaudit'), $this->userid);
	}

	/**
	 * Returns the URL to the report module.
	 *
	 * @return \moodle_url
	 */
	public function get_url() {
		return new \moodle_url('/report/assignaudit/index.php');
	}

	/** ??
	 */
	public static function get_other_mapping() {
		return false;
	}


};
