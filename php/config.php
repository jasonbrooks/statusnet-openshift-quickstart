<?php
if (!defined('STATUSNET') && !defined('LACONICA')) { exit(1); }

$config['site']['name'] = $_ENV['OPENSHIFT_APP_NAME'];

$config['site']['server'] = $_ENV['OPENSHIFT_APP_DNS'];
$config['site']['path'] = false; 

$config['site']['fancy'] = true;

$config['db']['database'] = $_ENV['OPENSHIFT_DB_URL'].$_ENV['OPENSHIFT_APP_NAME'];

$config['db']['type'] = $_ENV['OPENSHIFT_DB_TYPE'];

$config['site']['profile'] = 'private';

