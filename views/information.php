<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/25 - 21:38
 **/
?>
<iv-card class="information-container" :dis-hover="true" padding="0">
    <div class="card-body">
        <h3><?php echo get_search_query();?></h3>
        <p class="text">的搜索结果</p>
        <p class="count"><i class="ivu-icon ivu-icon-md-send"></i> <?php global $wp_query; echo $wp_query -> found_posts; ?> 个结果</p>
    </div>
</iv-card>