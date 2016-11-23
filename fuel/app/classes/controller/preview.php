<?php

/**
 * Class Controller_Preview
 */

class Controller_Preview extends Controller_Uos
{
	private static function convertarraytostring($array)
	{
		return implode(',',array_values($array));
	}

	private static function merge_two_array($array1,$array2,$title,$content)
	{
		$array_merge = array();
		foreach($array1 as $k1 => $v1)
		{
			$array_merge[$k1][$title] = $array1[$k1];
			$array_merge[$k1][$content] = $array2[$k1];
		}
		return json_decode(json_encode($array_merge),false);
	}

	public function action_index()
	{
		$job_id = \Fuel\Core\Input::get('job_id',0);

		$dec = Utility::decrypt(\Fuel\Core\Input::get('enc'));
		if ($dec == null)
		{
			return new Fuel\Core\Response('forbidden', 403);
		}

		$_array = explode(':', $dec);
		if (count($_array) != 2 || $job_id != $_array[0] || time() - $_array[1] > 86400)
		{
			return new Fuel\Core\Response('forbidden', 403);
		}

		$job = new Model_Job();
		$jobs = $job->get_data(array('preview' => $job_id));
		if(isset($jobs[0]->edit_data))
		{
			$edit_data = json_decode($jobs[0]->edit_data);
			$edit_data->employment_mark = self::convertarraytostring($edit_data->employment_mark);
			$edit_data->work_time_view = self::convertarraytostring($edit_data->work_time_view);
			$edit_data->trouble  = self::convertarraytostring($edit_data->trouble);
			$edit_data->phone_number1  = $edit_data->phone_number1_1.','.$edit_data->phone_number1_2.','.$edit_data->phone_number1_3;
			$edit_data->phone_number2  = $edit_data->phone_number2_1.','.$edit_data->phone_number2_2.','.$edit_data->phone_number2_3;
			$edit_data->job_id = $jobs[0]->job_id;
			$edit_data->station_name1 = $jobs[0]->station_name1;
			$edit_data->station_name2 = $jobs[0]->station_name2;
			$edit_data->station_name3 = $jobs[0]->station_name3;
			$edit_data->station_line1 = $jobs[0]->station_line1;
			$edit_data->station_line2 = $jobs[0]->station_line2;
			$edit_data->station_line3 = $jobs[0]->station_line3;
			$edit_data->addr1 = $jobs[0]->addr1;
			$edit_data->addr2 = $jobs[0]->addr2;
			$edit_data->station1 = $jobs[0]->station1;
			$edit_data->station2 = $jobs[0]->station2;
			$edit_data->station3 = $jobs[0]->station3;

			$data['job_adds'] = self::merge_two_array($edit_data->job_add_sub_title,$edit_data->job_add_text,'sub_title','text');
			$data['job_recruits'] = self::merge_two_array($edit_data->job_recruit_sub_title,$edit_data->job_recruit_text,'sub_title','text');

			$data['jobs'] = $edit_data;
		}
		else
		{
			$data['jobs'] = $jobs[0];
			$data['job_adds'] = Model_Jobadd::find_by('job_id',$job_id,'=');
			$data['job_recruits'] = Model_Jobrecruit::find_by('job_id',$job_id,'=');
		}


		$this->template->content = self::view('preview/index', $data);
	}
}