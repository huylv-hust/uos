<?php if($status == 99){ ?>
おしごとnaviをご利用いただきありがとうございます。
運営会社の株式会社ユーオーエス（宇佐美グループ）と申します。

おしごとnaviコンシェルジュ登録が完了しました。
ご登録頂いた情報をもとに求人案件をご連絡差し上げます。

弊社求人案件担当からの連絡をお待ちください。

※このメールは送信専用メールアドレスからお送りしています。
　ご返信いただいてもお答えすることができませんのでご了承ください。

お問い合わせにつきましては下記ＵＲＬからお願いいたします。
https://oshigoto-n.jp/contact/

━━━━━━━━━━━━━━━━━━━━━━━
おしごとnavi　http://oshigoto-n.jp/

運営会社：株式会社ユーオーエス

愛知県名古屋市中村区名駅南1-15-21
宇佐美名古屋ビル５階
━━━━━━━━━━━━━━━━━━━━━━━
<?php } ?>
<?php if($status == 1){ ?>
【おしごとnavi】にコンシェルジュ登録がありました。

求人管理システムから登録内容をご確認下さい。
<?php echo htmlspecialchars(Fuel\Core\Config::get('bo_url')) ?>support/concierge?register_id=<?php echo $register_id; ?>
<?php } ?>


