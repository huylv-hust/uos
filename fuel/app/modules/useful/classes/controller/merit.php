<?php

/**
 * Guide kiken controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_merit extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドで働くメリット | しごさが';

		$this->template->content = self::view('default/merit');
	}
}
