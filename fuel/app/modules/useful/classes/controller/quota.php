<?php

/**
 * Guide quota controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_quota extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドの販売ノルマは？ | しごさが';

		$this->template->content = self::view('default/quota');
	}
}
