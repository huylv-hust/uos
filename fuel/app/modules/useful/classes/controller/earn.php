<?php

/**
 * Guide earn controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_earn extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドで効率良く稼ぐ | しごさが';

		$this->template->content = self::view('default/earn');
	}
}
