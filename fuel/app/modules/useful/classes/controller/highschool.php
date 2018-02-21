<?php

/**
 * Guide highschool controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_highschool extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドバイトが高校生にお勧めの理由 | しごさが';

		$this->template->content = self::view('default/highschool');
	}
}
