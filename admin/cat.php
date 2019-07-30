<?php
if (!permissions::has("categories")) {
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

        if ($_POST['name'] == '') {
            $error = true;
            $message->add('danger', 'You need to specify a category name!');
        }

        if (!$error) {
            $name = strip_tags($_POST['name']);
            $order_id = $_POST['order_id'];

            if ($order_id == '') {
                $order_id = 0;
            }

            if ($id != '') {
                $db->execute("UPDATE categories SET name = ?, order_id = ? WHERE id = ?", [
                    $name, $order_id, $id
                ]);

                $message->add('success', 'Successfully updated a category!');
                prometheus::log('Edited a category', $_SESSION['uid']);
            } else {
                $db->execute("INSERT INTO categories SET name = ?, order_id = ?", [
                    $name, $order_id
                ]);

                $message->add('success', 'Successfully added a category!');
                prometheus::log('Added a category', $_SESSION['uid']);
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
    <span><i class="fa fa-bookmark"></i> <?= lang('categories'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">

                <?php if (!isset($_GET['add']) and !isset($_GET['edit'])) { ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="admin.php?a=cat&add">
                                <div class="srv-box"><i class="fa fa-check fa-4x"></i>

                                    <div class="srv-label"><?= lang('add_cat'); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="admin.php?a=cat&edit">
                                <div class="srv-box"><i class="fa fa-cogs fa-4x"></i>

                                    <div class="srv-label"><?= lang('edit_cat'); ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['edit']) && !isset($_GET['id'])) { ?>
                    <div class="darker-box">
                        <h2>Edit Category</h2>

                        <form method="POST" style="width: 40%;">
                            <select name="server_select" class="selectpicker" data-style="btn-prom"
                                    data-live-search="true"
                                    onChange="location.href='admin.php?a=cat&edit&id=' + this.value;">
                                <option value=""><?= lang('select_category'); ?></option>
                                <?= options::getCategories(); ?>
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
                                    <h2><?= lang('edit_cat'); ?></h2>
                                <?php } else { ?>
                                    <h2><?= lang('add_cat'); ?></h2>
                                <?php } ?>

                                <div id="message-location">
                                    <?php $message->display(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= lang('cat_name'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" value="<?= getEditCategory($id, 'name'); ?>"
                                       placeholder="..." class="form-control" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Order ID</label>

                            <div class="col-sm-10">
                                <input type="text" value="<?= getEditCategory($id, 'order_id'); ?>"
                                       placeholder="(Number)" class="form-control" name="order_id">
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
                                    <?= lang('danger_cat'); ?><br>
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
                                            <p><?= lang('sure_cat'); ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="<?= lang('yes'); ?>" class="btn btn-prom"
                                                   name="cat_del">
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

