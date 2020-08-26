<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/18 - 11:50
 **/
$mode = $GLOBALS['smallsMode'];
if ($mode == 'dev') {
    $js    = get_customize_js('smalls.min');
    $css   = get_customize_css('smalls.min');
    $style = get_style();
}
?>
<div class="common-features">
    <button id="smalls-back-top" class="btn top-btn smalls-back-top shadow-sm" type="button">
        <span class="btn-inner--icon"><i class="ivu-icon ivu-icon-ios-arrow-up"></i></span>
    </button>
    <button id="smalls-reading-progress" class="btn top-btn smalls-back-top shadow-sm" type="button">
        <div id="smalls-reading-progress-bar" style="width: 0%;"></div>
        <span id="smalls-reading-progress-details">0%</span>
    </button>
</div>
</body>
<link href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/assets/iconfont/iconfont.css" rel="stylesheet">
<?php if ($mode != 'dev') { ?>
    <link href="<?php echo esc_url(get_template_directory_uri()); ?>/style.css" rel="stylesheet">
    <link href="<?php echo esc_url(get_template_directory_uri()); ?>/dist/css/smalls.min.css" rel="stylesheet">
    <script src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/js/smalls.min.js" charset="UTF-8"></script>
<?php } else {
    echo '<style>' . $style . '</style>';
    echo '<style>' . $css . '</style>';
    echo '<script>' . $js . '</script>';
} ?>
<?php echo get_header_custom_html(); ?>
</html>
