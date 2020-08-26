<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/25 - 21:30
 **/
$data = get_option('smalls_setting_banner');
$datas = explode('&&&', $data);
$res  = [];
foreach ($datas as $value) {
    $value = explode('||', $value);
    $res[] = $value;
}
?>
<div class="smalls-post">
    <?php if ($data) { ?>
        <iv-carousel class="smalls-width-1-1 smalls-text-center" loop autoplay height="auto" dots="outside"
                     autoplay-speed="3000">
            <?php
            foreach ($res as $v) {
                echo '<iv-carousel-item>
            <a href="' . (isset($v[2]) ? $v[2] : "") . '" target="' . (isset($v[3]) ? ($v[3] == "1" ? "_blank" : '') : "") . '">
                <div class="smalls-carousel">
                    <img class="img" src="' . (isset($v[0]) ? $v[0] : "") . '"
                         alt="' . (isset($v[1]) ? $v[1] : "") . '"/>
                </div>
            </a>
        </iv-carousel-item>';
            }
            ?>
        </iv-carousel>
    <?php } ?>
</div>
