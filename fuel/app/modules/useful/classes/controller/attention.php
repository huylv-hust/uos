<?php

/**
 * Guide attention controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_attention extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドで働く際の注意点 | しごさが';

		$this->template->content = self::view('default/attention');
	}
}
