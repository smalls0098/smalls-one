<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/19 - 23:11
 **/
?>
<div id="index" class="index-container wp body-container">
    <div class="body-container">
        <div class="left smalls-width-4-24">
            <div class="layout">
                <?php get_customize_view('component/detail-left') ?>
            </div>
        </div>
        <div class="smalls-width-15-24">
            <div class="layout">
                <?php get_template_part('views/content', 'single'); ?>
            </div>
        </div>
        <div class="smalls-width-5-24">
            <div class="layout">
                <?php get_customize_view('hot-post') ?>
                <div class="mt20">
                    <?php get_customize_view('category') ?>
                </div>
                <div class="mt20">
                    <?php get_customize_view('label') ?>
                </div>
            </div>
        </div>
    </div>
</div>


