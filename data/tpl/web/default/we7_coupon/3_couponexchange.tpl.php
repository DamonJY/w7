<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($op == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWeburl('couponexchange');?>">管理卡券兑换</a></li>
	<li <?php  if($op == 'post' && !$id) { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWeburl('couponexchange', array('op' => 'post'))?>" id="add-card">添加卡券兑换</a></li>
	<?php  if($op == 'post' && $id) { ?><li class="active"><a href="<?php  echo $this->createWeburl('couponexchange', array('op' => 'post', 'id' => $id))?>">编辑卡券兑换</a></li><?php  } ?>
</ul>
<?php  if($op == 'display') { ?>
<div class="main">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form">
				<input type="hidden" name="c" value="site" />
				<input type="hidden" name="a" value="entry" />
				<input type="hidden" name="do" value="couponexchange" />
				<input type="hidden" name="m" value="we7_coupon" />
				<input type="hidden" name="op" value="display" />
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">卡券名称</label>
					<div class="col-sm-7 col-lg-8 col-xs-12">
						<input class="form-control" name="title" type="text" value="<?php  echo $_GPC['title'];?>">
					</div>
					<div class="pull-right col-lg-2">
						<input type="submit" name="submit" class="btn btn-default" value="搜索">
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>">
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php  if(empty($list)) { ?>
	<div class="alert alert-info">
		您当前没有兑换活动
	</div>
	<?php  } else { ?>
	<div class="panel panel-default">
		<div class="table-responsive panel-body">
			<table class="table table-hover">
				<thead class="navbar-inner">
				<tr>
					<th style="width:150px;">卡券名称</th>
					<th style="width:200px;">兑换条件</th>
					<th style="width:200px;">兑换次数</th>
					<th style="width:200px;">每人限领</th>
					<th style="width:200px;">兑换时间</th>
					<th style="width:150px;">兑换状态</th>
					<th style="width:200px;">操作</th>
				</tr>
				</thead>
				<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['coupon']['title'];?></td>
					<td>
						<?php  if($item['credittype'] == 'credit1') { ?>
						积分兑换
						<?php  } else if($item['credittype'] == 'credit2') { ?>
						余额兑换
						<?php  } ?>
					</td>
					<td><?php  echo $item['num'];?></td>
					<td><?php  echo $item['pretotal'];?></td>
					<td><?php  echo $item['starttime'];?> - <?php  echo $item['endtime'];?></td>
					<td>
						<input class="js-flag" type="checkbox" data-id="<?php  echo $item['id'];?>" <?php  if($item['status']) { ?>checked<?php  } ?>/>
						<script>
							require(['bootstrap.switch'],function($){
								$('.js-flag:checkbox').bootstrapSwitch({onText: '启用', offText: '关闭'});
								$('.js-flag:checkbox').on('switchChange.bootstrapSwitch', function(event, state) {
									var id = $(this).data('id');
									var ban = state ? 1 : 0;
									$.getJSON("<?php  echo $this->createWeburl('couponexchange', array('op' => 'change_status'))?>", {id:id, status:ban}, function(data) {
										var data = eval(data.message);
									});
								});
							});
						</script>
					</td>
					<td>
						<a href="<?php  echo $this->createWeburl('couponexchange', array('id' => $item['id'], 'op' => 'post'))?>">查看详情</a>
						<a href="<?php  echo $this->createWeburl('couponexchange', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('确定删除卡券兑换吗？');return false;">删除</a>
					</td>
				</tr>
				<?php  } } ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php  } ?>
	<?php  echo $pager;?>
</div>
<?php  } else if($op == 'post') { ?>
<form action="<?php  echo $this->createWeburl('couponexchange', array('op' => 'post'))?>" method="post" class="form-horizontal">
	<div class="panel panel-default">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<div class="clearfix">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="text-danger">* </span> 选择卡券</label>
					<div class="col-sm-8 col-xs-12">
						<?php  if(!$id) { ?>
						<button type="button" class="btn btn-default js-add-coupon" id="add_coupon">添加卡券</button>
						<?php  } ?>
						<img src="<?php  echo $data['coupon']['logo_url'];?>" id="coupon_image" style="height: 100px;width: 240px;<?php  if(!$id) { ?>display: none;<?php  } ?>" data-id="<?php  echo $data['coupon']['id'];?>">
						<span class="help-block" id="coupon_title"><?php  echo $data['coupon']['title'];?></span>
						<input type="hidden" name="coupon">
					</div>
					<div class="modal fade js-select-coupon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" style="width: 450px;">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">选择卡券</h4>
								</div>
								<div class="modal-body">
									<?php  if(empty($coupons)) { ?>
									您现在没有卡券，请先<a href="<?php  echo $this->createWeburl('couponmanage')?>">添加卡券</a>。
									<?php  } else { ?>
									<table class="table">
										<thead style="height: 20px;">
										<th style="width: 60px">缩略图</th>
										<th style="width: 120px">卡券名称</th>
										<th style="width: 100px">类型</th>
										<th style="width: 80px">选择</th>
										</thead>
										<tbody>
										<?php  $types = activity_coupon_type_label();?>
										<?php  if(is_array($coupons)) { foreach($coupons as $coupon) { ?>
										<tr style="height: 20px;">
											<?php  if(COUPON_TYPE == WECHAT_COUPON) { ?>
											<td><img src="<?php  echo $coupon['logo_url']?>" style="height: 10px;"></td>
											<td><?php  echo $coupon['title'];?></td>
											<td>
												<?php  echo $types[$coupon['type']]['0'];?>
											</td>
											<?php  } else { ?>
											<td><img src="<?php  echo $coupon['logo_url']?>" style="height: 30px;"></td>
											<td><?php  echo $coupon['title'];?></td>
											<td><?php  if($coupon['type'] == 2) { ?>代金券<?php  } else { ?>折扣券<?php  } ?></td>
											<?php  } ?>
											<td>
												<button type="button" class="btn btn-default coupon_check" data-src="<?php  echo $coupon['logo_url'];?>" data-cid="<?php  echo $coupon['id'];?>" data-title="<?php  echo $coupon['title'];?>" <?php  if($coupon['date_info']['time_type'] == 1) { ?>data-start="<?php  echo $coupon['date_info']['time_limit_start'];?>" data-end="<?php  echo $coupon['date_info']['time_limit_end'];?>"<?php  } ?> data-limit="<?php  echo $coupon['get_limit'];?>" data-type="<?php  echo $coupon['date_info']['time_type'];?>" data-date_limit="<?php  echo $coupon['date_info']['limit'];?>">选择</button>
											</td>
										</tr>
										<?php  } } ?>
										</tbody>
									</table>
									<?php  } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">兑换状态</label>
					<div class="col-sm-9 col-xs-12">
						<?php  if(!$id) { ?>
						<label class="radio-inline"><input id="a" type="radio" name="status" value="1" <?php  if($data['status'] == 1 || $data['status'] == '') { ?>checked<?php  } ?>/>开启</label>
						<label class="radio-inline"><input id="b" type="radio" name="status" value="0" <?php  if($data['status'] == 0 && $data['status'] != '') { ?>checked<?php  } ?>/>关闭</label>
						<span class="help-block">此设置项设置是否开启兑换</span>
						<?php  } else { ?>
						<label class="radio-inline"><?php  if($data['status'] == 1) { ?>开启<?php  } else { ?>关闭<?php  } ?></label>
						<?php  } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">积分类型</label>
					<div class="col-sm-9 col-xs-12">
						<?php  if(!$id) { ?>
						<select name="credittype" class="form-control">
							<option value="credit1">积分</option>
							<option value="credit2">余额</option>
						</select>
						<span class="help-block">此设置项设置当前卡券兑换需要消耗的积分类型,如:金币、积分、贡献等。</span>
						<?php  } else { ?>
						<label class="radio-inline"><?php  if($data['credittype'] == 'credit1') { ?>积分<?php  } else { ?>余额<?php  } ?></label>
						<?php  } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">积分数量</label>
					<div class="col-sm-9 col-xs-12">
						<?php  if(!$id) { ?>
						<input type="text" name="credit" value="<?php  echo $data['credit'];?>" class="form-control"/>
						<span class="help-block">此设置项设置当前卡券兑换需要消耗的积分数量。注：所需积分（余额）必须为正整数；</span>
						<?php  } else { ?>
						<label class="radio-inline"><?php  echo $data['credit'];?></label>
						<?php  } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">使用期限</label>
					<div class="col-sm-9 col-xs-12">
						<?php  if(!$id) { ?>
						<?php  echo tpl_form_field_daterange('date', array('start' => date('Y-m-d', $data['starttime']), 'end' => date('Y-m-d', $data['endtime'])))?>
						<?php  } else { ?>
						<label class="radio-inline"><?php  echo date('Y-m-d', $data['starttime']);?> - <?php  echo date('Y-m-d', $data['endtime']);?></label>
						<?php  } ?>
						<span style="display: none;" class="help-block"><span class="text-danger">注</span>:卡券有效期为<span id="start"></span> - <span id="end"></span></span>
					</div>
				</div>
				<input type="hidden" name="coupon_limit">
				<input type="hidden" name="coupon_start">
				<input type="hidden" name="coupon_end">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="text-danger"> </span>每人可领限制</label>
					<div class="col-sm-9 col-xs-12">
						<?php  if(!$id) { ?>
						<input type="text" name="pretotal" value="<?php  echo $data['pretotal'];?>" class="form-control"/>
						<span class="help-block" style="display: none;"><span class="text-danger">注</span>：卡券每人领券限制为<span id="limit"></span></span>
						<span class="help-block">此设置项设置每个用户可领取此折扣券数量, 默认为1。</span>
						<?php  } else { ?>
						<label class="radio-inline"><?php  echo $data['pretotal'];?></label>
						<?php  } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-1 col-xs-2 col-lg-10">
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>"/>
			<input type="hidden" name="id" value="<?php  echo $_GPC['id'];?>"/>
			<?php  if(!$id) { ?>
			<input type="submit" id="exchange" name="submit" value="提交" class="btn btn-primary"/>
			<?php  } else { ?>
			<a href="<?php  echo $this->createWeburl('couponexchange')?>" class="btn btn-primary">确定</a>
			<?php  } ?>
		</div>
	</div>
</form>
<script>
	require(['bootstrap'], function($) {
		$('#coupon_image').hover(function() {
			var coupon_info = $(this);
			$.post("<?php  echo $this->createWeburl('couponexchange', array('op' => 'coupon_info'))?>", {'id' : $(this).data('id')}, function(data) {
				var data = $.parseJSON(data);
				if (data.message.errno != 0) {
					coupon_info.popover({
						'html' : true,
						'placement' : 'right',
						'trigger':'manual',
						'content':'卡券不存在'
					});
					coupon_info.popover('show');
				} else {
					var data = data.message.message;
					var types = new Array();
					types = ['','折扣券','代金券','团购券','礼品券','优惠券'];
					var display = data.is_display == 1 ? '上架' : '下架';
					var content = '标题：'+ data.title+'<br/>';
					content += '状态：'+display+'<br/>';
					content += '类型：'+types[data.type]+'<br/>';
					if (data.extra_instruction != '') {
						content += '说明：'+data.extra_instruction+'<br/>';
					}
					coupon_info.popover({
						'html' : true,
						'placement' : 'right',
						'trigger':'manual',
						'content':content
					});
					coupon_info.popover('show');
				}
			});
		}, function(){
			$(this).popover('hide');
		});
	});
	$('.js-add-coupon').click(function() {
		$('.js-select-coupon').modal('show');
	})
	$('.coupon_check').click(function() {
		$('#coupon_image').attr('src', $(this).data('src'));
		$('#coupon_title').html($(this).data('title'));
		$('#add_coupon').hide();
		$('[name="coupon"]').val($(this).data('cid'));
		$('#coupon_image').data('id', $(this).data('cid'));
		var type = $(this).data('type');
		if (type  != 2) {
			$('[name="coupon_start"]').val($(this).data('start'));
			$('#start').html($(this).data('start'));
			$('[name="coupon_end"]').val($(this).data('end'));
			$('#end').html($(this).data('end'));
		} else {
			$('#end').html("领取后"+$(this).data('date_limit')+"天");
		}
		$('#start').parent().show();
		$('#end').parent().show();
		$('[name="coupon_limit"]').val($(this).data('limit'));
		$('#limit').html($(this).data('limit'));
		$('#limit').parent().show();
		$('#coupon_image').show();
		$('.js-select-coupon').modal('hide');
	});
	$('#exchange').click(function(){
		var coupon = $('[name="coupon"]').val();
		var pretotal = $('[name="pretotal"]').val();
		var total = $('[name="total"]').val();
		var limit = $('[name="coupon_limit"]').val();
		var credit = $('[name="credit"]').val();
		if (credit != parseInt(credit) && credit != '') {
			util.message('所需积分数量请填写正整数');
			return false;
		}
		limit = parseInt(limit);
		pretotal = parseInt(pretotal);
		if (pretotal > limit && limit != 0) {
			util.message('领取限制大于卡券领取限制，请重新填写');
			return false;
		}
		if (coupon == '') {
			util.message('请选择折扣券', '', 'info');
			return false;
		}
	});
</script>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>