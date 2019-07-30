<?php
$error = false;

if ($_POST['install_key'] == '') {
    $error = true;
    $message->Add('danger', 'You need to specify an API Key!');
}

if (!prometheus::lkcheck($_POST['install_key'])) {
    $error = true;
    $message->Add('danger', 'This is not a valid API Key!');
}

if ($_POST['install_title'] == '') {
    $error = true;
    $message->Add('danger', 'You need to specify a site title!');
}

if (isset($_POST['enable_paypal'])) {
    if ($_POST['install_email'] == '') {
        $error = true;
        $message->Add('danger', 'You need to specify your PayPal email!');
    }

    if ($_POST['install_ipn'] == '') {
        $error = true;
        $message->Add('danger', 'The IPN URL must be specified!');
    }

    if ($_POST['install_return'] == '') {
        $error = true;
        $message->Add('danger', 'The Return URL must be specified!');
    }

    if ($_POST['install_cancel'] == '') {
        $error = true;
        $message->Add('danger', 'The Cancellation URL must be specified!');
    }
}

if (!$error) {
    setSetting($_POST['install_key'], 'api_key', 'value');
    setSetting($_POST['install_title'], 'site_title', 'value');

    setSetting($_POST['install_ipn'], 'paypal_ipn', 'value');
    setSetting($_POST['install_return'], 'paypal_return', 'value');
    setSetting($_POST['install_cancel'], 'paypal_cancel', 'value');

    if (isset($_POST['enable_paypal'])) {
        setSetting($_POST['install_email'], 'paypal_email', 'value');

        gateways::setState('paypal', true);
    } else {
        gateways::setState('paypal', false);
    }

    if (isset($_POST['enable_credits'])) {
        if (isset($_POST['credits_only'])) {
            $credits_only = 1;
        } else {
            $credits_only = 0;
        }

        setSetting($credits_only, 'credits_only', 'value2');

        gateways::setState('credits', true);
    }

    if (isset($_POST['enable_paymentwall'])) {
        $paymentwall_project = strip_tags($_POST['paymentwall_project']);
        $paymentwall_secret = strip_tags($_POST['paymentwall_secret']);
        $paymentwall_widgetID = strip_tags($_POST['paymentwall_widgetID']);

        setSetting($paymentwall_project, 'paymentwall_projectKey', 'value');
        setSetting($paymentwall_secret, 'paymentwall_secretKey', 'value');
        setSetting($paymentwall_widgetID, 'paymentwall_widgetID', 'value');

        gateways::setState('paymentwall', true);
    }

    if (isset($_POST['enable_stripe'])) {
        $stripe_apiKey = strip_tags($_POST['stripe_apiKey']);
        $stripe_apiKey = strip_tags($_POST['stripe_publishableKey']);

        setSetting($stripe_apiKey, 'stripe_apiKey', 'value');
        setSetting($stripe_apiKey, 'stripe_publishableKey', 'value');

        gateways::setState('stripe', true);
    }

    setSetting(1, 'installed', 'value2');
    unlink('install.php');
    util::redirect('.?installed=true');
}
