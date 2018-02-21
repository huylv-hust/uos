<h1>完了ページ</h1>

<section>
    <div class="complete-03">
        <h2>保存が完了しました</h2>
        <p>掲載申請を出しますか？</p>
        <ul>
            <li><a href="#" name="apply-btn">YES</a></li>
            <li><a href="<?php echo \Fuel\Core\Uri::base().'customer/jobs'?>">NO</a></li>
        </ul>
    </div>
</section>

<form id="apply-form" method="post" action="apply">
    <input type="hidden" name="job_id" value="<?php echo Input::get('job_id') ?>">
</form>

<script>
    $(function() {
       $('[name=apply-btn]').on('click', function() {
            $('#apply-form').submit();
            return false;
       });
    });
</script>
