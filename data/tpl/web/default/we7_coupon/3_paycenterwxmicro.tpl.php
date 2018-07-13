<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'pay') { ?>class="active"<?php  } ?>><a href="<?php  echo url('paycenter/wxmicro/pay');?>">刷卡收款</a></li>
</ul>

<?php  if($op == 'pay') { ?>
<style>
	.panel .panel-heading input[name="fee"] {
		line-height:60px;
		height:60px; font-size:40px;
		padding-top:10px;
		text-align:right;
	}
	.panel .panel-heading .form-group{
		margin-bottom: 0px;
	}
	.panel .panel-body .row .col-md-4{
		margin-bottom: 15px;
	}
	.panel .panel-body .row .col-md-4 button, .panel-footer .row .col-md-6 button{
		line-height: 40px;
		font-size: 20px;
	}
	#wechat-pay .modal-content .form-group p{
		font-size: 16px;
	}
	#wechat-pay .modal-content .form-group p span{
		color: red;
	}
	#wechat-pay .modal-content .modal-body{
		text-align: center;
	}
	.row .col-md-3 .panel .panel-body span{
		font-size: 22px;
		color: #666;
		display: block;
	}
</style>
<div class="clearfix" ng-controller="microPay" id="microPay">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<img src="resource/images/money.png" height="50">
				</div>
				<div class="panel-body">
					<span>￥<?php  echo $credit_total;?></span>
					今日收款
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<img src="resource/images/wx-icon.png" height="50">
				</div>
				<div class="panel-body">
					<span>￥<?php  echo $wechat_total;?></span>
					今日收款
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">￥</span>
						<input type="text" name="fee" class="form-control input-lg" ng-model="micro.config.fee" ng-init="micro.config.fee" placeholder="支付金额(至少0.01元)" disabled>
						<span class="input-group-addon">元</span>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4" ng-repeat="num in micro.config.nums">
						<button type="button" class="btn btn-info btn-lg btn-block" ng-click="micro.num(num[0])">{{num[1]}}</button>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-6">
						<a ng-if="micro.config.fee == '0'" ng-click="micro.mcardPay()" class="btn btn-success btn-lg btn-block ">会员卡支付(-)</a>
						<a ng-if="micro.config.fee !='0'" data-toggle="modal" ng-click="micro.mcardPay('1')" class="btn btn-success btn-lg btn-block mccard">会员卡支付(-)</a>
					</div>
					<div class="col-md-6">
						<a ng-if="micro.config.fee == '0'" ng-click="micro.mcardPay()" class="btn btn-success btn-lg btn-block">微信刷卡支付(+)</a>
						<a ng-if="micro.config.fee != '0'" ng-click="micro.mcardPay('2')" data-toggle="modal" class="btn btn-success btn-lg btn-block">微信刷卡支付(+)</a>
						<div class="modal fade" id="wechat-pay">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-body" style="text-align:center;">
										<div class="form-group">
											<h2>刷卡支付</h2>
											<p>收款金额为<span> {{micro.config.fee}}元</span></p>
											<p class="js-userpaying" style="display:none;"><span>用户正在支付中</span></p>
											<input type="text" name="code" class="form-control js-input input-lg" ng-model="micro.config.code" tabindex="4" placeholder="微信刷卡支付授权码(请链接扫码枪扫码)">
										</div>
										<div class="form-group">
											<p class="js-pay-warning text-left" style="color:red;"></p>
										</div>
										<div class="form-group text-right">
											<a class="btn btn-primary btn-lg" id="micro-submit" ng-click="micro.submit()" ng-disabled="micro.last_money < 0">确认收款</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				消费记录(最近10条)
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>消费方式</th>
						<th>金额</th>
						<th>优惠金额</th>
						<th>实际支付</th>
						<th>状态</th>
					</tr>
					<?php  if(is_array($paycenter_records)) { foreach($paycenter_records as $record) { ?>
					<tr>
						<td><?php  echo $record['id'];?></td>
						<td>
							<?php  if($record['cash'] == '0') { ?>
							<span class="label label-info">会员卡支付</span>
							<?php  } else if(!empty($record['cash']) && $record['credit2'] == '0' && $record['credit1'] == '0') { ?>
							<span class="label label-success">微信支付</span>
							<?php  } else if(!empty($record['cash']) && (!empty($record['credit2']) || !empty($record['credit1']))) { ?>
							<span class="label label-warning">混合支付</span>
							<?php  } ?>
						</td>
						<td><?php  echo $record['fee'];?></td>
						<td><?php  echo $record['fee'] - $record['final_fee']?></td>
						<td><?php  echo $record['final_fee'];?></td>
						<td>
							<?php  if($record['status'] == '1') { ?>
							<span class="label label-primary">支付成功</span>
							<?php  } else { ?>
							<span class="label label-danger">支付失败</span>
							<?php  } ?>
						</td>
					</tr>
					<?php  } } ?>
				</table>
			</div>
		</div>
	</div>
<?php  } ?>

<?php  if(!empty($card_set)) { ?>
	<div ng-show="micro.config.body && micro.config.fee" class="modal fade" id="mcard-pay" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="form-group">
						<label>会员卡卡号</label>
						<input type="text" name="cardsn" class="form-control js-input" ng-model="micro.config.cardsn"  tabindex="1" placeholder="请输入11位会员卡卡号">
					</div>
					<div ng-show="micro.config.card_error" ng-bind="micro.config.card_error" class="text-danger"></div>
					<div ng-show="micro.config.loading" ng-bind="micro.config.loading"></div>
					<div ng-show="micro.config.member.uid > 0">
					<table class="table table-hover table-bordered" ng-show="micro.config.member.uid">
						<tr>
							<td colspan="4" style="text-align:center"><h4>{{micro.config.cardsn}}</h4></td>
						</tr>
						<tr>
							<th width="100">姓名</th>
							<td>{{micro.config.member.realname}}</td>
							<th>手机号</th>
							<td>{{micro.config.member.mobile}}</td>
						</tr>
						<tr>
							<th>积分</th>
							<td>{{micro.config.member.credit1}}</td>
							<th>余额</th>
							<td>{{micro.config.member.credit2}}</td>
						</tr>
						<tr>
							<th>会员等级</th>
							<td>{{micro.config.member.groupname}}</td>
							<th>优惠信息</th>
							<td>{{micro.config.member.discount_cn}}</td>
						</tr>
					</table>
					<div class="form-group" ng-if="micro.config.member.uid > 0">
						<label>实际支付金额</label>
						<input type="text" name="fact_fee" class="form-control" ng-model="micro.config.fact_fee" readonly>
					</div>
					<div ng-if="micro.config.fact_fee > 0">
						<div class="form-group">
							<label>支付方式</label>
							<table class="table table-hover table-bordered">
								<tr>
									<td>
										<label class="checkbox-inline">余额支付</label>
										<div class="input-group">
											<input type="text" class="form-control js-input" tabindex="2" name="credit2" ng-model="micro.config.credit2"/>
											<span class="input-group-addon">元</span>
										</div>
									</td>
								</tr>
								<tr ng-if="micro.config.card.offset_rate > 0">
									<td>
										<label class="checkbox-inline">积分抵现</label>
										<div class="input-group">
											<span class="input-group-addon">当前积分可抵扣<span>{{micro.config.member.credit1 / micro.config.card.offset_rate | credit1_num}}</span>元,选择抵扣</span>
											<input type="text" tabindex="3" class="form-control js-input" id="offset_money" ng-model="micro.config.offset_money"/>
											<span class="input-group-addon">元</span>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="form-group" ng-if="micro.config.is_showCode == '1'">
							<label>微信需支付</label>
							<div class="input-group">
								<input type="text" name="cash" class="form-control" ng-model="micro.last_money" readonly><span class="input-group-addon">元</span>
							</div>
							<label>刷卡授权码</label>
							<input type="text" name="code" class="form-control js-input" ng-model="micro.config.code" tabindex="4" placeholder="微信刷卡支付授权码(请链接扫码枪扫码)">
						</div>
						<div class="form-group">
							<div ng-show="micro.last_money >= 0">
								应支付<span ng-bind="micro.config.fact_fee"></span>元,余额抵扣<span ng-bind="micro.config.credit2"></span>元,还需支付<span ng-bind="micro.last_money"></span>元.
							</div>
							<div ng-show="micro.last_money < 0">
								超额支付
							</div>
						</div>
					</div>
					</div>
					<div class="form-group text-right" ng-show="micro.config.member.uid > 0">
						<a class="btn btn-primary js-mc-pay" id="micro-submit" ng-click="micro.submit()" ng-disabled="micro.last_money < 0">确认收款</a>
						<a class="btn btn-success" id="micro-query" ng-show="micro.show_query == 1" ng-click="micro.query()">查询支付情况</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php  } ?>
</div>
<script>
$(function(){
	angular.module('paycenterApp').value('config', {
		'card_set_str' : '<?php  echo $card_set_str;?>',
		'card_check_url' : '<?php  echo $this->createWeburl('paycenter', array('op' => 'check'))?>',
		'pay_url' : '<?php  echo $this->createWeburl('paycenter', array('op' => ''))?>',
		'query_url' : '<?php  echo $this->createWeburl('paycenter', array('op' => 'query'))?>',
		'checkpay_url' : '<?php  echo $this->createWeburl('paycenter', array('op' => 'checkpay'))?>',
		'redirect_url' : '<?php  echo $this->createWeburl('paycenter')?>'
	});
	angular.bootstrap(document, ['paycenterApp']);
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>