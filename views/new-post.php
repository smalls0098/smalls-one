<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/18 - 19:17
 **/
$postsPagePer = get_option('posts_per_page', 10);
$current      = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

if (is_category()) {
    $cid        = get_query_var('cat');
    $cate       = get_category($cid);
    $totalCount = $cate->count;
} else {
    $totalCount = wp_count_posts()->publish;
}
$GLOBALS['isShowPage'] = $postsPagePer > $totalCount ? false : true;

if (is_search()) {
    get_customize_view('information');
}
?>
    <iv-card class="smalls-post-card-container smalls-card-body" :dis-hover="true" padding="0">
        <?php
        if (is_home()) {
            get_customize_view('component/carousel');
        }
        get_customize_view('component/post');
        if (is_home()) {
            get_customize_view('component/introduce');
        }
        ?>
    </iv-card>
<?php get_customize_view('component/paginate') ?>