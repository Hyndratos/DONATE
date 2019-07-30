<?php

	if(!isset($devmode)){
		$devmode = false;
	}
	
	if($devmode){
		error_reporting(E_ALL);
		$time = microtime(true);
	} else {
		error_reporting(E_ALL);
	}
	
?>

<!DOCTYPE html>
<html lang="en" dir="<?= $dir; ?>">
	<head>
		<!-- Include required CSS and scripts -->
		<meta charset="utf-8">
		<title><?= getSetting('site_title', 'value'); ?> - <?= $page_title; ?></title>
		<meta http-equiv="content-type" value="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet" type="text/css" />
		<link rel="icon" href="favicon.ico" type="image/x-icon"/>

		<link rel="stylesheet" type="text/css" href="compiled/css/site.css">

		<?php 

			if(isset($_GET['a']) && $_GET['a'] == 'theme'){
				if(isset($_GET['default'])){
					setSetting('', 'theme', 'value');
				}
			}

			$theme = theme::current();
            if(isset($_COOKIE['prometheus_theme']) && getSetting('disable_theme_selector', 'value2') == 0){
                $theme = $_COOKIE['prometheus_theme'];
            }

			if($theme != ''){
				echo '<link rel="stylesheet" type="text/css" href="themes/'.$theme.'/style.css">';
			}

		?>

		<script src="compiled/js/essential.js?v=1.0.1"></script>
		<script type="text/javascript">
			<?php if($page != 'admin' && getSetting('christmas_things', 'value2') == 1){ ?>
				setTimeout(function(){
					snowStorm.start();
				}, 500);	
			<?php } ?>
		</script>	
	</head>

	<body>
	<?php if($page != 'admin'){ ?>
		<?php if(getSetting('paypal_sandbox', 'value2') == 1 && getSetting('warning_sandbox', 'value2') == 0 && prometheus::isAdmin() && gateways::enabled('paypal')) { ?>
			<div class="notSetup">
				<div class="container">
					<?= lang('header_sandbox'); ?>
				</div>
			</div>
		<?php } ?>

		<?php if(actions::missing() && getSetting('warning_missingactions', 'value2') == 0  && prometheus::isAdmin()) { ?>
			<div class="notSetup">
				<div class="container">
					<?= lang('missing_action'); ?>
				</div>
			</div>
		<?php } ?>

		<?php if(new datetime(getSetting('sale_enddate', 'value')) > new datetime()) { ?>
		<div class="sale-box">
			<div class="container">
				<div class="row">
					<div class="col-xs-10">
						<?= getSetting('sale_message', 'value'); ?>
					</div>
					<div class="col-xs-2" style="text-align: right;">
						<div id="countdown"></div>
					</div>
				</div>
			</div>
		</div>
		<script>
			var target_date = new Date("<?= getSetting('sale_enddate', 'value'); ?>").getTime();
			var days, hours, minutes, seconds;

			var countdown = document.getElementById("countdown");

			setInterval(function () {
				var current_date = new Date().getTime();
				var seconds_left = (target_date - current_date) / 1000;

				days = parseInt(seconds_left / 86400);
				seconds_left = seconds_left % 86400;

				hours = parseInt(seconds_left / 3600);
				seconds_left = seconds_left % 3600;

				minutes = parseInt(seconds_left / 60);
				seconds = parseInt(seconds_left % 60);

				if (hours < 10)
				{
					hours = '0' + hours;
				}

				if (days < 10)
				{
					days = '0' + days;
				}

				if (minutes < 10)
				{
					minutes = '0' + minutes;
				}

				if (seconds < 10)
				{
					seconds = '0' + seconds;
				}

				if(current_date < target_date)
				{
					countdown.innerHTML = "<i class='fa fa-clock-o'></i> " + days + ":" + hours + ":"
					+ minutes + ":" + seconds + "";
				}

			}, 1000);
		</script>
		<?php } ?>
	<?php } ?>
	<div class="wrap">
		<?php if($page != 'admin' && getSetting('site_banner', 'value') != ''){ ?>
		<div class="banner">
			<div class="container">
				<?php if(getSetting('site_banner', 'value') != ''){ ?>
					<img src="<?= getSetting('site_banner', 'value'); ?>"/>
				<?php } ?>

				<?php if(gateways::enabled('credits')){ ?>
					<?php if(prometheus::loggedin()) { ?>
						<div class="credits" style="float: right;">
							<?php echo credits::get($_SESSION['uid']); ?> CR
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
		<?php } ?>

		<nav class="navbar navbar-inverse <?= $page == 'admin' ? 'navbar-fixed-top' : ''; ?>" role="navigation">
			<?= $page == 'admin' ? '' : '<div class="container">'; ?>
			  <div class="container-fluid">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>

				  <?php if($page == 'admin') { ?>
					  <div class="toggle-menu visible-xs-inline-block">
					     <i class="fa fa-bars"></i>
					  </div>
				  <?php } ?>

				  <?php if(getSetting('site_logo', 'value') != ''){ ?>
				 	<a class="navbar-brand" href="."><img src="<?= getSetting('site_logo', 'value'); ?>" width="64px" height="64px"/></a>
				  <?php } ?>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav">
					<li class="<?php echo $page == 'home' ? 'active' : ''; ?>"><a href="."><i class="fa fa-home"></i> <?= lang('home'); ?></a></li>
					<?php if(getSetting('installed', 'value2') == 1){ ?>
						<li class="dropdown 
						<?php echo $page == 'store' ? 'active' : ''; ?>
						<?php echo $page == 'credits' ? 'active' : ''; ?>
						<?php echo $page == 'raffle' ? 'active' : ''; ?>
						">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?= lang('store'); ?> <i class="fa fa-caret-down"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li class="<?php echo $page == 'store' ? 'active' : ''; ?>"><a href="store.php?page=server"><i class="fa fa-shopping-cart"></i> <?= lang('store'); ?></a></li>
								<?php if (gateways::enabled('credits')) { ?>
									<li class="<?php echo $page == 'credits' ? 'active' : ''; ?>"><a href="store.php?page=credits"><i class="fa fa-money"></i> <?= lang('buy_credits'); ?></a></li>
								<?php } ?>

								<?php if (getSetting('enable_raffle', 'value2') == 1) { ?>
									<li class="<?php echo $page == 'raffle' ? 'active' : ''; ?>"><a href="store.php?page=raffle"><i class="fa fa-ticket"></i> <?= lang('raffles'); ?></a></li>
								<?php } ?>
							</ul>
						</li>

						<?php if (prometheus::loggedin() && getSetting('christmas_advent', 'value2') == 1) { ?>
							<li class="<?php echo $page == 'advent' ? 'active' : ''; ?>"><a href="store.php?page=advent"><i class="fa fa-tree"></i> <?= lang('advent'); ?></a></li>
						<?php } ?>

						<?php if (prometheus::loggedin()) { ?>
							<li class="<?php echo $page == 'profile' ? 'active' : ''; ?>"><a href="profile.php"><i class="fa fa-user"></i> <?= lang('profile'); ?></a></li>
						<?php } ?>
					 </ul>
					  <ul class="nav navbar-nav navbar-right">
						<?php if(prometheus::loggedin()) { ?>
							<?php if(getSetting('support_tickets', 'value2') == 1){ ?>
								<li class="<?php echo $page == 'support' ? 'active' : ''; ?>"><?php if(tickets::read(0) != 0){ ?><div class="notify-icon"><?= tickets::read(0); ?></div><?php } ?><a href="support.php"><i class="fa fa-question-circle"></i> <?= lang('support'); ?></a></li>
							<?php } ?>
							<?php if(prometheus::isAdmin()){ ?>
								<li class="<?php echo $page == 'admin' ? 'active' : ''; ?>"><?php if(tickets::read(1) != 0){ ?><div class="notify-icon"><?= tickets::read(1); ?></div><?php } ?><a href="admin.php"><i class="fa fa-cog"></i> <?= lang('admin'); ?></a></li>
							<?php } ?>
							<li class=""><a href="logout.php"><i class="fa fa-sign-out"></i> <?= lang('sign_out'); ?></a></li>
						<?php } ?>
						<?php if(!prometheus::loggedin()) { ?>
							<?php echo '<li><a href="'.SteamSignIn::genUrl().'"><i class="fa fa-sign-in"></i> ' . lang("sign_in") . '</a></li>'; ?>
						<?php } ?>
					  </ul>
				  <?php } ?>
				</div>
			  </div>
			<?= $page == 'admin' ? '' : '</div>'; ?>
		</nav>
