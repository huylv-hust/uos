<?php

/**
 * Concierge controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 30/11/2015
 */

class Controller_Concierge extends Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '無料コンシェルジェ相談 | しごさが';

		$this->template->content = self::view('concierge/index');
	}
}
