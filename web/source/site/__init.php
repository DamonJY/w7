<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.zheyitianshi.com/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

if ($action != 'entry') {
	checkaccount();
}

if (!($action == 'multi' && $do == 'post')) {
	define('FRAME', 'account');
}