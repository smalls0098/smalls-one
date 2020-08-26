<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/18 - 21:50
 **/

$tags   = get_tags('title_li=&orderby=name&hide_empty=0');
$output = '';
$colors = ['success', 'default', 'primary', 'error', 'warning', '#FFA2D3', 'purple', 'geekblue', 'blue', 'cyan', 'green', 'lime', 'yellow', 'gold', 'orange'];
$i      = 0;
if ($tags) {
    foreach ($tags as $c) {
        $color = 'default';
        if ($colors) {
            $color = $colors[$i];
        }
        $output .= '<a href="' . get_category_link($c->term_id) . '"><iv-tag color="' . $color . '" class="tag">' . $c->name . '(' . $c->count . ')</iv-tag></a>';
        $i >= count($colors) ? $i = 0 : $i++;
    }
}
?>
<iv-card class="category-list-container" :dis-hover="true" padding="0">
    <p class="title">我的标签</p>
    <iv-divider class="line"></iv-divider>
    <div class="info-container">
        <?php echo $output ?>
    </div>
</iv-card>
