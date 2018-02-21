<?php

/**
 * Privacy controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 01/12/2015
 */

class Controller_Privacy extends Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '個人情報保護方針 | しごさが';

		$this->template->content = self::view('general/privacy');
	}
}
