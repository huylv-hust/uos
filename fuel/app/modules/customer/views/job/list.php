<?php echo \Fuel\Core\Asset::js('customer/job.js'); ?>

<ul class="navi">
    <li><a href="<?php echo Uri::base() . 'customer/jobs'; ?>">求人管理</a></li>
    <li><a href="<?php echo Uri::base() . 'customer/persons'; ?>">応募者管理</a></li>
    <li><a href="<?php echo Uri::base() . 'customer/summary'; ?>">サマリー</a></li>
    <li><a href="<?php echo Uri::base() . 'customer/shops'; ?>">店舗管理</a></li>
</ul>

<h1>求人リスト<span class="plus" name="add-btn"><input value="新規追加" name="add-btn" type="button"></span></h1>
<?php
if (\Fuel\Core\Session::get_flash('error')) { ?>
    <div class="waiting"><?php echo \Fuel\Core\Session::get_flash('error');?></div>
<?php }?>
<?php if (\Fuel\Core\Session::get_flash('success')) { ?>
    <div class="waiting"><?php echo \Fuel\Core\Session::get_flash('success');?></div>
<?php }?>
<section id="search" class="list-search">
    <form action="" name="search" method="get" id="list-jobs">

        <div class="search-page07">
            <dl class="search">
                <dt><input style="padding: 0 10px" name="keyword" value="<?php echo htmlentities(Input::get('keyword')); ?>"
                           placeholder="キーワード" type="text"></dt>
            </dl>
            <div class="btn-page07">
                <button type="submit" class="btn-primary">検索</button>
            </div>
        </div>
        <div class="status">
            <ul class="fm_chk fm_required variable">
                <li>公開フラグ</li>
                <li>
                    <input name="is_available[]" id="is_available-1" value="1"
                           type="checkbox" <?php echo in_array('1', Input::get('is_available', [])) ? 'checked' : ''; ?>>
                    <label for="is_available-1">ON</label>
                </li>
                <li>
                    <input name="is_available[]" id="is_available-0" value="0"
                           type="checkbox" <?php echo in_array('0', Input::get('is_available', [])) ? 'checked' : ''; ?>>
                    <label for="is_available-0">OFF</label>
                </li>
            </ul>

            <ul class="fm_chk fm_required variable">
                <li>掲載状況</li>
                <li>
                    <input name="status[]" id="status-0" value="0"
                           type="checkbox" <?php echo in_array('0', Input::get('status', [])) ? 'checked' : ''; ?>>
                    <label for="status-0">編集中</label>
                </li>
                <li>
                    <input name="status[]" id="status-1" value="1"
                           type="checkbox" <?php echo in_array('1', Input::get('status', [])) ? 'checked' : ''; ?>>
                    <label for="status-1">掲載申請中</label>
                </li>
                <li>
                    <input name="status[]" id="status-2" value="2"
                           type="checkbox" <?php echo in_array('2', Input::get('status', [])) ? 'checked' : ''; ?>>
                    <label for="status-2">確認済み</label>
                </li>
            </ul>

        </div>

        <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit',Constants::$default_limit_pagination)?>">
    </form>
</section>

<?php if (\Fuel\Core\Input::server('QUERY_STRING')) { ?>
    <div class="text-center mb10 mt10">
        <button type="button" class="btn-info" name="filter-clear-btn">検索クリア</button>
    </div>
<?php } ?>

    <div id="pager">
        <?php if($count_sale_job) { ?>
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

<section class="list">

    <?php if(!empty($sale_jobs)) {?>
    <table id="page07">
        <thead>
        <tr>
            <th>掲載店舗</th>
            <th>掲載プラン</th>
            <th>掲載期間</th>
            <th>
                <pre>公開フラグ</pre>
            </th>
            <th>
                <pre>掲載状況</pre>
            </th>
            <th>管理</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sale_jobs as $k => $v) { ?>
            <tr data-status="<?php echo $v['status'] ?>">
                <td><?php echo $v['shop_name']; ?></td>
                <td><?php echo Constants::$sale_plan_code[$v['plan_code']]; ?></td>
                <td>
                    <?php echo $v['start_date'] . '～' . $v['end_date']; ?>
                    <?php if (date('Y-m-d') >= $v['start_date'] && date('Y-m-d') <= $v['end_date']) { ?>
                        <span class="label-status label-status-b3" style="display:inline">掲載期間内</span>
                    <?php } else { ?>
                        <span class="label-status label-status-a1" style="display:inline">期間外</span>
                    <?php } ?>
                </td>
                <td>
                    <?php
                    $class = $v['is_available'] == '1' ? 'label-status-a2' : 'label-status-a1';
                    $text = $v['is_available'] == '1' ? 'ON' : 'OFF';
                    ?>
                    <span class="label-status <?php echo $class; ?>"><?php echo $text; ?></span>
                </td>
                <td>
                    <?php
                    $class = 'label-status-b1';
                    $text = '編集中';
                    if ($v['status'] == '1') {
                        $class = 'label-status-b2';
                        $text = '掲載申請中';
                    }
                    if ($v['status'] == '2') {
                        $class = 'label-status-b3';
                        $text = '確認済み';
                    }
                    ?>
                    <span class="label-status <?php echo $class; ?>"><?php echo $text; ?></span>
                </td>
                <td>
                    <select name="process" job-id="<?php echo $v['job_id'];?>" data-enc="<?php echo Utility::encrypt($v['job_id'] . ':' . time()) ?>">
                        <option value="">処理を選択</option>
                        <option value="edit">編集</option>
                        <?php if ($v['is_available']) { ?>
                            <option value="stop">非公開</option>
                        <?php } else { ?>
                            <option value="open">公開</option>
                        <?php } ?>
                        <option value="delete">削除</option>
                        <option value="preview">プレビュー</option>
                    </select>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        該当するデータがありません
    <?php }?>
</section>

<div class="hide">
    <form id="preview-form" method="get" action="<?php echo \Fuel\Core\Uri::base() ?>cpreview" target="_blank">
        <input type="hidden" name="job_id" value="">
        <input type="hidden" name="enc" value="">
    </form>
</div>

<div id="pager">
    <?php if($count_sale_job) { ?>
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

<script>
    //Change limit pagination
    $(".limit").on('change',function(){
        var val = $(this).val();
        $("input[name='limit']").val(val);
        $("#list-jobs").submit();
    });
</script>
