<?php

/**
 * Guide item controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_Self extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'セルフ型ガソリンスタンドの仕事内容';

		$this->template->content = self::view('default/self');
	}
}
