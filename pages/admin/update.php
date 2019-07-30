<?php

if (!permissions::has("updates")) {
    die(lang('no_perm'));
}

if (isset($_POST['updateSubmit']) && !$demo) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");

    $json = prometheus::updateCheck();
    $array = json_decode($json, true);
    $source = prometheus::updateCheck('web');

    $latest = $array['latest'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $source);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    $destination = "updates/" . $latest . "_web.zip";
    $file = fopen($destination, "w+");
    fputs($file, $data);
    fclose($file);

    $zip = new ZipArchive;
    if ($zip->open('updates/' . $latest . '_web.zip') === TRUE) {
        $zip->extractTo('.');
        $zip->close();

        recursiveDelete('updates/' . $latest . '_web.zip');
    }
}

?>

<form method="POST" style="width: 100%;" class="form-horizontal" role="form">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <div class="row">
        <div class="col-sm-12">
            <?php $message->display(); ?>
            <h2><?= lang('automatic_updates', 'Automatic updates'); ?></h2>
            <?php

            if (!$demo) {
                cache::clear();
                $cur_ver = str_replace('.', '', $version);

                if (is__writable('updates/')) {
                    $json = prometheus::updateCheck();
                    $array = json_decode($json, true);

                    if ($array['uptodate'] == 1 or $cur_ver == $array['latest']) {
                        echo '
								<p class="bs-callout bs-callout-success">
									' . $array['msg'] . '
								</p>
								<a href="' . prometheus::updateCheck('lua') . '" class="btn btn-prom">' . lang('dl_lua', 'Download latest lua') . '</a>
							';
                    } else {
                        echo '
								<p class="bs-callout bs-callout-danger">
									' . $array['msg'] . ' ' . lang("newest_version", "Newest available version is:") . ' ' . $array['latest'] . '.
								</p>
								<form method="POST">
									<input type="submit" name="updateSubmit" value="' . lang('update', 'Update') . '" class="btn btn-prom">
								</form>
							';
                    }

                } else {
                    echo '
							' . lang("no_write_perm", "Your updates folder does not have write permissions! Automatic updates won\'t work unless you chmod it to 777. <br> You can however use this button to manually download the update") . '
							<br><br>
							<a href="' . prometheus::updateCheck('web') . '" class="btn btn-prom">' . lang('dl_web', 'Download latest web') . '</a> <a href="' . prometheus::updateCheck('lua') . '" class="btn btn-prom">' . lang('dl_lua', 'Download latest lua') . '</a>
						';
                }
            } else {
                echo 'This is a demo and this feature is disabled';
            }

            ?>
        </div>
    </div>
</form>