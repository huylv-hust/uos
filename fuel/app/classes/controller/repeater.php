<?php

/**
 * Repeater controller
 *
 * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
 * @date 30/11/2015
 */

class Controller_Repeater extends Controller_Uos
{
	public function action_index()
	{
		$this->template->title = '過去にエントリーしたことのある方へ | おしごとnavi';

		$this->template->content = self::view('repeater/index');
	}
}
