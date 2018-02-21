<h1>メールアドレス変更</h1>

<section>
    <div class="complete-01">
        <?php if (strlen($error)) { ?>
            <h2 class="error"><?php echo $error ?></h2>
        <?php } else { ?>
            <h2>メールアドレスの変更が完了しました。</h2>
            <p>
                5秒後に自動的にログイン画面に切り替わります。切り替わらな場合はこちら
                <a href="<?php echo \Fuel\Core\Uri::base() ?>customer/">ログイン</a>
            </p>
        <?php } ?>
    </div>
</section>

<?php if (strlen($error) == 0) { ?>
    <script>
        $(function() {
            setTimeout(function() {
                location.href = '<?php echo \Fuel\Core\Uri::base() ?>customer/';
            }, 5000);
        });
    </script>
<?php } ?>
