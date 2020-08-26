<?php
/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/24 - 20:45
 **/

add_action('admin_menu', 'theme_options_admin_menu');

//主题选项页面
function theme_options_admin_menu()
{
    /*后台管理面板侧栏添加选项*/
    add_menu_page("SOne 主题设置", "SOne 主题选项", 'edit_themes', basename(__FILE__), 'theme_options_view');
}

function smalls_update_theme_options()
{
    if ($_POST['update_theme_options'] == 'true') {
        if (!isset($_POST['smalls_update_theme_options_nonce'])) {
            return;
        }
        $nonce = $_POST['smalls_update_theme_options_nonce'];
        if (!wp_verify_nonce($nonce, 'smalls_update_theme_options')) {
            return;
        }
        unset($_POST['smalls_update_theme_options_nonce']);
        unset($_POST['update_theme_options']);
        foreach ($_POST as $key => $v) {
            $origin = ['smalls_setting_announcement', 'smalls_setting_seo_description', 'smalls_setting_custom_html_head', 'smalls_setting_custom_html_foot'];
            $judge  = ['smalls_setting_comment_need_captcha', 'smalls_setting_enable_login_css', 'smalls_setting_assets_cdn', 'smalls_setting_banner'];
            if (in_array($key, $origin)) {
                update_option($key, stripslashes($v));
            } elseif (in_array($key, $judge)) {
                update_option($key, $v);
            } else {
                update_option($key, htmlspecialchars(stripslashes($v)));
            }
        }
    }
}

smalls_update_theme_options();

function theme_options_view()
{
    /*具体选项*/
    ?>
    <script src="<?php echo $GLOBALS['smallsJSDir']; ?>jquery.min.js"></script>
    <script src="<?php echo $GLOBALS['smallsJSDir']; ?>headindex.js"></script>
    <script src="<?php echo $GLOBALS['smallsJSDir']; ?>dragula.js"></script>
    <div>
        <style type="text/css">
            h2 {
                font-size: 25px;
            }

            h2:before {
                content: '';
                background: #000;
                height: 16px;
                width: 6px;
                display: inline-block;
                border-radius: 15px;
                margin-right: 15px;
            }

            h3 {
                font-size: 18px;
            }

            th.subtitle {
                padding: 0;
            }

            .gu-mirror {
                position: fixed !important;
                margin: 0 !important;
                z-index: 9999 !important;
                opacity: .8;
                -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
                filter: alpha(opacity=80)
            }

            .gu-hide {
                display: none !important
            }

            .gu-unselectable {
                -webkit-user-select: none !important;
                -moz-user-select: none !important;
                -ms-user-select: none !important;
                user-select: none !important
            }

            .gu-transit {
                opacity: .2;
                -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)";
                filter: alpha(opacity=20)
            }
        </style>
        <h1 style="color: #57a3f3; margin-top: 50px">SmallsOne 主题设置</h1>
        <p>按下 <kbd style="font-family: sans-serif;">Ctrl + F</kbd> 或在右侧目录中来查找设置</p>
        <form method="POST" action="" id="main_form">
            <input type="hidden" name="update_theme_options" value="true"/>
            <?php wp_nonce_field("smalls_update_theme_options", "smalls_update_theme_options_nonce"); ?>
            <table class="form-table">
                <tbody>
                <tr>
                    <th class="subtitle"><h3>子目录</h3></th>
                </tr>
                <tr>
                    <th><label>Wordpress 安装目录</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_wp_path"
                               value="<?php echo(get_option('smalls_setting_wp_path') == '' ? '/' : get_option('smalls_setting_wp_path')); ?>"/>
                        <p class="description">如果 Wordpress 安装在子目录中，请在此填写子目录地址（例如 <code>/blog/</code>），注意前后各有一个斜杠。默认为
                            <code>/</code>。</br>如果不清楚该选项的用处，请保持默认。</p>
                    </td>
                </tr>
                <tr>
                    <th class="subtitle"><h2>顶栏</h2></th>
                </tr>
                <tr>
                    <th class="subtitle"><h3>标题</h3></th>
                </tr>
                <tr>
                    <th><label>顶栏标题</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_toolbar_title"
                               value="<?php echo get_option('smalls_setting_toolbar_title'); ?>"/></p>
                        <p class="description">留空则显示博客名称</p>
                    </td>
                </tr>
                <tr>
                    <th><label>顶栏副标题</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_toolbar_motto"
                               value="<?php echo get_option('smalls_setting_toolbar_motto'); ?>"/></p>
                        <p class="description">留空则显示博客副名称</p>
                    </td>
                </tr>
                <tr>
                    <th><label>图标地址</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_toolbar_icon"
                               value="<?php echo get_option('smalls_setting_toolbar_icon'); ?>"/>
                        <p class="description">图片地址，留空则不显示</p>
                    </td>
                </tr>
                <tr>
                    <th class="subtitle"><h2>我的卡片</h2></th>
                </tr>
                <tr>
                    <th class="subtitle"><h3>我的信息</h3></th>
                </tr>
                <tr>
                    <th><label>作者名称</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_name"
                               value="<?php echo get_option('smalls_setting_author_name'); ?>"/>
                        <p class="description">介绍一下自己（留空则管理员昵称）</p>
                    </td>
                </tr>
                <tr>
                    <th><label>作者介绍</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_desc"
                               value="<?php echo get_option('smalls_setting_author_desc'); ?>"/>
                        <p class="description">介绍一下自己</p>
                    </td>
                </tr>
                <tr>
                    <th><label>头像地址</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_avatar"
                               value="<?php echo get_option('smalls_setting_author_avatar'); ?>"/>
                        <p class="description">需带上 http(s) 开头</p>
                    </td>
                </tr>
                <tr>
                    <th><label>github地址</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_github"
                               value="<?php echo get_option('smalls_setting_author_github'); ?>"/>
                        <p class="description">需带上 http(s) 开头(留空则隐藏)</p>
                    </td>
                </tr>
                <tr>
                    <th><label>csdn地址</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_csdn"
                               value="<?php echo get_option('smalls_setting_author_csdn'); ?>"/>
                        <p class="description">需带上 http(s) 开头(留空则隐藏)</p>
                    </td>
                </tr>
                <tr>
                    <th><label>知乎地址</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_zhihu"
                               value="<?php echo get_option('smalls_setting_author_zhihu'); ?>"/>
                        <p class="description">需带上 http(s) 开头(留空则隐藏)</p>
                    </td>
                </tr>
                <tr>
                    <th><label>telegram地址</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_telegram"
                               value="<?php echo get_option('smalls_setting_author_telegram'); ?>"/>
                        <p class="description">需带上 http(s) 开头(留空则隐藏)</p>
                    </td>
                </tr>
                <tr>
                    <th class="subtitle"><h3>我的技能（最多5个）</h3></th>
                </tr>
                <tr>
                    <th><label>技能1</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_skill_1"
                               value="<?php echo get_option('smalls_setting_author_skill_1'); ?>"/>
                        <p class="description">格式：技能:百分比（比如：PHP:50）(留空则隐藏)</p>
                    </td>
                </tr>
                <tr>
                    <th><label>技能2</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_skill_2"
                               value="<?php echo get_option('smalls_setting_author_skill_2'); ?>"/>
                        <p class="description">格式：技能:百分比（比如：PHP:50）(留空则隐藏)</p>
                    </td>
                </tr>
                <tr>
                    <th><label>技能3</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_skill_3"
                               value="<?php echo get_option('smalls_setting_author_skill_3'); ?>"/>
                        <p class="description">格式：技能:百分比（比如：PHP:50）(留空则隐藏)</p>
                    </td>
                </tr>
                <tr>
                    <th><label>技能4</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_skill_4"
                               value="<?php echo get_option('smalls_setting_author_skill_4'); ?>"/>
                        <p class="description">格式：技能:百分比（比如：PHP:50）(留空则隐藏)</p>
                    </td>
                </tr>
                <tr>
                    <th><label>技能5</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_author_skill_5"
                               value="<?php echo get_option('smalls_setting_author_skill_5'); ?>"/>
                        <p class="description">格式：技能:百分比（比如：PHP:50）(留空则隐藏)</p>
                    </td>
                </tr>
                <tr>
                    <th class="subtitle"><h2>博客公告</h2></th>
                </tr>
                <tr>
                    <th><label>公告内容</label></th>
                    <td>
                        <textarea type="text" rows="5" cols="50"
                                  name="smalls_setting_announcement"><?php echo htmlspecialchars(get_option('smalls_setting_announcement')); ?></textarea>
                        <p class="description">显示在左侧栏顶部，留空则不显示，支持 HTML 标签</p>
                    </td>
                </tr>
                <tr>
                    <th class="subtitle"><h2>SEO</h2></th>
                </tr>
                <tr>
                    <th><label>网站描述 (Description Meta 标签)</label></th>
                    <td>
                        <textarea type="text" rows="5" cols="100"
                                  name="smalls_setting_seo_description"><?php echo htmlspecialchars(get_option('smalls_setting_seo_description')); ?></textarea>
                        <p class="description">设置针对搜索引擎的 Description Meta 标签内容。</br>在文章中，Samlls
                            会自动根据文章内容生成描述。在其他页面中，smalls 将使用这里设置的内容。如不填，smalls 将不会在其他页面输出 Description Meta 标签。</p>
                    </td>
                </tr>
                <tr>
                    <th><label>搜索引擎关键词（Keywords Meta 标签）</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_seo_keywords"
                               value="<?php echo get_option('smalls_setting_seo_keywords'); ?>"/>
                        <p class="description">设置针对搜索引擎使用的关键词（Keywords Meta 标签内容）。用英文逗号隔开。不设置则不输出该 Meta 标签。</p>
                    </td>
                </tr>
                <tr>
                    <th class="subtitle"><h3>赞赏</h3></th>
                </tr>
                <tr>
                    <th><label>赞赏二维码图片链接</label></th>
                    <td>
                        <input type="text" class="regular-text" name="smalls_setting_donate_qrcode_url"
                               value="<?php echo get_option('smalls_setting_donate_qrcode_url'); ?>"/>
                        <p class="description">赞赏二维码图片链接，填写后会在文章最后显示赞赏按钮，留空则不显示赞赏按钮</p>
                    </td>
                </tr>
                <tr>
                    <th class="subtitle"><h2>页脚</h2></th>
                </tr>
                <tr>
                    <th><label>页头脚本</label></th>
                    <td>
                        <textarea type="text" rows="15" cols="100"
                                  name="smalls_setting_custom_html_head"><?php echo htmlspecialchars(get_option('smalls_setting_custom_html_head')); ?></textarea>
                        <p class="description">HTML , 支持 script 等标签</br>插入到 body 之前</p>
                    </td>
                </tr>
                <tr>
                    <th><label>页尾脚本</label></th>
                    <td>
                        <textarea type="text" rows="15" cols="100"
                                  name="smalls_setting_custom_html_foot"><?php echo htmlspecialchars(get_option('smalls_setting_custom_html_foot')); ?></textarea>
                        <p class="description">HTML , 支持 script 等标签</br>插入到 body 之后</p>
                    </td>
                </tr>
                <tr>
                    <th class="subtitle"><h2>美化和验证</h2></th>
                </tr>
                <tr>
                    <th><label>评论是否需要验证码</label></th>
                    <td>
                        <select name="smalls_setting_comment_need_captcha">
                            <?php $smalls_setting_comment_need_captcha = get_option('smalls_setting_comment_need_captcha'); ?>
                            <option value="true" <?php if ($smalls_setting_comment_need_captcha == 'true') {
                                echo 'selected';
                            } ?>>需要
                            </option>
                            <option value="false" <?php if ($smalls_setting_comment_need_captcha == 'false') {
                                echo 'selected';
                            } ?>>不需要
                            </option>
                        </select>
                        <p class="description"></p>
                    </td>
                </tr>
                <tr>
                    <th><label>美化登录界面</label></th>
                    <td>
                        <select name="smalls_setting_enable_login_css">
                            <?php $smalls_setting_enable_login_css = get_option('smalls_setting_enable_login_css'); ?>
                            <option value="false" <?php if ($smalls_setting_enable_login_css == 'false') {
                                echo 'selected';
                            } ?>>不启用
                            </option>
                            <option value="true" <?php if ($smalls_setting_enable_login_css == 'true') {
                                echo 'selected';
                            } ?>>启用
                            </option>
                        </select>
                        <p class="description">使用 Smalls Design 风格的登录界面</p>
                    </td>
                </tr>
                <tr>
                    <th class="subtitle"><h2>其他功能</h2></th>
                </tr>
                <tr>
                    <th><label>矫正时区</label></th>
                    <td>
                        <select name="smalls_setting_enable_timezone_fix">
                            <?php $smalls_setting_enable_timezone_fix = get_option('smalls_setting_enable_timezone_fix'); ?>
                            <option value="false" <?php if ($smalls_setting_enable_timezone_fix == 'false') {
                                echo 'selected';
                            } ?>>不启用
                            </option>
                            <option value="true" <?php if ($smalls_setting_enable_timezone_fix == 'true') {
                                echo 'selected';
                            } ?>>启用
                            </option>
                        </select>
                        <p class="description">如果发现时间不正确可以使用矫正试试（UTC）</p>
                    </td>
                </tr>
                <tr>
                    <th><label>使用cdn加速</label></th>
                    <td>
                        <select name="smalls_setting_assets_cdn">
                            <?php $smalls_setting_assets_cdn = get_option('smalls_setting_assets_cdn'); ?>
                            <option value="me" <?php if ($smalls_setting_assets_cdn == 'me') {
                                echo 'selected';
                            } ?>>自带
                            </option>
                            <option value="bootcdn" <?php if ($smalls_setting_assets_cdn == 'bootcdn') {
                                echo 'selected';
                            } ?>>bootcdn
                            </option>
                            <option value="unpkg" <?php if ($smalls_setting_assets_cdn == 'unpkg') {
                                echo 'selected';
                            } ?>>unpkg
                            </option>
                            <option value="unpkg.zhimg.com" <?php if ($smalls_setting_assets_cdn == 'unpkg.zhimg.com') {
                                echo 'selected';
                            } ?>>unpkg.zhimg.com
                            </option>
                            <option value="jsDelivr" <?php if ($smalls_setting_assets_cdn == 'jsDelivr') {
                                echo 'selected';
                            } ?>>jsDelivr
                            </option>
                        </select>
                        <p class="description">设置cdn加速，可以减少服务器的压力（自带js逻辑判断不会使用cdn）</p>
                    </td>
                </tr>
                <tr>
                    <th class="subtitle"><h2>跑马灯（banner）</h2></th>
                </tr>
                <tr>
                    <th><label>跑马灯数据</label></th>
                    <td>
                        <textarea type="text" rows="15" cols="100"
                                  name="smalls_setting_banner"><?php echo htmlspecialchars(get_option('smalls_setting_banner')); ?></textarea>
                        <p class="description">（数据格式一定要是json数据）</p>
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="保存更改">
                <a class="button button-secondary" style="margin-left: 8px;" onclick="importSettings()">导入设置</a>
                <a class="button button-secondary" style="margin-left: 5px;" onclick="exportSettings()">导出设置</a>
            </p>
        </form>
    </div>
    <div id="headindex_box">
        <button id="headindex_toggler" onclick="$('#headindex_box').toggleClass('folded');">收起</button>
        <div id="headindex"></div>
    </div>
    <div id="exported_settings_json_box" class="closed">
        <div>请复制并保存导出后的 JSON</div>
        <textarea id="exported_settings_json" readonly="true" onclick="$(this).select();"></textarea>
        <div style="width: 100%;margin: auto;margin-top: 15px;cursor: pointer;user-select: none;"
             onclick="$('#exported_settings_json_box').addClass('closed');">关闭
        </div>
    </div>
    <style>
        .radio-with-img {
            display: inline-block;
            margin-right: 15px;
            text-align: center;
        }

        .radio-with-img > .radio-img {
            cursor: pointer;
        }

        .radio-with-img > label {
            display: inline-block;
            margin-top: 10px;
        }

        .radio-h {
            padding-bottom: 10px;
        }

        .radio-h > label {
            margin-right: 15px;
        }

        #headindex {
            margin-right: 20px;
        }

        #headindex_box {
            position: fixed;
            right: 10px;
            top: 50px;
            max-width: 180px;
            max-height: calc(100vh - 100px);
            opacity: .8;
            transition: all .3s ease;
            background: #fff;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
            padding: 6px 30px 6px 20px;
            overflow-y: auto;
        }

        .index-subItem-box {
            margin-left: 20px;
            margin-top: 10px;
        }

        .index-link {
            color: #23282d;
            text-decoration: unset;
            transition: all .3s ease;
            box-shadow: none !important;
        }

        .index-item {
            padding: 1px 0;
        }

        .index-item.current > a {
            color: #0073aa;
            font-weight: 600;
            box-shadow: none !important;
        }

        #headindex_toggler {
            position: absolute;
            right: 5px;
            top: 5px;
            color: #555;
            background: #f7f7f7;
            box-shadow: 0 1px 0 #ccc;
            outline: none !important;
            border: 1px solid #ccc;
            border-radius: 2px;
            cursor: pointer;
            width: 40px;
            height: 25px;
            font-size: 12px;
        }

        #headindex_box.folded {
            right: -185px;
        }

        #headindex_box.folded #headindex_toggler {
            position: fixed;
            right: 15px;
            top: 55px;
            font-size: 0px;
        }

        #headindex_box.folded #headindex_toggler:before {
            content: '展开';
            font-size: 12px;
        }

        @media screen and (max-width: 960px) {
            #headindex_box {
                display: none;
            }
        }

        #exported_settings_json_box {
            position: fixed;
            z-index: 99999;
            left: calc(50vw - 400px);
            right: calc(50vw - 400px);
            top: 50px;
            width: 800px;
            height: 500px;
            max-width: 100vw;
            max-height: calc(100vh - 50px);
            background: #fff;
            padding: 25px;
            border-radius: 5px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
            text-align: center;
            font-size: 20px;
            transition: all .3s ease;
        }

        #exported_settings_json {
            width: 100%;
            height: calc(100% - 70px);
            margin-top: 25px;
            font-size: 18px;
            background: #fff;
            resize: none;
        }

        #exported_settings_json::selection {
            background: #cce2ff;
        }

        #exported_settings_json_box.closed {
            transform: translateY(-30px) scale(.9);
            opacity: 0;
            pointer-events: none;
        }

        @media screen and (max-width: 800px) {
            #exported_settings_json_box {
                left: 0;
                right: 0;
                top: 0;
                width: calc(100vw - 50px);
            }
        }

        .form-table > tbody > tr:first-child > th {
            padding-top: 0 !important;
        }

        .form-table.form-table-dense > tbody > tr > th {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .form-table-mathrender > tbody > tr > th > label > div {
            margin-top: 10px;
            padding-left: 24px;
            opacity: .75;
            transition: all .3s ease;
        }

        .form-table-mathrender > tbody > tr > th > label:hover > div {
            opacity: 1;
        }

        .form-table-mathrender > tbody > tr > th > label > input:not(:checked) + div {
            display: none;
        }
    </style>
    <script type="text/javascript">
        $(document).on("click", ".radio-with-img .radio-img", function () {
            $("input", this.parentNode).click();
        });
        $(function () {
            $(document).headIndex({
                articleWrapSelector: '#main_form',
                indexBoxSelector: '#headindex',
                subItemBoxClass: "index-subItem-box",
                itemClass: "index-item",
                linkClass: "index-link",
                offset: 80,
            });
        });

        function setInputValue(name, value) {
            let input = $("*[name='" + name + "']");
            let inputType = input.attr("type");
            if (inputType == "checkbox") {
                if (value == "true") {
                    value = true;
                } else if (value == "false") {
                    value = false;
                }
                input[0].checked = value;
            } else if (inputType == "radio") {
                $("input[name='" + name + "'][value='" + value + "']").click();
            } else {
                input.val(value);
            }
        }

        function getInputValue(input) {
            let inputType = input.attr("type");
            if (inputType == "checkbox") {
                return input[0].checked;
            } else if (inputType == "radio") {
                let name = input.attr("name");
                let value;
                $("input[name='" + name + "']").each(function () {
                    if (this.checked) {
                        value = $(this).attr("value");
                    }
                });
                return value;
            } else {
                return input.val();
            }
        }

        function exportSmallsSettings() {
            let json = {};
            let pushIntoJson = function () {
                name = $(this).attr("name");
                value = getInputValue($(this));
                json[name] = value;
            };
            $("#main_form > .form-table input:not([name='submit']) , #main_form > .form-table select , #main_form > .form-table textarea").each(function () {
                name = $(this).attr("name");
                value = getInputValue($(this));
                json[name] = value;
            });
            return JSON.stringify(json);
        }

        function importSmallsSettings(json) {
            if (typeof (json) == "string") {
                json = JSON.parse(json);
            }
            let info = "";
            for (let name in json) {
                try {
                    if ($("*[name='" + name + "']").length == 0) {
                        throw "Input Not Found";
                    }
                    setInputValue(name, json[name]);
                } catch {
                    info += name + " 字段导入失败\n";
                }
            }
            return info;
        }

        function exportSettings() {
            $("#exported_settings_json").val(exportSmallsSettings());
            $("#exported_settings_json").select();
            $("#exported_settings_json_box").removeClass("closed");
        }

        function importSettings() {
            let json = prompt("请输入要导入的备份 JSON");
            if (json) {
                let res = importSmallsSettings(json);
                alert("已导入，请保存更改\n" + res)
            }
        }
    </script>
    <?php
}