<?php

if (!permissions::has("theme")) {
    die(lang('no_perm'));
}

if (prometheus::loggedin() && prometheus::isAdmin()) {
    if (isset($_POST['theme_submit'])) {
        include('admin/theme/submit.php');
    }
}

if (!is__writable('themes/')) {
    echo lang("theme_no_write_perm", "Your themes directory has no write permissions, you are not able to create themes without it.");
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
    <span><i class="fa fa-ticket"></i> <?= lang('theme_editor'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">

                <?php if (!isset($_GET['add']) and !isset($_GET['edit'])) { ?>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="admin.php?a=theme&add">
                                <div class="srv-box"><i class="fa fa-check fa-4x"></i>

                                    <div class="srv-label"><?= lang('add_theme', 'Add theme'); ?></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="admin.php?a=theme&edit">
                                <div class="srv-box"><i class="fa fa-cogs fa-4x"></i>

                                    <div class="srv-label"><?= lang('edit_theme', 'Edit theme'); ?></div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['edit']) && !isset($_GET['id'])) { ?>
                    <h2>Edit theme</h2>
                    <form method="POST" style="width: 40%;">
                        <?php if (!isset($_GET['id'])) { ?>
                            <select class="selectpicker" data-title="<?= lang('select_theme', 'Select theme'); ?>" data-style="btn-prom" data-live-search="true"
                                    onChange="location.href='admin.php?a=theme&edit&id=' + this.value;">
                                <?= theme::options(false); ?>
                            </select>
                        <?php } ?>
                    </form>
                <?php } ?>

                <?php if (isset($_GET['id']) or isset($_GET['add'])) { ?>
                    <div id="message-location">
                        <?php $message->display(); ?>
                    </div>

                    <b>Shoutout to JQuery:</b><br>
                    Fuck you for not allowing any selectors for CSS. Thank you :)<br>
                    Translated to understandable English: Any :hover, :focus, :after or :before colours wont apply to the live preview (Any triangles, hover or focus effects)

                    <form method="POST" class="form-horizontal form">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <hr>

                        <?php if (!isset($_GET['id'])) { ?>
                            <input type="text" name="theme_name" placeholder="<?= lang('theme_name'); ?>"
                                   class="form-control" style="margin-top: 5px;">
                        <?php } ?>

                        <h2>Common</h2>
                        <?php

                        $nav = new theme_checkbox(
                            'Navigation bar',
                            'common_nav',
                            array(
                                [
                                    'title' => 'Nav BG',
                                    'name' => 'bg',
                                    'desc' => 'Background colour',

                                    'class' => '.navbar-inverse',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Link colour',
                                    'name' => 'link_col',
                                    'desc' => 'Link colour',

                                    'class' => '.navbar-inverse .navbar-nav > li > a',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Link hover bg',
                                    'name' => 'link_hover_bg',
                                    'desc' => 'Link hover background',

                                    'class' => '.navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus, .navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > li > a:focus',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Link hover colour',
                                    'name' => 'link_hover_col',
                                    'desc' => 'Link hover colour',

                                    'class' => '.navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus, .navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > li > a:focus',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Link active bg',
                                    'name' => 'link_active_bg',
                                    'desc' => 'Link active background',

                                    'class' => '.navbar-inverse .navbar-nav > .active > a',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Link active colour',
                                    'name' => 'link_active_col',
                                    'desc' => 'Link active colour',

                                    'class' => '.navbar-inverse .navbar-nav > .active > a',
                                    'classtype' => 'color',
                                ],
                            )
                        );
                        $nav->display();

                        $common = new theme_checkbox(
                            'Main common',
                            'common',
                            array(
                                [
                                    'title' => 'Site BG',
                                    'name' => 'bg',
                                    'desc' => 'Background colour',

                                    'class' => 'body, .wrap',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Site BG Image',
                                    'name' => 'bg',
                                    'desc' => 'Background image',

                                    'class' => 'body, .wrap',
                                    'classtype' => 'background',
                                    'wrap' => 'url',
                                    'colour' => false,
                                    'extra' => 'no-repeat center center fixed',
                                    'extra_attr' => [
                                        'background-size: cover;',
                                        'background-position: fixed;',
                                    ]
                                ],
                                [
                                    'title' => 'Site colour',
                                    'name' => 'text_col',
                                    'desc' => 'Text colour',

                                    'class' => 'body',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'HR(line) colour',
                                    'name' => 'hr_col',
                                    'desc' => '<hr> colour',

                                    'class' => 'hr',
                                    'classtype' => 'border-color',
                                ],
                                [
                                    'title' => 'Link colour',
                                    'name' => 'linktext_col',
                                    'desc' => 'Link colour',

                                    'class' => 'a',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Link hover colour',
                                    'name' => 'linktext_hover_col',
                                    'desc' => 'Link hover colour',

                                    'class' => 'a:hover, a:focus',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'H1 colour',
                                    'name' => 'h1_col',
                                    'desc' => 'Header1 colour',

                                    'class' => 'h1, .header',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'H2 colour',
                                    'name' => 'h2_col',
                                    'desc' => 'Header2 colour',

                                    'class' => 'h2',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'H3 colour',
                                    'name' => 'h3_col',
                                    'desc' => 'Header3 colour',

                                    'class' => 'h3',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'H6 colour',
                                    'name' => 'h6_col',
                                    'desc' => 'Header6 colour',

                                    'class' => 'h6',
                                    'classtype' => 'color',
                                ],

                                /*
                                [
                                    'title' => 'Scrollbar BG',
                                    'name' => 'cscrollbar_bg',
                                    'desc' => 'Scrollbar background',

                                    'class' => '::-webkit-scrollbar',
                                    'classtype' => 'background',
                                ],
                                [
                                    'title' => 'Scrollbar thumb BG',
                                    'name' => 'cscrollbar_thumb_bg',
                                    'desc' => 'Scrollbar thumb background',

                                    'class' => '::-webkit-scrollbar-thumb',
                                    'classtype' => 'background',
                                ],
                                */
                            )
                        );
                        $common->display();

                        $warnings = new theme_checkbox(
                            'Warnings',
                            'warnings',
                            array(
                                [
                                    'title' => 'Warning BG',
                                    'name' => 'warning_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.bs-callout',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Warning text',
                                    'name' => 'warning_text',
                                    'desc' => 'Text colour',

                                    'class' => '.bs-callout',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Warning success',
                                    'name' => 'warning_success_col',
                                    'desc' => 'Success colour',

                                    'class' => '.bs-callout-success',
                                    'classtype' => 'border-left-color',
                                ],
                                [
                                    'title' => 'Warning danger',
                                    'name' => 'warning_danger_col',
                                    'desc' => 'Danger colour',

                                    'class' => '.bs-callout-danger',
                                    'classtype' => 'border-left-color',
                                ],
                                [
                                    'title' => 'Warning info',
                                    'name' => 'warning_info_col',
                                    'desc' => 'Info colour',

                                    'class' => '.bs-callout-info',
                                    'classtype' => 'border-left-color',
                                ]
                            )
                        );
                        $warnings->display();


                        $paging = new theme_checkbox(
                            'Pagination',
                            'paging',
                            array(
                                [
                                    'title' => 'Paging BG',
                                    'name' => 'paging_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.pagination li a',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Paging text',
                                    'name' => 'paging_text',
                                    'desc' => 'Text colour',

                                    'class' => '.pagination li a',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Paging hover BG',
                                    'name' => 'paging_hover_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.pagination li a:hover, .pagination li a:focus',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Paging hover text',
                                    'name' => 'paging_hover_col',
                                    'desc' => 'Text colour',

                                    'class' => '.pagination li a:hover, .pagination li a:focus',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Paging active BG',
                                    'name' => 'paging_pactive_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.pagination > .active > a, .pagination > .active > a:hover, .pagination > .active > a:focus',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Paging active text',
                                    'name' => 'paging_pactive_col',
                                    'desc' => 'Text colour',

                                    'class' => '.pagination > .active > a, .pagination > .active > a:hover, .pagination > .active > a:focus',
                                    'classtype' => 'color',
                                ]
                            )
                        );
                        $paging->display();

                        $selection = new theme_checkbox(
                            'Select boxes',
                            'selectboxes',
                            array(
                                [
                                    'title' => 'Selection label BG',
                                    'name' => 'selection_label_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.srv-label',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Selection label link',
                                    'name' => 'selection_label_link',
                                    'desc' => 'Link colour',

                                    'class' => 'a .srv-label',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Selection box hover BG',
                                    'name' => 'selection_box_hover_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.srv-box:hover',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Selection box hover icon',
                                    'name' => 'selection_box_hover_icon',
                                    'desc' => 'Icon colour',

                                    'class' => '.srv-box:hover .fa',
                                    'classtype' => 'color',
                                ],
                            )
                        );
                        $selection->display();

                        $content = new theme_checkbox(
                            'Content',
                            'content',
                            array(
                                [
                                    'title' => 'Content BG',
                                    'name' => 'cbg',
                                    'desc' => 'Background colour',

                                    'class' => '.options, .dashboard-widget-small-box, .panel-body, .stat-box, #sortable li',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Content colour',
                                    'name' => 'ctext_col',
                                    'desc' => 'Text colour',

                                    'class' => '.options, .dashboard-widget-small-box, .panel-body, .panel-body .panel-inner, .stat-box, .content',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Header BG',
                                    'name' => 'cheader_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.panel-body > .panel-header, .stat-box-header',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Header colour',
                                    'name' => 'cheader_col',
                                    'desc' => 'Text colour',

                                    'class' => '.panel-body > .panel-header, .stat-box-header',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Widget border',
                                    'name' => 'widget_border_col',
                                    'desc' => 'Colour',

                                    'class' => '.dashboard-widget-small-box',
                                    'classtype' => 'border-color',
                                ],
                                [
                                    'title' => 'Widget header',
                                    'name' => 'widget_header_col',
                                    'desc' => 'Colour',

                                    'class' => '.dashboard-widget-small-box .element',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Widget icon',
                                    'name' => 'widget_icon_col',
                                    'desc' => 'Colour',

                                    'class' => '.dashboard-widget-small-box i, #sortable li i',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Widget caption',
                                    'name' => 'widget_caption_col',
                                    'desc' => 'Colour',

                                    'class' => '.dashboard-widget-small-box .caption',
                                    'classtype' => 'color',
                                ],
                            )
                        );
                        $content->display();

                        $forms = new theme_checkbox(
                            'Forms',
                            'forms',
                            array(
                                [
                                    'title' => 'Forms BG',
                                    'name' => 'formsbg',
                                    'desc' => 'Background colour',

                                    'class' => '.form-control',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Text colour',
                                    'name' => 'text_col',
                                    'desc' => 'Text colour',

                                    'class' => '.form-control',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Focus border colour',
                                    'name' => 'focus_border',
                                    'desc' => 'Border focus colour',

                                    'class' => '.form-control:focus',
                                    'classtype' => 'border-color',
                                ],
                                [
                                    'title' => 'Checkbox BG',
                                    'name' => 'checkbox_BG',
                                    'desc' => 'Checkbox background',

                                    'class' => '.icheckbox_line-red, .iradio_line-red',
                                    'classtype' => 'background',
                                ],
                                [
                                    'title' => 'Checkbox text',
                                    'name' => 'checkbox_text',
                                    'desc' => 'Checkbox text',

                                    'class' => '.icheckbox_line-red, .iradio_line-red',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Checkbox yes',
                                    'name' => 'checkbox_yes',
                                    'desc' => 'Checkbox yes',

                                    'class' => '.icheckbox_line-red.checked, .iradio_line-red.checked',
                                    'classtype' => 'border-color',
                                ],
                                [
                                    'title' => 'Checkbox no',
                                    'name' => 'checkbox_no',
                                    'desc' => 'Checkbox no',

                                    'class' => '.icheckbox_line-red, .iradio_line-red',
                                    'classtype' => 'border-color',
                                ],
                                [
                                    'title' => 'Button BG',
                                    'name' => 'button_bg',
                                    'desc' => 'Button background',

                                    'class' => '.btn-prom',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Button text',
                                    'name' => 'button_text',
                                    'desc' => 'Button text',

                                    'class' => '.btn-prom',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Button hover BG',
                                    'name' => 'button_hover_bg',
                                    'desc' => 'Button background',

                                    'class' => '.btn-prom:hover, .btn-prom:focus',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Button hover text',
                                    'name' => 'button_hover_text',
                                    'desc' => 'Button text',

                                    'class' => '.btn-prom:hover, .btn-prom:focus',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Dropdown menu BG',
                                    'name' => 'dropdown_dmenu_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.dropdown-menu',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Dropdown menu text',
                                    'name' => 'dropdown_dmenu_col',
                                    'desc' => 'Text colour',

                                    'class' => '.dropdown-menu',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Dropdown menu hover BG',
                                    'name' => 'dropdown_dmenu_hover_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Dropdown menu hover text',
                                    'name' => 'dropdown_dmenu_hover_col',
                                    'desc' => 'Text colour',

                                    'class' => '.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Dropdown menu active BG',
                                    'name' => 'dropdown_dmenu_active_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Dropdown menu active text',
                                    'name' => 'dropdown_dmenu_active_col',
                                    'desc' => 'Text colour',

                                    'class' => '.dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus',
                                    'classtype' => 'color',
                                ],
                            )
                        );
                        $forms->display();

                        $tables = new theme_checkbox(
                            'Tables',
                            'tables',
                            array(
                                [
                                    'title' => 'Table header BG',
                                    'name' => 'table_header_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.table-striped thead',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Table header text',
                                    'name' => 'table_header_col',
                                    'desc' => 'Text colour',

                                    'class' => '.table-striped thead',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Normal BG',
                                    'name' => 'table_normal_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.table-striped > tbody > tr',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Alternating BG',
                                    'name' => 'table_alt_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.table-striped > tbody > tr:nth-of-type(odd)',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Alternating text colour',
                                    'name' => 'table_alt_col',
                                    'desc' => 'Text colour',

                                    'class' => '.table-striped > tbody > tr:nth-of-type(odd)',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Normal text colour',
                                    'name' => 'table_normal_col',
                                    'desc' => 'Text colour',

                                    'class' => '.table',
                                    'classtype' => 'color',
                                ]
                            )
                        );
                        $tables->display();

                        ?>

                        <h2>Admin</h2>
                        <?php

                        $admin_sidebar = new theme_checkbox(
                            'Sidebar',
                            'admin_sidebar',
                            array(
                                [
                                    'title' => 'Sidebar BG',
                                    'name' => 'bg',
                                    'desc' => 'Background colour',

                                    'class' => '.main-menu-box, .version-marker',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Link colour',
                                    'name' => 'sidebar_link_col',
                                    'desc' => 'Link colour',

                                    'class' => '.main-menu-box ul li',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Link hover bg',
                                    'name' => 'sidebar_link_hover_bg',
                                    'desc' => 'Link hover bg',

                                    'class' => '.main-menu-box ul li:hover',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Link active bg',
                                    'name' => 'sidebar_link_active_bg',
                                    'desc' => 'Link active bg',

                                    'class' => '.main-menu-box ul li.active',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Link active colour',
                                    'name' => 'sidebar_link_active_col',
                                    'desc' => 'Link active colour',

                                    'class' => '.main-menu-box ul li.active',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Version text colour',
                                    'name' => 'sidebar_version_col',
                                    'desc' => 'Version text colour',

                                    'class' => '.version-marker',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Submenu BG',
                                    'name' => 'sidebar_submenu_bg',
                                    'desc' => 'Submenu background',

                                    'class' => '.main-menu-box .sub-menu',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Submenu header colour',
                                    'name' => 'sidebar_submenu_header_col',
                                    'desc' => 'Submenu header colour',

                                    'class' => '.main-menu-box ul.sub-menu .submenu-header',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Submenu hover bg',
                                    'name' => 'sidebar_submenu_link_hover_bg',
                                    'desc' => 'Submenu link hover background',

                                    'class' => '.main-menu-box ul.sub-menu li:hover',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Submenu hover colour',
                                    'name' => 'sidebar_submenu_link_hover_col',
                                    'desc' => 'Submenu link hover colour',

                                    'class' => '.main-menu-box ul.sub-menu li:hover',
                                    'classtype' => 'color',
                                ],
                            )
                        );
                        $admin_sidebar->display();

                        $admin_pageheader = new theme_checkbox(
                            'Page header',
                            'admin_pageheader',
                            array(
                                [
                                    'title' => 'Background',
                                    'name' => 'pageheader_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.content-page-top',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Text colour',
                                    'name' => 'pageheader_col',
                                    'desc' => 'Text colour',

                                    'class' => '.content-page-top > span',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Icon colour',
                                    'name' => 'pageheader_icon',
                                    'desc' => 'Icon colour',

                                    'class' => '.content-page-top > span > i',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Arrow colour',
                                    'name' => 'pageheader_arrow',
                                    'desc' => 'Arrow colour',

                                    'class' => '.content-page-top:after',
                                    'classtype' => 'border-color',
                                    'extra' => 'transparent transparent',
                                ]
                            )
                        );
                        $admin_pageheader->display();

                        $admin_dashboard = new theme_checkbox(
                            'Dashboard',
                            'admin_dashboard',
                            array(
                                [
                                    'title' => 'Nav BG',
                                    'name' => 'dashboard_nav_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.dashboard-nav, .dashboard-nav a',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Nav link',
                                    'name' => 'dashboard_nav_link',
                                    'desc' => 'Link colour',

                                    'class' => '.dashboard-nav a',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Nav link hover BG',
                                    'name' => 'dashboard_nav_hover_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.dashboard-nav a:hover, .dashboard-nav a:focus',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Nav link hover text',
                                    'name' => 'dashboard_nav_hover_text',
                                    'desc' => 'Text colour',

                                    'class' => '.dashboard-nav a:hover, .dashboard-nav a:focus',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Nav active BG',
                                    'name' => 'dashboard_nav_active_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.dashboard-nav a.active',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Nav active link',
                                    'name' => 'dashboard_nav_active_link',
                                    'desc' => 'Link colour',

                                    'class' => '.dashboard-nav a.active',
                                    'classtype' => 'color',
                                ]
                            )
                        );
                        $admin_dashboard->display();

                        $admin_misc = new theme_checkbox(
                            'Miscellanious',
                            'admin_misc',
                            array(
                                [
                                    'title' => 'Package step BG',
                                    'name' => 'step_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.pkg-step',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Package step text',
                                    'name' => 'step_text',
                                    'desc' => 'Text colour',

                                    'class' => '.pkg-step',
                                    'classtype' => 'color',
                                ],
                            )
                        );
                        $admin_misc->display();


                        $admin_modal = new theme_checkbox(
                            'Modal popup',
                            'admin_modal',
                            array(
                                [
                                    'title' => 'Modal BG',
                                    'name' => 'modal_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.modal-content',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Modal text',
                                    'name' => 'modal_mtext',
                                    'desc' => 'Text colour',

                                    'class' => '.modal-content',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Modal header BG',
                                    'name' => 'modal_mheader_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.modal-header',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Modal header text',
                                    'name' => 'modal_mheader_text',
                                    'desc' => 'Text colour',

                                    'class' => '.modal-header',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Modal footer BG',
                                    'name' => 'modal_mfooter_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.modal-footer',
                                    'classtype' => 'background-color',
                                ]
                            )
                        );
                        $admin_modal->display();

                        ?>

                        <h2>User</h2>
                        <?php

                        $user_common = new theme_checkbox(
                            'Common',
                            'user_common',
                            array(
                                [
                                    'title' => 'Credits BG',
                                    'name' => 'credits_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.credits',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Credits text colour',
                                    'name' => 'credits_col',
                                    'desc' => 'Text colour',

                                    'class' => '.credits',
                                    'classtype' => 'color',
                                ]
                            )
                        );
                        $user_common->display();

                        $user_header = new theme_checkbox(
                            'Banner',
                            'banner',
                            array(
                                [
                                    'title' => 'Banner BG',
                                    'name' => 'banner_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.banner',
                                    'classtype' => 'background-color',
                                ]
                            )
                        );
                        $user_header->display();

                        $user_footer = new theme_checkbox(
                            'Footer',
                            'footer',
                            array(
                                [
                                    'title' => 'Footer BG',
                                    'name' => 'footer_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.footer',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Footer text',
                                    'name' => 'footer_text',
                                    'desc' => 'Text colour',

                                    'class' => '.footer',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Version text',
                                    'name' => 'version_text',
                                    'desc' => 'Version colour',

                                    'class' => '.version',
                                    'classtype' => 'color',
                                ],
                            )
                        );
                        $user_footer->display();

                        $user_store = new theme_checkbox(
                            'Store',
                            'store',
                            array(
                                [
                                    'title' => 'Darker box',
                                    'name' => 'darker_box',
                                    'desc' => 'Background colour',

                                    'class' => '.darker-box, .info-box',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Category BG',
                                    'name' => 'category_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.categoryLink',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Category text',
                                    'name' => 'category_text',
                                    'desc' => 'Text colour',

                                    'class' => '.categoryLink',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Category text hover',
                                    'name' => 'category_hover_text',
                                    'desc' => 'Text hover colour',

                                    'class' => '.categoryLink:hover',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Buy button BG',
                                    'name' => 'buy_btn_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.buy-btn',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Buy button text',
                                    'name' => 'buy_btn_text',
                                    'desc' => 'Text colour',

                                    'class' => '.buy-btn',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Buy button border',
                                    'name' => 'buy_btn_border_col',
                                    'desc' => 'Border colour',

                                    'class' => '.buy-btn',
                                    'classtype' => 'border-color',
                                ],
                                [
                                    'title' => 'Buy button hover BG',
                                    'name' => 'buy_btn_hover_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.buy-btn:hover, .buy-btn:focus',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Buy button hover text',
                                    'name' => 'buy_btn_hover_text',
                                    'desc' => 'Text colour',

                                    'class' => '.buy-btn:hover, .buy-btn:focus',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Buy button hover border',
                                    'name' => 'buy_btn_hover_border_col',
                                    'desc' => 'Border colour',

                                    'class' => '.buy-btn:hover',
                                    'classtype' => 'border-color',
                                ],
                                [
                                    'title' => 'Store box bg',
                                    'name' => 'store_box_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.store-box',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Store box text',
                                    'name' => 'store_box_text_col',
                                    'desc' => 'Text colour',

                                    'class' => '.store-box',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Store box border',
                                    'name' => 'store_box_border_col',
                                    'desc' => 'Border colour',

                                    'class' => '.store-box, .store-box-upper span, .store-box-upper li',
                                    'classtype' => 'border-color',
                                ],
                                [
                                    'title' => 'Store box price',
                                    'name' => 'store_box_price',
                                    'desc' => 'Text colour',

                                    'class' => '.store-box-upper span',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Store description text',
                                    'name' => 'store_box_lower_tcol',
                                    'desc' => 'Text colour',

                                    'class' => '.store-box-lower',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Store box header BG',
                                    'name' => 'store_box_header_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.store-box-header',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Store box header text',
                                    'name' => 'store_box_header_col',
                                    'desc' => 'Text colour',

                                    'class' => '.store-box-header',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Credits border',
                                    'name' => 'credit_box_border',
                                    'desc' => 'Border colour',

                                    'class' => '.credit-content',
                                    'classtype' => 'border-color',
                                ],
                                [
                                    'title' => 'Credits text',
                                    'name' => 'credit_box_text',
                                    'desc' => 'Text colour',

                                    'class' => '.credit-content',
                                    'classtype' => 'color',
                                ],
                                [
                                    'title' => 'Credits span',
                                    'name' => 'credit_box_span',
                                    'desc' => 'Span colour',

                                    'class' => '.credit-content span',
                                    'classtype' => 'color',
                                ]
                            )
                        );
                        $user_store->display();

                        $support_profile = new theme_checkbox(
                            'Profile and support',
                            'support_profile',
                            array(
                                [
                                    'title' => 'Ticket header BG',
                                    'name' => 'ticket_header_bg',
                                    'desc' => 'Background colour',

                                    'class' => '.ticket-header',
                                    'classtype' => 'background-color',
                                ],
                                [
                                    'title' => 'Ticket header text',
                                    'name' => 'ticket_header_col',
                                    'desc' => 'Text colour',

                                    'class' => '.ticket-header',
                                    'classtype' => 'color',
                                ],
                            )
                        );
                        $support_profile->display();

                        ?>

                        <hr>
                        <input type="hidden" name="theme_submit" value="true">
                        <input type="submit" class="btn btn-prom" value="<?= lang('submit'); ?>" name="theme_submit">
                    </form>

                    <?php if (isset($_GET['id'])) { ?>
                        <form method="POST" style="width: 100%;" class="form-horizontal form" role="form">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <br><br><br>
                                    <hr>
                                    <h2><?= lang('dangerous'); ?></h2>
                                    <?= lang('danger_theme', 'Don\'t delete this theme unless you are not currently using it!'); ?>
                                    <br>
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
                                            <p><?= lang('sure_theme', 'Are you sure you want to delete this theme?'); ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="<?= lang('yes'); ?>" class="btn btn-prom"
                                                   name="theme_del">
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