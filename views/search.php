<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/25 - 18:27
 **/

?>
<div id="index" class="index-container wp body-container">
    <div class="body-container">
        <div class="left smalls-width-4-24">
            <div class="layout">
                <?php get_customize_view('component/left') ?>
            </div>
        </div>
        <div class="smalls-width-15-24">
            <div class="layout">
                <?php get_customize_view('new-post') ?>
            </div>
        </div>
        <div class="smalls-width-5-24">
            <div class="layout">
                <?php get_customize_view('component/right') ?>
            </div>
        </div>
    </div>
</div>
