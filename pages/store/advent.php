<?php

    if(getSetting('christmas_advent', 'value2') == 0){ die('This feature is disabled'); }

    if(!prometheus::loggedin()){
        die('You must be logged in to view the advent calendar');
    }

    if(isset($_GET['claim'])){
        $notBeen = false;
        $pkg = '';

        if(!advent::claimed($_GET['claim']) && advent::canClaim($_GET['claim'])){
            $id = advent::claim($_GET['claim']);

            $pkg = $db->getOne("SELECT title FROM packages WHERE id = ?", $id);
        } else {
            $notBeen = true;
        }
    }

?>

<?php if(isset($_GET['claim']) && $pkg != '' && !$notBeen){ ?>
    <div class="darker-box">        
        <?php 

            echo lang('advent_opened', '', [
                $_GET['claim'],
                $pkg
            ]);

        ?>
    </div>
<?php } elseif(isset($_GET['claim']) && $pkg == '' && !$notBeen){ ?>
    <div class="darker-box">
        <?= lang('advent_nopkg'); ?>
    </div>
<?php } elseif(isset($_GET['claim']) && $notBeen){ ?>
    <div class="darker-box">
        Trying to fool the system? This day hasn't been yet, be patient
    </div> 
<?php } ?>

<div class="darker-box">
    <?= lang('advent_text'); ?>
</div>

<div class="darker-box">
    <div class="header">
        <?= lang('advent_calendar'); ?>
    </div>
    <div class="row">
        <?= advent::getPage(); ?>       
    </div>
</div>