

    <h1>お問い合わせ</h1>

    <section>
        <div class="page01-box">
            <form id="fm_action" method="post" class="h-adr" action="">
                <table>

                    <tbody><tr>
                        <th> <p>御社名</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['company_name']) ? $validate['company_name'] : ''; ?></span>
                            <?php echo Form::input('company_name', Input::post('company_name'), array('id' => 'company', 'placeholder' => '御社名を入力してください', 'maxlength' => 50, 'class' => isset($validate['company_name']) ? 'error_box' : ''));?>
                        </td>
                    </tr>

                    <tr>
                        <th> <p>御社名かな</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['company_kana']) ? $validate['company_kana'] : ''; ?></span>
                            <?php echo Form::input('company_kana', Input::post('company_kana'), array('id' => 'company_kana', 'placeholder' => '御社名かなを入力してください', 'maxlength' => 50, 'class' => isset($validate['company_kana']) ? 'error_box' : ''));?>
                    </tr>

                    <!-- 郵便番号 -->
                    <tr>
                        <th> <p>郵便番号</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red">
                            <?php if (isset($validate['zipcode1'])) {
                                echo $validate['zipcode1'];
                            } elseif (isset($validate['zipcode2'])) {
                                echo $validate['zipcode2'];
                            } ?>
                        </span>
                            <?php echo Form::input('zipcode1', Input::post('zipcode1'), ['maxlength' => '3', 'class' => isset($validate['zipcode1']) ? 'error_box wth_20 p-postal-code' : 'wth_20 p-postal-code'])?>
                            -
                            <?php echo Form::input('zipcode2', Input::post('zipcode2'), ['maxlength' => '4', 'class' => isset($validate['zipcode2']) ? 'error_box wth_20 p-postal-code' : 'wth_20 p-postal-code'])?>
                        </td>
                    </tr>

                    <!-- 都道府県 -->
                    <tr>
                        <th> <p>都道府県</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['prefecture_id']) ? $validate['prefecture_id'] : ''; ?></span>
                            <?php echo \Fuel\Core\Form::select('prefecture_id', \Fuel\Core\Input::post('prefecture_id'), Constants::get_search_address('都道府県を選択'), ['id' => 'ID_ADDR1', 'class' => isset($validate['prefecture_id']) ? 'selectBox200 error_box' : 'selectBox200']) ?>
                        </td>
                    </tr>

                    <!-- 市区町村 -->
                    <tr>
                        <th> <p>市区町村</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['city']) ? $validate['city'] : ''; ?></span>
                            <?php echo Form::input('city', Input::post('city'), ['placeholder' => '市区町村を入力してください', 'maxlength' => '10', 'type' => 'text', 'class' => isset($validate['city']) ? 'p-locality p-street-address p-extended-address error_box' : 'p-locality p-street-address p-extended-address'])?>
                    </tr>

                    <!-- 以降の住所 -->
                    <tr>
                        <th> <p>以降の住所</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['town']) ? $validate['town'] : ''; ?></span>
                            <?php echo Form::input('town', Input::post('town'), ['placeholder' => '番地・ビル名などを入力してください', 'maxlength' => '50', 'class' => isset($validate['town']) ? 'p-locality p-street-address p-extended-address error_box' : 'p-locality p-street-address p-extended-address'])?>
                    </tr>

                    <!-- 電話番号 -->
                    <tr>
                        <th> <p>お電話番号</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red">
                            <?php if (isset($validate['tel1'])){
                                echo $validate['tel1'];
                            }
                            elseif(isset($validate['tel2'])){
                                echo $validate['tel2'];
                            }
                            elseif(isset($validate['tel3'])){
                                echo $validate['tel3'];

                            } ?>
                        </span>
                            <?php echo Form::input('tel1', Input::post('tel1'), ['maxlength' => '5', 'class' => isset($validate['tel1']) ? 'wth_20 error_box' : 'wth_20'])?>
                            -
                            <?php echo Form::input('tel2', Input::post('tel2'), ['maxlength' => '4', 'class' => isset($validate['tel2']) ? 'wth_20 error_box' : 'wth_20'])?>
                            -
                            <?php echo Form::input('tel3', Input::post('tel3'), ['maxlength' => '4', 'class' => isset($validate['tel3']) ? 'wth_20 error_box' : 'wth_20'])?>
                        </td>
                    </tr>

                    <!-- 担当者氏名 -->
                    <tr>
                        <th> <p>ご担当者様氏名</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['staff_name']) ? $validate['staff_name'] : ''; ?></span>
                            <?php echo Form::input('staff_name', Input::post('staff_name'), ['placeholder' => 'ご担当者様氏名を入力してください', 'maxlength' => '50', 'class' => isset($validate['staff_name']) ? 'error_box' : ''])?>
                    </tr>

                    <tr>
                        <th> <p>ご担当者様氏名かな</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['staff_kana']) ? $validate['staff_kana'] : ''; ?></span>
                            <?php echo Form::input('staff_kana', Input::post('staff_kana'), ['placeholder' => 'ご担当者様氏名かなを入力してください', 'maxlength' => '50', 'class' => isset($validate['staff_kana']) ? 'error_box' : ''])?>
                    </tr>

                    <!-- メールアドレス -->
                    <tr>
                        <th> <p>ご担当者様メールアドレス</p><span class="essential">必須</span>
                        </th>
                        <td>
                            <span class="red"><?php echo isset($validate['email']) ? $validate['email'] : ''; ?></span>
                            <?php echo Form::input('email', Input::post('email'), ['placeholder' => 'ご担当者様メールアドレスを入力してください', 'maxlength' => '767', 'class' => isset($validate['email']) ? 'wth_70 error_box' : 'wth_70'])?>
                    </tr>

                    <tr>
                        <th>
                            <p>お問い合わせ内容</p><span class="essential">必須</span></th>
                        <td>
                            <span class="red"><?php echo isset($validate['comment']) ? $validate['comment'] : '';?></span>
                            <textarea class="<?php echo isset($validate['comment']) ? 'error_box' : '';?>" name="comment"><?php echo Input::post('comment');?></textarea>
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
