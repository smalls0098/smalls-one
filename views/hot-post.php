<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/18 - 22:56
 **/

$dateQuery = [
    [
        'column' => 'post_date',
        'before' => date('Y-m-d', time() + 86400),
        'after'  => date('Y-m-d', time() - 86400 * 30)   //此处30修改天数，代表提取最近30天的文章
    ]
];

$args = [
    'posts_per_page' => 5,  //提取文章数量
    'date_query'     => $dateQuery,  //引用上面时间段的分类
    'meta_key'       => 'views',   //根据浏览数量
    'orderby'        => 'meta_value_num',  //排序规则
    'post_status'    => 'publish',
];
?>

<iv-card class="hot-post-card-container" :dis-hover="true" padding="0">
    <p class="title">热门文章</p>
    <iv-divider class="line"></iv-divider>
    <div class="info-container">
        <?php
        query_posts($args);
        while (have_posts()) {
            the_post();
            echo '<a href="' . get_the_permalink() . '"><p>' . get_the_title() . '</p></a>';
        }
        wp_reset_query();
        ?>
    </div>
</iv-card>