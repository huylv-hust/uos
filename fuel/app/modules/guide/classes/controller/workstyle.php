<?php

/**
 * Guide workstyle controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Guide;

class Controller_Workstyle extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '働き方の紹介 | おしごとnavi';

		$this->template->content = self::view('default/workstyle');
	}
}
