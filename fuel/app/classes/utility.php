<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Utility
{
	/*
	 * Send mail
	 *
	 * @since 05/06/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function sendmail($mailto, $subject, $data, $template = false)
	{
		$body = isset($data['body']) ? $data['body'] : null;

		$email = \Email::forge();
		$email->from(\Fuel\Core\Config::get('mail_from'), \Fuel\Core\Config::get('mail_from_name'));

		//if is array mail
		$mail_to = array();
		if(is_array($mailto) && count($mailto))
		{
			foreach($mailto as $key => $value)
			{
				$mailto_arr = explode(',', trim($value, ','));
				if(count($mailto_arr))
				{
					foreach($mailto_arr as $k => $v)
					{
						if($v)
						{
							$mail_to[$v] = $v;
						}
					}
				}
			}

			$email->to($mail_to);
		}
		else
		{
			$email->to($mailto);
		}

		$email->subject($subject);
		$email->body($body);

		//use template
		if($template)
		{
			$email->body(\View::forge($template, $data)); //$data is var pass to template
		}

		//if have attach
		//$email->attach(DOCROOT.'my-pic.jpg');
		try
		{
			$email->send();
			return true;
		}
		catch(\EmailValidationFailedException $e)
		{
			Fuel\Core\Log::error('Mail validation: '.json_encode($mailto));
		}
		catch(\EmailSendingFailedException $e)
		{
			Fuel\Core\Log::error('Mail send failed: '.json_encode($mailto));
		}
	}

	/*
	 * Debug data
	 *
	 * @since 05/09/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public static function debug($value, $die = true)
	{
		echo '<pre>';
		print_r($value);
		echo '</pre>';
		if ($die)
		{
			die();
		}
	}

	public static function get_default_data($table_name)
	{
		$fields = \DB::list_columns($table_name);
		foreach($fields as $k => $v)
		{
			$_data_default[$k] = $v['default'];
		}

		$_data_default['is_new'] = true;
		return $_data_default;
	}

	/*
	 * Validate
	 * @singce 2015/10/28
	 * @author Dang Bui 6591
	 * */
	public static function format_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	public static function validate_required($value)
	{
		if(self::format_input($value) == '')
			return false;
		else
			return true;
	}
	public static function validate_email($value)
	{
		if ( ! filter_var(self::format_input($value), FILTER_VALIDATE_EMAIL))
			return false;
		else
			return true;
	}

	/**
	 * @author thuanth6589
	 * @param $date
	 * @return string
	 */
	public static function get_day_of_week($date)
	{
		$day = date('N', strtotime($date));
		return isset(Constants::$day_of_week[$day]) ? Constants::$day_of_week[$day] : '';
	}

	/**
	 * @author thuanth6589
	 * crop tring, add ...
	 * @param $str
	 * @param $length
	 * @param string $char
	 * @return string
	 */
	public static function crop_string($str, $length, $char=' ...')
	{
		$str = trim($str);

		// nếu str < length, return str
		$strlen	= mb_strlen($str, 'UTF-8');

		if($strlen <= $length) return $str;

		// Cắt chiều dài chuỗi tới đoạn cần lấy
		$substr	= mb_substr($str, 0, $length, 'UTF-8');
		return $substr.$char;
	}

	private static function _bit2mask($bit)
	{
		$bit = intval($bit);
		return bindec(
				str_repeat('1', $bit) . str_repeat('0', 32 - $bit)
		);
	}

	/*
	 * check IP range.
	 *
	 * @author Y.Hasegawa <hasegawa@d-o-m.jp>
	 * @return boolean
	 */
	public static function is_include_ip($ip, $ranges)
	{
		if (is_array($ranges) == false)
		{
			$ranges = array($ranges);
		}

		$ip_long = ip2long($ip);

		foreach ($ranges as $range)
		{
			@list($range_ip, $bit) = explode('/', $range);
			if (strlen($bit))
			{
				$range_ip_long = ip2long($range_ip);
				$mask = self::_bit2mask($bit);
				if (($ip_long & $mask) == ($range_ip_long & $mask))
				{
					return true;
				}
			}
			else if ($ip == $range)
			{
				return true;
			}
		}

		return false;
	}


	public static function get_head_seo()
	{
		$urlcurrent = Fuel\Core\Input::server('REQUEST_URI');
		$pos1 = str_replace('/uos/','',$urlcurrent);
		$pos1 = str_replace('.html','',$pos1);
		$pos1 = ltrim($pos1, '/');
		$pos1 = rtrim($pos1, '/');
		$pos1 = strtolower($pos1);
		if(strpos($pos1,'search/detail') !== false)
		{
			$pos1 = 'search/detail';
		}
		elseif(strpos($pos1,'search') !== false)
		{
			$jobs = new Model_Job();
			if($jobs->count_data(\Fuel\Core\Input::get()) == 0)
				$pos1 = 'search/no';
			else
				$pos1 = 'search';
		}
		elseif($pos1 === 'search')
		{
			$pos1 = 'search';
		}

		if(array_key_exists($pos1,Constants::$head_meta))
		{
			return Constants::$head_meta[$pos1];
		}

		return array(
			'title'       => '404 Page Not Found. | おしごとnavi',
			'h1'          => '404 Page Not Found.',
			'keywords'    => '404',
			'description' => '404 Page Not Found',
			'h_des'       => 'お探しのページは見つかりません。',
		);
	}

	/**
	 * Encrypt
	 * @author Y.Hasegawa <hasegawa@d-o-m.jp>
	 * @param mixed
	 * @return string
	 */
	public static function encrypt($data)
	{
		return bin2hex(mcrypt_encrypt(
			MCRYPT_BLOWFISH,
			pack("H*", Fuel\Core\Config::get('preview_encrypt_key')),
			serialize($data),
			MCRYPT_MODE_CBC,
			pack("H*", Fuel\Core\Config::get('preview_encrypt_iv'))
		));
	}

	/**
	 * Decrypt
	 * @author Y.Hasegawa <hasegawa@d-o-m.jp>
	 * @param string
	 * @return mixed
	 */
	public static function decrypt($encrypted)
	{
		try
		{
			$decrypted = rtrim(mcrypt_decrypt(
				MCRYPT_BLOWFISH,
				pack("H*", Fuel\Core\Config::get('preview_encrypt_key')),
				pack("H*", $encrypted),
				MCRYPT_MODE_CBC,
				pack("H*", Fuel\Core\Config::get('preview_encrypt_iv'))
			));

			return unserialize($decrypted);
		}
		catch (Fuel\Core\PhpErrorException $ex)
		{
			return null;
		}
	}

}