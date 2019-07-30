<?php

if (!permissions::has("view_customjobs")) {
    die(lang('no_perm'));
}

?>

<h2><?= lang('custom_jobs', 'Custom jobs'); ?></h2>

<script type="text/javascript">
    $(function () {
        $('#code_save').on('click', function () {
            var timestamp = $('#timestamp').text();
            var code = $('#code_text').val();
            var id = $('#id').text();

            $.ajax({
                url: "inc/ajax/packages.php",
                type: "POST",
                data: "action=updateJob&code=" + code + "&timestamp=" + timestamp + "&id=" + id,
                cache: false,
                success: function (data) {
                    $("#message-location").html(data);
                    $("html, body").animate({scrollTop: 0}, "slow");
                }
            });
        });
    });
</script>

<div id="message-location"></div>

<div id="codearea" class="darker-box" style="display: none;">
    <div id="timestamp" style="display: none;"></div>
    <div id="id" style="display: none;"></div>
    <textarea class="form-control" style="min-height: 300px;" id="code_text"></textarea>
    <button id="code_save" class="btn btn-prom" style="margin-top: 5px;">Save</button>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Job name</th>
        <th>Members</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?= customjob::getTable(); ?>
    </tbody>
</table>

<script type="text/javascript">
    $('.showCode').on('click', function () {
        var code = $(this).parent().find('#code').html();
        var timestamp = $(this).parent().find('#timestamp').text();
        var id = $(this).parent().find('#id').text();

        $('#code_text').html(code);
        $('#timestamp').text(timestamp);
        $('#id').text(id);
        $('#codearea').show();
    });
</script>