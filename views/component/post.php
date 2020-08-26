<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/25 - 21:31
 **/

function not_post_prompt()
{
    if (is_search()) {
        return '您搜索的关键词没有文章';
    } elseif (is_category()) {
        return '该分类没有文章';
    } elseif (is_tag()) {
        return '该标签没有文章';
    } elseif (is_page()) {
        return '没有自定义页面';
    } elseif (is_single()) {
        return '没有单页面';
    } else {
        return '不存在任何文章，非常抱歉';
    }
}


if (have_posts()) {
    if (is_category()) {
        $title = '分类文章';
    } elseif (is_search()) {
        $title = '搜索文章';
    } elseif (is_tag()) {
        $title = '标签文章';
    } else {
        $title = '最新文章';
    }
    ?>
    <div class="smalls-post post-module">
        <div class="divider smalls-text-center"><span><?php echo $title; ?></span></div>
        <ul class="smalls-post-list">
            <?php
            while (have_posts()) {
                the_post();
                get_template_part('views/post-item', get_post_format());
            }
            ?>
        </ul>
    </div>
<?php } else {
    echo '<p class="explanation error">' . not_post_prompt() . '</p>';
} ?>
