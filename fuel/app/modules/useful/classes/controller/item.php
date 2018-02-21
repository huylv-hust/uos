<?php

/**
 * Guide item controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_item extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドで働くなら知っておくと良い商品４選';

		$this->template->content = self::view('default/item');
	}
}
