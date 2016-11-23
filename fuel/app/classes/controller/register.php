<?php

/**
 * Register controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 30/10/2015
 */

class Controller_Register extends Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '無料コンシェルジュ 登録フォーム | おしごとnavi';

		$this->template->content = self::view('register/index');
	}

	public function action_confirm()
	{
		$this->template->title = '無料コンシェルジュ 登録フォーム | おしごとnavi';

		if(\Input::method() == 'POST')
		{
			$_POST['name_kana'] = mb_convert_kana(Input::post('name_kana'), 'HVc');

			$data['info'] = \Input::post();

			$model = new \Model_Register();
			if( ! $model->validate())
			{
				//get errors pass to view
				$data['errors'] = $model->get_list_errors();
				$this->template->content = self::view('register/index', $data);
			}
			else
			{
				if($data['info']['pass'] == 'true')
				{
					$model = new Model_Register();
					if($last = $model->save_data($data['info']))
					{
						//send mail
						$model_user = new \Model_Muser();
						$list_emails = $model_user->get_list_user_email();
						$datamail = array(
							'register_id' => $last[0],
							'email'       => $data['info']['mail'],
							'email2'      => $data['info']['mail2'],
							'list_emails' => $list_emails,
						);

						$model->sendmail($datamail, 99);
						$model->sendmail($datamail, 1);

						\Response::redirect(\Uri::base().'register/thanks');
					}
				}
				else
				{
					$this->template->content = self::view('register/confirm', $data);
				}
			}
		}
		else
		{
			\Response::redirect(\Uri::base().'register');
		}
	}

	public function action_thanks()
	{
		$this->template->title = '無料コンシェルジュ 登録フォーム | おしごとnavi';

		$this->template->content = self::view('register/thanks');
	}
}
