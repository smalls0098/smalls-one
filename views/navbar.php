<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/26 - 13:53
 **/

?>
<iv-card class="navbar-container" :dis-hover="true" padding="0">
    <div class="info-container">
        <ul>
            <li class="menu-item <?php echo is_home() ? 'current' : '' ?>"><a href="/"><i
                            class="ivu-icon ivu-icon-md-home"></i>首页</a></li>
            <li class="menu-item"><a href="/"><i class="ivu-icon ivu-icon-logo-github"></i>GITHUB</a></li>
            <li class="menu-item"><a href="/"><i class="ivu-icon ivu-icon-md-document"></i>日志</a></li>
            <li class="menu-item <?php echo is_archive() && is_month() ? 'current' : '' ?>"><a href="/"><i
                            class="ivu-icon ivu-icon-md-folder"></i>归档</a></li>
            <li class="menu-item"><a href="/"><i class="ivu-icon ivu-icon-ios-cog"></i>后台管理</a></li>
        </ul>
    </div>
</iv-card>
<iv-card class="tools-card-container" padding="0" :dis-hover="true" id="left-me-card">
    <div id="nav_menu-2" class="widget_nav_menu">
        <div class="menu-%e9%a6%96%e9%a1%b5-container">
            <ul id="menu-%e9%a6%96%e9%a1%b5" class="menu">
                <li id="menu-item-75"
                    class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-75">
                    <a href="http://127.0.0.1:8000/" aria-current="page"><i class="ivu-icon ivu-icon-logo-github"></i>首页</a>
                </li>
                <li id="menu-item-76" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-76"><a
                            href="http://127.0.0.1:8000/sample-page">示例页面</a></li>
                <li id="menu-item-77" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-77"><a
                            href="http://127.0.0.1:8000/privacy-policy">隐私政策</a></li>
            </ul>
        </div>
    </div>
</iv-card>


