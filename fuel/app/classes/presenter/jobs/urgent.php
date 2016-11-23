<?php

/**
 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
 * @params: Presenter_Job_Urgent
 */
class Presenter_Jobs_Urgent extends \Fuel\Core\Presenter
{
	/**
	 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
	 * @params: View Urgent
	 **/
	public function view()
	{
		$job = new Model_Job();
		$filter = array(
			'order_by'        => 'rand',
			'limit'           => 4,
			'is_conscription' => 1,
		);
		$jobs = $job->get_data($filter);
		$this->jobs = $jobs;
	}

}
