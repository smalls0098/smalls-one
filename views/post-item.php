<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/19 - 19:01
 **/

$interceptCount = 175;

$thumbnailUrl = esc_url(get_the_post_thumbnail_url());
$output       = '';
if (!$thumbnailUrl) {
    $content = get_the_content();
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $images  = get_post_image($content);
    if ($images) {
        if (count($images) == 1) {
            $thumbnailUrl = $images[0];
            $interceptCount = 90;
        } else {
            foreach ($images as $v) {
                $output .= '<div class="smalls-item-pl-30"><img class="img" src="' . $v . '" alt="一张文章图片"/></div>';
            }
        }
    }
}

$title = the_title('<h2>', '</h2>', false);

if (get_option("argon_hide_shortcode_in_preview") == 'true') {
    $preview = wp_trim_words(do_shortcode(get_the_content()), $interceptCount, '[...]');
} else {
    $preview = wp_trim_words(get_the_content(), $interceptCount, '[...]');
}
if (post_password_required()) {
    $preview = "这篇文章受密码保护，输入正确的密码才能阅读，一般人我不会告诉你密码的！！";
}

if ($preview == "") {
    $preview = "这篇文章没有摘要";
}
if ($post->post_excerpt) {
    $preview = $post->post_excerpt;
}

//分类信息
list($cate, $cateTis) = get_smalls_categories();

$other = '<div class="info smalls-item-pl-30"><span class="mr10">' . $cate . '</span><time>' . get_post_metas('time') . '</time><div class="icon ml10"><span class="i-icon mr smalls-icon-hot"></span><span class="text">' . get_post_metas('views') . '热度</span></div><div class="icon ml10"><span class="i-icon mr smalls-icon-comment"></span><span class="text">' . get_post_metas('comments') . '评论</span></div></div>';

?>

<li class="smalls-item smalls-grid-match" id="post-<?php the_ID(); ?>">

    <?php if ($thumbnailUrl) { ?>
        <div class="smalls-width-2-3 smalls-flex smalls-flex-column">
            <a href="<?php the_permalink(); ?>">
                <div class="smalls-item-content smalls-item-pl-30">
                    <?php echo $title ?>
                    <p><?php echo $preview ?></p>
                </div>
            </a>
        </div>
        <div class="smalls-width-1-3 smalls-item-images">
            <div class="smalls-child-width-1-1 images">
                <div class="single-image pl-30">
                    <img class="img smalls-flex-column"
                         src="<?php echo $thumbnailUrl ?>"
                         alt="<?php the_post_thumbnail_caption() ?>"/>
                </div>
            </div>
        </div>
        <div class="smalls-item-info">
            <?php echo $other ?>
        </div>
    <?php } else { ?>
        <div class="smalls-width-1-1 smalls-item-content smalls-item-pl-30">
            <a href="<?php the_permalink(); ?>">
                <?php echo $title ?>
                <p><?php echo $preview ?></p>
            </a>
        </div>
        <div class="smalls-width-1-1 smalls-item-images">
            <div class="smalls-child-width smalls-child-width-1-3 images">
                <?php echo $output ?>
            </div>
        </div>
        <div class="smalls-item-info smalls-width-1-1">
            <?php echo $other ?>
        </div>
    <?php } ?>
</li>
