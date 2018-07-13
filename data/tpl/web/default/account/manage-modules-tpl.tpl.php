<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('account/account-header', TEMPLATE_INCLUDEPATH)) : (include template('account/account-header', TEMPLATE_INCLUDEPATH));?>
<div id="js-account-manage-modules-tpl" ng-controller="AccountMangeModulesTpl" ng-cloak>

	<table class="table we7-table table-hover" ng-repeat="module_tpl in modules_tpl">
		<tr>
			<th colspan="6" class="text-left we7-padding-right">
				<span ng-bind="module_tpl.name"></span>
				
			</th>
		</tr>
		<tr>
			<td colspan="5">
				<div class="col-sm-1 color-gray text-left we7-padding-none">应用</div>
				<div class="col-sm-11">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="module_tpl.id != -1">
						<a href="javascript:;" class="label label-success">系统模块</a>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in module_tpl.modules">
						<a href="javascript:;" class="label label-info" ng-bind="module.title"></a>
					</div>
					
				</div>
			</td>
			<td class="we7-padding-right color-default"></td>
		</tr>
		<tr style="display:none;">
			<td colspan="5">
				<div class="col-sm-1 color-gray text-left we7-padding-none">小程序</div>
				<div class="col-sm-11">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in module_tpl.wxapp">
						<a href="javascript:;" class="label label-info" ng-bind="module.title"></a>
					</div>
					
				</div>
			</td>
			<td class="we7-padding-right color-default"></td>
		</tr>
		<tr >
			<td colspan="5">
				<div class="col-sm-1 color-gray text-left we7-padding-none">模板</div>
				<div class="col-sm-11">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="module_tpl.id != -1">
						<a href="javascript:;" class="label label-success">系统模板</a>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="tpl in module_tpl.templates">
						<a href="javascript:;" class="label label-info" ng-bind="tpl.title"></a>
					</div>
					
				</div>
			</td>
			<td class="we7-padding-right color-default"></td>
		</tr>
	</table>
	<table class="table we7-table table-hover account-package-extra">
		<tr>
			<th colspan="6" class="text-left we7-padding-right"><span>附加权限</span></th>
		</tr>
		<tr>
			<td colspan="5">
				<div class="col-sm-1 color-gray text-left we7-padding-none">应用</div>
				<div class="col-sm-11 js-extra-modules">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in extend.modules" ng-if="extend.modules">
						<a href="javascript:;" class="label label-info" ng-bind="module.title"></a>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="!extend.modules">
						<a href="javascript:;">---</a>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<div class="col-sm-1 color-gray text-left we7-padding-none">模板</div>
				<div class="col-sm-11 js-extra-templates">
					<div class="col-sm-3 text-left we7-margin-bottom" ng-repeat="module in extend.templates" ng-if="extend.templates">
						<a href="javascript:;" class="label label-info" ng-bind="module.title"></a>
					</div>
					<div class="col-sm-3 text-left we7-margin-bottom" ng-if="!extend.templates">
						<a href="javascript:;">---</a>
					</div>
				</div>
			</td>
		</tr>
	</table>

	<?php  if($_W['role'] == ACCOUNT_MANAGE_NAME_FOUNDER) { ?>
	<p>
		<a href="javascript:;" class="btn btn-primary" data-toggle="modal" data-target="#change-group">修改套餐</a>
		<a href="javascript:;" class="btn btn-primary" data-toggle="modal" data-target="#jurisdiction-add">修改附加权限</a>
	</p>
	
	<div class="modal" id="jurisdiction-add">
		<div class="modal-dialog we7-modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<ul role="tablist" class="nav nav-pills">
						<li class="active"><a class="we7-padding-horizontal" data-toggle="tab" role="tab" aria-controls="content-modules" href="#content-modules">模块</a></li>
						<li><a class="we7-padding-horizontal" data-toggle="tab" role="tab" aria-controls="content-templates" href="#content-templates">模板</a></li>
					</ul>
				</div>
				<div class="modal-body">
					<div class="tab-content">
						<div id="content-modules" class="tab-pane active" role="tabpanel">
							<table class="table we7-table table-hover vertical-middle">
								<col width="280px">
								<col width="220px">
								<col />
								<tr>
									<th>模块名称</th>
									<th>模块标识</th>
									<th></th>
								</tr>
								<?php  if(is_array($modules)) { foreach($modules as $module) { ?>
								<tr>
									<td><?php  echo $module['title'];?><?php  if($module['issystem']) { ?><span class="label label-success">系统模块</span><?php  } ?></td>
									<td><?php  echo $module['name'];?></td>
									<td><a class="btn btn-default js-btn-select <?php  if(is_array($extend['modules']) && in_array($module, $extend['modules'])) { ?>btn-primary<?php  } ?>" data-title="<?php  echo $module['title'];?>" data-name="<?php  echo $module['name'];?>" onclick="$(this).toggleClass('btn-primary')">选取</a></td>
								</tr>
								<?php  } } ?>
							</table>
						</div>
						<div id="content-templates" class="tab-pane" role="tabpanel">
							<table class="table we7-table table-hover vertical-middle">
								<col width="280px">
								<col width="220px">
								<col />
								<tr>
									<th>模板名称</th>
									<th>模板标识</th>
									<th></th>
								</tr>
								<?php  if(is_array($templates)) { foreach($templates as $temp) { ?>
								<tr>
									<td><?php  echo $temp['title'];?></td>
									<td><?php  echo $temp['name'];?></td>
									<td><a class="btn btn-default js-btn-select <?php  if(is_array($extend['templates']) && in_array($temp, $extend['templates'])) { ?>btn-primary<?php  } ?>" data-title="<?php  echo $temp['title'];?>" data-name="<?php  echo $temp['name'];?>" data-id="<?php  echo $temp['id'];?>" onclick="$(this).toggleClass('btn-primary')">选取</a></td>
								</tr>
								<?php  } } ?>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" ng-click="addExtend()">确定</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="change-group">
		<div class="modal-dialog we7-modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				</div>
				<div class="modal-body">
					<div class="tab-content we7-form">
						<table class="table we7-table table-hover">
							<tr>
								<th class="text-left bg-light-gray">应用权限组（各权限组均包含系统模块和微站默认模板）</th>
								<th class="text-left bg-light-gray">操作</th>
							</tr>
							<tr>
								<td class="text-left">
									<input id="check-0" type="checkbox" name="package[]" autocomplete="off" value="-1" <?php  if(is_array($owner['group']['package']) && in_array('-1', $owner['group']['package'])) { ?>checked disabled<?php  } ?><?php  if(is_array($extendpackage) && !empty($extendpackage['-1'])) { ?>checked <?php  } ?> />
									<label for="check-0" class="we7-padding-left we7-margin-horizontal-none">所有服务</label>
								</td>
								<td class="text-left">
									<div class="link-group">
										<a href="javascript:;" class="color-default js-unfold" data-toggle="collapse" data-target="#extend0" ng-click="changeText($event)">展开</a>
									</div>
								</td>
							</tr>
							<tr class="collapse bg-light-gray" aria-expanded="true" id="extend0">
								<td colspan="2">
									<div class="col-sm-2 color-gray text-left we7-padding-none">应用权限</div>
									<div class="col-sm-10">
										<div class="col-sm-3 text-left">
											<span class="label label-danger">系统所有模块</span>
										</div>
									</div>
									<div class="col-sm-2 color-gray text-left we7-padding-none">模板权限</div>
									<div class="col-sm-10">
										<div class="col-sm-3 text-left">
											<span class="label label-danger">系统所有模板</span>
										</div>
									</div>
								</td>
							</tr>
							<?php  if(is_array($unigroups)) { foreach($unigroups as $package) { ?>
								<tr>
									<td class="text-left">
										<input id="check-<?php  echo $package['id'];?>" type="checkbox" name="package[]" autocomplete="off" <?php  if(is_array($owner['group']['package']) && in_array($package['id'], $owner['group']['package'])) { ?>checked disabled<?php  } ?> <?php  if(is_array($extendpackage) && !empty($extendpackage[$package['id']])) { ?>checked <?php  } ?> value="<?php  echo $package['id'];?>" />
										<label for="check-<?php  echo $package['id'];?>" class="we7-padding-left we7-margin-horizontal-none"><?php  echo $package['name'];?></label>
									</td>
									<td class="text-left">
										<div class="link-group">
											<a href="javascript:;" class="color-default js-unfold" data-toggle="collapse" data-target="#extend<?php  echo $package['id'];?>" ng-click="changeText($event)">展开</a>
										</div>
									</td>
								</tr>
								<tr class="collapse bg-light-gray" aria-expanded="true" id="extend<?php  echo $package['id'];?>">
									<td colspan="2">
										<div>
											<div class="col-sm-2 color-gray text-left we7-padding-none">应用权限</div>
											<div class="col-sm-10">
												<div class="col-sm-3 text-left" ng-style="{'margin-right': '35px','margin-bottom': '15px'}">
													<a href="javascript:;" class="label label-info">系统模块</a>
												</div>
												<?php  if(is_array($package['modules'])) { foreach($package['modules'] as $module) { ?>
												<div class="col-sm-3 text-left" ng-style="{'margin-right': '35px','margin-bottom': '15px'}">
													<a href="javascript:;" class="label label-info"><?php  echo $module['title'];?></a>
												</div>
												<?php  } } ?>
											</div>
										</div>
										<div>
											<div class="col-sm-2 color-gray text-left we7-padding-none">模板权限</div>
											<div class="col-sm-10">
												<div class="col-sm-3 text-left" ng-style="{'margin-right': '35px','margin-bottom': '15px'}">
													<a href="javascript:;" class="label label-info">微站默认模板</a>
												</div>
												<?php  if(is_array($package['templates'])) { foreach($package['templates'] as $template) { ?>
												<div class="col-sm-3 text-left" ng-style="{'margin-right': '35px','margin-bottom': '15px'}">
													<a href="javascript:;" class="label label-info"><?php  echo $template['title'];?></a>
												</div>
												<?php  } } ?>
											</div>
										</div>
									</td>
								</tr>
							<?php  } } ?>
						</table>						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" ng-click="changeGroup()">确定</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>
	<?php  } ?>
</div>
<script>
	angular.module('accountApp').value('config', {
		owner: <?php echo !empty($owner) ? json_encode($owner) : 'null'?>,
		modules_tpl: <?php echo !empty($modules_tpl) ? json_encode($modules_tpl) : 'null'?>,
		extend: <?php echo !empty($extend) ? json_encode($extend) : 'null'?>,
		links: {
			postModulesTpl: "<?php  echo url('account/post/modules_tpl', array('acid' => $acid, 'uniacid' => $uniacid))?>",
		},
	});
	angular.bootstrap($('#js-account-manage-modules-tpl'), ['accountApp']);
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>