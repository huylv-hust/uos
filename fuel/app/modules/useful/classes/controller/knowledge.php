<?php

/**
 * Guide kiken controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 1/12/2015
 */

namespace Useful;

class Controller_knowledge extends \Controller_Uos
{
	public function action_index()
	{
		$this->template->title = 'ガソリンスタンドでバイトするなら知っておきたい基礎知識 | しごさが';

		$this->template->content = self::view('default/knowledge');
	}
}
