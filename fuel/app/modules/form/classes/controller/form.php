<?php
namespace Form;
use Fuel\Core\Session;
use Fuel\Core\Response;

/**
 * @author NamNT
 * Class Controller_Persons
 * @package Persons
 */
class Controller_Form extends \Controller_Uos
{
	/**
	 * @author NamNT
	 * action index
	 */
	public function action_index()
	{

		$data   = array();
		$model = new \Model_Person();
		$model_job = new \Model_Job();
		$sssale_id = null;
		$data['person_info'] = null;
		$job_id = \Input::post('job_id');
		if(\Input::post('job_id'))
		{
			$job_id = \Input::post('job_id');
			\Fuel\Core\Session::set('job_id',$job_id);
		}
		else
		{
			$job_id = \Fuel\Core\Session::get('job_id');
		}

		if($job_id == null)
		{
			Response::redirect('search');
		}

		if($job_id == null)
		{
			Response::redirect('search');
		}

		$data['job'] = $model_job->find_by_pk($job_id);
		if($data['job'] == null || $model_job->count_data(array('job_id' => $job_id)) == 0)
		{
			Session::set_flash('error','応募可能期間が終了しています');
		}

		$name = \Input::post('name',null);
		if(\Input::method() == 'POST' && isset($name))
		{
			$_POST['name_kana'] = mb_convert_kana(\Input::post('name_kana'), 'HVc');
			$datas = array();
			$dataPost = \Input::post();
			$datas = $model->get_person_data($dataPost);
			$datas['created_at'] = date('Y-m-d H:i:s');
			$datas['application_date'] = date('Y-m-d H:i:s');
			$datas['business_user_id'] = $model->get_default_business_user_id($job_id);
			$datas['interview_user_id'] = $datas['business_user_id'];
			$datas['agreement_user_id'] = $datas['business_user_id'];
			$datas['job_id'] = $job_id;
			$datas['sssale_id'] = $data['job']->sssale_id;
			foreach(\Input::post() as $key => $value)
			{
				if(\Input::post($key) == '')
				{
					$datas[$key] = null;
				}
			}

			if( ! $model ->validate())
			{
				$error = $model->get_list_error();
				$data['error'] = $error ;
			}
			else
			{
				\Fuel\Core\Session::set('notes',$datas['notes']);
				unset($datas['notes']);
				\Fuel\Core\Session::set('person_data',json_encode($datas));

				if( ! \Input::post('flg'))
					Response::redirect('form/confirm');
			}
		}

		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('form/person',$data);

	}

	public function action_confirm()
	{
		if( ! \Fuel\Core\Session::get('person_data'))
		{
			Response::redirect('form');
		}
		$model = new \Model_Person();
		$model_job = new \Model_Job();
		$sssale_id = null;

		$data = json_decode(\Fuel\Core\Session::get('person_data'), true);
		$data['notes'] = \Fuel\Core\Session::get('notes');
		$pesron_data = $model->get_mail_data($data['job_id']);

		$data['post_company_name'] = $pesron_data['post_company_name'];
		$data['job_category'] = $pesron_data['job_category'];

		if(\Input::method() == 'POST' && \Uri::segment(2) == 'confirm')
		{
			$model_user = new \Model_Muser();
			$email = array(
				0 => $data['mail_addr1'],
				1 => $data['mail_addr2'],
			);
			if( ! $model->validate())
			{
				$error = $model->get_list_error();
				$data['error'] = $error ;
			}

			elseif ($pesron_data == null || $model_job->count_data(array('job_id' => $data['job_id'])) == 0)
			{
				Session::set_flash('error','応募可能期間が終了しています');
			}

			else
			{
				$data['status'] = \Constants::$_status_person['approval'];
				$model->set($data);
				if($model->save())
				{
					$last_id = $model->person_id;

					//send mail
					$model_user = new \Model_Muser();
					$list_emails = $model_user->get_list_user_email();
					$department_id = ($pesron_data['department_id']) ? $pesron_data['department_id'] : 0;
					$list_email_department = $model_user->get_list_mail_department($department_id);
					$datamail_user = array(
						'phone_number' => isset($pesron_data['phone_number1']) ? $pesron_data['phone_number1'] : '',
						'email'        => $email,
					);
					$datamail_department = array(
						'm_group'     => isset($pesron_data['m_group_name']) ? $pesron_data['m_group_name'] : '',
						'branch_name' => isset($pesron_data['branch_name']) ? $pesron_data['branch_name'] : '',
						'ss_name'     => isset($pesron_data['ss_name']) ? $pesron_data['ss_name'] : '',
						'sale_name'   => isset($pesron_data['sale_name']) ? $pesron_data['sale_name'] : '',
						'list_emails' => array_merge($list_emails, $list_email_department),
						'last_id'     => $last_id,
					);

					$model->sendmail_user($datamail_user, 1);
					$model->sendmail_department($datamail_department);
					Response::redirect('form/thanks');
				}
				else
				{
					Session::set_flash('error', \Constants::$message_create_error);
				}
			}
		}

		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('form/confirm',$data);
	}
	public function action_thanks()
	{
		Session::delete('person_data');
		Session::delete('notes');
		Session::delete('job_id');
		$this->template->title = 'UOS求人システム';
		$this->template->content = \View::forge('form/thanks');
	}
}