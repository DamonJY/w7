<?PHP

/*
    签到：定义一个变量赋值为0，点击一次变量赋值为5，判断24小时之后点击一次在原基础上加5，循环
*/

defined('IN_IA') or exit('Access Denied');


    // 获取用户id 提取用户积分和点击时间。

    // 判断本次点击时间是否过了午夜12点。

    // 用户点击时记录点击时间和积分添加到数据库。

    class we7_qiandaobaModuleSite extends WeModuleSite {
        //  用户信息表
		private $tb_user = 'we7_qiandaoba_user';
		

		public function doWebRule(){
			global $_W, $_GPC;
			$rid = intval($_GPC['id']);
			echo $rid;
		}
	

/** 
 *  前端 签到首页
*/
public function doMobileStore() {
	// ini_set('display_errors','On');
	// error_reporting(E_ALL);

	global $_W, $_GPC;

	echo $_W['openid'];
	
	load()->model('mc');
	$avatar = '';
// todo 
	if (!empty($_W['member']['uid'])) {
		$member = mc_fetch(intval($_W['member']['uid']), array('avatar'));
		if (!empty($member)) {
			$avatar = $member['avatar'];
		}
	}
	if (empty($avatar)) {
		$fan = mc_fansinfo($_W['openid']);
		if (!empty($fan)) {
			$avatar = $fan['avatar'];
		}
	}
	if (empty($avatar)) {
		$userinfo = mc_oauth_userinfo();
		if (!is_error($userinfo) && !empty($userinfo) && is_array($userinfo) && !empty($userinfo['avatar'])) {
			$avatar = $userinfo['avatar'];
		}
	}
	if (empty($avatar) && !empty($_W['member']['uid'])) {
		$avatar = mc_require($_W['member']['uid'], array('avatar'));
	}
	if (empty($avatar)) {
		// 提示用户关注公众号。;
		echo "最终没有获取到头像,follow: {$_W['fans']['follow']}";
	} else {
		
	echo <<<IMG
<img src="$avatar">
IMG;
	}
	
	// var_export($avatar);die;
		// var_export($_W['member']);
		$info = $this->getAllInfo();
		// echo '<pre>';
		// var_export($info);
		// foreach ($info as $k => $v) {
		// 	return $v['jifen'];
		// }
		include $this->template('store');
	}
	

	/**
	 * 获取签到信息
	*/
	private function getAllInfo(){
		global $_W;
		$sql = 'SELECT * FROM '.tablename($this->tb_user).'WHERE id=:id ORDER BY id asc';
		// var_dump($sql);die;
		$params = array(
			':id' => $_W['member']['uid']
		);

		// var_dump($params);die;

		$info = pdo_fetchall($sql, $params);

		if(empty($info)){

			// $info['id'] = $_W['member']['uid'];
			// $info['name'] = $_W['fans']['nickname'];

			$xinxi = array(
				'id' => $_W['member']['uid'],
				'name' => $_W['fans']['nickname'],
			);

			pdo_insert('we7_qiandaoba_user', $xinxi , $replace = false);

		} else {

			$info = pdo_fetchall($sql, $params);

		}

		// var_dump($info);die;

		return $info;
	}


	/**
	 * 后台管理
	*/

	public function doMobileUpdateJifen(){
		global $_W, $_GPC;

		$id = intval($_W['member']['uid']);

		$activity = pdo_get('we7_qiandaoba_user', array('id' => $id));

		// var_export($activity);die;
	
		$activity['jifen'] = $activity['jifen'] + 1;

		$activity['start_time'] = $_W['timestamp'];


		// var_export($activity['start_time']);die;

		$data = array(
			'id' => $activity['id'],
			'name' => $activity['name'],
			'start_time' => $activity['start_time'],
			'end_time' => $activity['end_time'],
			'jifen' => $activity['jifen'],
		);

		// var_export($data);die;
		pdo_update('we7_qiandaoba_user', $data, array('id' => $id));

		message('签到成功~, 积分+1', referer(), 'success');
	}

}
