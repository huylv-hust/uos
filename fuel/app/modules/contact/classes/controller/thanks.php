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

class Controller_Thanks extends \Controller_Uos
{
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action top
	 */
	public function action_index()
	{
		if($data_contact = Input::post())
		{
			$contact = new \Model_Contact();
			if($contact->validate() and $save_contact = $contact->save_data($data_contact))
			{
				$data = array(
					'id_contact' => $save_contact->contact_id,
					'email'      => $save_contact->mail
				);
				$this->template->content = \View::forge('thanks/index');
				$contact->send_mail($data);
				return;
			}
		}

		Response::redirect(Uri::base().'contact/index');
	}
}