<?php
/**
 * 微商城公告模块微站定义
 *
 * @author 微擎团队
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Ewei_shopping_plugin_noticeModuleSite extends WeModuleSite {
	public function doWebNotice() {
		global $_GPC, $_W;
		$notice_info = pdo_get('shopping_notice', array('uniacid' => $_W['uniacid']));
		$notice = $notice_info['content'];
		if (checksubmit()) {
			if (empty($notice_info)) {
				pdo_insert('shopping_notice', array('content' => trim($_GPC['content']), 'uniacid' => $_W['uniacid']));
			} else {
				pdo_update('shopping_notice', array('content' => trim($_GPC['content'])), array('uniacid' => $_W['uniacid']));
			}
			itoast('提交成功', '', 'success');
		}
		include $this->template('notice');
	}
}