<?php
if (!permissions::has("packages")) {
    die(lang('no_perm'));
}

if (prometheus::loggedin() && prometheus::isAdmin()) {
    $display = true;

    if (store::countServers() == 0) {
        echo 'You need to <a href="admin.php?a=srv&add">create</a> a server before creating a package!';

        $display = false;
    }

    if (isset($_POST['pkg_submit'])) {
        include('admin/pkg/php.php');
    }

    if (isset($_POST['pkg_del'])) {
         if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $id = $_GET['id'];

        $img = $db->getOne("SELECT img FROM packages WHERE id = ?", $id);
        unset($img);

        $db->execute("DELETE FROM packages WHERE id = ?", $id);
        cache::clear();
        util::redirect('admin.php');

        prometheus::log('Deleted package ' . $id, $_SESSION['uid']);
    }

    if (isset($_POST['pkg_disable'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $id = $_GET['id'];
        $enabled = 0;

        $db->execute("UPDATE packages SET enabled = ? WHERE id = ?", [
            $enabled, $id
        ]);

        $message->add('success', 'Package disabled!');
        cache::clear();

        prometheus::log('Disabled package ' . $id, $_SESSION['uid']);
    }

    if (isset($_POST['pkg_enable'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $id = $_GET['id'];
        $enabled = 1;

        $db->execute("UPDATE packages SET enabled = ? WHERE id = ?", [
            $enabled, $id
        ]);

        $message->add('success', 'Package enabled!');
        cache::clear();

        prometheus::log('Enabled package ' . $id, $_SESSION['uid']);
    }

    if (isset($_GET['edit']) && isset($_GET['id']) && !store::packageExists($_GET['id'])) {
        die('This package does not exist');
    }

    if (isset($_POST['pkg_usersDisable'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $id = $_GET['id'];

        setSetting(date('Y-m-d H:i:s'), 'actions_lastupdated', 'value3');
        $db->execute("UPDATE actions SET active = 0, delivered = 0 WHERE package = ?", $id);

        prometheus::log('Disabled package ' . $id . ' from all users', $_SESSION['uid']);
    }

    if (isset($_POST['pkg_duplicate'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $db->execute("CREATE TEMPORARY TABLE tmptable SELECT * FROM packages WHERE id = ?", $_GET['id']);

        $increment = $db->getOne("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'packages'");

        $db->execute("UPDATE tmptable SET id = ? WHERE id = ?", [
            $increment, $_GET['id']
        ]);

        $db->execute("INSERT INTO packages SELECT * FROM tmptable WHERE id = ?", [
            $increment
        ]);

        $db->execute("DROP TABLE tmptable");

        prometheus::log('Duplicated package ' . $_GET['id'], $_SESSION['uid']);
        $message->add('success', 'Successfully duplicated package');
    }
}

?>

<script>

    $(document).ready(function (e) {
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

        var step1_visible = false;
        $("#pkg-step-1").on('click', (function (e) {
            e.preventDefault();

            if (!step1_visible) {
                $("#pkg-step-1-content").fadeToggle();
                step1_visible = true;
            } else {
                $("#pkg-step-1-content").fadeToggle();
                step1_visible = false;
            }
        }));

        var step2_visible = false;
        $("#pkg-step-2").on('click', (function (e) {
            e.preventDefault();

            if (!step2_visible) {
                $("#pkg-step-2-content").fadeToggle();
                step2_visible = true;
            } else {
                $("#pkg-step-2-content").fadeToggle();
                step2_visible = false;
            }
        }));

        var step3_visible = false;
        $("#pkg-step-3").on('click', (function (e) {
            e.preventDefault();

            if (!step3_visible) {
                $("#pkg-step-3-content").fadeToggle();
                step3_visible = true;
            } else {
                $("#pkg-step-3-content").fadeToggle();
                step3_visible = false;
            }
        }));
    });

</script>

<div class="content-page-top">
    <span><i class="fa fa-cubes"></i> <?= lang('packages_and_actions'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">

                <?php if ($display) { ?>
                    <?php if (!isset($_GET['add']) and !isset($_GET['edit'])) { ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="admin.php?a=pkg&add">
                                <div class="srv-box"><i class="fa fa-check fa-4x"></i>

                                    <div class="srv-label"><?= lang('add_package', 'Add package'); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="admin.php?a=pkg&edit">
                                <div class="srv-box"><i class="fa fa-cogs fa-4x"></i>

                                    <div class="srv-label"><?= lang('edit_package', 'Edit package'); ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['edit']) && !isset($_GET['id'])) { ?>
                    <script type="text/javascript">
                        $(function () {
                            $("form button[type=submit]").click(function () {
                                $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
                                $(this).attr("clicked", "true");
                            });

                            $("#packagesForm").on('submit', (function (e) {
                                e.preventDefault();

                                var category = $("button[type=submit][clicked=true]").val();

                                if (category === undefined) {
                                    var category = "none";
                                }

                                $('#packages').html('Loading ...');

                                $.ajax({
                                    url: "inc/ajax/packages.php",
                                    type: "POST",
                                    data: "action=get&category=" + category,
                                    cache: false,
                                    success: function (data) {
                                        $('#packages').html(data);

                                        $('.selectpicker').selectpicker();
                                    }
                                });

                            }));
                        });
                    </script>

                    <form method="POST" id="packagesForm">
                        <?= packages::getEdit('categories'); ?>
                        <div class="darker-box">
                            <?= lang('move_packages', null, ['<a href="admin.php?page=packages&action=move">' . lang('here') . '</a>']); ?>
                        </div>
                        <div id="packages" class="darker-box">
                            <?= packages::getEdit('packages'); ?>
                        </div>
                    </form>
                <?php } ?>

                <?php if (isset($_GET['edit']) && isset($_GET['id']) or isset($_GET['add'])) { ?>

                <?php
                if (isset($_GET['edit']) && isset($_GET['id'])) {
                    $id = $_GET['id'];
                } else {
                    $id = '';
                }
                ?>


                    <?php if (getEditPackage($id, 'enabled') == 0 && $id != '') { ?>
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                            <div class="package-disabled">
                                <input type="submit" value="Enable Package" class="btn btn-success"
                                       name="pkg_enable" style="margin-top: 5px;">
                            </div>
                        </form>
                    <?php } ?>

                    <form method="POST" enctype="multipart/form-data" class="form-horizontal form" role="form">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php if (isset($_GET['edit'])) { ?>
                                    <h2><?= lang('edit_package'); ?></h2>
                                <?php } else { ?>
                                    <h2><?= lang('add_package'); ?></h2>
                                <?php } ?>
                                <span id="message-location">
									<?php $message->display(); ?>
								</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="pkg-step" id="pkg-step-1">
                                    <span>Step 1</span>
                                    Basic package information
                                </div>
                            </div>
                        </div>

                        <div id="pkg-step-1-content" style="display: none;">
                            <div class="form-group">
                                <label
                                    class="col-sm-2 control-label"><?= lang('label_amount'); ?></label>

                                <div class="col-sm-10">
                                    <select class="selectpicker" data-style="btn-prom" name="pkg_label" id="pkg_label"
                                            style="padding-left: 8px;">
                                        <option value="<?= getEditPackage($id, 'labels_count'); ?>">Select:</option>
                                        <option value="none">None</option>
                                        <?php
                                        for ($i = 1; $i <= 25; $i++) {
                                            echo '
													<option value="' . $i . '">' . $i . '</option>
												';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?= lang('title', 'Title'); ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="..."
                                           value="<?= getEditPackage($id, 'title'); ?>" class="form-control"
                                           name="pkg_title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>

                                <div class="col-sm-10">
                                    <input type="checkbox" id="display_check"
                                           name="display_check" <?php echo getEditPackage($id, 'imageurl') == '' ? '' : 'checked'; ?>>
                                    <label>Use display image</label>
                                </div>
                            </div>
                            <div id="display_img"
                                 style="<?php echo getEditPackage($id, 'imageurl') == '' ? 'display: none;' : ''; ?> margin-top: 10px;">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Display image</label>

                                    <div class="col-sm-10">
                                        <div style="height: 0px; overflow: hidden;">
                                            <input type="file" id="img" name="pkg_img">
                                        </div>
                                        <button type="button" class="btn btn-prom" onclick="chooseFile();">Choose file
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Image URL</label>

                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Image URL" class="form-control"
                                               name="pkg_imageurl" value="<?= getEditPackage($id, 'imageurl'); ?>">
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="help-box" data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="Set this if you want to use a URL for your image instead of a file upload!">
                                            ?
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?= lang('category', 'Category'); ?></label>

                                <div class="col-sm-10">
                                    <select class="selectpicker" data-style="btn-prom" name="pkg_category"
                                            style="padding-left: 8px;">
                                        <?php echo options::getCategories($id); ?>
                                    </select>
                                </div>
                            </div>

                            <?php if (getSetting('credits_only', 'value2') == 0) { ?>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="checkbox" id="custom_price"
                                               name="custom_price" <?= getEditPackage($id, 'custom_price') ? 'checked' : ''; ?>>
                                        <label>Enable custom price</label>
                                    </div>
                                </div>
                                <div id="price_options2"
                                     style="<?= getEditPackage($id, 'custom_price') ? '' : 'display: none;'; ?>">
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="text" class="form-control" name="custom_price_min"
                                                   value="<?= getEditPackage($id, 'custom_price_min'); ?>"
                                                   placeholder="Minimum amount (Number)">
                                        </div>
                                    </div>
                                </div>

                                <?php if (gateways::enabled('paypal')) { ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>

                                        <div class="col-sm-10">
                                            <input type="checkbox" id="alternative_pp_check"
                                                   name="alternative_pp_check" <?php echo getEditPackage($id, 'alternative_pp') == '' ? '' : 'checked'; ?>>
                                            <label>Use a different PayPal account for this package</label>
                                        </div>
                                    </div>

                                    <div id="alternative_pp"
                                         style="<?php echo getEditPackage($id, 'alternative_pp') == '' ? 'display:  none;' : ''; ?>">
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="text" class="form-control" name="alternative_pp"
                                                       value="<?= getEditPackage($id, 'alternative_pp'); ?>"
                                                       placeholder="PayPal Email Address">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>

                            <div id="price_options" <?= getEditPackage($id, 'custom_price') ? 'style="display: none;"' : ''; ?>>
                                <?php if (getSetting('credits_only', 'value2') == 0) { ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><?= lang('price'); ?></label>

                                        <div class="col-sm-10">
                                            <input type="text" placeholder="0.00 (<?= lang('price'); ?>)" class="form-control" value="<?= getEditPackage($id, 'price'); ?>" name="pkg_price" style="display: inline-block;">
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if (gateways::enabled('credits')) { ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><?= lang('credits'); ?></label>

                                        <div class="col-sm-10">
                                            <input type="text" placeholder="(Number)"
                                                   class="form-control" value="<?= getEditPackage($id, 'credits'); ?>"
                                                   name="pkg_credits" style="display: inline-block;">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?= lang('servers'); ?></label>

                                <div class="col-sm-10" style="margin-top: -7px;">
                                    <?= checkbox_getServers('packages', $id); ?>
                                </div>
                            </div>
                            <?php $c = getEditPackage($id, 'labels_count'); ?>
                            <div id="labels" class="form-group"
                                 style="margin-top: -5px; <?php echo $c == 0 ? 'display: none;' : '' ?>">
                                <label class="col-sm-2 control-label"><?= lang('labels', 'Labels'); ?></label>

                                <div class="col-sm-10">
                                    <div id="inputs">
                                        <?php
                                        if ($c != 0) {
                                            foreach (range(0, $c - 1) as $num) {
                                                $labels_a = getEditPackage($id, 'labels');
                                                $value = htmlentities($labels_a[$num]);
                                                echo '
														<input class="form-control" style="margin-top: 5px;" value="' . $value . '" placeholder="Label ' . $num . '" name="labels[]">
													';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?= lang('description'); ?></label>

                                <div class="col-sm-10">
                                    <textarea
                                        placeholder="..."
                                        class="form-control" style="max-width: 100%;" id="pkg_desc"
                                        name="pkg_desc"><?= getEditPackage($id, 'desc'); ?></textarea>
                                    <script type="text/javascript">
                                        $('#pkg_desc').trumbowyg({
                                            removeformatPasted: true,
                                            autogrow: true,
                                            fullscreenable: false
                                        });
                                    </script>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="checkbox" id="pkg_permanent"
                                           name="pkg_permanent" <?= getEditPackage($id, 'permanent') ? 'checked' : ''; ?>>
                                    <label>Permanent package</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div id="days"
                                         style="<?= getEditPackage($id, 'permanent') ? 'display: none;' : ''; ?>">
                                        <input type="text" placeholder="Number of active days" class="form-control"
                                               name="pkg_days" value="<?= getEditPackage($id, 'days'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="subscription">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <input type="checkbox" name="pkg_subscription"
                                               id="subscription_check" <?= getEditPackage($id, 'subscription') ? 'checked' : ''; ?>>
                                        <label>PayPal Subscription based</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="pkg_hide" <?= getEditPackage($id, 'no_owned') ? 'checked' : ''; ?>>
                                        <label>Hide if user owns no other packages</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div id="rebuyable">
                                        <input type="checkbox" id="pkg_rebuyable"
                                               name="pkg_rebuyable" <?= getEditPackage($id, 'rebuyable') ? 'checked' : ''; ?>>
                                        <label>Buyable more than once if already active</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div id="once">
                                        <input type="checkbox" id="pkg_once"
                                               name="pkg_once" <?= getEditPackage($id, 'once') ? 'checked' : ''; ?>>
                                        <label>Buyable ONLY once</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="actions">
                            <?php include('admin/pkg/_actions.php'); ?>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="hidden" name="pkg_submit" value="true">
                                <input type="submit" value="<?= lang('submit'); ?>" class="btn btn-prom"
                                       name="pkg_submit" style="margin-top: 5px;">
                            </div>
                        </div>
                    </form>

                    <?php if ($id != ''){ ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <br><br><br>
                            <hr>
                            <h2><?= lang('dangerous'); ?></h2>
                            <?php if (getEditPackage($id, 'enabled') == 1) { ?>
                                If you don't want your users buying this package, you can disable it. It will still work for users who own this package.
                                <br>
                                <form method="POST">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                                    <input type="submit" value="Disable" class="btn btn-prom" name="pkg_disable"
                                           style="margin-top: 5px;">
                                </form>
                                <hr>
                            <?php } ?>
                            Disable this package for all users who currently own it?<br>
                            <input type="button" class="btn btn-prom" href="" data-toggle="modal"
                                   data-target="#usersDeleteModal" style="margin-top: 5px;"
                                   value="Disable for all current owners">
                            <hr>
                            Delete this package?<br>
                            <input type="button" class="btn btn-prom" href="" data-toggle="modal"
                                   data-target="#deleteModal" style="margin-top: 5px;" value="Delete">
                        </div>

                        <form method="POST" class="form">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                            <div class="col-xs-12">
                                <hr>
                                <input type="hidden" name="pkg_duplicate" value="true">
                                <input type="submit" value="<?= lang('duplicate', 'Duplicate'); ?>" class="btn btn-info"
                                       name="pkg_duplicate" style="margin-top: 5px;">
                            </div>
                        </form>
                    </div>

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
                                        <p>Are you sure you want to delete this package?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="Yes" class="btn btn-prom" name="pkg_del">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <div class="modal fade" id="usersDeleteModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span
                                                aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                        </button>
                                        <h4 class="modal-title">Are you sure?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to disable this package from all users?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="Yes" class="btn btn-prom" name="pkg_usersDisable">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
                <?php } ?>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
