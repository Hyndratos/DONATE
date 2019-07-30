<?php

if (!permissions::has("news")) {
    die(lang('no_perm'));
}


if (isset($_POST['add_news_submit']) && $_POST['add_news'] != '') {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");
        
    $p = $_POST['add_news'];

    news::add($p);
    $message->add('success', 'Successfully added news!');

    cache::clear();
}

if (isset($_POST['news_delete'])) {
    $p = $_POST['news_hidden'];

    news::del($p);
    $message->add('success', 'Successfully deleted news!');
}

if (isset($_POST['news_edit_submit'])) {
    $p = array(
        "text" => $_POST['news_edit_textarea'],
        "id" => $_POST['news_edit_hidden']
    );

    news::update($p);
    cache::clear();
}


?>

    <h2>news</h2>
<?php $message->Display(); ?>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
        <textarea id="add_news" name="add_news"></textarea><br>
        <script>
            $('#add_news').trumbowyg({
                removeformatPasted: true,
                autogrow: true,
                fullscreenable: false
            });
        </script>
        <input type="submit" name="add_news_submit" value="<?= lang('submit'); ?>" class="btn btn-prom">
    </form>

    <br>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Content</th>
            <th>Date</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <?php echo news::getTable(); ?>
        </tbody>
    </table>

<?php
if (isset($_POST['news_edit'])) {

    echo news::getPost($_POST['news_hidden'], true);

}

echo '
		<script type="text/javascript">
    		$(\'#news_edit_textarea\').trumbowyg({
                removeformatPasted: true,
                autogrow: true,
                fullscreenable: false
            });
		</script>
	';
?>