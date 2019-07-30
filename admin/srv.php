<?php
if (!permissions::has("servers")) {
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

        if ($_POST['name'] == '') {
            $error = true;
            $message->add('danger', 'You need to specify a server name!');
        }

        if (!$error) {
            $name = strip_tags($_POST['name']);
            $order_id = $_POST['order_id'];
            $featured = $_POST['featured'];

            $game = $_POST['game'];

            if ($game != 'gmod') {
                $ip = $_POST['ip'];
                $port = $_POST['port'];
                $rcon = $_POST['rcon'];
            } else {
                $ip = '';
                $port = '';
                $rcon = '';
            }

            if ($order_id == '') {
                $order_id = 0;
            }

            if ($_POST['image_link'] == '') {
                $image_link = null;
            } else {
                $image_link = $_POST['image_link'];
            }

            if ($id != '') {
                $db->execute("UPDATE servers SET name = ?, order_id = ?, featured_package = ?, image_link = ?, game = ?, ip = ?, port = ?, rcon = ? WHERE id = ?", [
                    $name, $order_id, $featured, $image_link, $game, $ip, $port, $rcon, $id
                ]);

                $message->add('success', 'Successfully updated a server!');

                prometheus::log('Edited a server', $_SESSION['uid']);
            } else {
                $db->execute("INSERT INTO servers SET name = ?, order_id = ?, image_link = ?, game = ?, ip = ?, port = ?, rcon = ?", [
                    $name, $order_id, $image_link, $game, $ip, $port, $rcon
                ]);

                $serverID = $db->getOne("SELECT id FROM servers WHERE name = ?", $name);
                $message->add('success', 'Successfully added a server!<br>Please note the serverID: ' . $serverID);

                prometheus::log('Added server ' . $serverID, $_SESSION['uid']);
            }

            cache::clear('servers');
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
    <span><i class="fa fa-server"></i> <?= lang('servers'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">

                <?php if (!isset($_GET['add']) and !isset($_GET['edit'])) { ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="admin.php?a=srv&add">
                                <div class="srv-box"><i class="fa fa-check fa-4x"></i>

                                    <div class="srv-label"><?= lang('add_srv'); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="admin.php?a=srv&edit">
                                <div class="srv-box"><i class="fa fa-cogs fa-4x"></i>

                                    <div class="srv-label"><?= lang('edit_srv'); ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['edit']) && !isset($_GET['id'])) { ?>
                    <div class="darker-box">
                        <h2>Edit Server</h2>

                        <form method="POST" style="width: 40%;">
                            <?php if (!isset($_GET['id'])) { ?>
                                <select name="server_select" class="selectpicker" data-style="btn-prom"
                                        data-live-search="true"
                                        onChange="location.href='admin.php?a=srv&edit&id=' + this.value;">
                                    <option value=""><?= lang('select_server'); ?></option>
                                    <?= options::getServers(); ?>
                                </select>
                            <?php } ?>
                        </form>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['id']) or isset($_GET['add'])) { ?>
                    <form method="POST" style="width: 100%;" class="form-horizontal form" role="form">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php if (isset($_GET['edit'])) { ?>
                                    <h2><?= lang('edit_srv'); ?></h2>
                                <?php } else { ?>
                                    <h2><?= lang('add_srv'); ?></h2>
                                <?php } ?>

                                <div id="message-location">
                                    <?php $message->display(); ?>
                                </div>

                            </div>
                        </div>
                        <?php if (isset($_GET['edit'])) { ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>

                                <div class="col-sm-10">
                                    <b>ServerID:</b> <?php echo $id; ?><br><br>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= lang('game'); ?></label>

                            <div class="col-sm-10">
                                <select name="game" class="selectpicker" data-style="btn-prom" id="game">
                                    <?= options::getServerGame($id); ?>
                                </select>
                            </div>

                            <script type="text/javascript">
                                $('#game').on('change', function () {
                                    var value = $(this).val();

                                    if (value != 'gmod') {
                                        $('#gameOptions').fadeIn();
                                    } else {
                                        $('#gameOptions').fadeOut();
                                    }
                                });
                            </script>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= lang('server_name'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" value="<?= getEditServer($id, 'name'); ?>"
                                       placeholder="<?= lang('server_name'); ?>" class="form-control" name="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= lang('order_id', 'Order ID'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" value="<?= getEditServer($id, 'order_id'); ?>"
                                       placeholder="<?= lang('order_id', 'Order ID (Number)'); ?>" class="form-control"
                                       name="order_id">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Image link</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Image link (360px x 90px)" class="form-control"
                                       name="image_link" value="<?= getEditServer($id, 'image_link'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= lang('featured_pkg_short'); ?></label>

                            <div class="col-sm-10">
                                <select name="featured" class="form-control">
                                    <option value="0"><?= lang('none'); ?></option>
                                    <?php echo options::getPackages($id); ?>
                                </select>
                            </div>
                        </div>

                        <div style="<?= getEditServer($id, 'game') != 'gmod' && $id != '' ? '' : 'display: none;'; ?>"
                             id="gameOptions">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?= lang('server_ip'); ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Server IP" class="form-control" name="ip"
                                           value="<?= getEditServer($id, 'ip'); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?= lang('server_port'); ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Server Port" class="form-control" name="port"
                                           value="<?= getEditServer($id, 'port'); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?= lang('server_rcon'); ?></label>

                                <div class="col-sm-10">
                                    <input type="password" placeholder="Server RCon Password" class="form-control"
                                           name="rcon" value="<?= getEditServer($id, 'rcon'); ?>">
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

                    <?php if (isset($_GET['id'])) { ?>
                        <form method="POST" style="width: 100%;" class="form-horizontal form" role="form">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <br><br><br>
                                    <hr>
                                    <h2><?= lang('dangerous'); ?></h2>
                                    <?= lang('danger_srv'); ?><br>
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
                                            <p><?= lang('sure_srv'); ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="<?= lang('yes'); ?>" class="btn btn-prom"
                                                   name="edit_del">
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
