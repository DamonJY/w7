<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.zheyitianshi.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function welcome_get_last_modules() {
	load()->classs('cloudapi');

	$api = new CloudApi();
	$last_modules = $api->get('store', 'app_fresh');
	return $last_modules;
}