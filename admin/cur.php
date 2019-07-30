<?php
if (!permissions::has("currencies")) {
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
        $id = $_GET['id'];

        if ($_POST['cc'] == '') {
            $error = true;
            $message->add('danger', 'You need to specify a currency code!');
        }
        if (strlen($_POST['cc']) > 3) {
            $error = true;
            $message->add('danger', 'The currency code can\'t be longer than 3 characters!');
        }

        if (!$error) {
            $cc = strip_tags($_POST['cc']);

            if ($id != '') {
                $db->execute("UPDATE currencies SET cc = ? WHERE id = ?", [$cc, $id]);
                $message->add('success', 'Successfully edited a currency!');
                prometheus::log('Edited a currency', $_SESSION['uid']);
            } else {
                $db->execute("INSERT INTO currencies SET cc = ?", $cc);
                $message->add('success', 'Successfully added a currency!');
                prometheus::log('Added a currency', $_SESSION['uid']);
            }

            cache::clear();
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
    <span><i class="fa fa-cc"></i> <?= lang('currencies'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">

                <?php if (!isset($_GET['add']) and !isset($_GET['edit'])) { ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="admin.php?a=cur&add">
                                <div class="srv-box"><i class="fa fa-check fa-4x"></i>

                                    <div class="srv-label"><?= lang('add_cur'); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="admin.php?a=cur&edit">
                                <div class="srv-box"><i class="fa fa-cogs fa-4x"></i>

                                    <div class="srv-label"><?= lang('edit_cur'); ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['edit']) && !isset($_GET['id'])) { ?>
                    <div class="darker-box">
                        <form method="POST" style="width: 40%;">
                            <h2><?= lang('select_currency'); ?></h2>
                            <select class="selectpicker" data-style="btn-prom" data-live-search="true"
                                    onChange="location.href='admin.php?a=cur&edit&id=' + this.value;">
                                <option value=""><?= lang('select_currency'); ?></option>
                                <?= options::getCurrencies(); ?>
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
                                    <h2><?= lang('edit_cur'); ?></h2>
                                <?php } else { ?>
                                    <h2><?= lang('add_cur'); ?></h2>
                                <?php } ?>

                                <div id="message-location">
                                    <?php $message->display(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= lang('cc'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?= getEditCurrency($id, 'cc'); ?>"
                                       placeholder="..." name="cc">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="hidden" name="submit" value="true">
                                <input type="submit" class="btn btn-prom" value="<?= lang('submit'); ?>" name="submit"
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
                                    <?= lang('danger_cur'); ?><br>
                                    <input type="button" class="btn btn-prom" data-toggle="modal"
                                           data-target="#deleteModal" style="margin-top: 5px;"
                                           value="<?= lang('delete'); ?>">
                                </div>
                            </div>
                        </form>
                    <?php } ?>

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
                                        <p><?= lang('sure_cur'); ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="<?= lang('yes'); ?>" class="btn btn-prom"
                                               name="cur_del">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal"><?= lang('no'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
