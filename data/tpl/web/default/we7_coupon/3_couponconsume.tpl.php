<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php  if($op == 'display') { ?>
<div class="main">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form">
				<input type="hidden" name="c" value="site">
				<input type="hidden" name="a" value="entry">
				<input type="hidden" name="do" value="couponconsume">
				<input type="hidden" name="m" value="we7_coupon">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">卡券类型</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<a href="<?php  echo filter_url('type:0')?>" class="btn btn-<?php  if(empty($_GPC['type'])) { ?>primary<?php  } else { ?>default<?php  } ?>">全部</a>
						<a href="<?php  echo filter_url('type:1')?>" class="btn btn-<?php  if($_GPC['type'] == 1) { ?>primary<?php  } else { ?>default<?php  } ?>">折扣券</a>
						<a href="<?php  echo filter_url('type:2')?>" class="btn btn-<?php  if($_GPC['type'] == 2) { ?>primary<?php  } else { ?>default<?php  } ?>">代金券</a>
						<?php  if(COUPON_TYPE == WECHAT_COUPON) { ?>
						<a href="<?php  echo filter_url('type:3')?>" class="btn btn-<?php  if($_GPC['type'] == 3) { ?>primary<?php  } else { ?>default<?php  } ?>">团购券</a>
						<a href="<?php  echo filter_url('type:4')?>" class="btn btn-<?php  if($_GPC['type'] == 4) { ?>primary<?php  } else { ?>default<?php  } ?>">礼品券</a>
						<a href="<?php  echo filter_url('type:5')?>" class="btn btn-<?php  if($_GPC['type'] == 5) { ?>primary<?php  } else { ?>default<?php  } ?>">优惠券</a>
						<?php  } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12 btn-group">
						<a class="btn btn-default <?php  if($_GPC['status'] == '0'||$_GPC['status'] == '') { ?>btn-primary<?php  } ?>" href="<?php  echo filter_url('status:0');?>">不限</a>
						<a class="btn btn-default <?php  if($_GPC['status'] == '1') { ?>btn-primary<?php  } ?>" href="<?php  echo filter_url('status:1');?>">未使用</a>
						<a class="btn btn-default <?php  if($_GPC['status'] == '2') { ?>btn-primary<?php  } ?>" href="<?php  echo filter_url('status:2');?>">已失效</a>
						<a class="btn btn-default <?php  if($_GPC['status'] == '3') { ?>btn-primary<?php  } ?>" href="<?php  echo filter_url('status:3');?>">已核销</a>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">code码</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<input class="form-control" name="code" placeholder="code码" type="text">
					</div>
				</div>
				<?php  if($_GPC['status'] == '3' || ($_GPC['status'] == '' || empty($_GPC['status']))) { ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">核销员</label>
					<div class="col-sm-6 col-md-8 col-lg-8 col-xs-12">
						<select class="form-control" name="clerk_id">
							<option value="">不限</option>
							<?php  if(is_array($clerks)) { foreach($clerks as $clerk) { ?>
							<option value="<?php  echo $clerk['id'];?>" <?php  if($_GPC['clerk_id'] == $clerk['id']) { ?>selected<?php  } ?>><?php  echo $clerk['name'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<?php  } ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">领取人</label>
					<div class="col-sm-7 col-lg-8 col-md-8 col-xs-12">
						<input class="form-control" name="nickname" placeholder="粉丝昵称" type="text" value="<?php  echo $_GPC['nickname'];?>">
					</div>
					<div class="pull-right col-xs-12 col-sm-3 col-lg-2">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="table-responsive panel-body">
			<table class="table table-hover">
				<thead class="navbar-inner">
				<tr>
					<th width="90">标题</th>
					<th width="90">领取方式</th>
					<th width="90">领取人</th>
					<th width="120">code码</th>
					<th width="60">状态</th>
					<th width="120">领取时间</th>
					<?php  if($_GPC['status'] == '3' || ($_GPC['status'] == '' || empty($_GPC['status']))) { ?>
					<th width="120">使用时间</th>
					<th width="80">核销员</th>
					<th width="80">核销门店</th>
					<?php  } ?>
					<th style="width:150px; text-align:center;">操作</th>
				</tr>
				</thead>
				<tbody>
				<?php  if(is_array($list)) { foreach($list as $row) { ?>
				<tr>
					<td><?php  echo $row['title'];?></td>
					<td>
						<?php  if($row['givebyfriend'] == 1) { ?>
						<span class="label label-danger" data-toggle="tooltip" data-placement="top" title="赠送人：">朋友赠送</span>
						<?php  } else if(!empty($row['grantmodule'])) { ?>
						<span class="label label-warning">模块发放</span>
						<?php  } else { ?>
						<span class="label label-success">自己领取</span>
						<?php  } ?>
					</td>
					<td>
						<?php  if($nicknames_info[$row['openid']]['nickname']) { ?>
						<?php  echo $nicknames_info[$row['openid']]['nickname'];?>
						<?php  } else { ?>
						<?php  echo cutstr($row['openid'], 8);?>
						<?php  } ?>
					</td>
					<td><?php  echo $row['code'];?></td>
					<td>
						<?php  if($row['rstatus'] == 1) { ?>
						<span class="label label-success">未使用</span>
						<?php  } else if($row['rstatus'] == 2) { ?>
						<span class="label label-warning">已失效</span>
						<?php  } else if($row['rstatus'] == 3) { ?>
						<span class="label label-danger">已核销</span>
						<?php  } else if($row['rstatus'] == 4) { ?>
						<span class="label label-default">已删除</span>
						<?php  } ?>
					</td>
					<td>
						<?php  echo date('Y-m-d H:i:s', $row['addtime']);?>
					</td>
					<?php  if($_GPC['status'] == '3' || ($_GPC['status'] == '' || empty($_GPC['status']))) { ?>
					<td>
						<?php  if($row['usetime']) { ?>
						<?php  echo date('Y-m-d H:i:s', $row['usetime']);?>
						<?php  } ?>
					</td>
					<td><?php  echo $row['clerk_name'];?></td>
						<td><?php  echo $row['store_name'];?></td>
					<?php  } ?>
					<td style="text-align:center;">
						<?php  if($row['rstatus'] == 1 && $row['starttime'] <= $row['time'] && $row['endtime'] >= $row['time'] ) { ?>
						<a href="javascript:;" onclick="util.ajaxshow('<?php  echo $this->createWebUrl('couponconsume', array('op' => 'consume', 'id' => $row['recid'], 'source' => $row['source']))?>')" class="btn btn-default btn-sm" title="核销优惠券">核销</a>
						<?php  } ?>
						<a href="javascript:;" onclick="util.ajaxshow('<?php  echo $this->createWebUrl('couponconsume', array('op' => 'delete', 'id' => $row['recid'], 'source' => $row['source']))?>')" class="btn btn-default btn-sm" title="删除兑换记录">删除</a>
					</td>
				</tr>
				<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php  echo $pager;?>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>