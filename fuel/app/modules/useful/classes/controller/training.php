<?php

/**
 * Guide training controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_training extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドに研修制度はあるの？ | しごさが';

		$this->template->content = self::view('default/training');
	}
}
