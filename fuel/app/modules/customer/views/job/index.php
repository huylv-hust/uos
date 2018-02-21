<?php echo \Fuel\Core\Asset::js('customer/job.js'); ?>
<?php echo \Fuel\Core\Asset::js('image.js'); ?>

    <ul class="navi">
        <!--<li><a href="">実績</a></li>-->
        <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/jobs">求人管理</a></li>
        <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/persons">応募者管理</a></li>
        <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/summary">サマリー</a></li>
        <li><a href="<?php echo \Fuel\Core\Uri::base();?>customer/shops">店舗管理</a></li>
    </ul>

    <h1>求人</h1>

    <p class="comment">募集要項のご登録をお願いします。</p>
    <div class="waiting <?php echo isset($is_view['title']) ? $is_view['title'] : 'hide'?>">※ この枠内は変更前の内容を記載しています</div>
    <?php if (\Fuel\Core\Session::get_flash('error')) { ?>
        <div class="waiting"><?php echo \Fuel\Core\Session::get_flash('error');?></div>
    <?php }?>
    <section>
        <div class="page01-box">
            <?php $url = \Fuel\Core\Input::get('job_id') ? \Fuel\Core\Uri::base().'customer/job?job_id='.\Fuel\Core\Input::get('job_id') : \Fuel\Core\Uri::base().'customer/job'; ?>
            <form id="fm_action" method="post" class="h-adr" action="<?php echo $url;?>">
                <input type="hidden" name="preview_url" value="<?php echo \Fuel\Core\Uri::base() ?>cpreview?enc=<?php echo Utility::encrypt(':' . time()) ?>">
                <table>

                    <!-- 課金プラン -->
                    <tbody><tr>
                        <th>
                            <p>掲載プラン</p>
                        </th>
                        <td>
                            <ul class="variable fm_chk fm_required">
                                <!--						<li>-->
                                <!--							<input type="radio" name="plan_code" id="a_1" value="application">-->
                                <!--							<label for="a_1">応募課金</label>-->
                                <!--						</li>-->
                                <li>
                                    <input name="plan_code" id="a_2" value="employment" checked="" type="radio">
                                    <label for="a_2">採用課金</label>
                                </li>
                                <li><input id="pay1" name="price_view" class="wth_30" disabled="" type="text" value="<?php echo $price ?>">
                                    <input name="price" value="<?php echo $price ?>" type="hidden">
                                    <span>円/人（税別）</span>
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <!-- 受付代行 -->
                    <!--            <tr>-->
                    <!--              <th>-->
                    <!--                  <p>受付代行</p>-->
                    <!--              </th>-->
                    <!--              <td>-->
                    <!--                  <input type="hidden" name="is_behalf" value="0">-->
                    <!--                  <input type="checkbox" name="is_behalf" id="b_1" value="1">-->
                    <!--                  <label for="b_1">代行を依頼する</label>-->
                    <!--               </td>-->
                    <!--            </tr>-->

                    <!-- 掲載期間 -->
                    <tr>
                        <th nowrap="nowrap">
                            <p>掲載期間</p><span class="essential">必須</span>
                            <div class="text-explain">※開始日と終了日を選択（最大6ケ月）</div>
                        </th>
                        <td>
                            <?php if(isset($validate['start_date'])) { ?>
                                <span class="red"><?php echo $validate['start_date'];?></span>
                            <?php  } elseif (isset($validate['end_date'])) { ?>
                                <span class="red"><?php echo $validate['end_date'];?></span>
                            <?php }?>
                            <?php echo Form::input('start_date', Input::post('start_date') !== null ? Input::post('start_date') : (isset($json) ? $json->start_date : ''), array('class' => isset($validate['start_date']) ? 'wth_30 dateform error_box' : 'wth_30 dateform', 'id' => 'year1'));?>
                            ～
                            <?php echo Form::input('end_date', Input::post('end_date') !== null ? Input::post('end_date') : (isset($json) ? $json->end_date : ''), array('class' => isset($validate['end_date']) ? 'wth_30 dateform error_box' : 'wth_30 dateform', 'id' => 'year2'));?>
                            <div class="editing <?php echo isset($is_view['start_date']) || isset($is_view['end_date']) ? '' : 'hide'?>">
                            <?php echo isset($sale_job->start_date) ? $sale_job->start_date : '';?>
                                ～
                            <?php echo isset($sale_job->end_date) ? $sale_job->end_date : '';?>
                            </div>
                        </td>
                    </tr>

                    <!-- 店舗 -->
                    <tr>
                        <th>
                            <p>店舗</p><span class="essential">必須</span>
                            <div class="text-explain">※勤務する店舗を選択</div>

                            <!-- モーダルスイッチ／テキストボタン START -->
                            <div class="remodal-bg search-btn remodal-is-closed">
                                <a href="#modal"><span><img src="<?php echo \Fuel\Core\Uri::base();?>assets/images/search.svg"></span></a>
                            </div>
                            <!-- モーダルスイッチ／テキストボタン END -->

                            <!-- モーダル DETAIL START -->
                            <input type="hidden" name="shop_id" value="<?php echo Input::post('shop_id') !== null ? Input::post('shop_id') : (isset($json) ? $json->shop_id : ($shop_id ? $shop_id :''));?>">
                        </th>
                        <td>
                            <?php $shop_name = Input::post('shop_name') !== null ? Security::htmlentities(Input::post('shop_name')) : (isset($shop_name_json) ? Security::htmlentities($shop_name_json) : (isset($shop_name) && $shop_name  ? Security::htmlentities($shop_name) : ''));?>
                            <span class="red"><?php echo isset($validate['shop_id']) ? $validate['shop_id'] : '';?></span>
                            <?php echo Form::hidden('shop_name', $shop_name);?>
                            <p id="shop_name"><?php echo $shop_name;?></p>
                            <div class="editing <?php echo (isset($shop_name_json) && ($shop_name_json != $shop_name_old)) ? '' : 'hide'?>"><?php echo isset($shop_name_old) ? $shop_name_old : ''; ?></div>
                        </td>
                    </tr>

                    <!-- 掲載者名 -->
                    <tr>
                        <th>
                            <p>掲載社名</p>
                        </th>
                        <td><?php echo isset($login_info['company_name']) ? $login_info['company_name'] : '';?></td>
                    </tr>

                    <!-- 店舗名表示 -->
                    <tr>
                        <th>
                            <p>店舗名表示</p>
                            <div class="text-explain">※募集内容に店舗名表示したくない場合は、非表示を選択</div>
                        </th>
                        <td>
                            <ul class="check_list fm_chk fm_required">
                                <li>
                                    <input name="visible_shop_name" id="c_1" value="1" <?php echo Input::post('visible_shop_name') == '1' ? 'checked' : ((isset($json->visible_shop_name) && $json->visible_shop_name == '1') || !isset($json) ? 'checked' : '')?> type="radio">
                                    <label for="c_1" class="<?php echo isset($is_view['visible_shop_name']) && $sale_job->visible_shop_name == '1' ? 'editing' : '';?>">表示</label>
                                </li>
                                <li>
                                    <input name="visible_shop_name" id="c_2" value="0" <?php echo Input::post('visible_shop_name') == '0' ? 'checked' : ((isset($json->visible_shop_name) && $json->visible_shop_name == '0') ? 'checked' : '')?> type="radio">
                                    <label for="c_2" class="<?php echo isset($is_view['visible_shop_name']) && $sale_job->visible_shop_name == '0' ? 'editing' : '';?>">非表示</label>
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <!-- 画像 -->
                    <tr>
                        <th>
                            <p>画像</p>
                            <div class="text-explain">※最大4枚まで（容量は200KBまで）</div>
                            <span class="plus">
                                <input value="追加" name="image_add_btn" type="button">
                            </span>
                            <input name="image" class="image hide" style="display: none;" type="file">
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['image_list']) ? $validate['image_list'] : '';?></span>
                            <ul class="variable img-contents <?php echo isset($validate['image_list']) ? 'error_box' : '';?>">
                                <?php
                                $_arr_check = array();
                                $content = \Fuel\Core\Input::post('content', '');
                                $alt = \Fuel\Core\Input::post('alt');
                                $mine_type = \Fuel\Core\Input::post('mine_type');
                                $m_image_id = \Fuel\Core\Input::post('m_image_id');
                                if(is_array($content)) {
                                    foreach($content as $k => $v) {
                                        ?>
                                        <li>
                                            <div class="img-area">
                                                <img src="data:<?php echo $mine_type[$k] ?>;base64,<?php echo $v ?>" width="200px" height="160px">
                                                <div class="close-btn">
                                                    <input value="×" type="button">
                                                </div></div>
                                            <input type="hidden" value="<?php echo isset($alt[$k]) ? $alt[$k] : ''; ?>" name="alt[]">
                                            <input type="hidden" name="content[]" value="<?php echo $v ?>">
                                            <input type="hidden" name="mine_type[]" value="<?php echo isset($mine_type[$k]) ? $mine_type[$k] : ''; ?>">
                                            <input type="hidden" name="m_image_id[]" value="<?php echo isset($m_image_id[$k]) ?  $m_image_id[$k] : '';?>">
                                        </li>
                                        <?php
                                    }
                                }
                                else if (count($m_image_edit)) {
                                foreach ($m_image_edit as $row) {
                                $_arr_check[] = $row['m_image_id'].'.'.$row['alt'];
                                ?>
                                    <li>
                                        <div class="img-area">
                                        <img src="data:<?php echo $row['mine_type'] ?>;base64,<?php echo $row['content'] ?>" width="200px" height="160px">
                                        <div class="close-btn">
                                        <input value="×" type="button">
                                        </div></div>
                                        <input type="hidden" value="<?php echo $row['alt'] ?>" name="alt[]">
                                        <input type="hidden" name="content[]" value="<?php echo $row['content'] ?>">
                                        <input type="hidden" name="mine_type[]" value="<?php echo $row['mine_type'] ?>">
                                        <input type="hidden" name="m_image_id[]" value="<?php echo $row['m_image_id'] ?>">
                                    </li>
                                <?php
                                }
                                }
                                ?>
                            </ul>
                            <?php
                            if(isset($is_view['image_list'])){
                                ?>
                                <ul class="editing">
                                    <?php
                                    if (count($m_image_old)) {
                                        foreach ($m_image_old as $row) {
                                            if( ! in_array($row['m_image_id'].'.'.$row['alt'],$_arr_check))
                                            {
                                                ?>
                                                <li>
                                                    <div class="img-area">
                                                        <img src="data:<?php echo $row['mine_type'] ?>;base64,<?php echo $row['content'] ?>" width="200px" height="160px">
                                                    </div>
                                                </li>
                                                <?php
                                            }}
                                    }
                                    ?>
                                </ul>
                            <?php }?>
                        </td>
                    </tr>

                    <!-- アクセス -->
                    <tr>
                        <th>
                            <p>アクセス</p>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['access']) ? $validate['access'] : '';?></span>
                            <?php echo Form::input('access', Input::post('access') !== null ? Input::post('access') : (isset($json) ? $json->access : ''), array('id' => 'line', 'maxlength' => 100, 'class' => isset($validate['access']) ? 'error_box' : ''));?>
                            <div class="editing <?php echo isset($is_view['access']) ? '' : 'hide'?>"><?php echo isset($sale_job->access) ? $sale_job->access : ''; ?></div>
                        </td>
                    </tr>

                    <!-- ホームページURL -->
                    <tr>
                        <th>
                            <p>ホームページURL</p>
                            <div class="text-explain">※会社ホームページがある場合、入力いただくと掲載内容に表示されます</div>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['url_home_page']) ? $validate['url_home_page'] : '';?></span>
                            <?php echo Form::input('url_home_page', Input::post('url_home_page') !== null ? Input::post('url_home_page') : (isset($json) ? $json->url_home_page : ''), array('id' => 'hp', 'maxlength' => 50, 'class' => isset($validate['url_home_page']) ? 'error_box' : ''));?>
                            <div class="editing <?php echo isset($is_view['url_home_page']) ? '' : 'hide'?>"><?php echo isset($sale_job->url_home_page) ? $sale_job->url_home_page : ''; ?></div>
                        </td>
                    </tr>

                    <!-- 雇用形態 -->
                    <tr>
                        <th>
                            <p>雇用形態</p><span class="essential">必須</span>
                            <div class="text-explain">※複数選択可</div>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['employment_mark']) ? $validate['employment_mark'] : '';?></span>
                            <ul class="check_list fm_chk fm_required <?php echo isset($validate['employment_mark']) ? 'error_box' : '';?>">
                                <?php
                                $arr_employment_edit = [];
                                $arr_employment_old= [];
                                if(Input::get('job_id')) {
                                    $arr_employment_edit = isset($json) ? explode(',', trim($json->employment_mark, ',')) : explode(',', trim($sale_job->employment_mark, ','));
                                    $arr_employment_old = explode(',', trim($sale_job->employment_mark, ','));
                                }
                                foreach(Constants::$sales_employment_type as $k => $v) {
                                    $check = '';
                                    if (Input::post('employment_mark') && in_array($k,Input::post('employment_mark'))) {
                                        $check = 'checked';
                                    }
                                    if (Input::method() != 'POST' && Input::get('job_id') && in_array($k, $arr_employment_edit)) {
                                        $check = 'checked';
                                    }
                                    ?>
                                    <li>
                                        <input <?php echo $check;?> name="employment_mark[]" id="d_<?php echo $k;?>" value="<?php echo $k;?>" type="checkbox">
                                        <label for="d_<?php echo $k;?>" class="<?php echo isset($is_view['employment_mark']) && ((!in_array($k, $arr_employment_old) && in_array($k, $arr_employment_edit)) || (in_array($k, $arr_employment_old) && !in_array($k, $arr_employment_edit))) ? 'editing' : ''?>"><?php echo $v;?></label>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </td>
                    </tr>

                    <!-- 職業 -->
                    <tr>
                        <th>
                            <p>職業1</p><span class="essential">必須</span>
                            <div class="text-explain">※該当する職業を2つまで選択</div>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['job_type']) ? $validate['job_type'] : '';?></span>
                            <?php echo Form::select('job_type', Input::post('job_type') !== null ? Input::post('job_type') : (isset($json) ? $json->job_type : ''), Constants::$job_type, array('class' => isset($validate['job_type']) ? 'error_box' : '')); ?>
                            <div class="editing <?php echo isset($is_view['job_type']) ? '' : 'hide'?>"><?php echo isset($sale_job->job_type) ? Constants::$job_type[$sale_job->job_type] : ''; ?></div>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <p>職業2</p
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['job_type2']) ? $validate['job_type2'] : '';?></span>
                            <?php echo Form::select('job_type2', Input::post('job_type2') !== null ? Input::post('job_type2') : (isset($json->job_type2) ? $json->job_type2 : ''), Constants::$job_type, array('class' => isset($validate['job_type2']) ? 'error_box' : '')); ?>
                            <div class="editing <?php echo isset($is_view['job_type2']) ? '' : 'hide'?>"><?php echo isset($sale_job->job_type2) ? Constants::$job_type[$sale_job->job_type2] : ''; ?></div>
                        </td>
                    </tr>

                    <!-- 職種 -->
                    <tr>
                        <th>
                            <p>職種</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['job_name']) ? $validate['job_name'] : '';?></span>
                            <?php echo Form::input('job_name', Input::post('job_name') !== null ? Input::post('job_name') : (isset($json) ? $json->job_name : ''), array('id' => 'category', 'maxlength' => 100, 'class' => isset($validate['job_name']) ? 'error_box' : ''));?>
                            <div class="editing <?php echo isset($is_view['job_name']) ? '' : 'hide'?>"><?php echo isset($sale_job->job_name) ? $sale_job->job_name : ''; ?></div>
                            <div class="text-example">例）未経験ＯＫ！給油がメインのガソリンスタンドスタッフ</div>
                        </td>
                    </tr>

                    <!-- 給与形態 -->
                    <tr>
                        <th>
                            <p>給与形態</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['salary_type']) ? $validate['salary_type'] : '';?></span>
                            <?php echo Form::select('salary_type', Input::post('salary_type') !== null ? Input::post('salary_type') : (isset($json->salary_type) ? $json->salary_type : ''), Constants::$sales_salary_type, array('class' => isset($validate['salary_type']) ? 'error_box' : '')); ?>
                            <div class="editing <?php echo isset($is_view['salary_type']) ? '' : 'hide'?>"><?php echo isset($sale_job->salary_type) ? Constants::$sales_salary_type[$sale_job->salary_type] : ''; ?></div>
                        </td>
                    </tr>

                    <!-- 給与 -->
                    <tr>
                        <th>
                            <p>給与</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['salary_des']) ? $validate['salary_des'] : '';?></span>
                            <?php echo Form::input('salary_des', Input::post('salary_des') !== null ? Input::post('salary_des') : (isset($json) ? $json->salary_des : ''), array('id' => 'pay', 'maxlength' => 100, 'class' => isset($validate['salary_des']) ? 'error_box' : ''));?>
                            <div class="editing <?php echo isset($is_view['salary_des']) ? '' : 'hide'?>"><?php echo isset($sale_job->salary_des) ? $sale_job->salary_des : ''; ?></div>
                            <div class="text-example">例）時給1000円以上（普通運転免許がある方は50円ＵＰ）</div>
                        </td>
                    </tr>

                    <!-- 最低時給 -->
                    <tr>
                        <th>
                            <p>最低時給</p><span class="essential">必須</span>
                            <div class="text-explain">※給与形態が時給の場合のみ</div>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['salary_min']) ? $validate['salary_min'] : '';?></span>
                            <?php echo Form::input('salary_min', Input::post('salary_min') !== null ? Input::post('salary_min') : (isset($json) ? $json->salary_min : ''), array('class' => isset($validate['salary_min']) ? 'wth_30 error_box' : 'wth_30', 'id' => 'pay2', 'maxlength' => 6));?>
                            <span>円</span>
<!--                            <span class="sample"><a href="javascript:void(0)">入力値のサンプルはこちら（PDF）</a></span>-->
                            <div class="editing <?php echo isset($is_view['salary_min']) ? '' : 'hide'?>"><?php echo isset($sale_job->salary_min) ? $sale_job->salary_min : ''; ?></div>
                            <div class="text-example">例）1000</div>
                        </td>
                    </tr>

                    <!-- キャッチコピー -->
                    <tr>
                        <th>
                            <p>キャッチコピー</p>
                            <div class="text-explain">※一番目立つ部分に表示されます</div>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['catch_copy']) ? $validate['catch_copy'] : '';?></span>
                            <textarea class="<?php echo isset($validate['catch_copy']) ? 'error_box' : '';?>" name="catch_copy"><?php echo Input::post('catch_copy') !== null ? Input::post('catch_copy') : (isset($json) ? $json->catch_copy : '');?></textarea>
                            <div class="editing <?php echo isset($is_view['catch_copy']) ? '' : 'hide'?>"><?php echo isset($sale_job->catch_copy) ? nl2br($sale_job->catch_copy) : ''; ?></div>
                            <div class="text-example">例）高校生さん・大学生さん・フリーターさんが活躍中のお店です！</div>
                        </td>
                    </tr>

                    <!-- リード -->
                    <tr>
                        <th>
                            <p>リード</p>
                            <div class="text-explain">※キャッチコピーの補足</div>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['lead']) ? $validate['lead'] : '';?></span>
                            <textarea class="<?php echo isset($validate['lead']) ? 'error_box' : '';?>" name="lead"><?php echo Input::post('lead') !== null ? Input::post('lead') : (isset($json) ? $json->lead : '');?></textarea>
                            <div class="editing <?php echo isset($is_view['lead']) ? '' : 'hide'?>"><?php echo isset($sale_job->lead) ? nl2br($sale_job->lead) : ''; ?></div>
                            <div class="text-example">例）未経験スタートの方がほとんどだから、初めてで不安な気持ち分かります！しっかりフォローするから安心してくださいね</div>
                        </td>
                    </tr>

                    <!-- 表示勤務時間帯 -->
                    <tr>
                        <th>
                            <p>表示勤務時間帯</p>
                            <div class="text-explain">※おおよその時間帯を選択</div>
                        </th>
                        <td>
                            <?php
                            $arr_work_time_edit = [];
                            $arr_work_time_old = [];

                            if(Input::get('job_id')) {
                                $arr_work_time_edit = isset($json) ? explode(',', trim($json->work_time_view, ',')) : explode(',', trim($sale_job->work_time_view, ','));
                                $arr_work_time_old = explode(',', trim($sale_job->work_time_view, ','));
                            }
                            ?>
                            <ul class="check_list fm_chk fm_required">
                            <?php
                            foreach(Constants::$sale_work_time_view as $k => $v) {
                                $check = '';
                                if (Input::post('work_time_view') && in_array($k,Input::post('work_time_view'))) {
                                    $check = 'checked';
                                }
                                if (Input::method() != 'POST' && Input::get('job_id') && in_array($k, $arr_work_time_edit)) {
                                    $check = 'checked';
                                }
                            ?>
                                <li>
                                    <input name="work_time_view[]" id="chk_<?php echo $k;?>" value="<?php echo $k;?>" type="checkbox" <?php echo $check;?>>
                                    <label class="<?php echo isset($is_view['work_time_view']) && ((in_array($k, $arr_work_time_old) && !in_array($k, $arr_work_time_edit)) || (!in_array($k, $arr_work_time_old) && in_array($k, $arr_work_time_edit))) ? 'editing' : ''?>" for="chk_<?php echo $k;?>"><?php echo $v;?></label>
                                </li>
                            <?php
                            }
                            ?>
                            </ul>
                        </td>
                    </tr>

                    <!-- 週当たり最低勤務日数 -->
                    <tr>
                        <th>
                            <p>週当たり最低勤務日数</p><span class="essential">必須</span>
                            <div class="text-explain">※週2日以上が必須であれば、2を入力</div>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['work_day_week']) ? $validate['work_day_week'] : '';?></span>
                            <?php echo Form::input('work_day_week', Input::post('work_day_week') !== null ? Input::post('work_day_week') : (isset($json) ? $json->work_day_week : ''), array('maxlength' => '1', 'class' => isset($validate['work_day_week']) ? 'wth_30 error_box' : 'wth_30', 'id' => 'working_days'));?>
                            <span>日</span>
                            <div class="editing <?php echo isset($is_view['work_day_week']) ? '' : 'hide'?>"><?php echo isset($sale_job->work_day_week) ? $sale_job->work_day_week : ''; ?></div>
                        </td>
                    </tr>

                    <!-- 勤務曜日・時間について -->
                    <tr>
                        <th>
                            <p>勤務曜日・時間について</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['work_time_des']) ? $validate['work_time_des'] : '';?></span>
                            <textarea class="<?php echo isset($validate['work_time_des']) ? 'error_box' : '';?>" style="height: 95px;" name="work_time_des"><?php echo Input::post('work_time_des') !== null ? Input::post('work_time_des') : (isset($json) ? $json->work_time_des : '');?></textarea>
                            <div class="editing <?php echo isset($is_view['work_time_des']) ? '' : 'hide'?>"><?php echo isset($sale_job->work_time_des) ? nl2br($sale_job->work_time_des) : ''; ?></div>
                            <div class="text-example">例）8：00～22：00の間で5時間ぐらいの勤務です。希望に沿ってシフトを作成するので、面接の際に相談してください。2週間ごとのシフトなので、予定を合わせやすいです。</div>
                        </td>
                    </tr>

                    <!-- 資格 -->
                    <tr>
                        <th>
                            <p>資格</p>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['qualification']) ? $validate['qualification'] : '';?></span>
                            <?php echo Form::input('qualification', Input::post('qualification') !== null ? Input::post('qualification') : (isset($json) ? $json->qualification : ''), array('class' => isset($validate['qualification']) ? 'error_box' : '', 'id' => 'certificate', 'maxlength' => 200));?>
                            <div class="editing <?php echo isset($is_view['qualification']) ? '' : 'hide'?>"><?php echo isset($sale_job->qualification) ? $sale_job->qualification : ''; ?></div>
                            <div class="text-example">例1）資格や学歴は不問です<br>
                                例2）普通自動車運転免許をお持ちの方に限る</div>
                        </td>
                    </tr>

                    <!-- 採用予定人数 -->
                    <tr>
                        <th>
                            <p>採用予定人数</p>
                        </th>
                        <td>
                            <ul class="variable">
                                <li>
                                    <?php
                                    Constants::$employment_people[''] = '選択してください';
                                    echo Form::select('employment_people', Input::post('employment_people') !== null ? Input::post('employment_people') : (isset($json) ? $json->employment_people : ''), Constants::$employment_people);
                                    ?>
                                    <div class="editing <?php echo isset($is_view['employment_people']) ? '' : 'hide'?>"><?php echo isset($sale_job->employment_people) ? Constants::$employment_people[$sale_job->employment_people] : ''; ?></div>
                                </li>
                                <li class="hide">
                                    <span class="red"><?php echo isset($validate['employment_people_num']) ? $validate['employment_people_num'] : '';?></span>
                                    <?php echo Form::input('employment_people_num', Input::post('employment_people_num') !== null ? Input::post('employment_people_num') : (isset($json) ? $json->employment_people_num : ''), array('class' => isset($validate['employment_people_num']) ? 'wth_50 error_box' : 'wth_50', 'maxlength' => 7));?>
                                    <span>人</span>
                                    <div class="editing <?php echo isset($is_view['employment_people_num']) ? '' : 'hide'?>"><?php echo isset($sale_job->employment_people_num) ? $sale_job->employment_people_num : ''; ?></div>
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <!-- 仕事内容 -->
                    <tr>
                        <th>
                            <p>仕事内容</p>
                        </th>
                        <td>
                            <ul>
                                <li>
                                    <span>見出し</span>
                                    <span class="red"><?php echo isset($validate['job_title']) ? $validate['job_title'] : '';?></span>
                                    <?php echo Form::input('job_title', Input::post('job_title') !== null ? Input::post('job_title') : (isset($json) ? $json->job_title : ''), array('class' => isset($validate['job_title']) ? 'error_box' : '', 'id' => 'midashi1', 'maxlength' => 100));?>
                                    <div class="editing <?php echo isset($is_view['job_title']) ? '' : 'hide'?>"><?php echo isset($sale_job->job_title) ? $sale_job->job_title : ''; ?></div>
                                    <div class="text-example">例）初めての方も大丈夫！</div>
                                </li>
                                <li>
                                    <span>本文</span>
                                    <textarea name="job_description"><?php echo Input::post('job_description') !== null ? Input::post('job_description') : (isset($json) ? $json->job_description : '');?></textarea>
                                    <div class="editing <?php echo isset($is_view['job_description']) ? '' : 'hide'?>"><?php echo isset($sale_job->job_description) ? nl2br($sale_job->job_description) : ''; ?></div>
                                    <div class="text-example">例）ガソリンや軽油を、トラックや乗用車に給油します。まずは先輩の研修を受けて、お手本をみながら作業するので安心です。そのほか、洗車やカーケア用品の販売なども、慣れてきたらお願いします。</div>
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <!-- 募集内容 -->
                    <tr>
                        <th>
                            <p>募集内容</p>
                            <div class="text-explain">※補足情報があればこちらへ入力</div>
                        </th>
                        <td>
                            <ul>
                                <li>
                                    <span>見出し</span>
                                    <span class="red"><?php echo isset($validate['recruit_title']) ? $validate['recruit_title'] : '';?></span>
                                    <?php echo Form::input('recruit_title', Input::post('recruit_title') !== null ? Input::post('recruit_title') : (isset($json) ? $json->recruit_title : ''), array('class' => isset($validate['recruit_title']) ? 'error_box' : '', 'id' => 'midashi2', 'maxlength' => 100));?>
                                    <div class="editing <?php echo isset($is_view['recruit_title']) ? '' : 'hide'?>"><?php echo isset($sale_job->recruit_title) ? $sale_job->recruit_title : ''; ?></div>
                                    <div class="text-example">例）待遇</div>
                                </li>
                                <li>
                                    <span>本文</span>
                                    <textarea name="recruit_description"><?php echo Input::post('recruit_description') !== null ? Input::post('recruit_description') : (isset($json) ? $json->recruit_description : '');?></textarea>
                                    <div class="editing <?php echo isset($is_view['recruit_description']) ? '' : 'hide'?>"><?php echo isset($sale_job->recruit_description) ? nl2br($sale_job->recruit_description) : ''; ?></div>
                                    <div class="text-example">例）車・バイク通勤の方も交通費を支給します。お得なスタッフ価格で、ガソリンを給油できます！</div>
                                </li>
                            </ul>
                        </td>
                    </tr>

                    <!--
                    <tr>
                        <th>
                            <p>代表番号</p>
                        </th>
                        <td>
                            <input value="<?php echo $login_info['tel'];?>" disabled="" type="text">
                        </td>
                    </tr>

                    <tr>
                        <th> <p>担当者</p>
                        </th>
                        <td>
                            <input value="<?php echo $login_info['staff_name'];?>" disabled="" type="text">
                        </td>
                    </tr>

                    <tr>
                        <th> <p>メールアドレス</p>
                        </th>
                        <td>
                            <input value="<?php echo $login_info['email'];?>" disabled="" type="text">
                        </td>
                    </tr>
                    -->

                    <!-- こだわり検索 -->
                    <tr>
                        <th>
                            <p>こだわり検索</p>
                            <div class="text-explain">※求人情報に該当する項目をお選びください。複数選択可。</div>
                        </th>
                        <td>
                            <?php foreach (Trouble::$categories as $k => $v) {?>
                            <dl class="category">
                                <dt><?php echo htmlspecialchars($v['name']) ?></dt>
                                <dd>
                                    <ul class="check_list fm_chk fm_required">
                                        <?php
                                        $trouble_old = Input::get('job_id') ? $sale_job->trouble : '';
                                        foreach (Trouble::$trouble as $key => $value) {
                                            if ($k == $value['category'] && $value['pubname']) {
                                                $class = '';
                                                if(
                                                    isset($is_view['trouble']) && (
                                                        !substr_count($json->trouble, ',' . $value['id'] . ',') && substr_count($trouble_old, ',' . $value['id'] . ',') ||
                                                        substr_count($json->trouble, ',' . $value['id'] . ',') && !substr_count($trouble_old, ',' . $value['id'] . ',')
                                                    )
                                                ) {
                                                    $class = 'editing';
                                                }

                                                $check = false;
                                                if (Input::post('trouble') && in_array($value['id'], Input::post('trouble'))) {
                                                    $check = true;
                                                }
                                                if (Input::method() != 'POST' &&  isset($json) && substr_count($json->trouble, ',' . $value['id'] . ',')) {
                                                    $check = true;
                                                }

                                                ?>
                                                <li>
                                                    <?php echo \Fuel\Core\Form::checkbox('trouble['.$value['id'].']', $value['id'], $check); ?>
                                                    <label for="form_trouble[<?php echo $value['id'];?>]" class="<?php echo $class;?>"><?php echo $value['pubname'];?></label>
                                                </li>
                                            <?php }
                                        }?>
                                    </ul>
                                </dd>
                            </dl>
                            <p>&#12288;</p>
                            <?php }?>
                        </td>
                    </tr>

                    </tbody></table>



                <!-- 送信ボタン START -->
                <ul class="transmission">
                    <li>
                        <input value="プレビュー" id="fm_btn_previes" type="button">
                    </li>
                    <li>
                        <input value="入力内容を確認する" id="fm_btn_confirm" type="submit">
                    </li>
                </ul>
                <!-- 送信ボタン END -->


            </form></div>
    </section>

    <!-- MODAL SEARCH SHOP -->
        <div id="shopfinder" class="remodal" data-remodal-id="modal" tabindex="-1">
            <button data-remodal-action="close" class="remodal-close"></button>
            <form class="finder">
            <section id="search">
                <dl class="search">
                    <dt><input class="modal_keyword_search" style="padding: 0 10px 0 10px;" value="" placeholder="" type="text"></dt>
                    <dd><button type="button" id="btn_search_shop"><span></span></button></dd>
                </dl>
            </section>
            </form>

            <table>
                <thead>
                <tr>
                    <th>検索結果</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>


        </div>
    <!-- END MODAL SEARCH SHOP -->
