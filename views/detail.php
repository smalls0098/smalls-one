<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/20 - 10:07
 **/

$author = get_post_metas('author');
smalls_set_post_views();

//分类信息
list($cate, $cateTis) = get_smalls_categories();
?>

<iv-card class="detail-card-container" :dis-hover="true" padding="0" id="post-<?php the_ID(); ?>">
    <div class="detail-container">
        <div class="title"><?php the_title(); ?></div>
        <?php if (!is_page()) { ?>
            <div class="detail">
                <div class="component">
                    <div class="icon">
                        <iv-tooltip content="作者是<?php echo $author ?>，你有什么意见吗" placement="bottom">
                            <a class="i-icon image smalls-icon-me"></a>
                            <a><?php echo $author ?></a>
                        </iv-tooltip>
                    </div>
                </div>
                <iv-divider type="vertical" class="detail-line"></iv-divider>
                <div class="component">
                    <div class="icon">
                        <iv-tooltip content="这是来<?php echo $cateTis ?>"
                                    placement="bottom">
                            <a class="i-icon image smalls-icon-category"></a>
                            <a><?php echo $cate ?></a>
                        </iv-tooltip>
                    </div>
                </div>
                <iv-divider type="vertical" class="detail-line"></iv-divider>
                <div class="component">
                    <div class="icon">
                        <a class="i-icon image smalls-icon-time"></a>
                        <a><?php echo get_the_time('Y-n-d') ?></a>
                    </div>
                </div>
                <iv-divider type="vertical" class="detail-line"></iv-divider>
                <div class="component">
                    <div class="icon">
                        <a class="i-icon image smalls-icon-hot"></a>
                        <a><?php echo smalls_get_post_views() ?>热度</a>
                    </div>
                </div>
                <iv-divider type="vertical" class="detail-line"></iv-divider>
                <div class="component">
                    <div class="icon">
                        <a class="i-icon image smalls-icon-comment"></a>
                        <a><?php echo get_post_metas('comments') ?>评论</a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <iv-divider></iv-divider>
        <div class="smalls-content" id="smalls-content">
            <?php if (post_password_required()) { ?>
                <form action="/wp-login.php?action=postpass" class="post-password-form" method="post">
                    <div class="smalls-text-center">
                        <h2>这是一篇受密码保护的文章，您需要提供访问密码</h2>
                        <iv-input class="smalls-width-1-2 mt20" type="password" name="post_password" password
                                  placeholder="请输入密码"></iv-input>
                        <div class="mt20">
                            <iv-button class="smalls-width-1-2" html-type="submit" type="primary">确定</iv-button>
                        </div>
                    </div>
                </form>
            <?php } else {
                the_content();
            }
            ?>
        </div>
    </div>
    <?php
    echo is_page() ? '' : '<div class="reward"><iv-button icon="logo-usd" shape="circle" @click="onReward">给作者打赏一下吧</iv-button></div>';
    ?>
    <?php if (is_singular('post')) {
        if (get_previous_post() || get_next_post()) {
            echo '<iv-divider class="context-divider"></iv-divider><div class="context">';
            if (get_previous_post()) {
                echo '<div class="smalls-width-1-2">';
                previous_post_link('%link', '<span>上一篇：</span><div>%title</div>');;
                echo '</div>';
            } else {
                echo '<div class="smalls-width-1-2"></div>';
            }
            if (get_next_post()) {
                echo '<div class="smalls-width-1-2">';
                next_post_link('%link', '<span>下一篇：</span><div>%title</div>');;
                echo '</div>';
            } else {
                echo '<div class="smalls-width-1-2"></div>';
            }
            echo '</div>';
        }
    } ?>
</iv-card>
