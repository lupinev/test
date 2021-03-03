<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',

	// Localhost
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'ess',

	// Online
	// 'hostname' => 'localhost',
	// 'username' => 'wportaladmin',
	// 'password' => 'W3b$3rveR_@dM!n',
	// 'database' => 'ess',

	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
