<?php

$disable_sorting = getSetting('disable_sorting', 'value2');

$store = new store('package');
$store->setServer($_GET['id']);

$sortArray = [
    "sortby" => "id",
    "cat" => "none",
    "search" => "%"
];

$store->setSortOptions($sortArray);

?>

<script type="text/javascript">
    $(document).ready(function (e) {
        $("form button[type=submit]").click(function () {
            $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
            $(this).attr("clicked", "true");
        });

        $("#storeSidebar").on('submit', (function (e) {
            e.preventDefault();

            sideBar(this);
        }));

        function sideBar(form) {
            var sid = getUrlParameter("id");
            var sortby = $(form).find('#sortby').val();
            var category = $("button[type=submit][clicked=true]").val();

            var search = $(form).find('input[type=text][name=search]').val();

            if (category === undefined) {
                var category = "none";
            }

            $('#packages').html('Loading ...');

            $.ajax({
                url: "inc/ajax/store.php",
                type: "POST",
                data: "action=get&type=package&id=" + sid + "&sortby=" + sortby + "&category=" + category + "&search=" + search,
                cache: false,
                success: function (data) {
                    $('#packages').html(data);
                }
            });
        }
    });
</script>

<div class="row">
    <div class="col-xs-12">
        <div class="header">
            <?php echo getServerName($_GET['id']); ?>
        </div>
    </div>
</div>

<?php if ($disable_sorting == 0) { ?>
    <div class="darker-box">
        <?= $store->getSidebar(); ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-xs-12">
        <?php if (tos::getLast() < getSetting('tos_lastedited', 'value3') && prometheus::loggedin()) { ?>
            <div class="info-box">
                <form method="POST" style="width: 40%;">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                    <h2><?= lang('tos'); ?></h2>
                    <?= lang('tos_edited'); ?><br>
                    <input type="submit" class="btn btn-success" value="<?= lang('tos_accept'); ?>" name="tos_submit"
                           style="margin-top: 5px;">
                </form>
            </div>
        <?php } ?>

        <br>
        <?php $message->display(); ?>

        <div id="packages">
            <?php
            echo $store->display();
            ?>
        </div>
    </div>
</div>