<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
	.account-stat-num > div{width:25%; float:left; font-size:16px; text-align:center;}
	.account-stat-num > div span{display:block; font-size:30px; font-weight:bold;}
</style>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'index') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWeburl('statcash', array('op' => 'index'))?>">消费日志</a></li>
	<li <?php  if($op == 'chart') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWeburl('statcash', array('op' => 'chart'))?>">消费统计</a></li>
</ul>
<?php  if($op == 'chart') { ?>
<div class="panel panel-default">
	<div class="panel-heading">
		现金统计
	</div>
	<div class="panel-body">
		<div class="account-stat-num row">
			<div style="width:50%">今日消费总额<span><?php  echo abs($today_consume);?></span></div>
			<div style="width:50%"><?php  echo date('Y-m-d', $starttime);?>~<?php  echo date('Y-m-d', $endtime);?><br>消费总额<span><?php  echo abs($total_consume)?></span></div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		现金统计
	</div>
	<div class="panel-body" id="scroll">
		<div class="pull-left">
			<form action="" id="form1">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="do" value="statcash">
				<input type="hidden" name="op" value="chart">
				<input type="hidden" name="m" value="we7_coupon">
				<?php  echo tpl_form_field_daterange('time', array('start' => date('Y-m-d', $starttime),'end' => date('Y-m-d', $endtime)), '')?>
				<input type="hidden" value="" name="scroll">
			</form>
		</div>
		<div class="pull-right">
			<div class="checkbox">
				<label style="color:rgba(203,48,48,1)"><input checked type="checkbox"> 消费统计</label>&nbsp;
			</div>
		</div>
		<div style="margin-top:20px">
			<canvas id="myChart" width="1200" height="300"></canvas>
		</div>
	</div>
</div>
<script>
	require(['chart', 'daterangepicker'], function(c) {
		$('.daterange').on('apply.daterangepicker', function(ev, picker) {
			$('#form1')[0].submit();
		});
		var chart = null;
		var chartDatasets = null;
		var templates = {
			consume: {
				label: '消费',
				fillColor : "rgba(203,48,48,0.1)",
				strokeColor : "rgba(203,48,48,1)",
				pointColor : "rgba(203,48,48,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(203,48,48,1)"
			},
			recharge: {
				label: '充值',
				fillColor : "rgba(149,192,0,0.1)",
				strokeColor : "rgba(149,192,0,1)",
				pointColor : "rgba(149,192,0,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(149,192,0,1)"
			}
		};

		function refreshData() {
			if(!chart || !chartDatasets) {
				return;
			}
			var visables = [];
			var i = 0;
			$('.checkbox input[type="checkbox"]').each(function(){
				if($(this).attr('checked')) {
					visables.push(i);
				}
				i++;
			});
			var ds = [];
			$.each(visables, function(){
				var o = chartDatasets[this];
				ds.push(o);
			});
			chart.datasets = ds;
			chart.update();
		}

		var url = location.href + '&#aaaa';
		$.post(url, function(data){
			var data = $.parseJSON(data)
			var datasets = data.datasets;

			if(!chart) {
				var label = data.label;
				var ds = $.extend(true, {}, templates);
				ds.consume.data = datasets.consume;
				ds.recharge.data = datasets.recharge;
				var lineChartData = {
					labels : label,
					datasets : [ds.consume, ds.recharge]
				};

				var ctx = document.getElementById("myChart").getContext("2d");
				chart = new Chart(ctx).Line(lineChartData, {
					responsive: true
				});
				chartDatasets = $.extend(true, {}, chart.datasets);
			}
			refreshData();
		});

		$('.checkbox input[type="checkbox"]').on('click', function(){
			$(this).attr('checked', !$(this).attr('checked'))
			refreshData();
		});
	});
</script>
<?php  } else { ?>
<div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
			<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="do" value="statcash">
				<input type="hidden" name="op" value="index">
				<input type="hidden" name="m" value="we7_coupon">
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">消费时间</label>
				<div class="col-sm-6 col-md-8 col-lg-8 col-xs-12">
					<?php  echo tpl_form_field_daterange('time', array('starttime' => date('Y-m-d', $starttime), 'endtime' => date('Y-m-d', $endtime),));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">姓名/手机号码/UID</label>
				<div class="col-sm-6 col-md-8 col-lg-8 col-xs-12">
					<input type="text" class="form-control" name="user" value="<?php  echo $_GPC['uid'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">操作人</label>
				<div class="col-sm-6 col-md-8 col-lg-8 col-xs-12">
					<?php  if($_W['user']['clerk_type'] == 3) { ?>
						<input type="text" class="form-control" value="<?php  echo $clerks[$_W['user']['clerk_id']]['name'];?>"  disabled/>
					<?php  } else { ?>
					<select class="form-control" name="clerk_id">
						<option value="">不限</option>
						<?php  if(is_array($clerks)) { foreach($clerks as $clerk) { ?>
						<option value="<?php  echo $clerk['id'];?>" <?php  if($_GPC['clerk_id'] == $clerk['id']) { ?>selected<?php  } ?>><?php  echo $clerk['name'];?></option>
						<?php  } } ?>
					</select>
					<?php  } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">消费门店</label>
				<div class="col-sm-6 col-md-8 col-lg-8 col-xs-12">
					<select class="form-control" name="store_id">
						<option value="">不限</option>
						<?php  if(is_array($stores)) { foreach($stores as $store) { ?>
						<option value="<?php  echo $store['id'];?>" <?php  if($_GPC['store_id'] == $store['id']) { ?>selected<?php  } ?>><?php  echo $store['business_name'];?></option>
						<?php  } } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label">积分/金额/实收</label>
				<div class="col-sm-6 col-md-8 col-lg-8 col-xs-12">
					<div class="input-group">
						<input type="text" class="form-control" name="min" value="<?php  echo $_GPC['min'];?>" />
						<span class="input-group-addon">至</span>
						<input type="text" class="form-control" name="max" value="<?php  echo $_GPC['max'];?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
				<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
					<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					<button name="export" value="export" class="btn btn-default"><i class="fa fa-download"></i> 导出数据</button>
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
				</div>
			</div>
		</form>
	</div>
</div>
<form method="post" class="form-horizontal" id="form1">
	<div class="panel panel-default ">
		<div class="table-responsive panel-body">
			<table class="table table-hover">
				<thead>
				<tr>
					<th style="width:80px;">会员编号</th>
					<th>姓名</th>
					<th>手机</th>
					<th>消费金额</th>
					<th>实收金额</th>
					<th>余额支付</th>
					<th>积分抵消</th>
					<th>实收现金</th>
					<th>消费门店</th>
					<th>操作人</th>
					<th width="150">操作时间</th>
				</tr>
				</thead>
				<tbody>
				<?php  if(is_array($data)) { foreach($data as $row) { ?>
				<tr title="点击查看详情" onclick="$(this).next().toggle();" style="cursor:pointer">
					<td><i class="fa fa-caret-down"></i> <?php  echo $row['uid'];?></td>
					<td><?php  echo $users[$row['uid']]['realname'];?></td>
					<td><?php  echo $users[$row['uid']]['mobile'];?></td>
					<td><?php  echo $row['fee'];?></td>
					<td><?php  echo $row['final_fee'];?></td>
					<td><?php  echo $row['credit2'];?></td>
					<td><?php  echo $row['credit1_fee'];?></td>
					<td><?php  echo $row['final_cash'];?></td>
					<td><?php  echo $row['store_cn'];?></td>
					<td><?php  echo $row['clerk_cn'];?></td>
					<td><?php  echo date('Y-m-d H:i', $row['createtime'])?></td>
				</tr>
				<tr style="display:none">
					<td colspan="11"><strong><?php  echo $row['remark'];?></strong></td>
				</tr>
				<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php  echo $pager;?>
</form>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>