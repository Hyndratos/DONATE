<?php
if (!permissions::has("coupons")) {
    die(lang('no_perm'));
}

if (prometheus::loggedin() && prometheus::isAdmin()) {
    if (!isset($_GET['id'])) {
        $id = '';
    } else {
        $id = $_GET['id'];
    }

    if (isset($_POST['submit'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");
        
        $error = false;

        if(empty($_POST['code'])){
            $error = true;
            $message->add('danger', "You must enter a coupon code");
        }

        if(empty($_POST['description'])){
            $error = true;
            $message->add('danger', "You must enter a description");        
        }

        if(empty($_POST['max']) and $_POST['max'] != 0){
            $error = true;
            $message->add('danger', "You must enter the max amount of uses");
        }

        if(!is_numeric($_POST['max']) or $_POST['max'] < 0){
            $error = true;
            $message->add('danger', "The max amount of uses must not be lower than 0. And must be a number");
        }

        if(empty($_POST['percent'])){
            $error = true;
            $message->add('danger', "You need to specify a coupon off percentage");
        }

        if(!is_numeric($_POST['percent']) or $_POST['percent'] < 1 or $_POST['percent'] > 99){
            $error = true;
            $message->add('danger', "The off percentage must not be lower than 1, not higher than 99 and must be a number");
        }

        if(empty($_POST['expire'])  and $_POST['expire'] != 0){
            $error = true;
            $message->add('danger', "You must enter an expire date");
        }

        if(empty($_POST['packages'])){
            $error = true;
            $message->add('danger', "You must select some packages to apply the coupon to");
        }

        if(!$error){
            if($_POST['expire'] != 0){
                $date = new DateTime($_POST['expire']);
                $expires = $date->format('Y-m-d H:i:s');
            } else {
                $expires = "1000-01-01 00:00:00";
            }

            if($id == ''){

                $db->execute("INSERT INTO coupons(coupon, description, packages, percent, max_uses, expires)
                    values(?, ?, ?, ?, ?, ?)", [
                        $_POST['code'], $_POST['description'], json_encode($_POST['packages']), $_POST['percent'], $_POST['max'], $expires
                    ]);

                $message->add('success', "Successfully added coupon code");

            } else {

                $db->execute("UPDATE coupons SET coupon = ?, description = ?, packages = ?, percent = ?, max_uses = ?, expires = ? WHERE id = ?", [
                        $_POST['code'], $_POST['description'], json_encode($_POST['packages']), $_POST['percent'], $_POST['max'], $expires, $id
                    ]);

                $message->add('success', "Successfully updated coupon code");

            }
        }
    }
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

<div class="content-page-top">
    <span><i class="fa fa-calendar-minus-o"></i> <?= lang('coupons'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">

                <?php if (!isset($_GET['add']) and !isset($_GET['edit'])) { ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="admin.php?a=cou&add">
                                <div class="srv-box"><i class="fa fa-check fa-4x"></i>

                                    <div class="srv-label"><?= lang('add_cou'); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="admin.php?a=cou&edit">
                                <div class="srv-box"><i class="fa fa-cogs fa-4x"></i>

                                    <div class="srv-label"><?= lang('edit_cou'); ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['edit']) && !isset($_GET['id'])) { ?>
                    <div class="darker-box">
                        <h2><?= lang('edit_cou'); ?></h2>

                        <form method="POST" style="width: 40%;">
                            <select name="server_select" class="selectpicker" data-style="btn-prom"
                                    data-live-search="true"
                                    onChange="location.href='admin.php?a=cou&edit&id=' + this.value;">
                                <option value=""><?= lang('select_cou'); ?></option>
                                <?= options::getCoupons(); ?>
                            </select>
                        </form>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['id']) or isset($_GET['add'])) { ?>
                    <form method="POST" style="width: 100%;" class="form-horizontal form" role="form">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php if ($id != '') { ?>
                                    <h2><?= lang('edit_cou'); ?></h2>
                                <?php } else { ?>
                                    <h2><?= lang('add_cou'); ?></h2>
                                <?php } ?>

                                <div id="message-location">
                                    <?php $message->display(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Coupon code</label>

                            <div class="col-sm-10">
                                <input name="code" type="text" class="form-control" placeholder="..." value="<?= coupon::getValue($id, 'coupon'); ?>">
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Coupon description</label>

                            <div class="col-sm-10">
                                <input name="description" type="text" class="form-control" placeholder="..." value="<?= coupon::getValue($id, 'description'); ?>">
                            </div>
                        </div> 


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Amount of uses</label>

                            <div class="col-sm-10">
                                <input name="max" type="number" class="form-control" placeholder="0 is infinite" value="<?= coupon::getValue($id, 'max_uses'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Off percentage</label>

                            <div class="col-sm-10">
                                <input name="percent" type="number" class="form-control" placeholder="1-99" max="99" min="1" value="<?= coupon::getValue($id, 'percent'); ?>">
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Expire date</label>

                            <div class="col-sm-10">
                                <input name="expire" type="text" class="form-control" id="datepicker" placeholder="Blank or 0 is never" value="<?= coupon::getValue($id, 'expires'); ?>">
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Packages</label>

                            <div class="col-sm-10">
                                <select name="packages[]" class="selectpicker" multiple data-style="btn-prom"
                                    data-live-search="true">
                                    <?= options::getPackages($id, 'coupons'); ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="hidden" name="submit" value="true">
                                <input type="submit" value="<?= lang('submit'); ?>" class="btn btn-prom" name="submit"
                                       style="margin-top: 5px;">
                            </div>
                        </div>
                    </form>

                    <?php if ($id != '') { ?>
                        <form method="POST" style="width: 100%;" class="form-horizontal" role="form">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <br><br><br>
                                    <hr>
                                    <h2><?= lang('dangerous'); ?></h2>
                                    <input type="button" class="btn btn-prom" href="" data-toggle="modal"
                                           data-target="#deleteModal" style="margin-top: 5px;"
                                           value="<?= lang('delete'); ?>">
                                </div>
                            </div>
                        </form>

                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                            <div class="modal fade" id="deleteModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span
                                                    aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="modal-title"><?= lang('sure'); ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <p><?= lang('sure_cou'); ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="<?= lang('yes'); ?>" class="btn btn-prom"
                                                   name="cou_del">
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal"><?= lang('no'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

