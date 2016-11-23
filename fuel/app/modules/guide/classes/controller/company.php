<?php

/**
 * Guide company controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Guide;

class Controller_Company extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '会社概要 | おしごとnavi';

		$this->template->content = self::view('default/company');
	}
}
