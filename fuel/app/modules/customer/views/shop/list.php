<style>
    li.active a{
        letter-spacing: 2px;
        color: #009d3d;
        font-weight: bold;
    }
</style>
<ul class="navi">
    <!--<li><a href="">実績</a></li>-->
    <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/jobs">求人管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/persons">応募者管理</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/summary">サマリー</a></li>
    <li><a href="<?php echo \Fuel\Core\Uri::base()?>customer/shops">店舗管理</a></li>
</ul>

<h1>店舗リスト<span class="plus" name="add-btn"><input value="新規追加" name="add-btn" type="button"></span></h1>

<?php
if(\Fuel\Core\Session::get_flash('report')){
?>
<div class="waiting"><?php echo \Fuel\Core\Session::get_flash('report');?></div>
<?php }?>
<section id="search">
    <form action="<?php echo \Fuel\Core\Uri::base()?>customer/shops" name="search" method="get" id="list-shops">
        <dl class="search">
            <dt><input name="keyword_modal_sale_job" style="height: 32px" value="<?php echo htmlspecialchars(\Fuel\Core\Input::get('keyword_modal_sale_job','')) ?>" placeholder="キーワード" type="text"></dt>
            <dd>
                <button><span></span></button>
            </dd>
        </dl>
        <input type="hidden" name="limit" value="<?php echo Fuel\Core\Input::get('limit',Constants::$default_limit_pagination)?>">
    </form>
</section>

<?php if (\Fuel\Core\Input::server('QUERY_STRING')) { ?>
<div class="text-center mb10">
    <button type="button" class="btn-info" name="filter-clear-btn">検索クリア</button>
</div>
<?php } ?>

<div id="pager">
    <?php if(count($list)) { ?>
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
    <?php if(count($list)){ ?>
    <table>
        <thead>
        <tr>
            <th width="60%">店舗名</th>
            <th width="30%">住所</th>
            <th>管理</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($list as $row){
        ?>
        <tr>
            <td><?php echo $row['shop_name']?></td>
            <td>
                <?php
                echo isset(Constants::$addr1[$row['prefecture_id']]) ? Constants::$addr1[$row['prefecture_id']] : '';
                echo $row['city'].$row['town']
                ?>
            </td>
            <td>
                <select name="process" id="<?php echo $row['shop_id'] ?>">
                    <option value="" selected="selected">処理を選択</option>
                    <option value="edit">編集</option>
                    <option value="delete">削除</option>
                    <option value="job">求人登録</option>
                </select>
            </td>
        </tr>
        <?php } ?>
        <?php } else{?>
            <tr>
                <td>
                    該当するデータがありません
                </td>
            </tr>

        <?php }?>

        </tbody>
    </table>

</section>

<div id="pager">
    <?php if(count($list)) { ?>
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
    $(function() {
        $('[name=add-btn]').on('click', function() {
            location.href = 'shop';
        });
        $('[name=process]').on('change', function() {
            var shop_id = $(this).attr('id');
            if ($(this).val() == 'edit') {
                location.href = '<?php echo Fuel\Core\Uri::base()?>customer/shop?shop_id='+shop_id;
            } else if ($(this).val() == 'job') {
                location.href = '<?php echo Fuel\Core\Uri::base()?>customer/job?shop_id='+shop_id;
            } else if ($(this).val() == 'delete') {
                if (confirm('指定店舗を削除します、よろしいですか？')) {
                    $.post('<?php echo Fuel\Core\Uri::base()?>customer/shops/delete',
                        {
                            'shop_id':shop_id
                        },
                        function(data){
                            window.location.reload();
                        }
                    );
                }
            }
            $(this).val('');
            return false;
        });
    });

    //Change limit pagination
    $(".limit").on('change',function(){
        var val = $(this).val();
        $("input[name='limit']").val(val);
        $("#list-shops").submit();
    });
</script>

