<?php

if (!permissions::has("users")) {
    die(lang('no_perm'));
}

?>

<div class="row">
    <div class="col-xs-12">
        <div class="ticket-header" style="margin-bottom: 0px;">
            <img src="<?php echo getUserSetting('steam_avatar', $UID_a); ?>" width="50px" height="50px">
            <?php echo getUserSetting("name", $UID_a); ?>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 25px;">
    <div class="col-xs-12">
        <a href="admin.php?page=users&action=package&id=<?= $_GET['id']; ?>" class="btn btn-success"
           style="margin-bottom: 5px;"><?= lang('assign_package', 'Assign package'); ?></a>
        <a href="admin.php?page=users&action=credits&id=<?= $_GET['id']; ?>" class="btn btn-success"
           style="margin-bottom: 5px;"><?= lang('set_credits', 'Set credits'); ?></a>
        <a href="admin.php?page=users&action=ticket&id=<?= $_GET['id']; ?>" class="btn btn-success"
           style="margin-bottom: 5px;"><?= lang('give_ticket', 'Give ticket'); ?></a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="stat-box-header">Account Information</div>
        <div class="stat-box">
            <div class="stat-box-inner">
                <b>User ID:</b> <a
                    href="http://steamcommunity.com/profiles/<?php echo $UID_a; ?>/"><?php echo $UID_a; ?></a><br>
                <b>SteamID:</b> <?php echo convertCommunityIdToSteamId($UID_a); ?>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-md-4">
        <div class="dashboard-widget-small-box">
            <div class="pull-left">
                <h2 class="element"><?php echo dashboard::getTotalCurrency(getSetting('dashboard_main_cc', 'value2'), 'total', null, false, $UID_a); ?></h2>

                <p class="caption"><?= lang('spent_total'); ?></p>
            </div>
            <i class="fa fa-money fa-4x pull-right"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-widget-small-box">
            <div class="pull-left">
                <h2 class="element"><?php echo dashboard::getTotalCurrency(getSetting('dashboard_main_cc', 'value2'), 'week', null, false, $UID_a); ?></h2>

                <p class="caption"><?= lang('spent_week'); ?></p>
            </div>
            <i class="fa fa-clock-o fa-4x pull-right"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-widget-small-box">
            <div class="pull-left">
                <h2 class="element"><?php echo dashboard::getTotalCurrency(getSetting('dashboard_main_cc', 'value2'), 'month', null, false, $UID_a); ?></h2>

                <p class="caption"><?= lang('spent_month'); ?></p>
            </div>
            <i class="fa fa-check-circle fa-4x pull-right"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel-body" style="margin-bottom: 0px !important;">
            <div class="panel-header">
                <div class="pull-left"><?= lang('your_spendings'); ?></div>
            </div>
            <div class="panel-inner">
                <?php

                echo lang('spendings_currency', null, [
                    $db->getOne("SELECT cc FROM currencies WHERE id = ?", getSetting('dashboard_main_cc', 'value2'))
                ]);

                ?>
                <br><br>
                <canvas id="adminChart" style="width: 100%; height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div id="adminChart_money" style="display: none;">
    <?php
    echo dashboard::getRevenue('money', $UID_a);
    ?>
</div>

<div id="adminChart_credits" style="display: none;">
    <?php
    echo dashboard::getRevenue('credits', $UID_a);
    ?>
</div>

<script>
    function getDates(startDate /*moment.js date object*/) {
        nowNormalized = moment().startOf("month"),
            startDateNormalized = startDate.clone().startOf("month").add(1, "M"),
            months = [];


        while (startDateNormalized.isBefore(nowNormalized)) {
            months.push(startDateNormalized.format("MMMM"));
            startDateNormalized.add(1, "M");
        }

        return months;
    }

    var thisMonth = moment();
    thisMonth = thisMonth.format('MMMM');

    var earlierMonths = moment();
    earlierMonths.subtract(5, 'months');
    earlierMonths = String(getDates(earlierMonths));
    earlierMonths = earlierMonths.split(',');

    var money = $('#adminChart_money').text();
    var moneyJson = $.parseJSON(money);

    var credits = $('#adminChart_credits').text();
    var creditsJson = $.parseJSON(credits);

    var adminChartData = {
        labels: [earlierMonths[0], earlierMonths[1], earlierMonths[2], earlierMonths[3], thisMonth],
        datasets: [
            {
                label: "Money revenue",
                fillColor: "rgba(60,60,60,0.2)",
                strokeColor: "rgba(193,0,0,1)",
                pointColor: "rgba(193,0,0,1)",
                pointStrokeColor: "#c10000",
                pointHighlightFill: "#c10000",
                pointHighlightStroke: "rgba(193,0,0,1)",
                data: [moneyJson[4], moneyJson[3], moneyJson[2], moneyJson[1], moneyJson[0]]
            },
            {
                label: "Credits revenue",
                fillColor: "rgba(60,60,60,0.2)",
                strokeColor: "rgba(156,156,156,1)",
                pointColor: "rgba(156,156,156,1)",
                pointStrokeColor: "#9c9c9c",
                pointHighlightFill: "#9c9c9c",
                pointHighlightStroke: "rgba(156,156,156,1)",
                data: [creditsJson[4], creditsJson[3], creditsJson[2], creditsJson[1], creditsJson[0]]
            }
        ]
    }

    window.onload = function () {
        var ctx = document.getElementById("adminChart").getContext("2d");
        window.myLine = new Chart(ctx).Line(adminChartData, {
            responsive: true
        });
    }
</script>

<div class="row">
    <div class="col-md-6">
        <?php if (gateways::enabled('credits')) { ?>
            <div class="stat-box-header" style="border-bottom: 0px;">Credits</div>
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td><?php echo credits::get($UID_a); ?></td>
                </tr>
                </tbody>
            </table>
        <?php } ?>
        <div class="stat-box-header">Package History</div>
        <table class="table table-striped">
            <thead style="border-top: 0px;">
            <th>Package</th>
            <th>Timestamp</th>
            </thead>

            <tbody>
            <?php echo getPackageHistory($UID_a); ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <div class="stat-box-header" style="border-bottom: 0px;">Non-Permanent Package</div>
        <table class="table table-striped">
            <tbody>
            <?php echo getNonPermanentPackages($UID_a); ?>
            </tbody>
        </table>
        <div class="stat-box-header" style="border-bottom: 0px;">Permanent Package(s)</div>
        <table class="table table-striped">
            <tbody>
            <?php echo getPermanentPackages($UID_a); ?>
            </tbody>
        </table>
    </div>
</div>