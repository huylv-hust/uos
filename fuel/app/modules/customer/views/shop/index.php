<?php
if (\Fuel\Core\Input::method() == 'POST') {
    $row = \Fuel\Core\Input::post();
    foreach($row as $key => &$value)
    {
        if(!is_array($value)){
            $value = htmlspecialchars($value);
        }
    }
    $arr_station = array();
    for ($i = 0; $i < 3; ++$i) {
        $arr_station[] = array(
            'company' => htmlspecialchars($row['station_company'][$i]),
            'line' => htmlspecialchars($row['station_line'][$i]),
            'name' => htmlspecialchars($row['station_name'][$i]),
            'time' => htmlspecialchars($row['station_time'][$i]),
        );
    }
    $row['stations'] = $arr_station;
}


$show_error = function ($field) use ($errors) {
    if (isset($errors[$field])) {
        return array('mes' => '<span class="red">' . $errors[$field] . '</span>', 'class' => 'class="error_box"');
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
<h1>店舗</h1>
<p class="comment">募集対象となる店舗情報のご登録をお願いします。</p>
<section>
    <div class="page01-box">
        <form id="fm_action" method="post" action="" class="h-adr">
            <input type="hidden" name="shop_id" value="<?php echo (int)$row['shop_id'] ?>">
            <input type="hidden" name="customer_id" value="<?php echo $row['customer_id'] ?>">
            <table>
                <!-- 店舗名 -->
                <tbody>
                <tr>
                    <th>
                        <p>店舗名</p><span class="essential">必須</span>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('shop_name');
                        echo $error['mes'];
                        ?>
                        <input name="shop_name" <?php echo $error['class'] ?> id="shop_name" placeholder="店舗名を入力してください"
                               value="<?php  echo  $row['shop_name'] ?>" maxlength="50" type="text">
                        <div class="text-example">例）国道3636号しごさがステーション</div>
                    </td>
                </tr>
                <!-- 店舗名かな -->
                <tr>
                    <th>
                        <p>店舗名かな</p><span class="essential">必須</span>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('shop_kana');
                        echo $error['mes'];
                        ?>
                        <input name="shop_kana" <?php echo $error['class'] ?> id="shop_kana"
                               value="<?php echo $row['shop_kana'] ?>" placeholder="店舗名かなを入力してください" maxlength="50"
                               type="text">
                        <div class="text-example">例）こくどうさんろくさんろくごうしごさがすてーしょん</div>
                    </td>
                </tr>

                <!-- 都道府県 -->
                <tr>
                    <th>
                        <p>都道府県</p><span class="essential">必須</span>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('prefecture_id');
                        if ($error['mes']) {
                            echo $error['mes'];
                            echo \Fuel\Core\Form::select('prefecture_id', $row['prefecture_id'], Constants::$addr1, array('id' => 'id_addr1', 'class' => 'error_box'));
                        } else {
                            echo \Fuel\Core\Form::select('prefecture_id', $row['prefecture_id'], Constants::$addr1, array('id' => 'id_addr1', 'class' => 'selectBox200'));
                        }
                        ?>
                        <div class="text-example">例）愛知県</div>
                    </td>
                </tr>
                <!-- 市区町村 -->
                <tr>
                    <th><p>市区町村</p><span class="essential">必須</span>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('city');
                        echo $error['mes'];
                        ?>
                        <input <?php echo $error['class'] ?> name="city" value="<?php echo $row['city'] ?>"
                                                             placeholder="市区町村を入力してください" maxlength="10" type="text">
                        <div class="text-example">例）名古屋市中村区　（政令指定都市の場合は区まで入力）</div>
                    </td>
                </tr>
                <!-- 以降の住所 -->
                <tr>
                    <th>
                        <p>以降の住所</p>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('town');
                        echo $error['mes'];
                        ?>
                        <input value="<?php echo $row['town'] ?>" <?php echo $error['class'] ?> name="town"
                               placeholder="番地・ビル名などを入力してください" maxlength="50" type="text">
                        <div class="text-example">例）名駅南0-00-00しごさがビル</div>
                    </td>
                </tr>
                <!-- アクセス -->
                <tr>
                    <th>
                        <p>アクセス</p>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('access');
                        echo $error['mes'];
                        ?>
                        <input name="access" id="access" <?php echo $error['class'] ?>
                               value="<?php echo $row['access'] ?>" placeholder="アクセスを入力してください" maxlength="50"
                               type="text">
                        <div class="text-example">例）国道3636号沿いのコンビニとなり、●●の看板が目印です</div>
                    </td>
                </tr>
                <!-- 最寄駅 -->
                <tr>
                    <th>
                        <p>最寄り駅</p>
                    </th>
                    <td>
                        <?php
                        for ($i = 0; $i < 3; ++$i) {
                            $row['stations'][$i]['name'] = isset($row['stations'][$i]['name']) ? $row['stations'][$i]['name'] : '';
                            if (isset($errors['station_time[' . $i . ']'])) {
                                echo '<span class="red">' . $errors['station_time[' . $i . ']'] . '</span>';
                                $color = "#ffaaaa";
                            } else
                                $color = '#fffff';
                            echo '<ul class="break" style="background-color: '.$color.'">';
                            echo '<li>
                                <span>会社</span>
                                <input name="station_company[' . $i . ']" id="company1" class="wth_70" placeholder="" maxlength="30" value="' . $row['stations'][$i]['company'] . '" type="text">
                            </li>
                            <li>
                                <input name="station_line[' . $i . ']" id="line1" class="wth_70" placeholder="" maxlength="30" value = "' . $row['stations'][$i]['line'] . '" type="text">
                                <span>線</span>
                            </li>
                            <li>
                                <input name="station_name[' . $i . ']" id="line1" class="wth_70" placeholder="" maxlength="30" type="text" value = "' . $row['stations'][$i]['name'] . '">
                                <span>駅</span>
                            </li>
                            <li>
                                <span>徒歩</span>
                                <input name="station_time[' . $i . ']" id="time1" class="wth_30" placeholder="" maxlength="2" value="' . $row['stations'][$i]['time'] . '" type="text">
                                <span>分</span>
                            </li>';
                            echo '</ul>';
                        }
                        ?>
                        <p>
                            ※入力例)
                        </p>
                        <ul class="break">
                            <li>
                                <span>会社</span>
                                <input type="text" class="wth_70" value="JR" disabled>
                            </li>
                            <li>
                                <input type="text" class="wth_70" value="山手" disabled>
                                <span>線</span>
                            </li>
                            <li>
                                <input class="wth_70" value="東京" disabled="" type="text">
                                <span>駅</span>
                            </li>
                            <li>
                                <span>徒歩</span>
                                <input type="text" class="wth_30" value="15" disabled>
                                <span>分</span>
                            </li>
                        </ul>
                    </td>
                </tr>
                <!-- 目印情報 -->
                <tr class="hide">
                    <th>
                        <p>目印情報</p>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('mark_info');
                        echo $error['mes'];
                        ?>
                        <input name="mark_info" <?php echo $error['class'] ?> value="<?php echo $row['mark_info'] ?>"
                               id="mark_info" placeholder="目印情報を入力してください" maxlength="100" type="text">
                    </td>
                </tr>
                <!-- 備考 -->
                <tr>
                    <th>
                        <p>備考</p>
                        <div class="text-explain">※実際の掲載内容には表示されない項目ですので、メモとしてご利用ください</div>
                    </th>
                    <td>
                        <?php
                        $error = $show_error('note');
                        echo $error['mes'];
                        ?>
                        <textarea name="note" <?php echo $error['class'] ?> placeholder=""
                                  id="note"><?php echo $row['note'] ?></textarea>
                    </td>
                </tr>

                </tbody>
            </table>
            <!-- 送信ボタン START -->
            <ul class="transmission">
                <li>
                    <input value="入力内容を確認する" id="fm_btn_confirm" type="submit">
                </li>
            </ul>
            <!-- 送信ボタン END -->
        </form>
    </div>
</section>
