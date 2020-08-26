<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/25 - 13:52
 **/

if (!have_posts()) {
    return;
}
the_post();
?>
<div id="index" class="index-container wp body-container">
    <div class="body-container">
        <div class="left smalls-width-4-24">
            <div class="layout">
                <?php get_customize_view('component/detail-left') ?>
            </div>
        </div>
        <div class="smalls-width-20-24">
            <div class="layout">
                <?php get_template_part('views/detail'); ?>
            </div>
        </div>
    </div>
</div>

