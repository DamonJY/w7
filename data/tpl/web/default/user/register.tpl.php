<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<script>
	$('#form1').submit(function(){
		if($.trim($(':text[name="username"]').val()) == '') {
			util.message('没有输入用户名.', '', 'error');
			return false;
		}
		if($('#password').val() == '') {
			util.message('没有输入密码.', '', 'error');
			return false;
		}
		if($('#password').val() != $('#repassword').val()) {
			util.message('两次输入的密码不一致.', '', 'error');
			return false;
		}
/* 		<?php  if(is_array($extendfields)) { foreach($extendfields as $item) { ?>
		<?php  if($item['required']) { ?>
			if (!$.trim($('[name="<?php  echo $item['field'];?>"]').val())) {
				util.message('<?php  echo $item['title'];?>为必填项，请返回修改！', '', 'error');
				return false;
			}
		<?php  } ?>
		<?php  } } ?>
 */		<?php  if($_W['setting']['register']['code']) { ?>
		if($.trim($(':text[name="code"]').val()) == '') {
			util.message('没有输入验证码.', '', 'error');
			return false;
		}
		<?php  } ?>
	});
	var h = document.documentElement.clientHeight;
	$(".login").css('min-height',h);
</script>
<div class="head">
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php  echo $_W['siteroot'];?>">
					<img src="<?php  if(!empty($_W['setting']['copyright']['blogo'])) { ?><?php  echo tomedia($_W['setting']['copyright']['blogo'])?><?php  } else { ?>./resource/images/logo/logo.png<?php  } ?>" class="pull-left" width="110px" height="35px">
					<span class="version"><?php echo IMS_VERSION;?></span>
				</a>
			</div>
		</div>
	</nav>
</div>
<div class="main">
	<div class="register" style="">
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="" class="we7-form" method="post" role="form" id="form1">
					<div class="form-group">
						<label class="control-label col-sm-1">用户名:<span class="color-red">*</span></label>
						<div class="col-sm-11">
							<input name="username" type="text" class="form-control" placeholder="请输入用户名">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-1">密码:<span class="color-red">*</span></label>
						<div class="col-sm-11">
							<input name="password" type="password" id="password" class="form-control col-sm-10" placeholder="请输入不少于8位的密码">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-1">确认密码:<span style="color:red">*</span></label>
						<div class="col-sm-11">
							<input name="password " type="password" id="repassword" class="form-control col-sm-10" placeholder="请再次输入不少于8位的密码">
						</div>
					</div>
					<?php  if($extendfields) { ?>
						<?php  if(is_array($extendfields)) { foreach($extendfields as $item) { ?>
							<div class="form-group">
								<label class="control-label col-sm-1"><?php  echo $item['title'];?>:<?php  if($item['required']) { ?><span class="color-red">*</span><?php  } ?></label>
								<div class="col-sm-11">
									<?php  echo tpl_fans_form($item['field'])?>
								</div>
							</div>
						<?php  } } ?>
					<?php  } ?>
					<?php  if($_W['setting']['register']['code']) { ?>
						<div class="form-group">
							<label class="control-label col-sm-1">验证码:<span class="color-red">*</span></label>
							<div class="col-sm-11">
								<div class="input-group">
									<input name="code" type="text" class="form-control" placeholder="请输入验证码">
									<a href="javascript:;" class="input-group-btn imgverify"><img src="<?php  echo url('utility/code');?>" class="img-rounded" onclick="this.src='<?php  echo url('utility/code');?>' + Math.random();" /></a>
								</div>
							</div>
						</div>
					<?php  } ?>
					<!--div class="form-group">
						<label>邀请码:<span style="color:red">*</span></label>
						<input name="invitation" type="text" class="form-control" placeholder="请输入邀请码">
					</div-->
					<div class="login-submit text-center">
						<input type="submit" name="submit" value="注册" class="btn btn-primary" />
						<a href="<?php  echo url('user/login');?>" class="btn btn-default">登录</a>
						<input name="token" value="<?php  echo $_W['token'];?>" type="hidden" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-base', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-base', TEMPLATE_INCLUDEPATH));?>
