<?php

/**
 * Set up capabilities for this report plugin.
 *
 * @package report_assignaudit
 * @author Test Valley School
 */

defined('MOODLE_INTERNAL') || die();


$capabilities = array(
	'report/assignaudit:audit' => array(
		'riskbitmask'            => RISK_PERSONAL,
		'captype'                => 'read',
		'contextlevel'           => CONTEXT_MODULE,
		'archetypes'             => array(
			'manager'   => CAP_ALLOW,
		),
	)
);
