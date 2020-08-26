<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/25 - 21:28
 **/
?>
<div class="page">
    <?php
    if ($GLOBALS['isShowPage']) {
        echo get_smalls_paginate_data(5);
    }
    ?>
</div>