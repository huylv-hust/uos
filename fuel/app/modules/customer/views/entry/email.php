<h1>メールアドレス確認</h1>

<section>
    <div class="complete-01">
        <?php if (strlen($error)) { ?>
            <h2 class="error"><?php echo $error ?></h2>
        <?php } else { ?>
            <h2>「しごさが」にご登録、ありがとうございました。</h2>
            <p>
                ご登録いただいたメールアドレスに、アカウント発行のお知らせをお送りします。<br>
                4～5営業日以内にメールが届かない場合は、お手数ですがお電話にてお問い合わせください。<br>
                メールが届かない場合は、【 0120-118-136 】にお電話ください（月～金　9～17時）
            </p>
        <?php } ?>
    </div>
</section>
