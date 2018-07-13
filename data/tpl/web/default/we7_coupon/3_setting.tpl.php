<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<div class="clearfix">
	<ul class="nav nav-tabs">
		<li class="active"><a href="javascript:;"><i class="fa fa-edit"></i> 模块配置参数</a></li>
	</ul>
	<div class="form-group" style="padding: 10px;">
	</div>

	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1">
		<div class="panel panel-default">
			<div class="panel-heading">模块配置参数</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-2 control-label">卡券类型 </label>
					<div class="col-md-10">
						<label class="radio-inline">
							<input type="radio" name="setting[coupon_type]" value="1" <?php  if($settings['coupon_type'] == 1) { ?>checked<?php  } ?>>
							系统卡券									</label>
						<label class="radio-inline">
							<input type="radio" name="setting[coupon_type]" value="2" <?php  if($settings['coupon_type'] == 2) { ?>checked<?php  } ?>>
							微信卡券									</label>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">是否开启兑换中心 </label>
					<div class="col-md-10">
						<label class="radio-inline">
							<input type="radio" name="setting[exchange_enable]" value="1" <?php  if($settings['exchange_enable'] == 1) { ?>checked<?php  } ?>>
							开启									</label>
						<label class="radio-inline">
							<input type="radio" name="setting[exchange_enable]" value="0" <?php  if($settings['exchange_enable'] == 0) { ?>checked<?php  } ?>>
							关闭									</label>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-10">
						<input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
						<!--<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />-->
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>