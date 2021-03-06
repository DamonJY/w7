<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="we7-page-title">
	入口设置
</div>
<ul class="we7-page-tab">
	<?php  if(!empty($module['isrulefields'])) { ?><li><a href="<?php  echo url('platform/reply', array('m' => $module['name']));?>">关键字链接入口 </a></li><?php  } ?>
	<?php  if(!empty($frames['section']['platform_module_common']['menu']['platform_module_cover'])) { ?>
	<li class="active"><a href="<?php  echo url('platform/cover', array('m' => $module['name'], 'eid' => $entry_id));?>">封面链接入口</a></li>
	<?php  } ?>
</ul>
<div id="js-keyword-display">
<?php  if($do == 'module') { ?>
	<div ng-controller="KeywordDisplay" ng-cloak>
		<table class="table we7-table table-hover vertical-middle">
			<col width="115px"/>
			<col width="200px" />
			<col width="" />
			<col width="250px" />
			<col />
			<tr>
				<th>二维码</th>
				<th class="text-left">入口名称</th>
				<th>关键字</th>
				<th class="text-left">操作</th>
			</tr>
			<?php  if(is_array($entries['cover'])) { foreach($entries['cover'] as $menu) { ?>
			<tr>
				<td data-url="<?php  echo $_W['siteroot'];?>app/<?php  echo $menu['url'];?>" data-size="100" class="js-url-qrcode"> 
					<div class="qrcode-block"><canvas></canvas></div>
				</td>
				<td class="text-left"><?php  echo $menu['title'];?></td>
				<td>
					<?php  if(is_array($menu['cover']['rule']['keywords'])) { foreach($menu['cover']['rule']['keywords'] as $kw) { ?>
					<span class="form-control-static keyword-tag" data-toggle="tooltip" data-placement="bottom" title="<?php  if($kw['type']==1) { ?>等于<?php  } else if($kw['type']==2) { ?>包含<?php  } else if($kw['type']==3) { ?>正则<?php  } ?>"><?php  echo $kw['content'];?></span>&nbsp;
					<?php  } } ?>
				</td>
				<td class="text-left">
					<div class="link-group" style="position:relative;">
						<a href="<?php  echo url('platform/cover/post', array('m' => $modulename, 'eid' => $menu['eid']));?>" class="color-default we7-margin-right">编辑</a>
						<a href="javascript:;" data-url="<?php  echo $_W['siteroot'];?>app/<?php  echo $menu['url'];?>" style="margin-right:0px;" class="color-default js-clip">复制链接</a>
					</div>
				</td>
			</tr>
			<?php  } } ?>
		</table>
	</div>
<?php  } else if($do == 'post') { ?>
<!--二维码-->
<div class="panel we7-panel">
	<div class="panel-heading">
		直接链接 
	</div>
	<div class="panel-body  we7-form we7-padding">
		<div class="form-group">
			<label for="" class="control-label col-sm-2">直接URL</label>
			<div class="form-controls col-sm-8">
				<input type="text" class="form-control" readonly="readonly" name="url_show" value="<?php  echo $reply['url_show'];?>">
				<span class="help-block">直接指向到入口的URL。您可以在自定义菜单（有oAuth权限）或是其它位置直接使用。 </span>
			</div>
		</div>
		<div class="form-group">
			<label for="" class="control-label col-sm-2">二维码</label>
			<div data-url="<?php  echo $reply['url_show'];?>" data-size="150" class="js-url-qrcode">
				<div class="qrcode-block"><canvas></canvas></div>
			</div>
		</div>
	</div>
</div>
<!--end二维码-->
<div class="we7-form" id="js-reply-form" ng-controller="KeywordReply" ng-cloak>
	<form id="reply-form" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="entry_id" value="<?php  echo $entry_id;?>" />
	<div class="form-group">
		<label for="" class="control-label col-sm-2">规则名称</label>
		<div class="form-controls col-sm-8">
			<input type="text" class="form-control" placeholder="请输入回复规则的名称" name="rulename" value="<?php  echo $reply['title'];?>">
			<span class="help-block">您可以给这组触发关键字规则起一个名字, 方便下次修改和查看. </span>
		</div>
	</div>
	<div class="form-group" ng-show="reply.showAdvance">
		<label for="" class="control-label col-sm-2">全局置顶</label>
		<div class="form-controls col-sm-8">
			<input id="istop-1" type="radio" name="istop" ng-model="reply.entry.istop" ng-value="1" value="1" <?php  if(intval($reply['rule']['displayorder'] >= 255)) { ?> checked="checked"<?php  } ?>/>
			<label for="istop-1" >是</label>
			<input id="istop-2" type="radio" name="istop" ng-model="reply.entry.istop" ng-value="0" value="0" <?php  if(intval($reply['rule']['displayorder'] < 255)) { ?> checked="checked"<?php  } ?>/>
			<label for="istop-2">否</label>
		</div>
		
	</div>
	<div class="form-group" ng-show="reply.entry.istop == 0 && reply.showAdvance">
		<label for="" class="control-label col-sm-2">回复优先级</label>
		<div class="form-controls col-sm-4">
		<input type="number" min="0" max="254" name="displayorder_rule" value="<?php  if(intval($reply['rule']['displayorder']) < 255) { ?><?php  echo $reply['rule']['displayorder'];?><?php  } ?>" placeholder="输入这条回复规则的优先级" class="form-control">
		<span class="help-block">
			规则优先级，越大则越靠前，最大不得超过254
		</span>
		</div>
	</div>
	<div class="form-group">
		<label for="" class="control-label col-sm-2">&nbsp;</label>
		<div class="form-controls color-default col-sm-8">
			<a href="javascript:void(0);" ng-click="changeShowAdvance()"><span ng-show="!reply.showAdvance">展开</span><span ng-show="reply.showAdvance">收起</span>高级设置<i class="fa fa-chevron-down" ng-class="{'fa-chevron-down': !reply.showAdvance, 'fa-chevron-up': reply.showAdvance}"></i></a>
		</div>
	</div>
	<div class="form-group">
		<input type="hidden" name="keywords">
		<input type="hidden" name="reply_type">
		<label class="control-label col-sm-2">触发关键字</label>
		<div class="form-controls col-sm-8 we7-padding-bottom">
			<input id="reply_type-1" type="radio" name="reply_type" ng-model="reply.entry.reply_type" ng-value="2" value="2" <?php  if(intval($reply['rule']['reply_type'] == 2)) { ?> checked="checked"<?php  } ?>/>
			<label for="reply_type-1" >单一</label>
			<input id="reply_type-2" type="radio" name="reply_type" ng-model="reply.entry.reply_type" ng-value="1" value="1" <?php  if(intval($reply['rule']['reply_type'] == 1)) { ?> checked="checked"<?php  } ?>/>
			<label for="reply_type-2">混合</label>
		</div>
		
		<div class="form-controls col-sm-8 col-sm-offset-2" ng-if="reply.entry.reply_type == 2">
			<div class="input-group">
				<div class="input-group-btn">
					<div class="font-default">
						<select name="trigger_type" class="we7-select" ng-model="reply.advanceTrigger" ng-change="changeTriggerType()">
							<option value="exact" ng-selected="!reply.advanceTrigger">精准触发</option>
							<option value="indistinct" ng-selected="reply.advanceTrigger">模糊触发</option>
						</select>
					</div>
				</div>
				<input type="text" class="keyword-input form-control" max="100" id="keyword-input-exact" ng-model="reply.keyword.exact" onblur="checkKeyWord($(this));">
				<span class="input-group-btn"><a href="javascript:;" class="btn btn-default" id="keyword-emoji" ng-init="initEmotion();"><i class="fa fa-github-alt"></i> 表情</a></span>
			</div>
			<span class="help-block">多个关键字请使用逗号隔开，如天气，今日天气</span>
		</div>

		<div class="form-controls col-sm-8 col-sm-offset-2" ng-if="reply.entry.reply_type == 1">
			<div class="we7-form">
				<div class="form-group">
					<label for="" class="control-label col-sm-3">精准触发</label>
					<div class="form-controls input-group col-sm-6">
						<input type="text" class="keyword-input form-control" max="30" id="keyword-exact" ng-model="reply.keyword.exact" onblur="checkKeyWord($(this));">
						<span class="input-group-btn"><a href="javascript:;" class="btn btn-default" id="emoji-exact" ng-init="initEmotion();"><i class="fa fa-github-alt"></i> 表情</a></span>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-sm-3">包含关键字触发</label>
					<div class="form-controls input-group col-sm-6">
						<input type="text" class="keyword-input form-control" max="30" id="keyword-indistinct" ng-model="reply.keyword.contain" onblur="checkKeyWord($(this));">
						<span class="input-group-btn"><a href="javascript:;" class="btn btn-default" id="emoji-indistinct"><i class="fa fa-github-alt"></i> 表情</a></span>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-sm-3">正则匹配关键字触发</label>
					<div class="form-controls input-group col-sm-6">
						<input type="text" class="keyword-input form-control" max="30" id="keyword-regexp" ng-model="reply.keyword.regexp" onblur="checkKeyWord($(this));">
						<span class="input-group-btn"><a href="javascript:;" class="btn btn-default" id="emoji-regexp"><i class="fa fa-github-alt"></i> 表情</a></span>
					</div>
				</div>
				<span class="help-block"></span>
			</div>
			<span class="help-block">多个关键字请使用逗号隔开，如天气，今日天气</span>
		</div>				

	</div>
	<div class="form-group">
		<label for="" class="control-label col-sm-2">是否开启</label>
		<div class="form-controls col-sm-8">
			<label>
				<input name="status" class="form-control" ng-model="reply.status" ng-hide="1">
				<div class="switch" ng-class="{'switchOn': reply.status}" ng-click="changeStatus()"></div>
			</label>
			<span class="help-block">您可以选择临时禁用这条回复.</span>
		</div>
	</div>
	<div class="form-group">
		<label for="" class="control-label col-sm-2">封面</label>
		<div class="form-controls col-sm-8">
			<?php  echo tpl_form_field_image('thumb', $reply['thumb'], '', array('width' => 400));?>
		</div>
	</div>
	<div class="form-group">
		<label for="" class="control-label col-sm-2">描述</label>
		<div class="form-controls col-sm-8">
			<textarea class="form-control" placeholder="添加图文消息的简短描述" name="description"><?php  echo $reply['description'];?></textarea>
		</div>
	</div>
	<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
	<input type="submit" name="submit" value="发布" class="btn btn-primary btn-submit"/>
	</form>
</div>
<?php  } ?>
</div>
<script type="text/javascript">
<!--
	$(function() {
		require(['jquery.qrcode'], function(){
			$('.js-url-qrcode').each(function(){
				url = $(this).data('url');
				$(this).find('.qrcode-block').html('').qrcode({
					render: 'canvas',
					width: $(this).data('size'),
					height: $(this).data('size'),
					text: url
				});
			});
		});
		$('.js-clip').each(function(){
			util.clip(this, $(this).data('url'));
		});
	});
	require(['underscore'], function() {
		angular.module('replyFormApp').value('config', {
			replydata: <?php  echo json_encode($reply['rule'])?>,
			uniacid: <?php  echo json_encode($_W['uniacid'])?>,
		});
		angular.bootstrap($('#js-keyword-display'), ['replyFormApp']);
	});

	// 检测规则是否已经存在
	window.checkKeyWord = function(key) {
	}
	window.validateReplyForm = function(key) {
	}
//-->
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>