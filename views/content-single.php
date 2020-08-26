<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/20 - 11:02
 **/

while (have_posts()) {
    the_post();
    get_template_part('views/detail');
    comments_template();
}