<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>OA-PHP管理系统</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="/Public/static/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/Public/static/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="/Public/static/css/ace-fonts.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="/Public/static/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="/Public/static/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="/Public/static/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="/Public/static/css/ace-ie.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="/Public/static/css/datepicker.css" />

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="/Public/static/js/html5shiv.js"></script>
		<script src="/Public/static/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout blur-login">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="ace-icon fa fa-leaf green"></i>
									<span class="red">CBD</span>
									<span class="white" id="id-text2">办公信息系统</span>
								</h1>
								<h4 class="light-blue" id="id-company-text">&copy; 办公信息系统</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												请输入您的登录信息
											</h4>

											<div class="space-6"></div>

											<form method="post" action="<?php echo U('Index/login');?>">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="用户名" name="username"/>
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="密码" name="password"/>
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">

														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">登录</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#signup-box" class="user-signup-link center">
													注册
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
											</div>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												新用户注册
											</h4>

											<div class="space-6"></div>
											<p> 请输入您的个人信息: </p>

											<form method="post" action="<?php echo U('Index/register');?>">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="用户名" name="username" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="登录密码" name="password1"/>
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="重复登录密码" name="password2"/>
															<i class="ace-icon fa fa-retweet"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="姓" name="first_name"/>
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="名" name="last_name"/>
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<select class="form-control" name="gender">
															<option value="0">性别</option>
															<option value="M">男</option>
															<option value="F">女</option>	
														</select>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<select class="form-control" name="department_id">
															<option value="0">所在处室</option>
															<?php if(is_array($departments)): foreach($departments as $key=>$depart): ?><option value="<?php echo ($depart["id"]); ?>"><?php echo ($depart["name"]); ?></option><?php endforeach; endif; ?>	
														</select>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<select class="form-control" name="department_id">
															<option value="0">职务</option>
															<?php if(is_array($duties)): foreach($duties as $key=>$duty): ?><option value="<?php echo ($duty["id"]); ?>"><?php echo ($duty["name"]); ?></option><?php endforeach; endif; ?>	
														</select>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<select class="form-control" name="level_id" data-placeholder="级别">
															<option value="0">级别</option>
															<?php if(is_array($levels)): foreach($levels as $key=>$level): ?><option value="<?php echo ($level["id"]); ?>"><?php echo ($level["name"]); ?></option><?php endforeach; endif; ?>	
														</select>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" name="birthday" placeholder="出生日期"/>
															<i class="ace-icon fa fa-birthday-cake"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" name="begin_work_date" placeholder="参加工作时间"/>
																	
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" name="enter_date" placeholder="进入本单位时间"/>
															<i class="ace-icon fa fa-birthday-cake"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="电子邮箱" name="email"/>
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">清除</span>
														</button>

														<button type="submit" class="width-65 pull-right btn btn-sm btn-success">
															<span class="bigger-110">注册</span>

															<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												返回登录
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
							</div><!-- /.position-relative -->

						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->
		

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='/Public/static/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='/Public/static/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='/Public/static/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="/Public/static/js/jquery.validate.min.js"></script>
		<script src="/Public/static/js/messages_zh.min.js"></script>
		<script src="/Public/static/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="/Public/static/js/date-time/locales/bootstrap-datepicker.zh-CN.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });

			 $('.date-picker').datepicker({
			 	autoclose: true,
			 	todayHighlight: true,
			 	language:'zh-CN',
			 	weekStart: 0,
			 	todayBtn: "linked"
			 });
			 //show datepicker when clicking on the icon
			 

			});
		</script>
	</body>
</html>