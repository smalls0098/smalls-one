<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/26 - 11:41
 **/
global $wp_query;
$postsPagePer = get_option('posts_per_page', 10);
$current      = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

$totalCount            = (int)$wp_query->found_posts;
$GLOBALS['isShowPage'] = $postsPagePer > $totalCount ? false : true;
if (is_category() || is_tag()) {
    $text = '的文章列表';
} else {
    $text = '的归档记录';
}

if (is_archive()) {
    ?>
    <iv-card class="information-container" :dis-hover="true" padding="0">
        <div class="card-body">
            <h3><?php the_archive_title(); ?></h3>
            <p class="text"><?php echo $text; ?></p>
            <p class="count"><i class="ivu-icon ivu-icon-md-send"></i> <?php echo $wp_query->found_posts; ?> 个结果</p>
        </div>
    </iv-card>
<?php } ?>
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