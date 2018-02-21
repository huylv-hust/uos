<h1>求人確認</h1>

<section>
    <div class="page01-box">
        <form id="fm_confilm" method="post" class="h-adr" action="">
            <!-- HIDDEN -->
            <input type="hidden" name="plan_code" value="<?php echo isset($data['plan_code']) ? $data['plan_code'] : '';?>">
            <input type="hidden" name="price" value="<?php echo isset($data['price']) ? $data['price'] : '';?>">
            <input type="hidden" name="start_date" value="<?php echo isset($data['start_date']) ? $data['start_date'] : '';?>">
            <input type="hidden" name="end_date" value="<?php echo isset($data['end_date']) ? $data['end_date'] : '';?>">
            <input type="hidden" name="shop_id" value="<?php echo isset($data['shop_id']) ? $data['shop_id'] : '';?>">
            <?php echo Form::hidden('shop_name', isset($data['shop_name']) ? htmlentities($data['shop_name']) : '');?>
            <input type="hidden" name="visible_shop_name" value="<?php echo isset($data['visible_shop_name']) ? $data['visible_shop_name'] : '';?>">
            <input type="hidden" name="access" value="<?php echo isset($data['access']) ? $data['access'] : '';?>">
            <input type="hidden" name="url_home_page" value="<?php echo isset($data['url_home_page']) ? $data['url_home_page'] : '';?>">
            <?php
                $employment_mark = isset($data['employment_mark']) ? explode(',', trim($data['employment_mark'], ',')) : [];
                foreach($employment_mark as $k => $v) {
            ?>
                    <input type="hidden" name="employment_mark[]" value="<?php echo $v;?>">
            <?php  }?>
            <input type="hidden" name="job_type" value="<?php echo isset($data['job_type']) ? $data['job_type'] : '';?>">
            <input type="hidden" name="job_type2" value="<?php echo isset($data['job_type2']) ? $data['job_type2'] : '';?>">
            <input type="hidden" name="job_name" value="<?php echo isset($data['job_name']) ? $data['job_name'] : '';?>">
            <input type="hidden" name="salary_type" value="<?php echo isset($data['salary_type']) ? $data['salary_type'] : '';?>">
            <input type="hidden" name="salary_des" value="<?php echo isset($data['salary_des']) ? $data['salary_des'] : '';?>">
            <input type="hidden" name="salary_min" value="<?php echo isset($data['salary_min']) ? $data['salary_min'] : '';?>">
            <input type="hidden" name="catch_copy" value="<?php echo isset($data['catch_copy']) ? $data['catch_copy'] : '';?>">
            <input type="hidden" name="lead" value="<?php echo isset($data['lead']) ? $data['lead'] : '';?>">
            <?php
            $work_time_view = isset($data['work_time_view']) ? explode(',', trim($data['work_time_view'], ',')) : [];
            foreach($work_time_view as $k => $v) {
                ?>
                <input type="hidden" name="work_time_view[]" value="<?php echo $v;?>">
            <?php  }?>
            <input type="hidden" name="work_day_week" value="<?php echo isset($data['work_day_week']) ? $data['work_day_week'] : '';?>">
            <input type="hidden" name="work_time_des" value="<?php echo isset($data['work_time_des']) ? $data['work_time_des'] : '';?>">
            <input type="hidden" name="qualification" value="<?php echo isset($data['qualification']) ? $data['qualification'] : '';?>">
            <input type="hidden" name="employment_people" value="<?php echo isset($data['employment_people']) ? $data['employment_people'] : '';?>">
            <input type="hidden" name="employment_people_num" value="<?php echo isset($data['employment_people_num']) ? $data['employment_people_num'] : '';?>">
            <input type="hidden" name="job_title" value="<?php echo isset($data['job_title']) ? $data['job_title'] : '';?>">
            <input type="hidden" name="job_description" value="<?php echo isset($data['job_description']) ? $data['job_description'] : '';?>">
            <input type="hidden" name="recruit_title" value="<?php echo isset($data['recruit_title']) ? $data['recruit_title'] : '';?>">
            <input type="hidden" name="recruit_description" value="<?php echo isset($data['recruit_description']) ? $data['recruit_description'] : '';?>">
            <?php
            $trouble = isset($data['trouble']) ? explode(',', trim($data['trouble'], ',')) : [];
            foreach($trouble as $k => $v) {
                ?>
                <input type="hidden" name="trouble[]" value="<?php echo $v;?>">
            <?php  }?>

            <?php
                if(isset($data['content']) && is_array($data['content'])) {
                    foreach($data['content'] as $k => $v) {
            ?>
                        <input type="hidden" value="<?php echo isset($data['alt'][$k]) ? $data['alt'][$k] : ''; ?>" name="alt[]">
                        <input type="hidden" name="content[]" value="<?php echo $v ?>">
                        <input type="hidden" name="mine_type[]" value="<?php echo isset($data['mine_type'][$k]) ? $data['mine_type'][$k] : ''; ?>">
                        <input type="hidden" name="m_image_id[]" value="<?php echo isset($data['m_image_id'][$k]) ? $data['m_image_id'][$k] : ''; ?>">
            <?php
                    }
                }
            ?>
            <!-- END HIDDEN -->

            <table class="page15">

                <tbody>
                <tr>
                    <th><p>掲載プラン</p>
                    </th>
                    <td>
                        <?php
                            $plan_code = isset($data['plan_code']) && $data['plan_code'] == 'employment' ? '採用課金' : '応募課金';
                            $price = isset($data['price']) && $data['price'] ? $data['price'] : 0;
                        ?>
                        <?php echo $plan_code ?>
                        <?php echo number_format($price) ?>円
                    </td>
                </tr>

                <tr>
                    <th><p>掲載期間</p>
                    </th>
                    <td>
                        <?php echo $data['start_date'] . '～' . $data['end_date']; ?>
                    </td>
                </tr>

                <tr>
                    <th><p>店舗</p>
                    </th>
                    <td>
                        <?php
                            echo isset($data['shop_name']) ? $data['shop_name'] : '';
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><p>掲載社名</p>
                    </th>
                    <td>
                        <?php
                        $login_info = \Fuel\Core\Session::get('login_info');
                        echo htmlentities($login_info['company_name']);
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><p>店舗名表示</p>
                    </th>
                    <td>
                        <?php
                            echo $data['visible_shop_name'] == '1' ? '表示' : '非表示';
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><p>画像</p>
                    </th>
                    <td>
                        <?php
                        if(isset($data['content']) && is_array($data['content'])) {
                        ?>
                        <ul class="variable img-contents">
                        <?php
                            foreach($data['content'] as $k => $v) {
                        ?>
                            <li>
                                <div class="img-area">
                                    <img src="data:image/jpeg;base64,<?php echo $v; ?>" width="200px" height="160px">

                            </li>
                        <?php
                            }
                        ?>
                        </ul>
                        <?php }?>
                    </td>
                </tr>

                <tr>
                    <th><p>アクセス</p>
                    </th>
                    <td><?php echo isset($data['access']) ? $data['access'] : ''; ?></td>
                </tr>

                <tr>
                    <th><p>ホームページURL</p>
                    </th>
                    <td><?php echo isset($data['url_home_page']) ? $data['url_home_page'] : ''; ?></td>
                </tr>

                <tr>
                    <th><p>雇用形態</p>
                    </th>
                    <td>
                    <?php
                        $employment_arr = explode(',', trim($data['employment_mark'], ','));
                        $employment = '';
                        foreach($employment_arr as $k => $v) {
                            if(isset(Constants::$sales_employment_type[$v])) {
                                $employment .=  Constants::$sales_employment_type[$v].',';
                            }
                        }
                    $employment = trim($employment, ',');
                    echo str_replace(',', '、', $employment);
                    ?>
                    </td>
                </tr>

                <tr>
                    <th><p>職業1</p>
                    </th>
                    <td><?php echo isset($data['job_type']) && isset(Constants::$job_type[$data['job_type']]) ? Constants::$job_type[$data['job_type']] : '';?></td>
                </tr>

                <tr>
                    <th><p>職業2</p>
                    </th>
                    <td><?php echo isset($data['job_type2']) && isset(Constants::$job_type[$data['job_type2']]) ? Constants::$job_type[$data['job_type2']] : '';?></td>
                </tr>

                <tr>
                    <th><p>職種</p>
                    </th>
                    <td><?php echo $data['job_name'];?></td>
                </tr>

                <tr>
                    <th><p>給与形態</p>
                    </th>
                    <td><?php echo isset(Constants::$sales_salary_type[$data['salary_type']]) ? Constants::$sales_salary_type[$data['salary_type']] : '';?></td>
                </tr>

                <tr>
                    <th><p>給与</p>
                    </th>
                    <td><?php echo $data['salary_des'];?></td>
                </tr>

                <tr>
                    <th><p>最低時給</p>
                    </th>
                    <td> <?php echo isset($data['salary_min']) ? $data['salary_min'] : '';?></td>
                </tr>

                <tr>
                    <th><p>キャッチコピー</p>
                    </th>
                    <td>
                        <?php
                            echo isset($data['catch_copy']) ? nl2br($data['catch_copy']) : '';
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><p>リード</p>
                    </th>
                    <td>
                        <?php
                        echo isset($data['lead']) ? nl2br($data['lead']) : '';
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><p>表示勤務時間帯</p>
                    </th>
                    <td>
                        <?php
                        $work_time_view_arr = explode(',', trim($data['work_time_view'], ','));
                        $work_time_view = '';
                        foreach($work_time_view_arr as $k => $v) {
                            if(isset(Constants::$sale_work_time_view[$v])) {
                                $work_time_view .=  Constants::$sale_work_time_view[$v].'、';
                            }
                        }
                        echo trim($work_time_view, '、');
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><p>週当たり最低勤務日数</p>
                    </th>
                    <td><?php echo $data['work_day_week']?></td>
                </tr>

                <tr>
                    <th><p>勤務曜日・時間について</p>
                    </th>
                    <td>
                        <?php echo nl2br($data['work_time_des']);?>
                    </td>
                </tr>

                <tr>
                    <th><p>資格</p>
                    </th>
                    <td><?php echo isset($data['qualification']) ? $data['qualification'] : '';?></td>
                </tr>

                <tr>
                    <th><p>採用予定人数</p>
                    </th>
                    <td>
                        <?php
                            echo isset($data['employment_people']) && isset(Constants::$employment_people[$data['employment_people']]) ? Constants::$employment_people[$data['employment_people']] : '';
                            echo isset($data['employment_people_num']) ? ': '.$data['employment_people_num'] : '';
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><p>仕事内容</p>
                    </th>
                    <td>
                        <ul>
                            <li>
                                <?php
                                if(isset($data['job_title']) && $data['job_title']) {
                                    ?>
                                    <span>見出し: </span>
                                    <?php
                                    echo $data['job_title'];
                                }
                                ?>
                            </li>
                            <li>
                                <?php
                                if(isset($data['job_description']) && $data['job_description']) {
                                    ?>
                                    <span>本文: </span>
                                    <?php
                                    echo $data['job_description'];
                                }
                                ?>
                            </li>
                        </ul>
                    </td>
                </tr>

                <tr>
                    <th><p>募集内容</p>
                    </th>
                    <td>
                        <ul>
                            <li>
                                <?php
                                    if(isset($data['recruit_title']) && $data['recruit_title']) {
                                ?>
                                        <span>見出し: </span>
                                <?php
                                        echo $data['recruit_title'];
                                    }
                                ?>
                            </li>
                            <li>
                                <?php
                                    if(isset($data['recruit_description']) && $data['recruit_description']) {
                                ?>
                                        <span>本文: </span>
                                <?php
                                        echo $data['recruit_description'];
                                    }
                                ?>
                            </li>
                        </ul>
                    </td>
                </tr>

                <tr>
                    <th><p>代表番号</p>
                    </th>
                    <td>
                        <?php
                        echo htmlentities($login_info['tel']);
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><p>担当者</p>
                    </th>
                    <td>
                        <?php
                        echo htmlentities($login_info['staff_name']);
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><p>メールアドレス</p>
                    </th>
                    <td>
                        <?php
                        echo htmlentities($login_info['email']);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><p>こだわり検索</p>
                    </th>
                    <td>
                        <?php
                            if(isset($data['trouble'])) {
                                $trouble_arr = explode(',', trim($data['trouble'], ','));
                                $trouble = '';
                                foreach($trouble_arr as $k => $v) {
                                    foreach(Trouble::$trouble as $key => $val) {
                                        if($val['id'] == $v) {
                                            $trouble .= $val['pubname'].',';
                                        }
                                    }
                                }
                            }
                        $trouble = trim($trouble, ',');
                        echo str_replace(',', '、', $trouble);
                        ?>
                    </td>
                </tr>

                </tbody>
            </table>

            <!-- 送信ボタン START -->
            <ul class="transmission">
                <li>
                    <input value="修正する" type="submit" id="fm_btn_back">
                </li>
                <li>
                    <input value="登録する" id="fm_btn_confirm" type="button">
                    <input type="hidden" name="hidden" value="back">
                </li>
            </ul>
            <!-- 送信ボタン END -->

        </form>
    </div>
</section>
<script>
    $('#fm_btn_confirm').on('click', function() {
        $('#fm_confilm').attr('action', baseUrl + 'customer/job/confirm').submit();
        $(this).attr('disabled', true);
        $('#fm_btn_back').attr('disabled', true);
    });
    $('#fm_btn_back').on('click', function() {
        var id = '<?php echo isset($data["job_id"]) && $data["job_id"] ? "?job_id=".$data["job_id"] : '';?>';
        $('#fm_confilm').attr('action', baseUrl + 'customer/job' + id).submit();
        $(this).attr('disabled', true);
        $('#fm_btn_confirm').attr('disabled', true);
    });
</script>
