<?php

//dezend by http://www.yunlu99.com/ QQ:270656184
defined('IN_IA') || die('Access Denied');
class We7_couponModule extends WeModule
{
	/**
	 * @inheritdoc
	 */
	public function settingsDisplay($settings)
	{
		if ($_POST) {
			global $_GPC;
			$cfg = $_GPC['setting'];
			if ($this->saveSettings($cfg)) {
				message('保存成功', 'refresh');
			}
		}
		include $this->template('setting');
	}
}