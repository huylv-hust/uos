<?php
echo \Fuel\Core\Asset::js('customer/person.js');
?>
<ul class="navi">
    <!--<li><a href="">実績</a></li>-->
    <li><a href="<?php echo \Fuel\Core\Uri::base() . 'customer/jobs' ?>">求人管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base() . 'customer/persons' ?>">応募者管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base() . 'customer/summary' ?>">サマリー</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base() . 'customer/shops' ?>">店舗管理</a></li>
</ul>

<h1>応募者リスト</h1>

<?php
if (\Fuel\Core\Session::get_flash('error')) { ?>
    <div class="waiting"><?php echo \Fuel\Core\Session::get_flash('error'); ?></div>
<?php } ?>
<?php if (\Fuel\Core\Session::get_flash('success')) { ?>
    <div class="waiting"><?php echo \Fuel\Core\Session::get_flash('success'); ?></div>
<?php } ?>

<section id="search">
    <form action="" name="search" method="get" id="list-persons">
        <dl class="search">
            <dt>
                <?php echo \Fuel\Core\Form::input('keyword', Input::get('keyword'), ['style' => 'padding: 0 10px', 'placeholder' => '氏名/かな/メールアドレス/電話番号', 'type' => 'text']) ?>
            </dt>
            <dd>
                <button><span></span></button>
            </dd>
        </dl>
        <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit',Constants::$default_limit_pagination)?>">
    </form>
</section>

<?php if (\Fuel\Core\Input::server('QUERY_STRING')) { ?>
    <div class="text-center mb10">
        <button type="button" class="btn-info" name="filter-clear-btn">フィルタ解除</button>
    </div>
<?php } ?>

<div id="pager">
    <?php if($count_sale_person) { ?>
        <div style="float: left">
            <?php echo html_entity_decode($pagination); ?>
        </div>
        <div style="display: inline-block; margin-top: 25px">
            <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit') ? \Fuel\Core\Input::get('limit') : Constants::$default_limit_pagination, Constants::$limit_pagination, array('class' => 'limit'))?>
        </div>
        <div style="clear: both"></div>
    <?php } ?>
    <ul class="pagination"></ul>
</div>

<section class="list">

    <?php if (!empty($sale_persons)) { ?>

        <table id="page09">
            <thead>
            <tr>
                <th>応募日時</th>
                <th>氏名</th>
                <th>アドレス</th>
                <th>店舗</th>
                <th>選考</th>
                <th>確定月</th>
                <th>詳細</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($sale_persons as $k => $v) { ?>
                <tr data-application-date="<?php echo substr($v['application_time'], 0, 10) ?>">
                    <input name="person_id" value="<?php echo $v['person_id'] ?>" type="hidden">
                    <td><?php echo $v['application_time'] ?></td>
                    <td>
                        <?php echo $v['person_name'] ? $v['person_name'] : $v['person_kana'] ?>
                        <?php echo $v['is_read'] == Constants::$is_read['unread'] ? '<span class="label-status label-status-a1">未開封</span>' : '' ?>
                    </td>
                    <td>
                        <div><?php echo $v['mail_addr1'] ?></div>
                        <?php echo isset($v['mail_addr2']) ? '<div>' . $v['mail_addr2'] . '</div>' : '' ?>

                    </td>
                    <td><?php echo $v['shop_name'] ?></td>
                    <td>
                        <?php
                        $class = '';
                        $text = '';
                        if ($v['result'] == '1') {
                            $class = 'label-status-b1';
                            $text = '採用';
                        }
                        if ($v['result'] == '2') {
                            $class = 'label-status-a1';
                            $text = '不採用';
                        }
                        ?>
                        <?php if ($text) { ?>
                            <span class="label-status <?php echo $class; ?>"><?php echo $text; ?></span>
                        <?php } ?>
                        <?php if (!$v['result']) { ?>
                            <select name="result" class="chg_modal">
                                <option value="0">未定</option>
                                <option value="1">採用</option>
                                <option value="2">不採用</option>
                            </select>
                        <?php }  ?>
                    </td>
                    <td>
                        <?php if ($v['result'] == 1) {
                            echo isset($v['result_time']) ? date('Y/m', strtotime($v['result_time'])) : '';
                        } ?>
                    </td>
                    <td><a href="<?php echo \Fuel\Core\Uri::base() . 'customer/person?person_id=' . $v['person_id'] ?>">編集</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        該当するデータがありません
    <?php } ?>
</section>

<div id="pager">
    <?php if($count_sale_person) { ?>
        <div style="float: left">
            <?php echo html_entity_decode($pagination); ?>
        </div>
        <div style="display: inline-block; margin-top: 25px">
            <?php echo \Fuel\Core\Form::select('', \Fuel\Core\Input::get('limit', Constants::$default_limit_pagination), Constants::$limit_pagination, array('class' => 'limit'))?>
        </div>
        <div style="clear: both"></div>
    <?php } ?>
    <ul class="pagination"></ul>
</div>

<!-- modal employment-->

<div class="remodal" id="employment-modal" tabindex="-1" data-remodal-options="closeOnConfirm: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <section>
        <form action="" name="" method="POST" id="employment-form">
            <p>入社日を入力して確定ボタンを押してください。<br><span class="red">※確定後のキャンセルはできません※</span></p>
            <table>
                <tbody>
                <tr>
                    <th>
                        <p>入社日入力</p><span class="essential">必須</span>
                    </th>
                    <td>
                        <input name="working_days" class="wth_30 dateform" placeholder="" type="text">
                    </td>
                </tr>
                </tbody>
            </table>
            <button data-remodal-action="cancel" class="remodal-cancel">キャンセル</button>
            <button data-remodal-action="confirm" class="remodal-confirm">確定</button>
        </form>
    </section>
</div>


<!-- modal reject-->
<div class="remodal" id="reject-modal" tabindex="-1" data-remodal-options="closeOnConfirm: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <section>
        <form action="" name="" method="POST" id="reject-form">
            <p>不採用理由を選択して確定ボタンを押してください。<br><span class="red">※確定後のキャンセルはできません※</span></p>
            <?php echo \Fuel\Core\Form::select('reject_reason', '', Constants::$reject_reason) ?>
            <button data-remodal-action="cancel" class="remodal-cancel">キャンセル</button>
            <button data-remodal-action="confirm" class="remodal-confirm">確定</button>
        </form>
    </section>
</div>

<script>
    $(function () {
        $('select[name=result').change(function () {
            var result = $(this).val(),
                id = $(this).closest('tr').find('input[name=person_id]').val();
            $('#employment-form').attr(
                'data-application-date',
                $(this).closest('tr').attr('data-application-date')
            );
            if (result == '1') {
                $('#employment-form').attr('action', baseUrl + 'customer/persons/change_result?person_id=' + id + '&type=employment');
                $('#employment-modal').remodal().open();
            } else if (result == '2') {
                $('#reject-form').attr('action', baseUrl + 'customer/persons/change_result?person_id=' + id + '&type=reject');
                $('#reject-modal').remodal().open();
            }
        });
    });

    //Change limit pagination
    $(".limit").on('change',function(){
        var val = $(this).val();
        $("input[name='limit']").val(val);
        $("#list-persons").submit();
    });
</script>
