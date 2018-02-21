<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller group
 **/
namespace Tops;

use Fuel\Core\Controller;
use Fuel\Core\Presenter;
use Parser\View;

class Controller_Top extends \Controller_Uos
{
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action top
	 */
	public function action_index()
	{
		\Fuel\Core\Cookie::set('url_job_search', json_encode(array('title' => 'Home', 'url' => '')));// For Thuan
		$data = array();
		$job = new \Model_Job();
		$filter_new = array(
			'new_updated' => date('Y-m-d', strtotime("-1 week"))
		);
		$filter_last_updated = array(
			'limit'    => 1
		);
		$troubles = $job->get_all_job([], 'trouble');

		$count = array();
		foreach(\Trouble::$trouble as $v)
		{
			$count[$v['id']] = 0;
			foreach($troubles as $trouble)
			{
				$num = substr_count($trouble->trouble, ','.$v['id'].',');

				if($num > 0)
					$count[$v['id']] = $count[$v['id']] + 1;
			}
		}

		$data['trouble_count'] = $count;
		$data['count_job'] = $job->get_all_job([], 'job_id', 'count');
		$data['count_job_new'] = $job->get_all_job($filter_new, 'job_id', 'count');
		$last_updated_at = $job->get_all_job($filter_last_updated, 'updated_at');
		if ($last_updated_at === null)
		{
			$data['last_updated_at'] = '';
		} else {
			$data['last_updated_at'] = date('m/d',strtotime($last_updated_at[0]->updated_at));
		}
		$this->template->title = 'しごさが';
		$this->template->content = \View::forge('top/index',$data);
	}

	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action error 404
	 */

	public function action_404()
	{
		$this->template->content = \View::forge('top/404');
	}

}
