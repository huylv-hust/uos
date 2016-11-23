<div class="col2 pick_up">
	<h2><img src="<?php echo \Fuel\Core\Uri::base(); ?>assets/images/index/ico_recruit02.png" alt="">PICK UP</h2>
	<?php
	foreach($jobs as $job)
	{
		?>
		<div class="line">
			<a href="<?php echo \Fuel\Core\Uri::base(); ?>search/detail/<?php echo isset($job) ? $job->job_id : 0; ?>" class="job pic_l imghover clearfix">
				<span class="img" style="background-image: url(<?php echo Constants::get_image(Model_Mimage::get_data_image(html_entity_decode($job->image_list))['data'])?>)">
				</span>
				<span class="msg">
					<span class="detail" style="min-height: 40px;"><?php echo isset($job->catch_copy) ? Utility::crop_string($job->catch_copy,Constants::$limit_catch_copy)  : ''; ?></span>
					<em><?php echo isset($job->post_company_name) ? Utility::crop_string($job->post_company_name,Constants::$limit_post_company_name) : ''; ?></em>
					<span class="place"><?php echo isset($job) ? (Constants::$addr1[$job->addr1].'-'.$job->addr2) : '' ; ?></span>
					<span class="yen" style="min-height: 30px;">時給<?php echo isset($job->salary_des) ? Utility::crop_string($job->salary_des,Constants::$limit_salary_des) : ''; ?></span>
				</span>
			</a><!-- /.job -->
		</div>
		<!-- /.line -->
	<?php
	}
	?>
	<!-- /.line -->
</div>
