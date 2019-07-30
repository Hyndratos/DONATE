<?php
if (!permissions::has("credit")) {
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

        if ($_POST['title'] == '') {
            $error = true;
            $message->add('danger', 'You need to specify a title!');
        }

        if ($_POST['descr'] == '') {
            $error = true;
            $message->add('danger', 'You need to give a brief description!');
        }

        if ($_POST['amt'] == '' or !is_numeric($_POST['amt']) && $_POST['amt'] > 0.01) {
            $error = true;
            $message->add('danger', 'You need to assign a positive numeric amount of tickets!');
        }

        if ($_POST['price'] == '' or !is_numeric($_POST['price']) && $_POST['price'] > 0.01) {
            $error = true;
            $message->add('danger', 'You need to assign a positive numeric price amount!');
        }

        if (!$error) {
            $p = [
                "title" => strip_tags($_POST['title']),
                "descr" => strip_tags($_POST['descr']),
                "amt" => strip_tags($_POST['amt']),
                "price" => strip_tags($_POST['price']),
                "id" => $id
            ];

            if ($id != '') {
                credits::update($p);
                $message->Add('success', 'Successfully updated a credit package!');
                prometheus::log('Edited a credit package', $_SESSION['uid']);
            } else {
                credits::add($p);
                $message->Add('success', 'Successfully added a credit package!');
                prometheus::log('Added a credit package', $_SESSION['uid']);
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
    <span><i class="fa fa-money"></i> <?= lang('credit_packages'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">

                <?php if (!isset($_GET['add']) and !isset($_GET['edit'])) { ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="admin.php?a=cre&add">
                                <div class="srv-box"><i class="fa fa-check fa-4x"></i>

                                    <div class="srv-label"><?= lang('add_cre'); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="admin.php?a=cre&edit">
                                <div class="srv-box"><i class="fa fa-cogs fa-4x"></i>

                                    <div class="srv-label"><?= lang('edit_cre'); ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['edit']) && !isset($_GET['id'])) { ?>
                    <div class="darker-box">
                        <form method="POST" style="width: 40%;">
                            <h2><?= lang('choose_cre', 'Choose credit package'); ?></h2>
                            <select class="selectpicker" data-style="btn-prom" data-live-search="true"
                                    onChange="location.href='admin.php?a=cre&edit&id=' + this.value;">
                                <option value=""><?= lang('select_package'); ?></option>
                                <?= options::getCreditPackages(); ?>
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
                                    <h2><?= lang('edit_cre'); ?></h2>
                                <?php } else { ?>
                                    <h2><?= lang('add_cre'); ?></h2>
                                <?php } ?>

                                <span id="message-location">
								<?php $message->display(); ?>
							</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= lang('pack_title'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       placeholder="..." name="title"
                                       value="<?= credits::getValue($id, 'title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= lang('description'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       placeholder="..." name="descr"
                                       value="<?= credits::getValue($id, 'descr'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= lang('amount', 'Amount'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       placeholder="(Number)" name="amt"
                                       value="<?= credits::getValue($id, 'amount'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= lang('price', 'Price'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       placeholder="(Number)" name="price"
                                       value="<?= credits::getValue($id, 'price'); ?>">
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
                        <form method="POST" enctype="multipart/form-data" class="form-horizontal" role="form">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <br><br><br>
                                    <hr>
                                    <h2><?= lang('dangerous'); ?></h2>
                                    <?= lang('sure_cre', 'Or alternatively, you can delete this credit package.'); ?>
                                    <br>
                                    <input type="button" class="btn btn-prom" data-toggle="modal"
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
                                            <p><?= lang('sure_cre', 'Are you sure you want to delete this credit package?'); ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="<?= lang('yes'); ?>" class="btn btn-prom"
                                                   name="credit_del">
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


