<?php
if (!permissions::has("permissions")) {
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
            $message->add("danger", "You need to specify a title!");
        }

        if ($_POST['permissions'] == null) {
            $error = true;
            $message->add("danger", "You need to select permissions!");
        }

        if (!$error) {
            $title = $_POST['title'];

            $permissions = $_POST['permissions'];
            $json = '';

            if ($permissions != null) {
                foreach ($permissions as $key => $value) {
                    $json .= '"' . $key . '",';
                }
            }

            $json = rtrim($json, ',');
            $json = '[' . $json . ']';

            if ($id != '') {
                permissions::update($_GET['id'], $title, $json);
                $message->add("success", "Successfully edited a permission group!");
            } else {
                permissions::add($title, $json);
                $message->add("success", "Successfully added a permission group!");
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
    <span><i class="fa fa-gavel"></i> <?= lang('permissions'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">

                <?php if (!isset($_GET['add']) and !isset($_GET['edit'])) { ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="admin.php?a=per&add">
                                <div class="srv-box"><i class="fa fa-check fa-4x"></i>

                                    <div class="srv-label"><?= lang('add_permission', 'Add permission group'); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="admin.php?a=per&edit">
                                <div class="srv-box"><i class="fa fa-cogs fa-4x"></i>

                                    <div
                                        class="srv-label"><?= lang('edit_permission', 'Edit permission group'); ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>


                <?php if (isset($_GET['edit']) && !isset($_GET['id'])) { ?>
                    <div class="darker-box">
                        <form method="POST" style="width: 40%;">
                            <select class="selectpicker" data-style="btn-prom"
                                    onChange="location.href='admin.php?a=per&edit&id=' + this.value;">
                                <option>Select permission group:</option>
                                <?= permissions::getOptions(); ?>
                            </select>
                        </form>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['id']) or isset($_GET['add'])) { ?>
                    <form method="POST" enctype="multipart/form-data" class="form-horizontal form" role="form">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php if ($id != '') { ?>
                                    <h2><?= lang('edit_permission', 'Edit permission group'); ?></h2>
                                <?php } else { ?>
                                    <h2><?= lang('add_permission', 'Add permission group'); ?></h2>
                                <?php } ?>

                                <span id="message-location">
								<?php $message->display(); ?>
							</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title</label>

                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control"
                                       placeholder="..."
                                       value="<?= permissions::value($id, 'title'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Permissions</label>

                            <div class="col-sm-10">
                                <div class="row">
                                    <?= permissions::get($id); ?>
                                </div>
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

                    <form method="POST" enctype="multipart/form-data" class="form-horizontal" role="form">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <?php if ($id != '' && $id != 1) { ?>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <br><br><br>
                                    <hr>
                                    <h2><?= lang('dangerous'); ?></h2>
                                    Delete this permission group?<br>
                                    <input type="button" class="btn btn-prom" href="" data-toggle="modal"
                                           data-target="#deleteModal" style="margin-top: 5px;" value="Delete">
                                </div>
                            </div>
                        <?php } ?>
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
                                        <h4 class="modal-title">Are you sure?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this permission group?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="Yes" class="btn btn-prom" name="group_del">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
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
