<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/18 - 19:02
 **/
$authors           = get_author_info();
$authorInfo        = get_user_meta($authors->ID);
$authorName        = get_option('smalls_setting_author_name') ? get_option('smalls_setting_author_name') : $authorInfo['nickname'][0];
$authorDescription = get_option('smalls_setting_author_desc') ? get_option('smalls_setting_author_desc') : strtoupper($authorInfo['description'][0]);
$authorPic         = get_option('smalls_setting_author_avatar') ? get_option('smalls_setting_author_avatar') : get_avatar_url($authors->user_email);
?>
<iv-card class="me-card-container" padding="0" :dis-hover="true" id="left-me-card">
    <img src="<?php echo $authorPic ?>" class="avatar" alt="<?php echo $authorName ?>的头像"/>
    <p class="name"><?php echo $authorName ?></p>
    <p class="desc"><?php echo $authorDescription ?></p>
    <div class="icon">
        <?php
        $github = get_option('smalls_setting_author_github');
        if ($github) { ?>
            <iv-tooltip content="<?php echo $authorName ?>的Github" placement="bottom">
                <a class="i-icon icon smalls-icon-github" href="<?php echo $github; ?>"
                   target="github"></a>
            </iv-tooltip>
        <?php } ?>
        <?php
        $csdn = get_option('smalls_setting_author_csdn');
        if ($csdn) { ?>
            <iv-tooltip content="<?php echo $authorName ?>的CSDN" placement="bottom">
                <a class="i-icon icon smalls-icon-csdn" href="<?php echo $csdn; ?>"
                   target="csdn"></a>
            </iv-tooltip>
        <?php } ?>
        <?php
        $zhihu = get_option('smalls_setting_author_zhihu');
        if ($zhihu) { ?>
            <iv-tooltip content="<?php echo $authorName ?>的知乎" placement="bottom">
                <a class="i-icon icon smalls-icon-zhihu" href="<?php echo $zhihu; ?>"
                   target="zhihu"></a>
            </iv-tooltip>
        <?php } ?>
        <?php
        $telegram = get_option('smalls_setting_author_telegram');
        if ($telegram) { ?>
            <iv-tooltip content="<?php echo $authorName ?>的Telegram" placement="bottom">
                <a class="i-icon icon smalls-icon-telegram" href="<?php echo $telegram; ?>"
                   target="telegram"></a>
            </iv-tooltip>
        <?php } ?>
    </div>
    <iv-divider></iv-divider>
    <h4>我的技能</h4>
    <div class="progress-container">
        <?php
        $skills = get_author_skill();
        if ($skills) {
            foreach ($skills as $key => $v) {
                if ($key == 4) {
                    echo '<div class="progress mt10"><p class="title">' . $v["name"] . '</p><iv-progress hide-info stroke-color="' . $v["type"] . '" percent="' . $v["percentage"] . '" class="bar"></iv-progress></div>';
                } else {
                    echo '<div class="progress mt10"><p class="title">' . $v["name"] . '</p><iv-progress hide-info status="' . $v["type"] . '" percent="' . $v["percentage"] . '" class="bar"></iv-progress></div>';
                }
            }
        }
        ?>
    </div>
</iv-card>
