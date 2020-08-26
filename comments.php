<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/21 - 16:35
 **/
if (post_password_required()) {
    return;
}

//是否登录
$isLogin = is_user_logged_in();
//获取管理员用户信息
$adminUserInfo = wp_get_current_user();
//获取当前评论信息
$currentCommenter = wp_get_current_commenter();
//参数
$nickname = $isLogin ? ($adminUserInfo->exists() ? $adminUserInfo->display_name : '') : htmlspecialchars($currentCommenter['comment_author']);
$email    = $isLogin ? ($adminUserInfo->exists() ? $adminUserInfo->user_email : '') : htmlspecialchars($currentCommenter['comment_author_email']);
$webUrl   = $isLogin ? site_url() : htmlspecialchars($currentCommenter['comment_author_url']);

if ($isLogin) {
    $loginLogout = '<i>已登录 ' . ($adminUserInfo->exists() ? $adminUserInfo->display_name : '') . ',<a href="' . wp_logout_url(apply_filters('the_permalink', get_permalink(), '')) . '">注销?</a></i>';
} else {
    $loginLogout = '';
}

list($prev, $next) = get_smalls_comment_paginate_links();
?>
<iv-card class="comment-card-container" :dis-hover="true" padding="0">
    <div class="comment-container" id="comments">
        <p class="title">文章评论</p>
        <iv-divider class="comment-line"></iv-divider>
        <div class="comment">
            <?php if (have_comments()) {
                wp_list_comments(
                    array(
                        'avatar_size'       => 35,
                        'style'             => 'div',
                        'type'              => 'comment',
                        'callback'          => 'smalls_comment_list',
                        'reverse_top_level' => get_option('comment_order') == 'desc',
                        'short_ping'        => true
                    )
                );
            } else { ?>
                <div class="no-comment smalls-text-center mt50">
                    <i class="ivu-icon ivu-icon-ios-alert-outline"></i>
                    <span>暂无评论</span>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php if ($next != NULL || $prev != NULL) { ?>
        <iv-divider class="context-divider"></iv-divider>
        <div class="context">
            <div class="smalls-width-1-2">
                <?php if ($prev != NULL) { ?>
                    <a href="<?php echo $prev ?>">
                        <div>上一页</div>
                    </a>
                <?php } ?>
            </div>
            <div class="smalls-width-1-2">
                <?php if ($next != NULL) { ?>
                    <a href="<?php echo $next ?>">
                        <div>下一页</div>
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</iv-card>
<iv-card class="reply-card-container" :dis-hover="true" :padding="0" id="comments-reply">
    <div class="reply-container">
        <i class="i-icon mr smalls-icon-commenting"></i>
        <i class="mr10">留言板</i>
        <?php echo $loginLogout ?>
    </div>
    <div id="comment-reply-info" class="mb10" style="display: none;">
        <span>正在回复<span id="comment-reply-nickname" style="font-weight: bold; color: #57a3f3">SMALLS</span>的评论</span>
        <div class="line-comment-item ivu-divider ivu-divider-vertical ivu-divider-default"></div>
        <span id="comment-reply-cancel" @click="onReplyCancel">取消回复</span>
    </div>
    <div class="input-container">
        <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) { ?>
            <i>本文章已经关闭评论</i>
        <?php } else { ?>
            <input id="post-comment-post-id" value="<?php the_ID(); ?>" style="display: none;"/>
            <iv-input maxlength="1000" :rows="5" show-word-limit type="textarea" v-model="content"
                      placeholder="客官来都来了，怎么不留个名纪念一下呢~\(≧▽≦)/~"></iv-input>
            <div class="info-container smalls-width-1-1">
                <div class="smalls-child-width smalls-width-1-3 input">
                    <iv-input class="nickname" size="large" type="text" placeholder="您的网名(必须)"
                              data-nickname="<?php echo $nickname ?>"
                              v-model="nickname">
                        <i slot="prefix" class="i-icon smalls-icon-nickname"></i>
                    </iv-input>
                </div>
                <div class="smalls-child-width smalls-width-1-3 input">
                    <iv-input class="email" size="large" type="email" placeholder="您的邮箱(必须)" v-model="email"
                              data-email="<?php echo $email ?>">
                        <i slot="prefix" class="i-icon smalls-icon-email"></i>
                    </iv-input>
                </div>
                <div class="smalls-child-width smalls-width-1-3 input">
                    <iv-input class="web-url" size="large" type="url" placeholder="您的网站(选填)"
                              data-url="<?php echo $webUrl ?>"
                              v-model="webUrl">
                        <i slot="prefix" class="i-icon smalls-icon-diannao"></i>
                    </iv-input>
                </div>
            </div>
            <div class="smalls-width-1-1 sub">
                <iv-button type="primary" size="large" class="btn" @click="onSubComment">评论</iv-button>
            </div>
        <?php } ?>
    </div>
</iv-card>