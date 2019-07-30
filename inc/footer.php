<?php if ($page != 'admin') { ?>
    <div class="push"></div>
<?php } ?>
</div>

<?php if ($page != 'admin') { ?>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <?php if(getSetting('disable_tos', 'value2') == 0){ ?>
                        <a href="tos.php" class="tos-link"><?= lang('tos'); ?></a>
                    <?php } ?>

                    <?php if (getSetting('imprint_enable', 'value2') == 1) { ?>
                        - <a href="imprint.php" class="tos-link"><?= lang('imprint'); ?></a>
                    <?php } ?>

                    <?php if(getSetting('privacy_enable', 'value2') == 1){ ?>
                        <br>
                        <a href="privacy.php" class="tos-link"><?= lang('privacy', 'Privacy Policy'); ?></a>
                    <?php } ?>
                </div>
                <div class="col-xs-6" style="text-align: right;">

                    <!-- Check if copyright is set to show -->
                    <?php if(getSetting('site_copyright', 'value2') == 1) { ?>
						<font color="#c10000"><a href="http://PrometheusIPN.com">Prometheus</a></font> &copy; IPN <?= lang('by'); ?> <a href="http://steamcommunity.com/profiles/76561197988497435/">Marcuz</a> & <a href="http://steamcommunity.com/profiles/76561198043838389/">Newjorciks</a></a><br>
						<?php } ?>
                    <i class="fa fa-steam"></i> Powered by <a href="http://steampowered.com">Steam</a><br>

                    <!-- Print version number -->
                    <span class="version">v.<?= $version; ?></span>
                    <!--
                        Revision
                        377295453
                    -->
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 text-right" style="margin-top: 5px;">
                    <?php if(getSetting('disable_language_selector', 'value2') == 0) { ?>
                        <select name="language" class="selectpicker client_language_picker" data-style="btn-prom" data-live-search="true">
                            <?php
                            echo options::languages();
                            ?>
                        </select>
                    <?php } ?>

                    <?php if(getSetting('disable_theme_selector', 'value2') == 0) { ?>
                        <select name="theme" class="selectpicker client_theme_picker" data-style="btn-prom" data-live-search="true">
                            <?php
                                echo theme::options();
                            ?>
                        </select>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script src="compiled/js/site.js?v=1.0.1"></script>

<script>
    <?php if($page != 'admin' && getSetting('halloween_things', 'value2') == 1){ ?>
        $.fn.halloweenBats({});
    <?php } ?>
</script>

<script type="template" id="message-danger">
    <p class='bs-callout bs-callout-danger'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </p>
</script>

<script type="template" id="message-success">
    <p class='bs-callout bs-callout-success'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </p>
</script>
</body>
</html>

<?php
if ($devmode) {
    echo "Page loaded in: " . (microtime(true) - $time) . "s";
}

//var_dump($db->querys);
?>
