<?php

/**
 * Term controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 01/12/2015
 */

class Controller_Term extends Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ご利用にあたって | しごさが';

		$this->template->content = self::view('general/term');
	}
}
