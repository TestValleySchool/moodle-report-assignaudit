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
 * Module version information for Audit Assignments 
 *
 * @package report_assignaudit
 * @author Test Valley School
 * @copyright 2017 Test Valley School {@link https://www.testvalley.hants.sch.uk/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2017020201;			// YYYYMMDDXX where XX is an incrementing revision number for that day
$plugin->requires  = 2016052300;			// required Moodle version string
$plugin->component = 'report_assignaudit';		// Full name of the plugin
$plugin->maturity  = MATURITY_BETA;			// 
$plugin->release   = 'v1.0';				// friendly version number
$plugin->cron      = 0;
