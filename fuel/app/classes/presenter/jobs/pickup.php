<?php

/**
 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
 * @params: Presenter_Job_Pickup
 */
class Presenter_Jobs_Pickup extends \Fuel\Core\Presenter
{
	/**
	 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
	 * @params: View pickup
	 **/
	public function view()
	{
		$job = new Model_Job();
		$filter = array(
			'limit'     => 4,
			'is_pickup' => '1',
			'order_by'  => 'rand'
		);
		$jobs = $job->get_data($filter);
		$this->jobs = $jobs;
	}

}
