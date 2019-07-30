<?php
if (!permissions::has("raffles")) {
    die(lang('no_perm'));
}

if (prometheus::loggedin() && prometheus::isAdmin()) {
    if (!isset($_GET['id'])) {
        $id = '';
    } else {
        $id = $_GET['id'];
    }

    if (isset($_POST['submit'])) {
        $error = false;

        if ($_POST['title'] == '') {
            $error = true;
            $message->add('danger', 'You need to specify a title!');
        }
        if ($_POST['descr'] == '') {
            $error = true;
            $message->add('danger', 'You need to specify a description!');
        }
        if ($_POST['package'] == '') {
            $error = true;
            $message->add('danger', 'You need to select a package!');
        }

        if ($_POST['end'] == '' or !is_numeric($_POST['end'])) {
            $error = true;
            $message->add('danger', 'End amount must be a numeric value!');
        }
        if ($_POST['end'] <= 0) {
            $error = true;
            $message->add('danger', 'End amount must be greater than 0!');
        }

        if (getSetting('credits_only', 'value2') == 0) {
            if ($_POST['price'] == '' or !is_numeric($_POST['price'])) {
                $error = true;
                $message->add('danger', 'Price must be a numeric value!');
            }
            if ($_POST['price'] < 0) {
                $error = true;
                $message->add('danger', 'Price must be greater than or equal to 0!');
            }
        }

        if (gateways::enabled('credits')) {
            if ($_POST['credits'] == '' or !is_numeric($_POST['credits'])) {
                $error = true;
                $message->add('danger', 'Credits must be a numeric value!');
            }
            if ($_POST['credits'] < 0) {
                $error = true;
                $message->add('danger', 'Credits must be greater than or equal to 0!');
            }
        }

        if ($_POST['max'] == '' or !is_numeric($_POST['max'])) {
            $error = true;
            $message->add('danger', 'Max per person amount must be a numeric value!');
        }
        if ($_POST['max'] <= 0) {
            $error = true;
            $message->add('danger', 'Max per person amount must be greater than 0!');
        }

        if (!$error) {
            if (isset($_POST['price'])) {
                $price = $_POST['price'];
            } else {
                $price = 0;
            }

            if (gateways::enabled('credits')) {
                if (isset($_POST['credits'])) {
                    $credits = $_POST['credits'];
                }
            } else {
                if ($id != '') {
                    $credits = $db->getOne("SELECT credits FROM raffles WHERE id = ?", $id);
                } else {
                    $credits = 0;
                }
            }

            if (isset($_POST['imageurl'])) {
                $imageurl = strip_tags($_POST['imageurl']);
            } else {
                $imageurl = NULL;
            }

            if (isset($_POST['display_check'])) {
                if ($_FILES['img']["name"] != NULL) {
                    $allowedExts = array("jpg", "png");
                    $temp = explode(".", $_FILES["img"]["name"]);
                    $extension = end($temp);

                    if (in_array($extension, $allowedExts)) {
                        $rand = chr(mt_rand(97, 122)) . substr(md5(time()), 1);
                        $uploadfile = 'img' . DIRECTORY_SEPARATOR . 'raffles' . DIRECTORY_SEPARATOR . $rand . '.' . $extension;
                        move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile);
                        $img = $uploadfile;
                    } else {
                        $message->add('danger', 'The image must be a .png or .jpg');
                    }
                }

                if ($_FILES['img']["name"] == NULL && $imageurl != '') {
                    $img = $imageurl;
                }

            } else {
                $img = '';
            }

            if ($id != '') {
                $db->execute("UPDATE raffles SET title = ?, descr = ?, package = ?, end_amount = ?, max_per_person = ?, price = ?, credits = ?, img = ? WHERE id = ?",
                    array($_POST['title'], $_POST['descr'], $_POST['package'], $_POST['end'], $_POST['max'], $price, $credits, $img, $id));

                $message->Add('success', 'Successfully edited a raffle!');
                prometheus::log('Edited raffle ' . $id, $_SESSION['uid']);
            } else {
                $db->execute("INSERT INTO raffles SET title = ?, descr = ?, package = ?, end_amount = ?, max_per_person = ?, price = ?, credits = ?, img = ?",
                    array($_POST['title'], $_POST['descr'], $_POST['package'], $_POST['end'], $_POST['max'], $price, $credits, $img));
                $message->Add('success', 'Successfully added a raffle!');

                prometheus::log('Added a raffle ', $_SESSION['uid']);
            }

        }
    }

    if (isset($_POST['raffle_disable'])) {
        $enabled = 0;

        $db->execute("UPDATE raffles SET enabled = ? WHERE id = ?", array($enabled, $id));
        $message->add('success', 'Raffle disabled!');

        prometheus::log('Disabled raffle ' . $id, $_SESSION['uid']);
        $message->Add('success', 'Disabled raffle');
    }

    if (isset($_POST['raffle_enable'])) {
        $enabled = 1;

        $db->execute("UPDATE raffles SET enabled = ? WHERE id = ?", array($enabled, $id));
        $message->add('success', 'Raffle enabled!');

        prometheus::log('Enabled raffle ' . $id, $_SESSION['uid']);
        $message->Add('success', 'Enabled raffle');
    }

    if (isset($_POST['raffle_cleanup'])) {
        raffle::cleanup($id);

        prometheus::log('Cleaned up raffle ' . $id, $_SESSION['uid']);
        $message->Add('success', 'Cleaned up raffle');
    }

    if (isset($_POST['raffle_close'])) {
        if(!raffle::end(true, $id))
            $message->add('danger', 'No raffle entries, can\'t draw winner early. Disable it instead.');
        else
            $message->Add('success', 'Ended raffle');

        prometheus::log('Ended raffle: ' . $id . ' early', $_SESSION['uid']);
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
    <span><i class="fa fa-puzzle-piece"></i> <?= lang('raffles'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">

                <?php if (!isset($_GET['add']) and !isset($_GET['edit'])) { ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="admin.php?a=raf&add">
                                <div class="srv-box"><i class="fa fa-check fa-4x"></i>

                                    <div class="srv-label">Add raffle</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="admin.php?a=raf&edit">
                                <div class="srv-box"><i class="fa fa-cogs fa-4x"></i>

                                    <div class="srv-label">Edit raffle</div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['edit']) && !isset($_GET['id'])) { ?>
                    <div class="darker-box">
                        <form method="POST" style="width: 40%;">
                            <h2><?= lang('edit_raffle'); ?></h2>
                            <select class="selectpicker" data-live-search="true" data-style="btn-prom"
                                    onChange="location.href='admin.php?a=raf&edit&id=' + this.value;">
                                <option value=""><?= lang('select_raffle'); ?></option>
                                <?= options::getRaffles(); ?>
                            </select>
                        </form>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['id']) && isset($_GET['id']) or isset($_GET['add'])) { ?>
                    <form method="POST" style="width: 100%;" enctype="multipart/form-data" class="form-horizontal form"
                          role="form">
                          <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php if (isset($_GET['id'])) { ?>
                                    <h2><?= lang('edit_raffle'); ?></h2>
                                <?php } else { ?>
                                    <h2><?= lang('add_raffle'); ?></h2>
                                <?php } ?>

                                <div id="message-location">
                                    <?php $message->display(); ?>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($_GET['id'])) { ?>
                            <?php if (raffle::getEdit($id, 'enabled') == 0) { ?>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="package-disabled">
                                            <input type="submit" value="Enable Raffle" class="btn btn-success"
                                                   name="raffle_enable" style="margin-top: 5px;">
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (raffle::getEdit($id, 'ended') == 1) { ?>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="package-disabled">
                                            This raffle has ended, do you want to clean it up and restart it?<br>
                                            <input type="submit" value="Clean up" class="btn btn-success"
                                                   name="raffle_cleanup" style="margin-top: 5px;">
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </form>

                    <form method="POST" style="width: 100%;" enctype="multipart/form-data" class="form-horizontal form"
                          role="form">
                          <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Raffle title</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Raffle title" name="title"
                                       value="<?php echo raffle::getEdit($id, 'title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Raffle desc</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Raffle description" name="descr"
                                       value="<?php echo raffle::getEdit($id, 'descr'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>

                            <div class="col-sm-10">
                                <input type="checkbox" id="display_check"
                                       name="display_check" <?php echo raffle::getEdit($id, 'img') != '' ? 'checked' : ''; ?>>
                                <label>Use display image</label>
                            </div>
                        </div>
                        <div id="display_img"
                             style="<?php echo raffle::getEdit($id, 'img') != '' ? '' : 'display: none;'; ?> margin-top: 10px;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Display image</label>

                                <div class="col-sm-10">
                                    <div style="height: 0px; overflow: hidden;">
                                        <input type="file" id="img" name="img">
                                    </div>
                                    <button type="button" class="btn btn-prom" onclick="chooseFile();">Choose file
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Image URL</label>

                                <div class="col-sm-9">
                                    <input type="text" placeholder="Image URL" class="form-control" name="imageurl"
                                           value="<?php echo raffle::getEdit($id, 'img'); ?>">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                            title="Set this if you want to use a URL for your image instead of a file upload!">
                                        ?
                                    </button>
                                </div>
                            </div>
                        </div>
                        <script>
                            $("#display_check").on("ifChanged", function () {
                                var done = ($(this).is(':checked')) ? true : false;
                                if (done) {
                                    $('#display_img').show();
                                } else {
                                    $('#display_img').hide();
                                }
                            });
                        </script>

                        <?php if (getSetting('credits_only', 'value2') == 0) { ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Price</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Price" name="price"
                                           value="<?php echo raffle::getEdit($id, 'price'); ?>">
                                </div>
                            </div>
                        <?php }
                        if (gateways::enabled('credits')) { ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Credits</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Price(Credits)" name="credits"
                                           value="<?php echo raffle::getEdit($id, 'credits'); ?>">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Package</label>

                            <div class="col-sm-10">
                                <select name="package" class="selectpicker" data-style="btn-prom"
                                        data-live-search="true">
                                    <?= options::getPackages(raffle::getEdit($id, 'package'), 'raffle'); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">End Amount</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       placeholder="Amount of entries to end the raffle at" name="end"
                                       value="<?php echo raffle::getEdit($id, 'end_amount'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Max Per Person</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Max amount of entries per person"
                                       name="max" value="<?php echo raffle::getEdit($id, 'max_per_person'); ?>">
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

                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <?php if (isset($_GET['id'])) { ?>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <br><br><br>
                                    <hr>
                                    <input type="submit" value="Draw winner early" class="btn btn-prom"
                                           name="raffle_close" style="margin-top: 5px;">
                                    <hr>
                                    <h2>Dangerous settings</h2>
                                    <?php if (raffle::getEdit($id, 'enabled') == 1) { ?>
                                        If you don't want your users buying this raffle, you can disable it.<br>
                                        <input type="submit" value="Disable" class="btn btn-prom" name="raffle_disable"
                                               style="margin-top: 5px;">
                                        <hr>
                                    <?php } ?>
                                    Or alternatively, you can delete this raffle.<br>
                                    <input type="button" class="btn btn-prom" data-toggle="modal"
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
                                        <p>Are you sure you want to delete this raffle?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="Yes" class="btn btn-prom" name="raffle_del">
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

