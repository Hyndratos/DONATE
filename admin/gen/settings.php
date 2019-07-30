<?php

if (!permissions::has("settings")) {
    die(lang('no_perm'));
}

if (isset($_POST['settings_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");

    // Get values
    $site_title = strip_tags($_POST['settings_title']);
    $site_banner = strip_tags($_POST['site_banner']);
    $site_logo = strip_tags($_POST['site_logo']);
    $theme = strip_tags($_POST['theme']);

    $main_cc = $_POST['main_cc'];
    $featured_package = $_POST['featured_package'];

    if (isset($_POST['tracking'])) {
        $tracking = 1;

        if (getSetting('tracking_optout', 'value2') == 0) {
            prometheus::sitrep_opt(1);
        }
    } else {
        $tracking = 0;

        if (getSetting('tracking_optout', 'value2') == 1) {
            prometheus::sitrep_opt(0);
        }
    }

    if (isset($_POST['enable_raffle'])) {
        setSetting(1, 'enable_raffle', 'value2');
    } else {
        setSetting(0, 'enable_raffle', 'value2');
    }

    if (isset($_POST['maintenance'])) {
        $maintenance = 1;
    } else {
        $maintenance = 0;
    }

    if (isset($_POST['warning_sandbox'])) {
        $warning_sandbox = 1;
    } else {
        $warning_sandbox = 0;
    }

    if (isset($_POST['warning_missingactions'])) {
        $warning_missingactions = 1;
    } else {
        $warning_missingactions = 0;
    }

    if (isset($_POST['settings_support'])) {
        $support_tickets = 1;
    } else {
        $support_tickets = 0;
    }

    if (isset($_POST['settings_copyright'])) {
        $site_copyright = 1;
    } else {
        $site_copyright = 0;
    }

    if (isset($_POST['enable_globalPackages'])) {
        $enable_globalPackages = 1;
    } else {
        $enable_globalPackages = 0;
    }

    if (isset($_POST['enable_goal'])) {
        $enable_goal = 1;
        $enable_goal_date = $_POST['enable_goal_date'];
        $monthly_goal = $_POST['monthly_goal'];
    } else {
        $enable_goal = 0;
        $enable_goal_date = getSetting('enable_goal', 'value');
        $monthly_goal = 0;
    }

    if (isset($_POST['show_recent'])) {
        $show_recent = 1;
        $show_recent_num = $_POST['show_recent_num'];
    } else {
        $show_recent = 0;
        $show_recent_num = getSetting('show_recent', 'value');
    }

    if (isset($_POST['show_top'])) {
        $show_top = 1;
        $show_top_num = $_POST['show_top_num'];
    } else {
        $show_top = 0;
        $show_top_num = getSetting('show_top', 'value');
    }

    if (isset($_POST['disable_news'])) {
        $disable_news = 1;
    } else {
        $disable_news = 0;
    }

    if (isset($_POST['disable_sorting'])) {
        $disable_sorting = 1;
    } else {
        $disable_sorting = 0;
    }

    if (isset($_POST['disable_customjob'])) {
        $disable_customjob = 1;
    } else {
        $disable_customjob = 0;
    }

    if (isset($_POST['buy_others'])) {
        $buy_others = 0;
    } else {
        $buy_others = 1;
    }

    if (isset($_POST['profile_nostats'])) {
        $profile_nostats = 1;
    } else {
        $profile_nostats = 0;
    }

    if (isset($_POST['profile_nononperm'])) {
        $profile_nononperm = 1;
    } else {
        $profile_nononperm = 0;
    }

    if (isset($_POST['profile_noperm'])) {
        $profile_noperm = 1;
    } else {
        $profile_noperm = 0;
    }

    if (isset($_POST['christmas_things'])) {
        $christmas_things = 1;
    } else {
        $christmas_things = 0;
    }

    if (isset($_POST['christmas_advent'])) {
        $christmas_advent = 1;
    } else {
        $christmas_advent = 0;
    }

    if (isset($_POST['halloween_things'])) {
        $halloween_things = 1;
    } else {
        $halloween_things = 0;
    }

    if (isset($_POST['enable_coupons'])) {
        $enable_coupons = 1;
    } else {
        $enable_coupons = 0;
    }  

    if (isset($_POST['disable_tos'])) {
        $disable_tos = 1;
    } else {
        $disable_tos = 0;
    }

    if (isset($_POST['disable_theme_selector'])) {
        $disable_theme_selector = 1;
    } else {
        $disable_theme_selector = 0;
    }

    if (isset($_POST['disable_language_selector'])) {
        $disable_language_selector = 1;
    } else {
        $disable_language_selector = 0;
    }

    $package_display = $_POST['package_display'];

    // Set the values
    setSetting($package_display, 'store_packageDisplay', 'value2');

    setSetting($site_title, 'site_title', 'value');
    setSetting($site_banner, 'site_banner', 'value');
    setSetting($site_logo, 'site_logo', 'value');
    setSetting($theme, 'theme', 'value');
    setSetting($disable_theme_selector, 'disable_theme_selector', 'value2');
    setSetting($disable_language_selector, 'disable_language_selector', 'value2');

    setSetting($site_copyright, 'site_copyright', 'value2');
    setSetting($support_tickets, 'support_tickets', 'value2');
    setSetting($main_cc, 'dashboard_main_cc', 'value2');
    setSetting($featured_package, 'featured_package', 'value2');
    setSetting($tracking, 'tracking_optout', 'value2');
    setSetting($warning_sandbox, 'warning_sandbox', 'value2');
    setSetting($warning_missingactions, 'warning_missingactions', 'value2');
    setSetting($maintenance, 'maintenance', 'value2');
    setSetting($enable_globalPackages, 'enable_globalPackages', 'value2');
    setSetting($disable_news, 'disable_news', 'value2');
    setSetting($disable_sorting, 'disable_sorting', 'value2');
    setSetting($disable_customjob, 'disable_customjob', 'value2');
    setSetting($enable_coupons, 'enable_coupons', 'value2');
    setSetting($disable_tos, 'disable_tos', 'value2');

    setSetting($buy_others, 'buy_others', 'value2');

    setSetting($enable_goal, 'enable_goal', 'value2');
    setSetting($enable_goal_date, 'enable_goal', 'value');
    setSetting($monthly_goal, 'monthly_goal', 'value2');


    setSetting($show_recent, 'show_recent', 'value2');
    setSetting($show_top, 'show_top', 'value2');
    setSetting($show_top_num, 'show_top', 'value');
    setSetting($show_recent_num, 'show_recent', 'value');

    setSetting($profile_nostats, 'profile_nostats', 'value2');
    setSetting($profile_nononperm, 'profile_nononperm', 'value2');
    setSetting($profile_noperm, 'profile_noperm', 'value2');
    
    setSetting($christmas_things, 'christmas_things', 'value2');
    setSetting($christmas_advent, 'christmas_advent', 'value2');

    setSetting($halloween_things, 'halloween_things', 'value2');

    $message->Add('success', 'Successfully updated settings!');
    cache::clear('settings');
    cache::del('topDonators');

    prometheus::log('Modified the general settings', $_SESSION['uid']);
}

?>

<script type="text/javascript">
    $(function () {
        $(".form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: document.location.href,
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var msg = $(data).find('.bs-callout');

                    $("#message-location").html(msg);
                    $("html, body").animate({scrollTop: 0}, "slow");
                }
            });
        }));
    });
</script>

<form method="POST" style="width: 100%;" class="form-horizontal form" role="form">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <h2>Settings</h2>

			<span id="message-location">
				<?php $message->Display(); ?>
			</span>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <h6>General settings</h6>
        </div>
    </div>

    <div class="darker-box">
        <div class="form-group">
            <label class="col-sm-2 control-label">Site Title</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="settings_title" placeholder="Site Title"
                       value="<?= getSetting('site_title', 'value'); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Banner URL</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="site_banner" placeholder="Banner URL"
                       value="<?= getSetting('site_banner', 'value'); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Logo URL</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="site_logo" placeholder="Logo URL"
                       value="<?= getSetting('site_logo', 'value'); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Default theme</label>

            <div class="col-sm-9">
                <p>
                    A theme a user has selected will override this value unless you disable theme selection below.
                </p>

                <select name="theme" class="selectpicker" data-style="btn-prom" data-live-search="true">
                    <?php
                        echo theme::options(true, true);
                    ?>
                </select>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                        title="If there are none here, you can create one using the theme editor">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="disable_theme_selector" <?php echo getSetting('disable_theme_selector', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Disable Theme Selector</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to disable client side theme selection?">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="disable_language_selector" <?php echo getSetting('disable_language_selector', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Disable Language Selector</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to disable client side language selection?">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Main Currency</label>

            <div class="col-sm-9">
                <select name="main_cc" class="selectpicker" data-style="btn-prom">
                    <?= options::getCurrencies(getSetting('dashboard_main_cc', 'value2'), ''); ?>
                </select>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                        title="This is the currency the panel converts all the other currencies to for an overall display in the Admin Dashboard.">
                    ?
                </button>
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-top: 13px;">
        <div class="col-sm-offset-2 col-sm-10">
            <h6>Store settings</h6>
        </div>
    </div>

    <div class="darker-box">
        <div class="form-group">
            <label class="col-sm-2 control-label">Featured pkg</label>

            <div class="col-sm-9">
                <select name="featured_package" class="selectpicker" data-style="btn-prom" data-live-search="true">
                    <option value="0">None</option>
                    <?= options::getPackages('', 'featured'); ?>
                </select>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                        title="Select a package here if you want to feature one in the 'Store' page!">?
                </button>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Package display</label>

            <div class="col-sm-9">
                <select name="package_display" class="selectpicker" data-style="btn-prom">
                    <?php
                    if (getSetting('store_packageDisplay', 'value2') == 0) {
                        echo '
    							<option value="0">Wide (1 Across)</option>
    							<option value="1">Medium (2 Across)</option>
    							<option value="2">Small (3 Across)</option>
    						';
                    } elseif (getSetting('store_packageDisplay', 'value2') == 1) {
                        echo '
    							<option value="1">Medium (2 Across)</option>
    							<option value="2">Small (3 Across)</option>
    							<option value="0">Wide (1 Across)</option>
    						';
                    } elseif (getSetting('store_packageDisplay', 'value2') == 2) {
                        echo '
    							<option value="2">Small (3 Across)</option>
    							<option value="1">Medium (2 Across)</option>
    							<option value="0">Wide (1 Across)</option>
    						';
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                        title="You can select how to display your packages on the store page. Either wide(one big across), or small(3 across).">
                    ?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="enable_coupons" <?php echo getSetting('enable_coupons', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Enable coupons</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to enable coupon codes?">?
                </button>
            </div>
        </div>  
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="disable_tos" <?php echo getSetting('disable_tos', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Disable Terms of Service</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to disable the accepting of ToS">?
                </button>
            </div>
        </div>      
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="buy_others" <?php echo getSetting('buy_others', 'value2') == 0 ? 'checked' : ''; ?>>
                    <label>Disable buying for others</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to disable the ability to purchase packages for other?">?
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="disable_sorting" <?php echo getSetting('disable_sorting', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Disable sorting options</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="Do you want to disable the sorting options for raffles/packages/credits?">?
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox" id="disable_customjob"
                           name="disable_customjob" <?php echo getSetting('disable_customjob', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Disable custom job auto giving</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to disable automatic giving of custom jobs?">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="settings_support" <?php echo getSetting('support_tickets', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Enable support tickets</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="If you don't want your users submitting support tickets you can disable them here.">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox" id="enable_raffle"
                           name="enable_raffle" <?php echo getSetting('enable_raffle', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Enable Raffle</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to enable the raffle system?">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox" id="enable_globalPackages"
                           name="enable_globalPackages" <?php echo getSetting('enable_globalPackages', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Enable Global Packages</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to enable the global packages tab in the 'Store' area?">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="maintenance" <?php echo getSetting('maintenance', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Maintenance mode</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="With maintenance mode no users are able to use the store apart from admins of the system.">?
                </button>
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-top: 15px;">
        <div class="col-sm-offset-2 col-sm-10">
            <h6>Main page settings</h6>
        </div>
    </div>

    <div class="darker-box">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="disable_news" <?php echo getSetting('disable_news', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Disable news</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="Do you want to disable the news section on the main page? This makes the main page's content wider">
                    ?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox" name="show_top"
                           id="show_top" <?php echo getSetting('show_top', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Display top donators</label>
                </div>

                <script type="text/javascript">
                    $("#show_top").on("ifChanged", function () {
                        var done = ($(this).is(':checked')) ? true : false;
                        if (done) {
                            $('#show_top_num').show();
                        } else {
                            $('#show_top_num').hide();
                        }
                    });
                </script>

                <div id="show_top_num" style="<?php echo getSetting('show_top', 'value2') == 1 ? '' : 'display: none;'; ?>">
                    <input type="text" name="show_top_num" class="form-control" style="margin-top: 5px"
                           placeholder="Amount of top donators shown (Number)"
                           value="<?= getSetting('show_top', 'value'); ?>">
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to display the top 3 donators on the main page?">?
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox" name="show_recent"
                           id="show_recent" <?php echo getSetting('show_recent', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Display recent donators</label>
                </div>

                <script type="text/javascript">
                    $("#show_recent").on("ifChanged", function () {
                        var done = ($(this).is(':checked')) ? true : false;
                        if (done) {
                            $('#show_recent_num').show();
                        } else {
                            $('#show_recent_num').hide();
                        }
                    });
                </script>

                <div id="show_recent_num"
                     style="<?php echo getSetting('show_recent', 'value2') == 1 ? '' : 'display: none;'; ?>">
                    <input type="text" name="show_recent_num" class="form-control" style="margin-top: 5px"
                           placeholder="Amount of recent donators shown (Number)"
                           value="<?= getSetting('show_recent', 'value'); ?>">
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="Do you want to display the last 10 recent donators on the main page?">?
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox" name="enable_goal"
                           id="enable_goal" <?php echo getSetting('enable_goal', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Enable monthly goal</label>
                </div>

                <script type="text/javascript">
                    $("#enable_goal").on("ifChanged", function () {
                        var done = ($(this).is(':checked')) ? true : false;
                        if (done) {
                            $('#enable_goal_date').show();
                        } else {
                            $('#enable_goal_date').hide();
                        }
                    });
                </script>

                <div id="enable_goal_date"
                     style="<?php echo getSetting('enable_goal', 'value2') == 1 ? '' : 'display: none;'; ?>">
                    <input type="text" style="margin-top: 5px;" class="form-control" name="monthly_goal"
                           placeholder="Monthly goal" value="<?= getSetting('monthly_goal', 'value2'); ?>">
                    <input type="text" name="enable_goal_date" class="form-control" style="margin-top: 5px"
                           placeholder="Day of month to reset goal (Number)"
                           value="<?= getSetting('enable_goal', 'value'); ?>">
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to display a monthly goal on the main page?">?
                </button>
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-top: 15px;">
        <div class="col-sm-offset-2 col-sm-10">
            <h6>User profile settings</h6>
        </div>
    </div>

    <div class="darker-box">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="profile_nostats" <?php echo getSetting('profile_nostats', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Don't show statistics on users profiles</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to disable showing of statistics on a users profile?">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="profile_nononperm" <?php echo getSetting('profile_nononperm', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Don't show non-permanent packages on users profiles</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="Do you want to disable showing of non permanent packages on a users profile?">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="profile_noperm" <?php echo getSetting('profile_noperm', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Don't show permanent packages on users profiles</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="Do you want to disable showing of permanent packages on a users profile?">?
                </button>
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-top: 15px;">
        <div class="col-sm-offset-2 col-sm-10">
            <h6>Other settings</h6>
        </div>
    </div>

    <div class="darker-box">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="settings_copyright" <?php echo getSetting('site_copyright', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Show copyright</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Do you want to disable the copyright in the footer?">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="tracking" <?php echo getSetting('tracking_optout', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Opt out of stats tracking</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="Do you want to opt out of the stats tracking, aka stop sending statistics to prometheusipn.com?">
                    ?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox" name="clear_cache">
                    <label>Clear cache</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="If you tick this and hit submit you clear all the site cache. Useful if you've made edits in the database">
                    ?
                </button>
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-top: 15px;">
        <div class="col-sm-offset-2 col-sm-10">
            <h6>Seasonal settings</h6>
        </div>
    </div>

    <div class="darker-box">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="christmas_things" <?php echo getSetting('christmas_things', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Enable christmas things</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Enables snow on the user pages">?
                </button>
            </div>
        </div> 

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="christmas_advent" <?php echo getSetting('christmas_advent', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Enable advent calendar</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Enables a christmas advent calendar. Fully configurable in the advent calendar area.">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="halloween_things" <?php echo getSetting('halloween_things', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Enable halloween things</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom" title="Enables bats flying around on the user pages">?
                </button>
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-top: 15px;">
        <div class="col-sm-offset-2 col-sm-10">
            <h6>Warning settings</h6>
        </div>
    </div>

    <div class="darker-box">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <input type="checkbox"
                           name="warning_sandbox" <?php echo getSetting('warning_sandbox', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Disable sandbox warning</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <input type="checkbox"
                           name="warning_missingactions" <?php echo getSetting('warning_missingactions', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Disable missing actions warning</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="hidden" name="settings_submit" value="true">
            <input type="submit" name="settings_submit" value="<?= lang('submit'); ?>" class="btn btn-prom"
                   style="margin-top: 5px;">
        </div>
    </div>
</form>