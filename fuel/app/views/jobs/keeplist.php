<?php
	$data_keeplist = json_decode(\Fuel\Core\Cookie::get('bookmark','[]'),true);
	$job_id = isset($job_id) ? $job_id : 0;
	if( ! in_array($job_id,$data_keeplist))
	{
	?>
		<div class="btn-keeplist keeplist<?php echo isset($job_id) ? $job_id : '' ?>" id="" value="<?php echo isset($job_id) ? $job_id : '' ?>" style="cursor: pointer">
			<img class="imghover" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_application01.png" alt="キープする" style="opacity: 1;">
		</div>
	<?php
	}
	else
	{
	?>
		<div class="btn-keeplist keeplist<?php echo isset($job_id) ? $job_id : '' ?>" id="" value="<?php echo isset($job_id) ? $job_id : '' ?>" style="cursor: pointer">
			<img alt="キープ削除" src="<?php echo \Fuel\Core\Uri::base(); ?>assets/common_img/btn_application01_2.png" class="imghover" style="opacity: 1;">
		</div>
	<?php
	}
?>
