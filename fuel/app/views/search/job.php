<?php
$tmp = '';
if ($job->work_time_view) {
    foreach (Constants::$work_time_view as $key => $val) {
        if (substr_count($job->work_time_view, ',' . $key . ','))
            $tmp .= $val . '、';
    }
}

$data->work_time_view = trim($tmp, '、');
$data->start_date = str_replace('-', '/', $data->start_date);
$data->end_date = str_replace('-', '/', $data->end_date);
?>
<?php if (substr($data->job_id, 0, 1) == 'c') { ?>
    <img src="<?php echo \Fuel\Core\Uri::base() ?>beacon/salejob?job_id=<?php echo substr($data->job_id, 1) ?>" width="1" height="1" class="hide">
<?php } ?>
<div class="list_box container" id="item-job-<?php echo $data->job_id; ?>">
    <div class="tit_list clearfix">
        <a href="<?php echo \Fuel\Core\Uri::base() ?>search/detail/<?php echo $data->job_id ?>"></a>
        <p>
            <a href="<?php echo \Fuel\Core\Uri::base() ?>search/detail/<?php echo $data->job_id ?>"><?php echo $data->catch_copy; ?></a>
            <span><?php echo $data->post_company_name; ?></span>
        </p>
    </div>
    <!-- /.tit_list -->
    <div class="list_wrap">
        <div class="pic_l clearfix">
            <div class="img search_img">
                <a href="<?php echo \Fuel\Core\Uri::base() ?>search/detail/<?php echo $data->job_id ?>">
                    <span class="image"
                          style="background-image:url(<?php echo Constants::get_image($data->image['data']); ?>)"></span>
                </a>
            </div>
            <div class="msg list_search">
                <table>
                    <tbody>
                    <tr class="alt">
                        <td class="first" colspan="2"><?php echo \Fuel\Core\Security::htmlentities($data->job_category) ?> ID:<?php echo $job->job_id ?></td>
                    </tr>
                    <tr>
                        <th><span class="ico01">雇用形態</span></th>
                        <td class="status">
                            <?php
                            $employment_mark = trim($data->employment_mark, ',') == '' ? array() : explode(',', trim($data->employment_mark, ','));
                            if(!$data->ss_id) {
                                $employment_mark = trim($data->employment_type, ',') == '' ? array() : explode(',', trim($data->employment_type, ','));
                            }
                            $str_mark = '、';
                            $employment_marks = '';
                            foreach ($employment_mark as $k => $v) {
                                $employment_marks .= $data->ss_id ? Constants::$employment_mark[$v] . '||' : Constants::$sales_employment_type[$v] . '||';
                            }
                            $employment_marks = trim($employment_marks, '||');
                            echo str_replace('||', $str_mark, $employment_marks);
                            ?>
                        </td>
                    </tr>

                    <tr class="alt">
                        <th><span class="ico02">給与</span></th>
                        <td><?php echo $data->salary_des; ?></td>
                    </tr>
                    <tr>
                        <th><span class="ico03">勤務地</span></th>
                        <td>
                            <div><?php echo $job->store_name ?></div>
                            <?php if ($job->addr_is_view == 1) { ?>
                                <div><?php echo \Constants::$addr1[$job->addr1] . $job->addr2 ?></div>
                            <?php } else { ?>
                                <div><?php echo \Constants::$addr1[$job->addr1] . $job->address23 ?></div>
                            <?php } ?>
                            <div>
                                <?php echo $job->traffic ?>
                                【
                                <span class="car">最寄り駅：</span>
                                <?php echo implode('、', $stations) ?>
                                】
                            </div>
                        </td>
                    </tr>

                    <tr class="alt">
                        <th><span class="ico04">時間帯</span></th>
                        <td><?php echo $data->work_time_view ?></td>
                    </tr>
                    <tr>
                        <th><span class="ico05">こだわり</span></th>
                        <td>
                            <ul>
                                <?php $_troubles = array_column(Trouble::$trouble, 'pubname', 'id'); ?>
                                <?php foreach ($data->trouble as $v) { if (!$v || !isset($_troubles[$v])) { continue; } ?>
                                <li><span><?php echo htmlspecialchars($_troubles[$v]) ?></span></li>
                                <?php } ?>
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.container -->
        <p class="txt"><?php echo nl2br($data->lead); ?></p>

        <div class="detail_link_wrap"><a
                href="<?php echo \Fuel\Core\Uri::base() ?>search/detail/<?php echo $data->job_id ?>"
                class="detail_link_btn"><span>詳細はこちら</span></a></div>
        <div class="application clearfix">
            <?php
            $mid = '';
            $end = ($data->end_date) ? ' 23:59（終了予定）' : '';
            if ($data->start_date || $data->end_date) {
                $mid = '～';
                $text = (($data->start_date) ? $data->start_date . '（' . Utility::get_day_of_week($data->start_date) . '）' : '') . $mid . (($data->end_date) ? $data->end_date . '（' . Utility::get_day_of_week($data->end_date) . '）' : '') . $end;
            } else {
                $text = '随時募集中！ご応募お待ちしております。';
            }
            ?>
            <p><span>応募可能期間</span><br class="sp"><?php echo $text; ?></p>
            <ul>
                <li><?php echo \Fuel\Core\Presenter::forge('jobs/keeplist')->set('job_id', $data->job_id); ?></li>
                <li>
                    <?php
                        $url = $data->ss_id ? \Fuel\Core\Uri::base() . 'form' : \Fuel\Core\Uri::base() . 'customer/form';
                    ?>
                    <form method="post" action="<?php echo $url;?>">
                        <input type="hidden" class="hidden_job_id" value="<?php echo $data->job_id; ?>" name="job_id">
                        <img class="btn_submit_apply_job imghover" alt="応募する"
                             src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_application02.png">
                    </form>
                </li>
            </ul>
        </div>
        <!-- /.application -->
    </div>
    <!-- /.list_wrap -->
</div>
