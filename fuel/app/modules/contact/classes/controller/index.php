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

class Controller_Index extends \Controller_Uos
{
	/**
	 * @author Bui Dang <dangbcd6591@seta-asia.com.vn>
	 * action top
	 */
	public function action_index()
	{
		$this->template->content = \View::forge('index/index');
	}


}