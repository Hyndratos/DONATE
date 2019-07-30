<?php

if (!permissions::has("frontpage")) {
    die(lang('no_perm'));
}

if (isset($_POST['frontpage_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");
        
    page::edit('frontpage', $_POST['frontpage_text']);
    $message->add('success', 'Successfully updated front page!');

    cache::clear();
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

<h2>Main page</h2>
<span id="message-location">
	<?php $message->Display(); ?>
</span>
Modify the information displayed on the frontpage<br><br>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <textarea id="frontpage" name="frontpage_text"
              class="form-control"><?php echo page::get('frontpage', true); ?></textarea>
    <script type="text/javascript">
        $('#frontpage').trumbowyg({
            removeformatPasted: true,
            autogrow: true,
            fullscreenable: false
        });
    </script>

    <input type="hidden" name="frontpage_submit" value="true">
    <input type="submit" name="frontpage_submit" value="<?= lang('submit'); ?>" class="btn btn-prom">
</form>