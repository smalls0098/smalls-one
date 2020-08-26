<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/18 - 11:50
 **/
//dev是开发模式，prod是正常模式
$GLOBALS['smallsMode'] = 'prod';
$seoDescription        = get_seo_description();
$barHeaderIcon         = get_option('smalls_setting_toolbar_icon');
$barHeaderTitle        = get_option('smalls_setting_toolbar_title');
$barHeaderMotto        = get_option('smalls_setting_toolbar_motto');
?>
<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta charset="utf-8"/>
    <meta http-equiv="x-dns-prefetch-control" content="on"/>
    <title><?php site_page_title(); ?></title>
    <meta name="keywords" content="<?php echo get_seo_keywords(); ?>"/>
    <meta name="description" content="<?php echo $seoDescription ?>">

    <meta property="og:title" content="<?php echo wp_get_document_title(); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo get_url(); ?>">
    <meta property="og:description" content="<?php echo $seoDescription ?>">
    <meta name="theme-version" content="<?php echo $GLOBALS['themeVersion']; ?>">
    <meta name="theme-name" content="<?php echo $GLOBALS['themeName']; ?>">
    <meta name="theme-desc" content="<?php echo $GLOBALS['themeDesc']; ?>">
    <link rel="shortcut icon" href="<?php echo get_home_url(); ?>/favicon.ico">
    <?php
    if (get_option('smalls_setting_assets_cdn') == 'bootcdn') {
        ?>
        <script src="//cdn.bootcdn.net/ajax/libs/vue/2.6.11/vue.min.js" charset="UTF-8"></script>
        <script src="//cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js" charset="UTF-8"></script>
        <script src="//cdn.bootcdn.net/ajax/libs/highlight.js/10.1.2/highlight.min.js" charset="UTF-8"></script>
        <script src="//cdn.bootcdn.net/ajax/libs/view-design/4.3.2/iview.min.js" charset="UTF-8"></script>
    <link href="//cdn.bootcdn.net/ajax/libs/view-design/4.3.2/styles/iview.css" rel="stylesheet">
    <?php
    } elseif (get_option('smalls_setting_assets_cdn') == 'unpkg') { ?>
        <script src="//unpkg.com/vue@2.6.11/dist/vue.min.js" charset="UTF-8"></script>
        <script src="//unpkg.com/jquery@3.5.1/dist/jquery.min.js" charset="UTF-8"></script>
        <script src="//unpkg.com/highlightjs@9.16.2/highlight.pack.js" charset="UTF-8"></script>
        <script src="//unpkg.com/view-design@4.3.2/dist/iview.min.js" charset="UTF-8"></script>
    <link href="//unpkg.com/view-design@4.3.2/dist/styles/iview.css" rel="stylesheet">
    <?php
    } elseif (get_option('smalls_setting_assets_cdn') == 'unpkg.zhimg.com') { ?>
        <script src="//unpkg.zhimg.com/vue@2.6.11/dist/vue.min.js" charset="UTF-8"></script>
        <script src="//unpkg.zhimg.com/jquery@3.5.1/dist/jquery.min.js" charset="UTF-8"></script>
        <script src="//unpkg.zhimg.com/highlightjs@9.16.2/highlight.pack.js" charset="UTF-8"></script>
        <script src="//unpkg.zhimg.com/view-design@4.3.2/dist/iview.min.js" charset="UTF-8"></script>
    <link href="//unpkg.zhimg.com/view-design@4.3.2/dist/styles/iview.css" rel="stylesheet">
    <?php
    } elseif (get_option('smalls_setting_assets_cdn') == 'jsDelivr') { ?>
        <script src="//cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.min.js" charset="UTF-8"></script>
        <script src="//cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" charset="UTF-8"></script>
        <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@10.1.2/build/highlight.min.js"
                charset="UTF-8"></script>
        <script src="//cdn.jsdelivr.net/npm/view-design@4.3.2/dist/iview.min.js" charset="UTF-8"></script>
    <link href="//cdn.jsdelivr.net/npm/view-design@4.3.2/dist/styles/iview.css" rel="stylesheet">
    <?php }else{ ?>
        <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/vue.min.js" charset="UTF-8"></script>
        <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/jquery.min.js" charset="UTF-8"></script>
        <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/highlight.min.js" charset="UTF-8"></script>
        <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/iview.min.js" charset="UTF-8"></script>
    <link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/iview/iview.css" rel="stylesheet">
    <?php } ?>
    <style>
        .loading {
            background: #fff;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            text-align: center
        }

        .loading div {
            width: 150px;
            height: 15px;
            margin: 100px auto 0;
            text-align: center
        }

        .loading div span {
            display: inline-block;
            width: 15px;
            height: 100%;
            margin-right: 5px;
            background: #57a3f3;
            -webkit-transform-origin: right bottom;
            -webkit-animation: load 1s ease infinite
        }

        .loading div span:last-child {
            margin-right: 0
        }

        @-webkit-keyframes load {
            0% {
                opacity: 1;
                -webkit-transform: scale(1)
            }
            to {
                opacity: 0;
                -webkit-transform: rotate(90deg) scale(.3)
            }
        }

        .loading div span:first-child {
            -webkit-animation-delay: .13s
        }

        .loading div span:nth-child(2) {
            -webkit-animation-delay: .26s
        }

        .loading div span:nth-child(3) {
            -webkit-animation-delay: .39s
        }

        .loading div span:nth-child(4) {
            -webkit-animation-delay: .52s
        }

        .loading div span:nth-child(5) {
            -webkit-animation-delay: .65s
        }
    </style>
    <script>
        window.DATA = {
            admin_ajax: "<?php echo admin_url('admin-ajax.php'); ?>",
        }
    </script>
    <?php echo get_header_custom_html(); ?>
</head>
<body>
<div class="loading">
    <div>
        <span></span><span></span><span></span><span></span>
    </div>
</div>
<div id="bar-header" class="bar-header">
    <div class="header-container">
        <button class="nav-bar-drop-down" id="menu-sm">
            <i class="ivu-icon ivu-icon-ios-menu icon"></i>
        </button>
        <a class="logo" href="<?php bloginfo('url'); ?>">
            <img src="<?php echo $barHeaderIcon; ?>" alt="首页">
            <span class="title"><?php echo $barHeaderTitle; ?></span>
            <span class="motto ml10"><?php echo $barHeaderMotto; ?></span>
        </a>
        <div class="menu-modal">
            <div class="modal-header hidden" id="menu-modal-close">
                <i class="ivu-icon ivu-icon-md-close"></i>
            </div>
            <ul class="header-nav">
                <li>
                    <form id="search-form" method="get" actions="<?php bloginfo('url'); ?>">
                        <iv-input name="s" search placeholder="请输入你要搜索的内容，按Enter搜索" type="text" maxlength="40"
                                  class="nav-link search"></iv-input>
                    </form>
                </li>
                <?php

                /*顶栏菜单*/

                class toolbarMenuWalker extends Walker_Nav_Menu
                {
                    public function start_lvl(&$output, $depth = 0, $args = array())
                    {
                        $indent = str_repeat("\t", $depth);
                        $output .= "\n$indent<div class=\"dropdown-menu\">\n";
                    }

                    public function end_lvl(&$output, $depth = 0, $args = array())
                    {
                        $indent = str_repeat("\t", $depth);
                        $output .= "\n$indent</div>\n";
                    }

                    public function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
                    {
                        if ($depth == 0) {
                            $output .= "<li><a href='" . $object->url . "' target='" . $object->target . "' title='" . $object->description . "'>" . $object->title . "</a>";
                        } else if ($depth == 1) {
                            $output .= "<a href=" . $object->url . " target='" . $object->target . "' title='" . $object->description . "'>" . $object->title . "</a>";
                        }
                    }

                    public function end_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
                    {
                        if ($depth == 0) {
                            $output .= "\n</li>";
                        }
                    }
                }

                wp_nav_menu(array(
                    'container'      => '',
                    'theme_location' => 'toolbar_menu',
                    'items_wrap'     => '%3$s',
                    'depth'          => 0,
                    'walker'         => new toolbarMenuWalker()
                ));
                ?>
            </ul>
        </div>
    </div>
</div>