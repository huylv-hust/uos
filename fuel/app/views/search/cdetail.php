<?php
echo \Fuel\Core\Asset::js('jquery.fadeimg.js');
echo \Fuel\Core\Asset::js('validate/job.js');
$default = json_encode(array('title' => '仕事を探す', 'url' => \Fuel\Core\Uri::base() . 'search'));
$arr = json_decode(\Fuel\Core\Cookie::get('url_job_search', $default), true);
?>
<script>
    $(window).load(function (e) {
        // accordion
        $("#tabbox01 a").fadeimg({fadeimg_show: ".show01"});

        // accordion
        if ($(window).width() > 768) {
            $('.accordion .toggle').show();
        } else {
            $('.accordion .toggle').hide();
        }
        $(".detail_box .sp").accor({conAcc: ".detail_box .toggle"});
    });
</script>
<?php
    $job = (object)$job;
    $sale_job_id = null;
    if (isset($job->job_id)) {
        $sale_job_id = $job->job_id;
        $job->job_id = 'c'.$job->job_id;
    }
    $job->start_date = str_replace('-', '/', $job->start_date);
    $job->end_date = str_replace('-', '/', $job->end_date);
    $mid = '';
    $end = ($job->end_date) ? ' 23:59（終了予定）' : '';
    $text = '';
    if ($job->start_date || $job->end_date) {
        $mid = '～';
        $text = (($job->start_date) ? $job->start_date . '（' . Utility::get_day_of_week($job->start_date) . '）' : '') . $mid . (($job->end_date) ? $job->end_date . '（' . Utility::get_day_of_week($job->end_date) . '）' : '') . $end;
    }
    ?>
<img src="<?php echo \Fuel\Core\Uri::base() ?>beacon/salejob?job_id=<?php echo $sale_job_id ?>" width="1" height="1">
<div id="topicPath">
    <ul>
        <li class="home"><a href="<?php echo \Fuel\Core\Uri::base(); ?>">HOME</a></li>
        <?php if ($arr['title'] != 'Home') { ?>
            <li><a href="<?php echo $arr['url']; ?>"><?php echo $arr['title']; ?></a></li>
        <?php } ?>
        <li><?php echo $customer_info->company_name ?></li>
    </ul>
</div>
<main>
    <div id="page_search_detail">
        <div class="section box">
            <h2 class="tit_main"><?php echo $customer_info->company_name ?></h2>
            <div class="container" id="search_list">
                <div class="list_box list_wrap">
                    <div class="list_search item">
                        <table>
                            <tbody>
                            <tr class="alt">
                                <td class="first" colspan="2"><?php echo $job->job_name; ?></td>
                            </tr>
                            <tr>
                                <!-- employment_mark -->
                                    <th><span class="ico01">雇用形態</span></th>
                                <td class="status">
                                    <?php
                                    $str_mark = '、';
                                    $employmentMarks = [];
                                    if (isset($job->employment_mark) && is_array($job->employment_mark)) {
                                        $employmentMarks = $job->employment_mark;
                                    } else {
                                        if (isset($job->employment_mark) && strlen($job->employment_mark)) {
                                            $employmentMarks = explode(',', trim($job->employment_mark, ','));
                                        }
                                    }
                                    $employmentMarkNames = [];
                                    foreach ($employmentMarks as $k => $v) {
                                        $employmentMarkNames[] = @Constants::$sales_employment_type[$v];
                                    }
                                    echo implode('、', $employmentMarkNames);
                                    ?>
                                </td>
                            </tr>
                            <tr class="alt">
                                <th><span class="ico02">給与</span></th>
                                <td><?php echo $job->salary_des; ?></td>
                            </tr>
                            <tr>
                                <!-- nhà ga -->
                                <th><span class="ico03">勤務地</span></th>
                                <td>
                                    <?php echo $shop_info->city ?>
                                    【
                                    <span class="car">最寄り駅：</span>
                                    <?php echo implode('、', $stations) ?>
                                    】
                                </td>
                            </tr>
                            <tr class="alt">
                                <?php
                                $workTimeViews = [];
                                if (isset($job->work_time_view)) {
                                    if (is_array($job->work_time_view)) {
                                        $workTimeViews = $job->work_time_view;
                                    } else {
                                        $workTimeViews = explode(',', trim($job->work_time_view, ','));
                                    }
                                }
                                $workTimeViewNames = [];
                                foreach ($workTimeViews as $v) {
                                    if (isset(Constants::$work_time_view[$v])) {
                                        $workTimeViewNames[] = Constants::$work_time_view[$v];
                                    }
                                }
                                ?>
                                <th><span class="ico04">時間帯</span></th>
                                <td><?php echo implode('、', $workTimeViewNames); ?></td>
                            </tr>
                            <tr>
                                <th><span class="ico05">こだわり</span></th>
                                <td>
                                    <ul>
                                        <?php
                                        $_troubles = array_column(Trouble::$trouble, 'pubname', 'id');
                                        $arr_trouble = [];
                                        if (isset($job->trouble)) {
                                            if (is_array($job->trouble)) {
                                                $arr_trouble = $job->trouble;
                                            } else if (strlen($job->trouble)) {
                                                $arr_trouble = explode(',', trim($job->trouble, ','));
                                            }
                                        }
                                        ?>
                                        <?php foreach ($arr_trouble as $v) { if (!$v || !isset($_troubles[$v])) { continue; } ?>
                                            <li><span><?php echo htmlspecialchars($_troubles[$v]) ?></span></li>
                                        <?php } ?>
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="application clearfix">
                        <p>
                            <span>応募可能期間</span>
                            <br class="sp">
                            <?php echo $text; ?>
                        </p>
                        <?php if ($is_preview == false) { ?>
                        <ul>
                            <li>
                                <?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id', $job->job_id); ?>
                            </li>
                            <li>
                                <form method="post" action="<?php echo \Fuel\Core\Uri::base() ?>customer/form">
                                    <input class="hidden_job_id" type="hidden" value="<?php echo $job->job_id; ?>"
                                           name="job_id">
                                    <img class="btn_submit_apply_job imghover" alt="応募する"
                                         src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_application02.png">
                                </form>
                            </li>
                        </ul>
                        <?php } ?>
                    </div><!-- /.application -->
                </div><!-- /.list_box -->
            </div><!-- /#search_list -->
            <div id="tabbox01" class="container pic_l clearfix case">
                <div class="img">
                    <div class="pic" id="detail_image">
                        <?php
                        $image_random_info = [];
                        $postImages = [];
                        if (isset($job->image_list)) {
                            $image_random_info = Model_Mimage::get_data_image(html_entity_decode($job->image_list));
                        } else {
                            if (isset($job->alt) && is_array($job->alt)) {
                                foreach ($job->content as $key => $val) {
                                    $postImages[] = [
                                        'data' => 'data:' . $job->mine_type[$key] . ';base64,' . $val,
                                        'alt' => $job->alt[$key]
                                    ];
                                }
                                shuffle($postImages);
                                $image_random_info = array_shift($postImages);
                            } else {
                                $image_random_info = [
                                    'data' => '',
                                    'alt' => '',
                                ];
                            }
                        }
                        ?>
                        <?php if ($image_random_info) { ?>
                        <span
                            style="background-image: url(<?php echo Constants::get_image($image_random_info['data']); ?>)"
                            class="image show01"></span>
                        <p title="<?php echo $image_random_info['alt']; ?>"><?php echo $image_random_info['alt']; ?></p>
                        <?php } ?>
                    </div>
                    <div class="thumbnail clearfix">
                        <ul class="clearfix">
                            <?php
                            $image = [];
                            if (isset($job->image_list)) {
                                $image = Model_Mimage::get_image_list(html_entity_decode($job->image_list));
                            } else {
                                foreach ($postImages as $val) {
                                    $image[] = [
                                        0 => $val['data'],
                                        1 => $val['alt']
                                    ];
                                }
                            }
                            foreach ($image as $k => $v) { ?>
                                <li>
                                    <a alt="<?php echo $v[1]; ?>" href="<?php echo $v[0]; ?>" style="opacity: 1;">
                                        <span
                                            style="background-image: url(<?php echo Constants::get_image($v[0]); ?>)"
                                            class="image_detail"></span>
                                        <img style="height: 126px; display: none" alt="<?php echo $v[1]; ?>"
                                             src="<?php echo Constants::get_image($v[0]); ?>">
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div><!--/.thumbnail-->
                </div><!--/.img-->
                <div class="msg">
                    <h3 class="tit_detail"><?php echo $job->catch_copy; ?></h3>
                    <?php echo nl2br($job->lead); ?>
                </div><!--/.msg-->
            </div><!-- /.container -->
            <div class="container pack sty_form accordion detail_box">
                <div class="sty_line sty_green pack">
                    <div class="title_look">
                        <span class="tit_line pc">お仕事情報</span>
                        <span class="tit_line sp">お仕事情報</span>
                    </div><!--/.title_look-->

                    <div class="toggle">
                        <table class="tb_styform">
                            <tbody>
                            <tr class="alt">
                                <th><?php echo $job->job_title; ?></th>
                                <td><?php echo $job->job_description; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!--/.toggle-->
                </div><!-- /.sty_line -->
                <div class="application clearfix pc">
                    <p>
                        <span>応募可能期間</span>
                        <br class="sp">
                        <?php echo $text; ?>
                    </p>
                    <?php if ($is_preview == false) { ?>
                    <ul>
                        <li>
                            <?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id', $job->job_id); ?>
                        </li>
                        <li>
                            <form method="post" action="<?php echo \Fuel\Core\Uri::base() ?>customer/form">
                                <input class="hidden_job_id" type="hidden" value="<?php echo $job->job_id; ?>"
                                       name="job_id">
                                <img class="btn_submit_apply_job imghover" alt="応募する"
                                     src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_application02.png">
                            </form>
                        </li>
                    </ul>
                    <?php } ?>
                </div><!-- /.application -->
            </div><!--/.container-->
            <div class="container pack sty_form accordion detail_box">
                <div class="sty_line sty_green pack">
                    <div class="title_look">
                        <span class="tit_line pc">勤務地・応募対象</span>
                        <span class="tit_line sp">勤務地・応募対象</span>
                    </div><!--/.title_look-->

                    <div class="toggle">
                        <table class="tb_styform">
                            <tbody>
                            <tr>
                                <th>勤務地</th>
                                <td>
                                    <?php if ($job->visible_shop_name) { ?>
                                    <div><?php echo $shop_info->shop_name ?></div>
                                    <?php } ?>
                                    <div><?php echo \Constants::$addr1[$shop_info->prefecture_id] . $shop_info->city . $shop_info->town ?></div>
                                    <div><?php echo $job->access ?></div>
                                </td>
                            </tr>
                            <tr>
                                <th>最寄り駅</th>
                                <td>
                                    <?php foreach ($stations as $key => $station) { ?>
                                        <div><?php echo htmlspecialchars($station) ?></div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr class="alt">
                                <th>勤務曜日・時間</th>
                                <td>
                                    <?php echo $job->work_time_des; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>資格</th>
                                <td><?php echo $job->qualification; ?></td>
                            </tr>
                            <?php if ($job->employment_people || $job->employment_people_num) { ?>
                                <tr class="alt">
                                    <th>採用予定人数</th>
                                    <td>
                                        <?php
                                        $people = ($job->employment_people_num) ? '人' : '';
                                        ?>
                                        <?php echo Constants::$employment_people[$job->employment_people]; ?>
                                        &#12288;&#12288;<?php echo $job->employment_people_num . $people; ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th><?php echo $job->recruit_title; ?></th>
                                <td><?php echo $job->recruit_description; ?></td>
                            </tr>

                            </tbody>
                        </table>
                    </div><!--/.toggle-->
                </div><!-- /.sty_line -->
                <div class="application clearfix pc">
                    <p>
                        <span>応募可能期間</span>
                        <br class="sp">
                        <?php echo $text; ?>
                    </p>
                    <?php if ($is_preview == false) { ?>
                    <ul>
                        <li>
                            <?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id', $job->job_id); ?>
                        </li>
                        <li>
                            <form method="post" action="<?php echo \Fuel\Core\Uri::base() ?>customer/form">
                                <input class="hidden_job_id" type="hidden" value="<?php echo $job->job_id; ?>"
                                       name="job_id">
                                <img class="btn_submit_apply_job imghover" alt="応募する"
                                     src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_application02.png">
                            </form>
                        </li>
                    </ul>
                    <?php } ?>
                </div><!-- /.application -->
            </div><!--/.container-->
            <div class="container sty_form accordion detail_box">
                <div class="sty_line sty_green">
                    <div class="title_look">
                        <span class="tit_line pc">応募情報</span>
                        <span class="tit_line sp">応募情報</span>
                    </div><!--/.title_look-->

                    <div class="toggle">
                        <table class="tb_styform last">
                            <tbody>
                            <tr class="alt">
                                <th>面接地・他</th>
                                <td>面接は勤務地または近隣にて行います。</td>
                            </tr>
                            <tr>
                                <th>応募方法</th>
                                <td>「応募する」ボタンより、応募シートに必要事項を入力の上、送信して下さい。※応募書類は返却致しません。ご了承ください。</td>
                            </tr>
                            <tr class="alt">
                                <th>応募後のプロセス</th>
                                <td>追って、こちらからご連絡差し上げます。※ご連絡は平日に致します。★ネット応募は24ｈ受付中!!</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="clearfix" id="company">
                            <div class="info">
                                <p class="title"><?php echo $customer_info->company_name; ?></p>
                            </div>
                            <?php if ($job->url_home_page) { ?>
                                <div class="btn">
                                    <a target="_blank" href="<?php echo $job->url_home_page ?>"><img alt="ホームページを見る"
                                                                                                     src="<?php echo \Fuel\Core\Uri::base() ?>assets/images/search/btn_detail.png"
                                                                                                     class="imghover"></a>
                                </div><!--/.btn-->
                            <?php } ?>
                        </div>
                    </div><!--/.toggle-->

                </div><!-- /.sty_line -->
            </div><!--/.container-->
            <div class="application app_big pc clearfix">
                <?php if ($is_preview == false) { ?>
                <ul>
                    <li>
                        <?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id', $job->job_id); ?>
                    </li>
                    <li>
                        <form method="post" action="<?php echo \Fuel\Core\Uri::base() ?>customer/form">
                            <input class="hidden_job_id" type="hidden" value="<?php echo $job->job_id; ?>"
                                   name="job_id">
                            <img class="btn_submit_apply_job imghover" alt="応募する"
                                 src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_application02.png">
                        </form>
                    </li>
                </ul>
                <?php } ?>
                <p>
                    <span>応募可能期間</span>
                    <br class="sp">
                    <?php echo $text; ?>
                </p>
            </div><!-- /.application -->
            <div class="application sp clearfix">
                <p>
                    <span>応募可能期間</span>
                    <br class="sp">
                    <?php echo $text; ?>
                </p>
                <?php if ($is_preview == false) { ?>
                <ul>
                    <li>
                        <?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id', $job->job_id); ?>
                    </li>
                    <li>
                        <form method="post" action="<?php echo \Fuel\Core\Uri::base() ?>customer/form">
                            <input class="hidden_job_id" type="hidden" value="<?php echo $job->job_id; ?>"
                                   name="job_id">
                            <img class="btn_submit_apply_job imghover" alt="応募する"
                                 src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_application02.png">
                        </form>
                    </li>
                </ul>
                <?php } ?>
            </div><!-- /.application -->
        </div>
        <!-- /.section -->
    </div><!-- /#page_search -->
</main>
