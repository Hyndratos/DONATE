<?php if (!isset($_GET['a'])) {
    $_GET['a'] = null;
} ?>

<div class="main-menu-box">
    <div class="main-menu-outer-box">
        <ul>
            <a href="admin.php">
                <li class="<?php echo $_GET['a'] == '' ? 'active' : ''; ?>">
                    <div class="nav-icons"><i class="fa fa-pie-chart"></i></div> <?= lang('dashboard'); ?></li>
            </a>

            <a href="#">
                <li data-toggle="collapse"
                    class="manu-collaps collapsed <?php echo $_GET['a'] == 'gen' ? 'active' : ''; ?>"
                    data-target="#main-menu-settings">
                    <div class="nav-icons"><i class="fa fa-cogs"></i></div> <?= lang('general_settings'); ?>
                    <div class="pull-right"><i class="fa fa-angle-right"></i></div>
                </li>
            </a>
            <ul class="sub-menu collapse" id="main-menu-settings">
                <a href="admin.php?a=gen">
                    <li>Menu</li>
                </a>

                <div class="submenu-header">
                    <?= lang('general_settings'); ?>
                </div>

                <?php if (permissions::has("settings")) { ?>
                    <a href="admin.php?a=gen&p=settings">
                        <li><?= lang('settings'); ?></li>
                    </a>
                <?php } ?>

                <?php if (permissions::has("frontpage")) { ?>
                    <a href="admin.php?a=gen&p=frontpage">
                        <li><?= lang('main_page'); ?></li>
                    </a>
                <?php } ?>

                <?php if (getSetting('disable_news', 'value2') == 0 && permissions::has("news")) { ?>
                    <a href="admin.php?a=gen&p=news">
                        <li><?= lang('news'); ?></li>
                    </a>
                <?php } ?>

                <?php if (permissions::has("tos")) { ?>
                    <a href="admin.php?a=gen&p=tos">
                        <li><?= lang('tos'); ?></li>
                    </a>
                <?php } ?>

                <?php if (permissions::has("notifications")) { ?>
                    <a href="admin.php?a=gen&p=messages">
                        <li><?= lang('ingame_notifications'); ?></li>
                    </a>
                <?php } ?>

                <?php if (permissions::has("imprint")) { ?>
                    <a href="admin.php?a=gen&p=imprint">
                        <li><?= lang('imprint', 'Imprint'); ?></li>
                    </a>
                <?php } ?>

                <?php if (permissions::has("privacy")) { ?>
                    <a href="admin.php?a=gen&p=privacy">
                        <li><?= lang('privacy', 'Privacy Policy'); ?></li>
                    </a>
                <?php } ?>

                <?php if (permissions::has("gateways")) { ?>
                    <div class="submenu-header">
                        <?= lang('payment_gateways', 'Payment Gateways'); ?>
                    </div>

                    <a href="admin.php?a=gen&p=paypal">
                        <li>PayPal</li>
                    </a>

                    <a href="admin.php?a=gen&p=credits">
                        <li>Credits</li>
                    </a>

                    <a href="admin.php?a=gen&p=paymentwall">
                        <li>Paymentwall</li>
                    </a>

                    <a href="admin.php?a=gen&p=stripe">
                        <li>Stripe</li>
                    </a>
                <?php } ?>

                <?php if (permissions::has("gateways")) { ?>
                    <div class="submenu-header">
                        <?= lang('integration_settings'); ?>
                    </div>

                    <a href="admin.php?a=gen&p=teamspeak">
                        <li>Teamspeak 3</li>
                    </a>
                <?php } ?>

                <?php if (permissions::has("api")) { ?>
                    <div class="submenu-header">
                        <?= lang('advanced', 'Advanced'); ?>
                    </div>

                    <a href="admin.php?a=gen&p=api">
                        <li><?= lang('api_settings', 'API setttings'); ?></li>
                    </a>
                <?php } ?>
            </ul>

            <a href="#">
                <li data-toggle="collapse"
                    class="manu-collaps collapsed <?php echo $_GET['a'] == 'per' ? 'active' : ''; ?> <?php echo !permissions::has("permissions") ? 'disabled' : ''; ?>"
                    data-target="#main-menu-permissions">
                    <div class="nav-icons"><i class="fa fa-gavel"></i>
                    </div> <?= lang('permission_groups', 'Permission groups'); ?>
                    <div class="pull-right"><i class="fa fa-angle-right"></i></div>
                </li>
            </a>
            <ul class="sub-menu collapse" id="main-menu-permissions">
                <a href="admin.php?a=per&add">
                    <li><?= lang('add'); ?></li>
                </a>
                <a href="admin.php?a=per&edit">
                    <li><?= lang('edit'); ?></li>
                </a>
            </ul>

            <?php if (getSetting('support_tickets', 'value2') == 1) { ?>
                <a href="admin.php?a=sup">
                    <li class="<?php echo $_GET['a'] == 'sup' ? 'active' : ''; ?> <?php echo !permissions::has("support") ? 'disabled' : ''; ?>">
                        <div class="nav-icons"><i class="fa fa-ticket"></i>
                        </div> <?= lang('support_tickets'); ?><?php if (tickets::read(1) != 0) { ?><span
                            class="badge notification pull-right"><?php echo tickets::read(1); ?></span><?php } ?></li>
                </a>
            <?php } ?>

            <a href="#">
                <li data-toggle="collapse"
                    class="manu-collaps collapsed <?php echo $_GET['a'] == 'srv' ? 'active' : ''; ?> <?php echo !permissions::has("servers") ? 'disabled' : ''; ?>"
                    data-target="#main-menu-servers">
                    <div class="nav-icons"><i class="fa fa-server"></i></div> <?= lang('servers'); ?>
                    <div class="pull-right"><i class="fa fa-angle-right"></i></div>
                </li>
            </a>
            <ul class="sub-menu collapse" id="main-menu-servers">
                <a href="admin.php?a=srv&add">
                    <li><?= lang('add'); ?></li>
                </a>
                <a href="admin.php?a=srv&edit">
                    <li><?= lang('edit'); ?></li>
                </a>
            </ul>

            <a href="#">
                <li data-toggle="collapse"
                    class="manu-collaps collapsed <?php echo $_GET['a'] == 'cur' ? 'active' : ''; ?> <?php echo !permissions::has("currencies") ? 'disabled' : ''; ?>"
                    data-target="#main-menu-currencies">
                    <div class="nav-icons"><i class="fa fa-cc"></i></div> <?= lang('currencies'); ?>
                    <div class="pull-right"><i class="fa fa-angle-right"></i></div>
                </li>
            </a>
            <ul class="sub-menu collapse" id="main-menu-currencies">
                <a href="admin.php?a=cur&add">
                    <li><?= lang('add'); ?></li>
                </a>
                <a href="admin.php?a=cur&edit">
                    <li><?= lang('edit'); ?></li>
                </a>
            </ul>

            <a href="#">
                <li data-toggle="collapse"
                    class="manu-collaps collapsed <?php echo $_GET['a'] == 'cat' ? 'active' : ''; ?> <?php echo !permissions::has("categories") ? 'disabled' : ''; ?>"
                    data-target="#main-menu-categories">
                    <div class="nav-icons"><i class="fa fa-bookmark"></i></div> <?= lang('categories'); ?>
                    <div class="pull-right"><i class="fa fa-angle-right"></i></div>
                </li>
            </a>
            <ul class="sub-menu collapse" id="main-menu-categories">
                <a href="admin.php?a=cat&add">
                    <li><?= lang('add'); ?></li>
                </a>
                <a href="admin.php?a=cat&edit">
                    <li><?= lang('edit'); ?></li>
                </a>
            </ul>

            <a href="#">
                <li data-toggle="collapse"
                    class="manu-collaps collapsed <?php echo $_GET['a'] == 'pkg' ? 'active' : ''; ?> <?php echo !permissions::has("packages") ? 'disabled' : ''; ?>"
                    data-target="#main-menu-packages">
                    <div class="nav-icons"><i class="fa fa-cubes"></i></div> <?= lang('packages_and_actions'); ?>
                    <div class="pull-right"><i class="fa fa-angle-right"></i></div>
                </li>
            </a>
            <ul class="sub-menu collapse" id="main-menu-packages">
                <a href="admin.php?a=pkg&add">
                    <li><?= lang('add'); ?></li>
                </a>
                <a href="admin.php?a=pkg&edit">
                    <li><?= lang('edit'); ?></li>
                </a>
            </ul>

            <?php if (gateways::enabled('credits')) { ?>
                <a href="#">
                    <li data-toggle="collapse"
                        class="manu-collaps collapsed <?php echo $_GET['a'] == 'cre' ? 'active' : ''; ?> <?php echo !permissions::has("credit") ? 'disabled' : ''; ?>"
                        data-target="#main-menu-credit">
                        <div class="nav-icons"><i class="fa fa-money"></i></div> <?= lang('credit_packages'); ?>
                        <div class="pull-right"><i class="fa fa-angle-right"></i></div>
                    </li>
                </a>
                <ul class="sub-menu collapse" id="main-menu-credit">
                    <a href="admin.php?a=cre&add">
                        <li><?= lang('add'); ?></li>
                    </a>
                    <a href="admin.php?a=cre&edit">
                        <li><?= lang('edit'); ?></li>
                    </a>
                </ul>
            <?php } ?>

            <?php if (getSetting('enable_raffle', 'value2') == 1) { ?>
                <a href="#">
                    <li data-toggle="collapse"
                        class="manu-collaps collapsed <?php echo $_GET['a'] == 'raf' ? 'active' : ''; ?> <?php echo !permissions::has("raffles") ? 'disabled' : ''; ?>"
                        data-target="#main-menu-raffles">
                        <div class="nav-icons"><i class="fa fa-puzzle-piece"></i></div> <?= lang('raffles'); ?>
                        <div class="pull-right"><i class="fa fa-angle-right"></i></div>
                    </li>
                </a>
                <ul class="sub-menu collapse" id="main-menu-raffles">
                    <a href="admin.php?a=raf&add">
                        <li><?= lang('add'); ?></li>
                    </a>
                    <a href="admin.php?a=raf&edit">
                        <li><?= lang('edit'); ?></li>
                    </a>
                </ul>
            <?php } ?>

            <?php if (getSetting('enable_coupons', 'value2') == 1) { ?>
            <a href="#">
                <li data-toggle="collapse"
                    class="manu-collaps collapsed <?php echo $_GET['a'] == 'cou' ? 'active' : ''; ?> <?php echo !permissions::has("coupons") ? 'disabled' : ''; ?>"
                    data-target="#main-menu-coupons">
                    <div class="nav-icons"><i class="fa fa-calendar-minus-o"></i></div> <?= lang('coupons'); ?>
                    <div class="pull-right"><i class="fa fa-angle-right"></i></div>
                </li>
            </a>
            <ul class="sub-menu collapse" id="main-menu-coupons">
                <a href="admin.php?a=cou&add">
                    <li><?= lang('add'); ?></li>
                </a>
                <a href="admin.php?a=cou&edit">
                    <li><?= lang('edit'); ?></li>
                </a>
            </ul>
            <?php } ?>

            <a href="#">
                <li data-toggle="collapse"
                    class="manu-collaps collapsed <?php echo $_GET['a'] == 'theme' ? 'active' : ''; ?> <?php echo !permissions::has("theme") ? 'disabled' : ''; ?>"
                    data-target="#main-menu-theme">
                    <div class="nav-icons"><i class="fa fa-bars"></i></div> <?= lang('theme_editor'); ?>
                    <div class="pull-right"><i class="fa fa-angle-right"></i></div>
                </li>
            </a>
            <ul class="sub-menu collapse" id="main-menu-theme">
                <a href="admin.php?a=theme&add">
                    <li><?= lang('add'); ?></li>
                </a>
                <a href="admin.php?a=theme&edit">
                    <li><?= lang('edit'); ?></li>
                </a>
            </ul>

            <?php if (getSetting('christmas_advent', 'value2') == 1) { ?>
            <a href="admin.php?a=adv">
                <li class="<?php echo $_GET['a'] == 'adv' ? 'active' : ''; ?>">
                    <div class="nav-icons"><i class="fa fa-tree"></i></div> <?= lang('advent_calendar'); ?></li>
            </a>
            <?php } ?>

            <a href="http://wiki.prometheusipn.com/" target="_blank">
                <li class="">
                    <div class="nav-icons"><i class="fa fa-book"></i></div> <?= lang('wiki', 'Wiki'); ?></li>
            </a>
        </ul>
    </div>
    <div class="version-marker hidden-xs text-center">
        <?php if(getSetting('site_copyright', 'value2') == 1) { ?>
			<font color="#c10000"><a href="http://PrometheusIPN.com">Prometheus</a></font> &copy; IPN <?= lang('by'); ?><br> <a href="http://steamcommunity.com/profiles/76561197988497435/">Marcuz</a> & <a href="http://steamcommunity.com/profiles/76561198043838389/">Newjorciks</a></a><br><br>
		<?php } ?>
        <i class="fa fa-steam"></i> Powered by <a href="http://steampowered.com">Steam</a><br>
        Version <?= $version; ?>
    </div>
</div>