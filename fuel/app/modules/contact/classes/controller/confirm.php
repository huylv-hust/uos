<?php
/**
 * @author: Bui Cong Dang (dangbcd6591@seta-asia.com.vn)
 * @paramr: File controller group
 **/
namespace Contact;

use Fuel\Core\Controller;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

class Controller_Confirm extends \Controller_Uos
{

	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action top
	 */
	public function action_index()
	{
		$data = array();
		if($data_contact = Input::post())
		{
			$_POST['name_kana'] = mb_convert_kana(Input::post('name_kana'), 'HVc');

			$contact = new \Model_Contact();
			if( ! $contact->validate())
			{
				$error = $contact->get_list_error();
				$data['error'] = $error ;
				$this->template->content = View::forge('index/index',$data);
			}
			else
			{
				$this->template->content = View::forge('confirm/index');
			}
			return;
		}

		Response::redirect(Uri::base().'contact/index');

	}
}