<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div id="js-profile-tplnotice" ng-controller="tplCtrl" ng-cloak>
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
		<li class="active">
			<a href="<?php  echo url('profile/tplnotice')?>">微信通知设置</a>
		</li>
		<li>
			<a href="<?php  echo url('profile/notify')?>">邮件通知参数</a>
		</li>
		<li>
		<a href="<?php  echo url('profile/common/uc_setting')?>">uc站点整合</a>
		</li>
		<li>
		<a href="<?php  echo url('profile/common/upload_file')?>">上传js接口文件</a>
		</li>
	</ul>

	<table class="table we7-table table-hover table-form">
		<col width="200px " />
		<col />
		<col width="100px" />
		<tr>
			<th class="text-left" colspan="3">设置通知模板</th>
		</tr>
		<tr ng-repeat="(key, tpl) in tplList track by key">
			<td class="text-left table-label">
				{{ tpl.name }}
			</td>
			<td class="text-left">
				{{ tpl.tpl }}
			</td>
			<td class="text-left ">
				<div class="link-group"><a href="javascript:;" data-toggle="modal" data-target="#jsauth_acid" ng-click="changeActive(key)">修改</a></div>
			</td>
		</tr>
	</table>
	<div class="modal fade" id="jsauth_acid" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="we7-modal-dialog modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<div class="modal-title">{{ tplList[active]['name'] }}</div>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="" name="" id="" ng-model="activetpl" class="form-control" placeholder="{{ tplList[active]['name'] }}" />
						<span class="help-block">{{ tplList[active]['help'] }}</span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" ng-click="saveTpl()">确定</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	angular.module('profileApp').value('config', {
		'tplList' : <?php  echo json_encode($tpl)?>,
		'url' : "<?php  echo url('profile/tplnotice/set')?>"
	});
	angular.bootstrap($('#js-profile-tplnotice'), ['profileApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>