<?php
if ($is_read) { ?>
    <div id="messages" style="background: #ffffcc; padding:12px; font-weight:bold; font-size:120%;">
        <span style="color:#ff0000;">！未開封の応募者がいます ⇒ <a href="<?php echo \Fuel\Core\Uri::base() . 'customer/persons'?>" style="text-decoration:underline;color:#00aa00;">応募者リストで確認</a></span>
    </div>
<?php }?>
