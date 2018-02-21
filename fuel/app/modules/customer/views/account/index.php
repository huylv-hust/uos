<main role="main">

    <ul class="navi">
        <!--<li><a href="">実績</a></li>-->
        <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/jobs">求人管理</a></li>
        <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/persons">応募者管理</a></li>
        <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/summary">サマリー</a></li>
        <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/shops">店舗管理</a></li>
    </ul>

    <h1>アカウント情報</h1>

    <section>
        <div class="page01-box">
            <form id="fm_action" method="post" class="h-adr" action="">
                <table>

                    <!-- メールアドレス -->
                    <tbody><tr>
                        <th> <p>メールアドレス</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <?php echo $sale_customer->email;?>
                            <span class="sample"><a href="email">変更する場合はこちら</a></span>
                        </td>
                    </tr>

                    <!-- 会社名 -->
                    <tr>
                        <th> <p>会社名</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['company_name']) ? $validate['company_name'] : ''; ?></span>
                            <?php echo Form::input('company_name', Input::post('company_name', $sale_customer->company_name) , ['placeholder' => '会社名を入力してください', 'maxlength' => '50', 'class' => isset($validate['company_name']) ? 'error_box' : ''])?>
                    </tr>

                    <!-- 会社名かな -->
                    <tr>
                        <th> <p>会社名かな</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['company_kana']) ? $validate['company_kana'] : ''; ?></span>
                            <?php echo Form::input('company_kana', Input::post('company_kana', $sale_customer->company_kana), ['placeholder' => '会社名かなを入力してください', 'maxlength' => '50', 'class' => isset($validate['company_kana']) ? 'error_box' : ''])?>
                    </tr>

                    <!-- 郵便番号 -->
                    <tr>
                        <th> <p>郵便番号</p><span class="essential">必須</span>
                        </th>
                        <td>
                           <span class="red">
                            <?php if (isset($validate['zipcode1'])){
                                echo $validate['zipcode1'];
                            }
                            elseif(isset($validate['zipcode2'])){
                                echo $validate['zipcode2'];
                            } ?>
                        </span>
                            <?php echo Form::input('zipcode1', Input::post('zipcode1', substr($sale_customer->zipcode, 0, 3)), ['maxlength' => '3', 'class' => isset($validate['zipcode1']) ? 'wth_20 p-postal-code error_box' : 'wth_20 p-postal-code'])?>
                            -
                            <?php echo Form::input('zipcode2', Input::post('zipcode2', substr($sale_customer->zipcode, 3, 4)), ['maxlength' => '4', 'class' => isset($validate['zipcode2']) ? 'wth_20 p-postal-code error_box' : 'wth_20 p-postal-code'])?>
                        </td>
                    </tr>

                    <!-- 都道府県 -->
                    <tr>
                        <th> <p>都道府県</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['prefecture_id']) ? $validate['prefecture_id'] : ''; ?></span>
                            <?php echo \Fuel\Core\Form::select('prefecture_id', \Fuel\Core\Input::post('prefecture_id', $sale_customer->prefecture_id), Constants::get_search_address('都道府県を選択'), ['id' => 'ID_ADDR1', 'class' => isset($validate['prefecture_id']) ? 'selectBox200 error_box' : 'selectBox200']) ?>
                        </td>
                    </tr>

                    <!-- 市区町村 -->
                    <tr>
                        <th> <p>市区町村</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['city']) ? $validate['city'] : ''; ?></span>
                            <?php echo Form::input('city', Input::post('city', $sale_customer->city), ['placeholder' => '市区町村を入力してください', 'maxlength' => '10', 'class' => isset($validate['city']) ? 'p-locality p-street-address p-extended-address error_box' : 'p-locality p-street-address p-extended-address'])?>
                    </tr>

                    <!-- 以降の住所 -->
                    <tr>
                        <th> <p>以降の住所</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['town']) ? $validate['town'] : ''; ?></span>
                            <?php echo Form::input('town', Input::post('town', $sale_customer->town), ['placeholder' => '番地・ビル名などを入力してください', 'maxlength' => '50', 'type' => 'text', 'class' => isset($validate['town']) ? 'p-locality p-street-address p-extended-address error_box' : 'p-locality p-street-address p-extended-address'])?>
                    </tr>

                    <!-- 電話番号 -->
                    <tr>
                        <th> <p>電話番号</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red">
                            <?php
                            $tel = explode('-', $sale_customer->tel);
                            if (isset($validate['tel1'])) {
                                echo $validate['tel1'];
                            } elseif (isset($validate['tel2'])) {
                                echo $validate['tel2'];
                            } elseif (isset($validate['tel3'])) {
                                echo $validate['tel3'];
                            }
                            ?>
                        </span>
                            <?php echo Form::input('tel1', Input::post('tel1', $tel[0]), ['maxlength' => '5', 'class' => isset($validate['tel1']) ? 'wth_20 error_box' : 'wth_20'])?>

                            -
                            <?php echo Form::input('tel2', Input::post('tel2', $tel[1]), ['maxlength' => '4', 'class' => isset($validate['tel2']) ? 'wth_20 error_box' : 'wth_20'])?>
                            -
                            <?php echo Form::input('tel3', Input::post('tel3', $tel[2]), ['maxlength' => '4', 'class' => isset($validate['tel3']) ? 'wth_20 error_box' : 'wth_20'])?>
                        </td>
                    </tr>

                    <!-- FAX番号 -->
                    <tr>
                        <th> <p>FAX</p>
                        </th>
                        <td>
                            <span class="red">
                            <?php
                            $fax = $sale_customer->fax ? explode('-', $sale_customer->fax) : ['','',''];
                            if (isset($validate['fax1'])) {
                                echo $validate['fax1'];
                            } elseif (isset($validate['fax2'])) {
                                echo $validate['fax2'];
                            } elseif (isset($validate['fax3'])) {
                                echo $validate['fax3'];
                            }
                            ?>
                        </span>
                            <?php echo Form::input('fax1', Input::post('fax1', $fax[0]), ['maxlength' => '5', 'class' => isset($validate['fax1']) ? 'wth_20 error_box' : 'wth_20'])?>
                            -
                            <?php echo Form::input('fax2', Input::post('fax2', $fax[1]), ['maxlength' => '4', 'class' => isset($validate['fax2']) ? 'wth_20 error_box' : 'wth_20'])?>
                            -
                            <?php echo Form::input('fax3', Input::post('fax3', $fax[2]), ['maxlength' => '4', 'class' => isset($validate['fax3']) ? 'wth_20 error_box' : 'wth_20'])?>

                        </td>
                    </tr>

                    <!-- 代表者氏名 -->
                    <tr>
                        <th> <p>代表者氏名</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['president_name']) ? $validate['president_name'] : ''; ?></span>
                            <?php echo Form::input('president_name', Input::post('president_name', $sale_customer->president_name), ['placeholder' => '代表者氏名を入力してください', 'maxlength' => '50', 'class' => isset($validate['president_name']) ? 'error_box' : ''])?>
                    </tr>

                    <!-- 代表者氏名かな -->
                    <tr>
                        <th> <p>代表者氏名かな</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['president_kana']) ? $validate['president_kana'] : ''; ?></span>
                            <?php echo Form::input('president_kana', Input::post('president_kana', $sale_customer->president_kana), ['placeholder' => '代表者氏名かなを入力してください', 'maxlength' => '50', 'class' => isset($validate['president_kana']) ? 'error_box' : ''])?>
                    </tr>

                    <!-- 担当者氏名 -->
                    <tr>
                        <th> <p>担当者氏名</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['staff_name']) ? $validate['staff_name'] : ''; ?></span>
                            <?php echo Form::input('staff_name', Input::post('staff_name', $sale_customer->staff_name), ['placeholder' => '担当者氏名を入力してください', 'maxlength' => '50', 'class' => isset($validate['staff_name']) ? 'error_box' : ''])?>
                    </tr>

                    <!-- 担当者氏名かな -->
                    <tr>
                        <th> <p>担当者氏名かな</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['staff_kana']) ? $validate['staff_kana'] : ''; ?></span>
                            <?php echo Form::input('staff_kana', Input::post('staff_kana', $sale_customer->staff_kana), ['placeholder' => '担当者氏名かなを入力してください', 'maxlength' => '50', 'class' => isset($validate['staff_kana']) ? 'error_box' : ''])?>
                    </tr>

                    <!-- パスワード -->
                    <tr>
                        <th> <p>パスワード</p>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['password']) ? $validate['password'] : ''; ?></span>
                            <?php echo Form::input('password', Input::post('password'), ['placeholder' => 'パスワードを入力してください', 'maxlength' => '50', 'type' => 'password', 'class' => isset($validate['password']) ? 'wth_50 error_box' : 'wth_50'])?>
                            <p class="atn">※英数8文字以上、変更する場合のみ入力してください</p>
                        </td>
                    </tr>

                    <!-- パスワード確認 -->
                    <tr>
                        <th> <p>パスワード確認</p>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['password_check']) ? $validate['password_check'] : ''; ?></span>
                            <?php echo Form::input('password_check', Input::post('password_check'), ['placeholder' => '確認のため再度入力してください', 'maxlength' => '50', 'type' => 'password', 'class' => isset($validate['password_check']) ? 'wth_50 error_box' : 'wth_50'])?>
                        </td>
                    </tr>
                    </tbody></table>


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
</main>
