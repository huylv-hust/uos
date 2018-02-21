<?php

/**
 * Guide appearance controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_appearance extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドでの身だしなみ | しごさが';

		$this->template->content = self::view('default/appearance');
	}
}
