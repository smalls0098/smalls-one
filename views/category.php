<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/18 - 21:50
 **/

class Category
{

    private $categories;

    public function __construct()
    {
        $this->categories = get_categories('title_li=&orderby=name&hide_empty=0');
    }

    public function getHtmlCategory()
    {
        $output = '';
        $colors = ['success', 'default', 'primary', 'error', 'warning'];
        $i      = 0;
        if ($this->categories) {
            foreach ($this->categories as $c) {
                $color = 'default';
                if ($colors) {
                    $color = $colors[$i];
                }
                $output .= '<a href="' . get_category_link($c->term_id) . '"><iv-tag type="dot" color="' . $color . '" class="tag">' . $c->cat_name . '(' . $c->count . ')' . '</iv-tag></a>';
                $i >= count($colors) ? $i = 0 : $i++;
            }
        }
        return $output;
    }
}

$category = (new Category())->getHtmlCategory();
?>
<iv-card class="category-list-container" :dis-hover="true" padding="0">
    <p class="title">我的分类</p>
    <iv-divider class="line"></iv-divider>
    <div class="info-container">
        <?php echo $category ?>
    </div>
</iv-card>
