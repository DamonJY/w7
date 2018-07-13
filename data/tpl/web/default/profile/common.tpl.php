<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-title">
	参数设置
</div>
<ul class="we7-page-tab">
	<li>
	<a href="<?php  echo url('profile/passport')?>">借用权限</a>
	</li>
	<li>
		<a href="<?php  echo url('profile/payment')?>">支付参数</a>
	</li>
	<li>
		<a href="<?php  echo url('profile/tplnotice')?>">微信通知设置</a>
	</li>
	<li>
		<a href="<?php  echo url('profile/notify')?>">邮件通知参数</a>
	</li>
	<li<?php  if($do == 'uc_setting') { ?> class="active"<?php  } ?>>
	<a href="<?php  echo url('profile/common/uc_setting')?>">uc站点整合</a>
	</li>
	<li<?php  if($do == 'upload_file') { ?> class="active"<?php  } ?>>
	<a href="<?php  echo url('profile/common/upload_file')?>">上传js接口文件</a>
	</li>
</ul>

<?php  if($do == 'uc_setting') { ?>
<div class="main js-profile-uc" ng-controller="ucCtrl">
	<form id="form1" action="<?php  echo url('profile/common/uc_setting')?>" method="post" class="we7-form form ng-cloak" >
		<div class="panel panel-default">
			<div class="panel-heading">
				设置UC参数
			</div>
			<div class="panel-body">
				<div class="alert alert-info">
					<p>
						使用UC能够整合其他系统的会员信息. 如果你不清楚此功能的作用, 请咨询您的技术人员. <br />
						1. 在UC系统中增加新的应用, 并填写[应用接口文件名称]为: uc.php?uniacid=<?php  echo $_W['uniacid'];?> <br />
						2. 在下方启用UC, 并按照UC系统中新增的应用参数填写
					</p>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">启用UC</label>
					<div class="col-sm-8">
						<input type="radio" id="status1" name="status" ng-model="uc.status" value="1"/>
						<label class="radio-inline" for="status1">开启</label>
						<input type="radio" id="status0" name="status" ng-model="uc.status" value="0"/>
						<label class="radio-inline" for="status0">关闭</label>
						<span class="help-block">使用UC能够整合其他系统的会员信息. 如果你不清楚此功能的作用, 请咨询您的技术人员.</span>
					</div>
				</div>
				<div  ng-show="uc.status == '1'">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">快速录入</label>
						<div class="col-sm-8 col-xs-12">
							<textarea class="form-control" rows="6" id="textarea"></textarea>
							<span class="help-block">你可以直接复制UC中的[应用的 UCenter 配置信息]来快速搞定配置参数.</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
						<div class="col-sm-8 col-xs-12">
							<input id="submit" type="button" class="btn btn-primary" value="一键录入">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">通行证名称</label>
						<div class="col-sm-8 col-xs-12">
							<input type="text" name="title" class="form-control" value="{{uc.title}}" autocomplete="off">
							<span class="help-block">请输入你的通行证名称, 方便与UC系统联系.比如: 你的论坛名字</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">应用ID</label>
						<div class="col-sm-8 col-xs-12">
							<input type="text" name="appid" class="form-control" value="{{uc.appid}}" autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">通信密钥</label>
						<div class="col-sm-8 col-xs-12">
							<input type="text" name="key" class="form-control" value="{{uc.key}}" autocomplete="off"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">UCenter字符集</label>
						<div class="col-sm-8 col-xs-12">
							<input type="text" name="charset" class="form-control" value="{{uc.charset}}" autocomplete="off"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">通信方式</label>
						<div class="col-sm-8 col-xs-12">
							<input type="radio" id="connect-1" name="connect" ng-model="uc.connect" value="mysql"/>
							<label class="radio-inline" for="connect-1">MYSQL方式</label>
							<input type="radio" id="connect-2" name="connect" ng-model="uc.connect" value="http"/>
							<label class="radio-inline" for="connect-2">远程方式HTTP</label>
						</div>
					</div>
					<div class="tb mysql" ng-show="uc.connect == 'mysql';">
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">数据库主机</label>
							<div class="col-sm-8 col-xs-12">
								<input type="text" name="dbhost" class="form-control" value="{{uc.dbhost}}" autocomplete="off">
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">数据库用户名</label>
							<div class="col-sm-8 col-xs-12">
								<input type="text" name="dbuser" class="form-control" value="{{uc.dbuser}}" autocomplete="off"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">数据库密码</label>
							<div class="col-sm-8 col-xs-12">
								<input type="text" name="dbpw" class="form-control" value="{{uc.dbpw}}" autocomplete="off"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">数据库名称</label>
							<div class="col-sm-8 col-xs-12">
								<input type="text" name="dbname" class="form-control" value="{{uc.dbname}}" autocomplete="off"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">数据库字符集</label>
							<div class="col-sm-8 col-xs-12">
								<input type="text" name="dbcharset" class="form-control" value="{{uc.dbcharset}}" autocomplete="off"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">表前缀</label>
							<div class="col-sm-8 col-xs-12">
								<input type="text" name="dbtablepre" class="form-control" value="{{uc.dbtablepre}}" autocomplete="off"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否持久连接</label>
							<div class="col-sm-8 col-xs-12">
								<input type="radio" id="dbconnect-1" name="dbconnect" value="1" ng-model="uc.dbconnect"/>
								<label class="radio-inline" for="dbconnect-1">是</label>
								<input type="radio" id="dbconnect-2" name="dbconnect" value="0" ng-model="uc.dbconnect"/>
								<label class="radio-inline" for="dbconnect-2">否</label>
							</div>
						</div>
					</div>
					<div class="tb http" ng-show="uc.connect != 'mysql';">
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">服务端URL地址</label>
							<div class="col-sm-8 col-xs-12">
								<input type="text" name="api" class="form-control" value="{{uc.api}}" autocomplete="off"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label">服务端IP</label>
							<div class="col-sm-8 col-xs-12">
								<input type="text" name="ip" class="form-control" value="{{uc.ip}}" autocomplete="off"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12">
			<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>
<script type="text/javascript">
	angular.module('profileApp').value('config', {
		'uc' : <?php  echo json_encode($uc)?>
	});
	angular.bootstrap($('.js-profile-uc'), ['profileApp']);
	//处理快速录入
</script>

<?php  } else if($do == 'upload_file') { ?>
<div class="main" >
	<form id="form21" action="<?php  echo url('profile/common/upload_file')?>" method="post" class="we7-form form" enctype="multipart/form-data">
		<div class="panel-body">
			<div class="alert alert-info">
				<p>
					设置JS接口安全域名，需要上传的文件。 <br />
				</p>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">上传文件</label>
				<div class="col-sm-8">
					<input type="file" name="file" value="">
				</div>
			</div>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			<input type="submit" class="btn btn-primary" name="submit" value="上传" />
		</div>
	</form>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
