<?php
if (\Fuel\Core\Input::method() == 'POST') {
    $row = \Fuel\Core\Input::post();
    $row['gender'] = isset($row['gender']) ?  $row['gender'] : null;
    foreach($row as $key => &$value){
        $value = htmlentities($value);
    }
}

if(\Fuel\Core\Input::get('back')){
    foreach($row as $key => &$value){
        $value = htmlentities(htmlspecialchars_decode($value));
    }
}
$show_error = function ($field) use ($errors) {
    if (isset($errors[$field])) {
        return array('mes' => '<span class="red">' . $errors[$field] . '</span>', 'class' => 'error_box');
    }
    return array('mes' => '', 'class' => '');
};

?>
<ul class="navi">
    <!--<li><a href="">実績</a></li>-->
    <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/jobs">求人管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/persons">応募者管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/summary">サマリー</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/shops">店舗管理</a></li>
</ul>
<h1>応募者</h1>
<section>
    <div class="page01-box">
        <form id="fm_action" method="post" action="<?php echo \Fuel\Core\Uri::base()?>customer/person?person_id=<?php echo \Fuel\Core\Input::get('person_id')?>" class="h-adr">
            <input type="hidden" name="person_id" value="<?php echo \Fuel\Core\Input::get('person_id') ?>"/>
            <table>
                <!-- 掲載プラン -->
                <tbody>
                <tr>
                    <th><p>掲載プラン</p>
                    </th>
                    <input type="hidden" name="plan_code" value="employment"/>
                    <td>採用課金</td>
                </tr>
                <!-- 応募日時 -->
                <tr>
                    <th>
                        <p>応募日時</p>
                        <span class="essential">必須</span>
                    </th>
                    <td>
                        <ul class="variable">
                            <?php
                            $error = $show_error('application_time_d');
                            echo $error['mes'];
                            ?>
                            <li>
                                <input name="application_time_d" class="dateform <?php echo $error['class']?>" placeholder="" value="<?php echo $row['application_time_d']?>" type="text">
                            </li>
                            <li>
                                <select name="application_time_h">
                                    <?php

                                    for ($i = 0; $i < 24; ++$i) {
                                        if($i == $row['application_time_h'])
                                            echo '<option selected="selected" value="' . str_pad($i, 2, 0, STR_PAD_LEFT) . '">' . str_pad($i, 2, 0, STR_PAD_LEFT) . '</option>';
                                        else
                                            echo '<option value="' . str_pad($i, 2, 0, STR_PAD_LEFT) . '">' . str_pad($i, 2, 0, STR_PAD_LEFT) . '</option>';
                                    }
                                    ?>
                                </select>
                                <span>時</span>
                            </li>
                            <li>
                                <select name="application_time_m">
                                    <?php
                                    for ($i = 0; $i < 60; ++$i) {
                                        if($i == $row['application_time_m'])
                                            echo '<option selected="selected" value="' . str_pad($i, 2, 0, STR_PAD_LEFT) . '">' . str_pad($i, 2, 0, STR_PAD_LEFT) . '</option>';
                                        else
                                            echo '<option value="' . str_pad($i, 2, 0, STR_PAD_LEFT) . '">' . str_pad($i, 2, 0, STR_PAD_LEFT) . '</option>';
                                    }
                                    ?>
                                </select>
                                <span>分</span>
                            </li>
                        </ul>

                    </td>
                </tr>
                <!-- 応募対象求人 -->
                <tr>
                    <th><p>応募対象求人</p></th>
                    <td>
                        <?php echo $row['shop_name'] ?>
                        <input type="hidden" value="<?php echo $row['job_name'] ?>" name="job_name">
                        <input type="hidden" value="<?php echo $row['shop_name'] ?>" name="shop_name">
                        <input type="hidden" value="<?php echo $row['job_id'] ?>" name="job_id">
                    </td>
                </tr>
                <!-- 氏名 -->
                <tr>
                    <th><p>氏名</p>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('person_name');
                        echo $error['mes'];
                        ?>
                        <input name="person_name" class="<?php echo $error['class'] ?>"
                               value="<?php echo $row['person_name'] ?>" id="person_name" placeholder="氏名を入力してください"
                               maxlength="50" type="text">
                    </td>
                </tr>
                <!-- かな -->
                <tr>
                    <th>
                        <p>かな</p><span class="essential">必須</span>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('person_kana');
                        echo $error['mes'];
                        ?>
                        <input name="person_kana" class="<?php echo $error['class'] ?>"
                               value="<?php echo $row['person_kana'] ?>" id="kana" placeholder="かなを入力してください"
                               maxlength="50" type="text">
                    </td>
                </tr>

                <!-- 生年月日 -->
                <tr>
                    <th>
                        <p>生年月日</p><span class="essential">必須</span>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('birthday');
                        echo $error['mes'];
                        ?>
                        <ul class="variable <?php echo $error['class'] ?>">
                            <li>
                                <select name="birthday_y">
                                    <option value="">----</option>
                                    <?php
                                    $year_limit = date('Y') - 12;
                                    for ($i = $year_limit; $i >= 1940; --$i)
                                        if ($row['birthday_y'] == $i)
                                            echo '<option selected="selected" value="' . str_pad($i, 2, 0, STR_PAD_LEFT) . '">' . str_pad($i, 2, 0, STR_PAD_LEFT) . '</option>';
                                        else
                                            echo '<option value="' . str_pad($i, 2, 0, STR_PAD_LEFT) . '">' . str_pad($i, 2, 0, STR_PAD_LEFT) . '</option>';
                                    ?>
                                </select>
                                <span>年</span>
                            </li>
                            <li>
                                <select name="birthday_m">
                                    <option value="">--</option>
                                    <?php
                                    for ($i = 1; $i <= 12; ++$i) {
                                        if ($row['birthday_m'] == $i)
                                            echo '<option selected="selected" value="' . str_pad($i, 2, 0, STR_PAD_LEFT) . '">' . str_pad($i, 2, 0, STR_PAD_LEFT) . '</option>';
                                        else
                                            echo '<option value="' . str_pad($i, 2, 0, STR_PAD_LEFT) . '">' . str_pad($i, 2, 0, STR_PAD_LEFT) . '</option>';
                                    }
                                    ?>
                                </select>
                                <span>月</span>
                            </li>
                            <li>
                                <select name="birthday_d">
                                    <option value="">--</option>
                                    <?php
                                    for ($i = 1; $i <= 31; ++$i) {
                                        if ($row['birthday_d'] == $i)
                                            echo '<option selected="selected" value="' . str_pad($i, 2, 0, STR_PAD_LEFT) . '">' . str_pad($i, 2, 0, STR_PAD_LEFT) . '</option>';
                                        else
                                            echo '<option value="' . str_pad($i, 2, 0, STR_PAD_LEFT) . '">' . str_pad($i, 2, 0, STR_PAD_LEFT) . '</option>';
                                    }
                                    ?>
                                </select>
                                <span>日</span>
                            </li>
                        </ul>

                    </td>
                </tr>

                <!-- 性別 -->
                <tr>
                    <th>
                        <p>性別</p>
                        <span class="essential">必須</span>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('gender');
                        echo $error['mes'];
                        ?>
                        <ul class="check_list fm_chk fm_required <?php echo $error['class'] ?>">
                            <li>
                                <input name="gender" id="s_1"
                                       value="1" <?php if ($row['gender'] == '1') echo 'checked="checked"' ?> type="radio">
                                <label for="s_1">男性</label>
                            </li>
                            <li>
                                <input name="gender" id="s_2"
                                       value="2" <?php if ($row['gender'] == '2') echo 'checked="checked"' ?> type="radio">
                                <label for="s_2">女性</label>
                            </li>
                        </ul>
                    </td>
                </tr>

                <!-- 郵便番号 -->
                <tr>
                    <th><p>郵便番号</p>
                    </th>
                    <td>
                        <?php
                        $error1 = $show_error('zipcode1');
                        $error2 = $show_error('zipcode2');
                        echo $error1['mes'] ? $error1['mes'] : $error2['mes'];
                        $class = $error1['class'] ? $error1['class'] : $error2['class'];
                        ?>
                        <input class="wth_20 p-postal-code <?php echo $class ?>" value="<?php echo $row['zipcode1'] ?>"
                               name="zipcode1" placeholder="" maxlength="3" type="text">
                        -
                        <input class="wth_20 p-postal-code <?php echo $class ?>" value="<?php echo $row['zipcode2'] ?>"
                               name="zipcode2" placeholder="" maxlength="4" type="text">
                    </td>
                </tr>

                <!-- 都道府県 -->
                <tr>
                    <th><p>都道府県</p>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('prefecture_id');
                        if ($error['mes']) {
                            echo $error['mes'];
                            echo '<ul class="variable error_box"><li>';
                            echo \Fuel\Core\Form::select('prefecture_id', $row['prefecture_id'], Constants::$addr1, array('id' => 'prefecture_id', 'class' => 'selectBox200 error_box'));
                            echo '</li></ul>';
                        } else {
                            echo \Fuel\Core\Form::select('prefecture_id', $row['prefecture_id'], Constants::$addr1, array('id' => 'prefecture_id', 'class' => 'selectBox200'));
                        }
                        ?>
                    </td>
                </tr>

                <!-- 市区町村 -->
                <tr>
                    <th>
                        <p>市区町村</p>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('city');
                        echo $error['mes'];
                        ?>
                        <input
                            class="p-locality p-street-address p-extended-address <?php echo $error['class'] ?>" value="<?php echo $row['city'] ?>"
                            name="city" placeholder="市区町村を入力してください" maxlength="10" type="text">
                    </td>
                </tr>

                <!-- 以降の住所 -->
                <tr>
                    <th><p>以降の住所</p>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('town');
                        echo $error['mes'];
                        ?>
                        <input
                            class="p-locality p-street-address p-extended-address <?php echo $error['class'] ?>" value="<?php echo $row['town'] ?>"
                            name="town"
                            placeholder="番地・ビル名などを入力してください" maxlength="50" type="text"></td>
                </tr>

                <!-- 電話番号（携帯） -->
                <tr>
                    <th><p>電話番号（携帯）</p>
                    </th>
                    <td>
                        <?php
                        $error1 = $show_error('mobile1');
                        $error2 = $show_error('mobile2');
                        $error3 = $show_error('mobile3');
                        $class = '';
                        if ($error1['mes'] || $error2['mes'] || $error3['mes']) {
                            echo '<span class="red">' . ($error1['mes'] ? $error1['mes'] : ($error2['mes'] ? $error2['mes'] : $error3['mes'])) . '</span>';
                            $class = 'error_box';
                        }
                        ?>
                        <input class="wth_20 <?php echo $class ?>" value="<?php echo $row['mobile1'] ?>" name="mobile1"
                               placeholder="" maxlength="5" type="text">
                        -
                        <input class="wth_20 <?php echo $class ?>" value="<?php echo $row['mobile2'] ?>" name="mobile2"
                               placeholder="" maxlength="4" type="text">
                        -
                        <input class="wth_20 <?php echo $class ?>" value="<?php echo $row['mobile3'] ?>" name="mobile3"
                               placeholder="" maxlength="4" type="text">
                    </td>
                </tr>

                <!-- 電話番号（固定） -->
                <tr>
                    <th><p>電話番号（固定）</p>
                    </th>
                    <td>
                        <?php
                        $error1 = $show_error('tel1');
                        $error2 = $show_error('tel2');
                        $error3 = $show_error('tel3');
                        $class = '';
                        if ($error1['mes'] || $error2['mes'] || $error3['mes']) {
                            echo '<span class="red">' . ($error1['mes'] ? $error1['mes'] : ($error2['mes'] ? $error2['mes'] : $error3['mes'])) . '</span>';
                            $class = 'error_box';
                        }
                        ?>
                        <input class="wth_20 <?php echo $class ?>" value="<?php echo $row['tel1'] ?>" name="tel1"
                               placeholder="" maxlength="5" type="text">
                        -
                        <input class="wth_20 <?php echo $class ?>" value="<?php echo $row['tel2'] ?>" name="tel2"
                               placeholder="" maxlength="4" type="text">
                        -
                        <input class="wth_20 <?php echo $class ?>" value="<?php echo $row['tel3'] ?>" name="tel3"
                               placeholder="" maxlength="4" type="text">
                    </td>
                </tr>

                <!-- メールアドレス -->
                <tr>
                    <th><p>メールアドレス1</p><span class="essential">必須</span>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('mail_addr1');
                        echo $error['mes'];
                        ?>
                        <input class="wth_70 <?php echo $error['class'] ?>" value="<?php echo $row['mail_addr1'] ?>"
                               name="mail_addr1" placeholder="メールアドレスを入力してください" maxlength="255"
                               type="text">
                    </td>
                </tr>

                <!-- メールアドレス -->
                <tr>
                    <th><p>メールアドレス2</p>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('mail_addr2');
                        echo $error['mes'];
                        ?>
                        <input class="wth_70 <?php echo $error['class'] ?>" value="<?php echo $row['mail_addr2'] ?>"
                               name="mail_addr2" placeholder="メールアドレスを入力してください" maxlength="255"
                               type="text">
                    </td>
                </tr>

                <!-- 現在職種 -->
                <tr>
                    <th>
                        <p>現在職種</p>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('occupation_now');
                        if ($error['mes']) {
                            echo $error['mes'];
                            echo '<ul class="variable error_box"><li>';
                            echo \Fuel\Core\Form::select('occupation_now', $row['occupation_now'], Constants::$occupation_now, array('id' => 'occupation_now', 'class' => 'error_box'));
                            echo '</li></ul>';
                        } else {
                            echo \Fuel\Core\Form::select('occupation_now', $row['occupation_now'], Constants::$occupation_now, array('id' => 'occupation_now',));
                        }
                        ?>
                    </td>
                </tr>

                <!-- その他備考 -->
                <tr>
                    <th>
                        <p>その他備考</p></th>
                    <td>
                        <textarea name="note" placeholder=""><?php echo $row['note'] ?></textarea>
                    </td>
                </tr>

                </tbody>
            </table>


            <!-- 送信ボタン START -->
            <ul class="transmission">
                <li>
                    <input value="確認" id="fm_btn_confirm" type="submit">
                </li>
            </ul>
            <!-- 送信ボタン END -->

        </form>
    </div>
</section>

