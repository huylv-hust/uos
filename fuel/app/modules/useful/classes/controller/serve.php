<?php

/**
 * Guide serve controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_serve extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンド初心者必読！接客の基本 | しごさが';

		$this->template->content = self::view('default/serve');
	}
}
