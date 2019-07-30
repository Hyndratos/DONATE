<?php

if (!permissions::has("packages")) {
    die(lang('no_perm'));
}

?>

<h2><?= lang('move_packages', 'Move packages'); ?></h2>

<script type="text/javascript">
    $(function () {
        $("#sortable").sortable();
        $("#sortable").disableSelection();

        $('#savePackages').on('click', function () {
            var sortable = $('#sortable');

            var ids = '';

            $(sortable.find('.pid')).each(function (i, obj) {
                ids = ids + $(obj).text() + ',';
            });

            ids = ids.slice(0, -1);

            $.ajax({
                url: "inc/ajax/packages.php",
                type: "POST",
                data: "action=order&ids=" + ids,
                cache: false,
                success: function (data) {
                    $('#message-location').html(data);
                }
            });
        });
    });
</script>

<div id="message-location"></div>

<ul id="sortable">
    <?= packages::getMove(); ?>
</ul>

<button class="btn btn-prom" id="savePackages">Save</button>