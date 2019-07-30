<?php
SESSION_START();

ob_start();

$page = 'install';
$page_title = 'Installation';
require_once('inc/classes/steamLogin.class.php');

include('inc/functions.php');
require_once('inc/classes/FlashMessages.class.php');
cache::clear();

if (getSetting('installed', 'value2') == 1) {
    die('System already installed, please remove this file!');
}

$message = new FlashMessages();

$page_url = getUrl();

setcookie('uid', '', 0, "/");
setcookie('token', '', 0, "/");
unset($_COOKIE["uid"]);
unset($_COOKIE["token"]);

SESSION_DESTROY();

if (file_exists('validation.php')) {
    die('This system is already installed! (install.php is not in the root directory)');
}

$URL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$URL = str_replace('install.php', '', $URL);

$res = $db->getAll("SELECT * FROM settings");
if ($res == NULL) {
    include('install/sql.php');
}

if (isset($_POST['install_submit'])) {
    include('install/validation.php');
}

ob_end_clean();
?>

<?php include('inc/header.php'); ?>

<?php if (getSetting('installed', 'value2') == 0) { ?>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="header">
                        Prometheus - Installation
                    </div>
                    <br>

                    <div class="bs-callout bs-callout-info">Your License key (API key) is found at PrometheusIPN.com!
                    </div>
                    <br>

                    <form method="POST" style="width: 75%;" class="form-horizontal" role="form">
                        <?php $message->display(); ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">License key</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="install_key"
                                       placeholder="Your license key" value="<?php if (isset($_POST['install_key'])) {
                                    echo $_POST['install_key'];
                                } ?>">
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                        title="Go to http://prometheusIPN.com/ and click 'Sign In'. After signing in you will see an 'API Key' setting.">
                                    ?
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Site Title</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="install_title" placeholder="Site Title"
                                       value="<?php if (isset($_POST['install_title'])) {
                                           echo $_POST['install_title'];
                                       } ?>">
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                        title="Your site title. Eg: The name of your community.">?
                                </button>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
                                <h2>Payment gateways</h2>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <input type="checkbox" id="paypal_tick" name="enable_paypal">
                                    <label>PayPal</label>
                                </div>
                            </div>
                        </div>
                        <div id="paypal" style="display: none;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Paypal Email</label>

                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="install_email"
                                           placeholder="Paypal Email" value="<?php if (isset($_POST['install_email'])) {
                                        echo $_POST['install_email'];
                                    } ?>">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                            title="Your Paypal Email. You must have at least a premier or business account!">
                                        ?
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">IPN URL</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="install_ipn" placeholder="IPN URL"
                                           value="<?= $URL . 'ipn.php'; ?>">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                            title="Goes to yoursite.com/donate/ipn.php. This should be filled in automatically.">
                                        ?
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Return URL</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="install_return"
                                           placeholder="Return URL" value="<?= $URL . 'profile.php'; ?>">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                            title="Goes to yoursite.com/donate/profile.php. This should be filled in automatically.">
                                        ?
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Cancel URL</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="install_cancel"
                                           placeholder="Cancel URL" value="<?= $URL . 'index.php'; ?>">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                            title="Goes to yoursite.com/donate/index.php. This should be filled in automatically.">
                                        ?
                                    </button>
                                </div>
                            </div>
                        </div>
                        <script>
                            $("#paypal_tick").on("ifChanged", function () {
                                var done = ($(this).is(':checked')) ? true : false;
                                if (done) {
                                    $('#paypal').show();
                                } else {
                                    $('#paypal').hide();
                                }
                            });
                        </script>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <input type="checkbox" id="credits_tick" name="enable_credits">
                                    <label>Credits</label>
                                </div>
                            </div>
                        </div>
                        <div id="credits" style="display: none;">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-9">
                                    <div class="checkbox">
                                        <input type="checkbox" name="credits_only">
                                        <label>Only use credits as payment for packages / raffles</label>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" style="margin-top: 7px;"
                                            data-toggle="tooltip" data-placement="bottom"
                                            title="Check this if you only want to allow credits as currency for packages / raffles">
                                        ?
                                    </button>
                                </div>
                            </div>
                        </div>
                        <script>
                            $("#credits_tick").on("ifChanged", function () {
                                var done = ($(this).is(':checked')) ? true : false;
                                if (done) {
                                    $('#credits').show();
                                } else {
                                    $('#credits').hide();
                                }
                            });
                        </script>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <input type="checkbox" id="paymentwall_tick" name="enable_paymentwall">
                                    <label>PaymentWall</label>
                                </div>
                            </div>
                        </div>
                        <div id="paymentwall" style="display: none;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Project Key</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="paymentwall_project"
                                           placeholder="Paymentwall Project Key">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                            title="This is your Paymentwall project key found in your paymentwall project area">
                                        ?
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Secret Key</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="paymentwall_secret"
                                           placeholder="Paymentwall Secret Key">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                            title="This is your Paymentwall secret key found in your paymentwall project area, same place as your project key">
                                        ?
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Widget ID</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="paymentwall_widgetID"
                                           placeholder="Paymentwall WidgetID" value="p10_1">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                            title="This is your Paymentwall widget id. By default you can use p10_1">?
                                    </button>
                                </div>
                            </div>
                        </div>
                        <script>
                            $("#paymentwall_tick").on("ifChanged", function () {
                                var done = ($(this).is(':checked')) ? true : false;
                                if (done) {
                                    $('#paymentwall').show();
                                } else {
                                    $('#paymentwall').hide();
                                }
                            });
                        </script>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <input type="checkbox" id="stripe_tick" name="enable_stripe">
                                    <label>Stripe</label>
                                </div>
                            </div>
                        </div>
                        <div id="stripe" style="display: none;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">API Key</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="stripe_apiKey"
                                           placeholder="Stripe API Key">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                            title="Your live Stripe API key found on your Stripe account. View the Prometheus wiki if you are unsure about this!">
                                        ?
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Publishable Key</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="stripe_publishableKey"
                                           placeholder="Stripe Publishable Key">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                            title="Your live Stripe Publishable key found on your Stripe account. View the Prometheus wiki if you are unsure about this!">
                                        ?
                                    </button>
                                </div>
                            </div>
                        </div>
                        <script>
                            $("#stripe_tick").on("ifChanged", function () {
                                var done = ($(this).is(':checked')) ? true : false;
                                if (done) {
                                    $('#stripe').show();
                                } else {
                                    $('#stripe').hide();
                                }
                            });
                        </script>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>

                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-prom" value="<?= lang('submit'); ?>"
                                       name="install_submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include('inc/footer.php'); ?>
<?php } else { ?>
    <div class="content">
        <div class="container">
            <div class="bs-callout bs-callout-success">The installation has been finished. Please delete the install.php
                file!
            </div>
        </div>
    </div>
    <?php include('inc/footer.php'); ?>
<?php } ?>
