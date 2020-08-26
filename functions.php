<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/18 - 11:49
 **/

////////////////////////////////////////////////////////
///
/// 这边是设置全局变量：过滤器、动作操作等等
/// @author：smalls
/// @email：smalls0098@gmail.com
/// @github：https://www.github.com/smalls0098
///
////////////////////////////////////////////////////////

/**
 * @var WP_Theme
 */
$WP_Theme                   = wp_get_theme();
$GLOBALS['smallsCssDir']    = get_bloginfo('template_url') . '/css/';
$GLOBALS['smallsJSDir']     = get_bloginfo('template_url') . '/js/';
$GLOBALS['smallsImagesDir'] = get_bloginfo('template_url') . '/images/';
$GLOBALS['themeVersion']    = $WP_Theme->__get('version');
$GLOBALS['themeName']       = $WP_Theme->__get('name');
$GLOBALS['themeDesc']       = $WP_Theme->__get('description');;

/*登录界面 CSS*/
if (get_option('smalls_setting_enable_login_css') == 'true') {
    add_action('login_head', 'smalls_login_view_style');
}
function smalls_login_view_style()
{
    wp_enqueue_style("smalls_login_css", $GLOBALS['smallsCssDir'] . "login.css", null, $GLOBALS['theme_version']);
}

if (get_option('smalls_setting_enable_login_css') == 'true') {
    add_action('admin_head', 'smalls_admin_view_style');
}
function smalls_admin_view_style()
{
    wp_enqueue_style("smalls_admin_css", $GLOBALS['smallsCssDir'] . "admin.css", null, $GLOBALS['theme_version']);
}

/*主题菜单*/
register_nav_menus([
    'toolbar_menu' => '顶部导航',
    'leftbar_menu' => '左侧栏菜单',
]);

if (!get_option('upload_path') || !get_option('upload_url_path')) {
    update_option('upload_url_path', get_option('siteurl') . '/wp-content/uploads');
    update_option('upload_path', WP_CONTENT_DIR . '/uploads');
}
/*恢复链接管理器*/
add_filter('pre_option_link_manager_enabled', '__return_true');
/*日志*/
add_action('init', 'log_init');
function log_init()
{
    $labels = [
        'name'               => '日志',
        'singular_name'      => '日志',
        'add_new'            => '发表日志',
        'add_new_item'       => '发表日志',
        'edit_item'          => '编辑日志',
        'new_item'           => '新日志',
        'view_item'          => '查看日志',
        'search_items'       => '搜索日志',
        'not_found'          => '暂无日志',
        'not_found_in_trash' => '没有已遗弃的日志',
        'parent_item_colon'  => '',
        'menu_name'          => '日志'
    ];
    $args   = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'exclude_from_search' => true,
        'query_var'           => true,
        'rewrite'             => [
            'slug'       => 'log',
            'with_front' => false
        ],
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => null,
        'menu_icon'           => 'dashicons-format-quote',
        'supports'            => ['editor', 'author', 'title', 'custom-fields', 'comments']
    ];
    register_post_type('log', $args);
}

/*更改受保护的标题前缀*/
add_filter('protected_title_format', 'change_protected_title_prefix');
function change_protected_title_prefix()
{
    return '密码保护：%s';
}

/*更改私人标题前缀*/
add_filter('private_title_format', 'change_private_title_prefix');
function change_private_title_prefix()
{
    return '私密：%s';
}

//时区修正
if (get_option('smalls_setting_enable_timezone_fix') == 'true') {
    date_default_timezone_set('UTC');
}

//注册小工具
add_action('widgets_init', 'smalls_widgets_init');
function smalls_widgets_init()
{
    register_sidebar(
        array(
            'name'          => '左侧栏小工具',
            'id'            => 'leftbar-tools',
            'description'   => __('左侧栏小工具 (如果设置会在侧栏增加一个 Tab)'),
            'before_widget' => '<iv-card class="tools-card-container" padding="0" :dis-hover="true" id="left-me-card"><div id="%1$s" class="%2$s">',
            'after_widget'  => '</div></iv-card>',
            'before_title'  => '<p class="title">',
            'after_title'   => '</p><iv-divider class="line"></iv-divider>',
        )
    );
    register_sidebar(
        array(
            'name'          => '右侧栏小工具',
            'id'            => 'rightbar-tools',
            'description'   => __('右侧栏小工具 (如果设置会在侧栏增加一个 Tab)'),
            'before_widget' => '<iv-card class="tools-card-container" padding="0" :dis-hover="true" id="left-me-card"><div id="%1$s" class="%2$s">',
            'after_widget'  => '</div></iv-card>',
            'before_title'  => '<p class="title">',
            'after_title'   => '</p><iv-divider class="line"></iv-divider>',
        )
    );
}

/*提交评论*/
add_action('wp_ajax_ajax_post_comment', 'ajax_post_comment');
add_action('wp_ajax_nopriv_ajax_post_comment', 'ajax_post_comment');
function ajax_post_comment()
{
    $comment = wp_handle_comment_submission(wp_unslash($_POST));
    if (is_wp_error($comment)) {
        $data = $comment->get_error_data();
        if (!empty($data)) {
            show([], $comment->get_error_message(), false);
        } else {
            show([], '内部未知错误', false);
        }
    }
    $user = wp_get_current_user();
    do_action('set_comment_cookies', $comment, $user);
    $GLOBALS['comment'] = $comment;
    $html               = build_comment_item($comment, '', '') . '</div>';
    show($html, 'success', true, [
        'comments_per_page' => get_option('comments_per_page'),
        'comment_order'     => get_option('comment_order')
    ]);
}

add_action('wp_print_scripts', 'smalls_disable_autosave');
function smalls_disable_autosave()
{
    wp_deregister_script('autosave');
}

add_filter('wp_revisions_to_keep', 'smalls_specs_wp_revisions_to_keep', 10, 2);
function smalls_specs_wp_revisions_to_keep($num, $post)
{
    return 0;
}

add_action('init', 'wp_remove_open_sans_from_wp_core');
function wp_remove_open_sans_from_wp_core()
{
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans', '');
}

remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
// HTTP header 中的 link
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('template_redirect', 'rest_output_link_header', 11);

/**
 * 引入后台设置模块
 */
require_once get_template_directory() . '/views/admin/setting.php';
////////////////////////////////////////////////////////
///
/// 后面这些是自定义函数
/// @author：smalls
/// @email：smalls0098@gmail.com
/// @github：https://www.github.com/smalls0098
///
////////////////////////////////////////////////////////


if (!function_exists('site_page_title')) {
    /**
     * 网站首页标题
     * @author smalls
     * @email smalls0098@gmail.com
     */
    function site_page_title()
    {
        if (is_home()) {
            bloginfo('name');
            echo " - ";
            bloginfo('description');
        } elseif (is_category()) {
            single_cat_title();
            echo " - ";
            bloginfo('name');
        } elseif (is_single() || is_page()) {
            $title = single_post_title('', false);
            if ($title == '') {
                bloginfo('name');
                echo " - ";
                bloginfo('description');
            } else {
                echo $title;
            }
        } elseif (is_search()) {
            echo "搜索结果";
            echo " - ";
            bloginfo('name');
        } elseif (is_404()) {
            echo '没有找到页面';
        } else {
            wp_title('', true);
        }
    }
}

function get_style()
{
    $templateFile = STYLESHEETPATH . DIRECTORY_SEPARATOR . 'style.css';
    if (file_exists($templateFile)) {
        return file_get_contents($templateFile);
    }
    return '';
}

function get_customize_css($view = '')
{
    if ($view == '') {
        return '';
    }
    $templateFile = STYLESHEETPATH . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $view . '.css';
    if (file_exists($templateFile)) {
        return file_get_contents($templateFile);
    }
    return '';
}

function get_customize_js($view = '')
{
    if ($view == '') {
        return '';
    }
    $templateFile = STYLESHEETPATH . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . $view . '.js';
    if (file_exists($templateFile)) {
        return file_get_contents($templateFile);
    }
    return '';
}


if (!function_exists('get_customize_view')) {
    /**
     * 获取自定义页面
     * @param string $view 自定义页面名
     * @author smalls
     * @email smalls0098@gmail.com
     */
    function get_customize_view($view = '')
    {
        if ($view == '') {
            return;
        }
        $templateFile = STYLESHEETPATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
        if (file_exists($templateFile)) {
            require_once $templateFile;
        }
        return;
    }
}


if (!function_exists('get_author_info')) {
    /**
     * 获取作者信息
     * @return string
     * @author smalls
     * @email smalls0098@gmail.com
     */
    function get_author_info()
    {
        $blogUsers = get_users('role=Administrator');
        if ($blogUsers) {
            foreach ($blogUsers as $user) {
                return $user;
            }
        }
        return '';
    }
}

if (!function_exists('get_post_image')) {
    /**
     * @param string $content 文章内容
     * @param int $count 获取图片数量
     * @return array
     * @author smalls
     * @email smalls0098@gmail.com
     */
    function get_post_image($content, $count = 3)
    {
        preg_match_all('/<img.*?[ \t\r\n]?src=[\'"]?(.+?)[\'"]?(?:[ \t\r\n]+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        if (isset($strResult[1])) {
            $image = [];
            foreach ($strResult[1] as $v) {
                if (substr($v, 0, 4) === 'http') {
                    $image[] = $v;
                    if (count($image) === $count) {
                        break;
                    }
                }
            }
            return $image;
        }
        return [];
    }
}


if (!function_exists('get_excerpt_length')) {
    /**
     * @param int $length
     * @return int
     * @author smalls
     * @email smalls0098@gmail.com
     */
    function get_excerpt_length($length = 300)
    {
        return $length;
    }
}

//页面浏览量
function get_post_views($post_id)
{
    $count_key = 'views';
    $count     = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        $count = '0';
    }
    return number_format_i18n($count);
}

//获取文章 Meta
function get_post_metas($type)
{
    if ($type == 'time') {
        return get_the_time('Y-n-d');
    }
    if ($type == 'views') {
        return get_post_views(get_the_ID());
    }
    if ($type == 'comments') {
        return get_post(get_the_ID())->comment_count;
    }
    if ($type == 'author') {
        return get_the_author();
    }
}

function get_smalls_categories()
{
    //分类信息
    $categories = get_the_category();
    $cate       = '';
    $cateTis    = '';
    foreach ($categories as $index => $category) {
        $cateTis .= $category->cat_name;
        $cate    .= '<a href="' . get_category_link($category->term_id) . '" target="_blank">' . $category->cat_name . '</a>';
        if ($index != count($categories) - 1) {
            $cate    .= ',';
            $cateTis .= ',';
        }
    }
    if ($cate == '') {
        $cate    = '没有分类';
        $cateTis = '没有分类';
    }
    return [$cate, $cateTis];
}

//输出分页页码
function get_smalls_paginate_data($maxPageNumbers = 7, $extraClasses = '')
{
    $args = array(
        'prev_text'          => '',
        'next_text'          => '',
        'before_page_number' => '',
        'after_page_number'  => '',
        'show_all'           => True
    );
    $res  = paginate_links($args);
    //单引号转双引号 & 去除上一页和下一页按钮
    $res = preg_replace(
        '/\'/',
        '"',
        $res
    );
    $res = preg_replace(
        '/<a class="prev page-numbers" href="(.*?)">(.*?)<\/a>/',
        '',
        $res
    );
    $res = preg_replace(
        '/<a class="next page-numbers" href="(.*?)">(.*?)<\/a>/',
        '',
        $res
    );
    //寻找所有页码标签
    preg_match_all('/<(.*?)>(.*?)<\/(.*?)>/', $res, $pages);

    $total   = count($pages[0]);
    $current = 0;
    $urls    = array();
    for ($i = 0; $i < $total; $i++) {
        if (preg_match('/<span(.*?)>(.*?)<\/span>/', $pages[0][$i])) {
            $current = $i + 1;
        } else {
            preg_match('/<a(.*?)href="(.*?)">(.*?)<\/a>/', $pages[0][$i], $tmp);
            $urls[$i + 1] = $tmp[2];
        }
    }

    if ($total == 0) {
        return "";
    }

    //计算页码起始
    $from = max($current - ($maxPageNumbers - 1) / 2, 1);
    $to   = min($current + $maxPageNumbers - ($current - $from + 1), $total);
    if ($to - $from + 1 < $maxPageNumbers) {
        $to   = min($current + ($maxPageNumbers - 1) / 2, $total);
        $from = max($current - ($maxPageNumbers - ($to - $current + 1)), 1);
    }

    //生成新页码
    $html = "";
    if ($from > 1) {
        $html .= '<li class="ivu-page-item"><a href="' . $urls[1] . '"><i class="ivu-icon ivu-icon-ios-arrow-back"></i></a></li>';
    }
    if ($current > 1) {
        $html .= '<li class="ivu-page-item"><a href="' . $urls[$current - 1] . '"><i class="ivu-icon ivu-icon-md-arrow-dropleft"></i></a></li>';
    }
    for ($i = $from; $i <= $to; $i++) {
        if ($current == $i) {
            $html .= '<li class="ivu-page-item ivu-page-item-active"><a>' . $i . '</a></li>';
        } else {
            $html .= '<li class="ivu-page-item"><a class="page-link" href="' . $urls[$i] . '">' . $i . '</a></li>';
        }
    }
    if ($current < $total) {
        $html .= '<li class="ivu-page-item"><a href="' . $urls[$current + 1] . '"><i class="ivu-icon ivu-icon-md-arrow-dropright"></i></a></li>';
    }
    if ($to < $total) {
        $html .= '<li class="ivu-page-item"><a href="' . $urls[$total] . '"><i class="ivu-icon ivu-icon-ios-arrow-forward"></i></a></li>';
    }
    return '<nav><ul class="ivu-page' . $extraClasses . '">' . $html . '</ul></nav>';
}


//文章阅读量统计
function smalls_set_post_views()
{
    if (is_singular()) {
        global $post;
        $post_ID = $post->ID;
        if ($post_ID) {
            $post_views = (int)get_post_meta($post_ID, 'views', true);
            if (!update_post_meta($post_ID, 'views', ($post_views + 1))) add_post_meta($post_ID, 'views', 1, true);
        }
    }
}

function num2tring($num)
{
    if ($num >= 1000) $num = round($num / 1000 * 100) / 100 . 'k';
    return $num;
}

function smalls_get_post_views($before = '', $after = '', $echo = 1)
{
    global $post;
    $post_ID = $post->ID;
    $views   = (int)get_post_meta($post_ID, 'views', true);
    return num2tring($views);
}

//悄悄话
function is_comment_private_mode($id)
{
    if (strlen(get_comment_meta($id, "private_mode", true)) != 32) {
        return false;
    }
    return true;
}

function user_can_view_comment($id)
{
    if (!is_comment_private_mode($id)) {
        return true;
    }
    if (current_user_can("manage_options")) {
        return true;
    }
    if ($_COOKIE['argon_user_token'] == get_comment_meta($id, "private_mode", true)) {
        return true;
    }
    return false;
}

function smalls_comment_list($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    if (user_can_view_comment(get_comment_ID())) {
        $html = build_comment_item($comment, $args, $depth);
        echo $html;
    }
}

function build_comment_item($comment, $args, $depth)
{
    $id        = get_comment_ID();
    $author    = get_comment_author();
    $authorUrl = get_comment_author_url();
    $other     = '';
    if (user_can($comment->user_id, "update_core")) {
        $other .= '<span class="ml-10 badge badge-primary badge-admin">博主</span>';
    }
    if ($authorUrl) {
        $author = '<a href="' . $authorUrl . '" target="_blank">' . $author . '</a>';
    }
    $author = '<p class="username">' . $author . $other . '</p>';
    $time   = '<p class="sys-time" data-time="' . get_comment_time('U', true) . '">' . human_time_diff(get_comment_time('U'), current_time('timestamp')) . '</p>';
    $avatar = get_avatar($comment, $size = '35');

    $reply = '<div class="line-comment-item ivu-divider ivu-divider-vertical ivu-divider-default"></div>
                            <a data-id="' . $id . '" @click="onReply(' . $id . ', \'' . get_comment_author() . '\')">回复</a>';

    if ($comment->comment_approved == 0) {
        $tis   = '<div class="ivu-alert ivu-alert-warning mt10 ml-50"><span class="ivu-alert-message">您的这条评论正在等待审核中</span><span class="ivu-alert-desc"></span></div>';
        $reply = '<div class="line-comment-item ivu-divider ivu-divider-vertical ivu-divider-default"></div>
                            <a>等待审核</a>';
    } else {
        $tis = '';
    }
    $class = $comment->comment_parent ? "ml-50" : "";

    if ($args == '' || $depth == '') {
        $reply = '<div class="line-comment-item ivu-divider ivu-divider-vertical ivu-divider-default"></div>
                            <a>无法回复</a>';
    }

    $commentText = get_comment_text();
    if (strpos($commentText, '<code>') > -1 && strpos($commentText, '</code>') > -1) {
        $commentText = str_replace('<code>', '<pre><code>', $commentText);
        $commentText = str_replace('</code>', '</code></pre>', $commentText);
    }

    return '<div class="comment-item-info-container ' . $class . '" id="comment-' . $id . '">
                    <div class="header smalls-flex smalls-flex-row">
                    ' . $avatar . '
                    <div class="user">
                        ' . $author . '
                        <div class="info">
                            ' . $time . ($args == '' || $depth == '' ? $reply : ($depth < $args['max_depth'] ? $reply : '')) . '
                        </div>
                    </div>
                </div>
                <div class="ml-50">
                <div class="smalls-content">' . $commentText . '</div>
                </div>' . $tis;
}

function get_smalls_comment_paginate_links()
{
    $args = array(
        'prev_text'          => '',
        'next_text'          => '',
        'before_page_number' => '',
        'after_page_number'  => '',
        'show_all'           => True,
        'echo'               => False
    );
    $str  = paginate_comments_links($args);
    //单引号转双引号
    $str = preg_replace(
        '/\'/',
        '"',
        $str
    );
    //获取上一页地址
    preg_match(
        '/<a class="prev page-numbers" href="(.*?)">(.*?)<\/a>/',
        $str,
        $url
    );
    $prev = $url[1];
    preg_match(
        '/<a class="next page-numbers" href="(.*?)">(.*?)<\/a>/',
        $str,
        $url
    );
    $next = $url[1];
    return [$prev, $next];
}


function show($data = [], $message = 'success', $status = true, $expand = [])
{
    header("content:application/json;chartset=uft-8");
    $result = [
        'status'  => $status,
        'message' => $message,
        'data'    => $data,
        'expand'  => $expand,
    ];
    $res    = json_encode($result);
    exit($res);
}

//页面 Keywords
function get_seo_keywords()
{
    $customTags = get_option('smalls_setting_seo_keywords');
    if (is_single()) {
        global $post;
        $tags = get_the_tags($post->ID);
        if ($tags) {
            $tags = array_column($tags, 'name');
            $tags = implode($tags, ',');
            return $tags . ',' . $customTags;
        }
    }
    if (is_category()) {
        return single_cat_title('', false) . ',' . $customTags;
    }
    if (is_tag()) {
        return single_tag_title('', false) . ',' . $customTags;
    }
    if (is_author()) {
        return get_the_author() . ',' . $customTags;
    }
    if (is_post_type_archive()) {
        return post_type_archive_title('', false) . ',' . $customTags;
    }
    if (is_tax()) {
        return single_term_title('', false) . ',' . $customTags;
    }
    return $customTags;
}

function get_url()
{
    global $wp;
    return home_url(add_query_arg(array(), $wp->request));
}

//页面 Description Meta
function get_seo_description()
{
    global $post;
    if ((is_single() || is_page())) {
        if (post_password_required()) {
            return "这是一个加密页面，需要密码来查看";
        }
        if (get_the_excerpt() != "") {
            return get_the_excerpt();
        }
        return htmlspecialchars(mb_substr(str_replace("\n", '', strip_tags($post->post_content)), 0, 50)) . "...";
    } else {
        return get_option('smalls_setting_seo_description');
    }
}

//获取作者技能
function get_author_skill()
{
    $count  = 5;
    $skills = [];
    $type   = ['active', 'success', 'wrong', 'normal', "['#108ee9', '#87d068']"];
    for ($i = 1; $i <= $count; $i++) {
        $skill = get_option('smalls_setting_author_skill_' . $i);
        if ($skill) {
            list($name, $percentage) = explode(':', $skill);
            $skills[] = [
                'name'       => $name,
                'percentage' => $percentage,
                'type'       => $type[$i - 1],
            ];
        }
    }
    return $skills;
}

function get_header_custom_html()
{
    return get_option('smalls_setting_custom_html_head');
}

function get_header_footer_html()
{
    return get_option('smalls_setting_custom_html_foot');
}

//当前文章是否可以生成目录
function have_catalog()
{
    if (!is_single() && !is_page()) {
        return false;
    }
    if (post_password_required()) {
        return false;
    }
    $content = get_post(get_the_ID())->post_content;
    if (preg_match('/<h[1-6](.*?)>/', $content)) {
        return true;
    } else {
        return false;
    }
}

function getContentImage()
{
    $thumbnailUrl = esc_url(get_the_post_thumbnail_url());
    if (!$thumbnailUrl) {
        $content = get_the_content();
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        $images  = get_post_image($content);
        if ($images) {
            $thumbnailUrl = $images[0];
        } else {
            //TODO 默认的图片URL地址
            $thumbnailUrl = 'https://cdn.jsdelivr.net/gh/solstice23/cdn@master/argon-render-1.jpg';
        }
    }
    return $thumbnailUrl;
}