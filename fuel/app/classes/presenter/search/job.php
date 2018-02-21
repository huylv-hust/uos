<?php
/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 */
class Presenter_Search_Job extends Presenter
{
	public function view()
	{
		$job = $this->job;
		$job->trouble = ($job->trouble == '') ? array() : explode(',', trim($job->trouble, ','));
		$job->image = Model_Mimage::get_data_image(html_entity_decode($job->image_list));
		$this->data = $job;
	}
}
