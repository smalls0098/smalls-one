<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/26 - 17:13
 **/

/*侧栏上部菜单*/

class lefterMenuWalker extends Walker_Nav_Menu
{
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"leftbar-menu-item leftbar-menu-subitem shadow-sm\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent</ul>\n";
    }

    public function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
    {

        $target = $object->target == '' ? '' : ' target=' . $object->target;
        $output .= "<li class='menu-item" . ($object->current == 1 ? " current" : "") . "'><a href='" . $object->url . "'{$target}>" . $object->post_excerpt . $object->title . "</a>";
    }

    public function end_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
    {
        if ($depth == 0) {
            $output .= "</li>";
        }
    }
}

echo '<iv-card class="tools-card-container" padding="0" :dis-hover="true" id="left-me-card">';
echo '<div class="widget_nav_menu">';
echo "<ul id='left-bar-menu' class='menu'>";
if (has_nav_menu('leftbar_menu')) {
    wp_nav_menu(array(
        'container'      => '',
        'theme_location' => 'leftbar_menu',
        'items_wrap'     => '%3$s',
        'depth'          => 0,
        'walker'         => new lefterMenuWalker()
    ));
}
echo "</ul></div></iv-card>";
?>
