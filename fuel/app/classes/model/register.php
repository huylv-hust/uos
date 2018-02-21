<?php

class Model_Register extends \Fuel\Core\Model_Crud
{
	protected static $_primary_key = 'register_id';
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events'          => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events'          => array('before_update'),
			'mysql_timestamp' => false,
		),
	);
	protected static $_table_name = 'register';
	public $data_default;

	private $validation;
	private $errors = array();

	public function __construct()
	{
		\Fuel\Core\Config::set('language', 'jp');
		\Fuel\Core\Lang::load('validation');
		$this->validation = \Validation::instance();
		$this->data_default = \Utility::get_default_data(self::$_table_name);
	}

	/*
	 * Validate register
	 *
	 * @since 02/11/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public function validate()
	{
		if( ! $this->validation->input('name'))
		{
			$this->errors['name'] = '氏名(全角)を入力してください。';
		}

		if(mb_strlen($this->validation->input('name')) > 50)
		{
			$this->errors['name'] = '50文字以内で入力してください';
		}

		if( ! $this->validation->input('name_kana'))
		{
			$this->errors['name_kana'] = '氏名(ふりがな)を入力してください。';
		}

		//kana
		if($this->validation->input('name_kana') && ! preg_match('/^([ぁ-ん+一]|\s)+$/',$this->validation->input('name_kana')))
		{
			$this->errors['name_kana'] = 'ひらがなを入力してください';
		}

		if(mb_strlen($this->validation->input('name_kana')) > 50)
		{
			$this->errors['name_kana'] = '50文字以内で入力してください';
		}

		if( ! $this->validation->input('birthday_year') || ! $this->validation->input('birthday_month') || ! $this->validation->input('birthday_day'))
		{
			$this->errors['birthday'] = '生年月日を選択してください。';
		}
		else
		{
			if( ! checkdate($this->validation->input('birthday_month'), $this->validation->input('birthday_day'), $this->validation->input('birthday_year')))
			{
				$this->errors['birthday'] = '日付が正しくありません';
			}
		}

		if($this->validation->input('gender') == null)
		{
			$this->errors['gender'] = '性別を選択してください。';
		}

		//zipcode
		if( ! $this->validation->input('zipcode_first') || ! $this->validation->input('zipcode_last'))
		{
			$this->errors['zipcode'] = '郵便番号を入力してください。';
		}
		else
		{
			if(strlen($this->validation->input('zipcode_first')) != 3)
			{
				$this->errors['zipcode'] = '正しくありません';
			}

			if(strlen($this->validation->input('zipcode_last')) != 4)
			{
				$this->errors['zipcode'] = '正しくありません';
			}

			$zipcode = trim($this->validation->input('zipcode_first').$this->validation->input('zipcode_last'));
			if($zipcode && (strlen($zipcode) != 7 || ! is_numeric($zipcode)))
			{
				$this->errors['zipcode'] = '正しくありません';
			}
		}

		if( ! $this->validation->input('addr1'))
		{
			$this->errors['addr1'] = '都道府県を選択してください。';
		}

		if( ! $this->validation->input('addr2'))
		{
			$this->errors['addr2'] = '市区町村を入力してください。';
		}

		if(mb_strlen($this->validation->input('addr2')) > 20)
		{
			$this->errors['addr2'] = '20文字以内で入力してください。';
		}

		if( ! $this->validation->input('addr3'))
		{
			$this->errors['addr3'] = '以降の住所を入力してください。';
		}

		if(mb_strlen($this->validation->input('addr3')) > 20)
		{
			$this->errors['addr3'] = '20文字以内で入力してください。';
		}

		if( ! $this->validation->input('mobile_home') && ! $this->validation->input('mobile'))
		{
			$this->errors['mobile'] = '携帯電話番号を入力してください。';
			$this->errors['mobile_home'] = '固定電話番号を入力してください。';
		}
		else
		{
			if($this->validation->input('mobile_home')  and ! preg_match('/^0[0-9]+$/',$this->validation->input('mobile_home')))
			{
				$this->errors['mobile_home'] = '正しい電話番号をご入力下さい。';
			}

			if($this->validation->input('mobile_home') and strlen($this->validation->input('mobile_home')) != 10 and strlen($this->validation->input('mobile_home')) != 11)
			{
				$this->errors['mobile_home'] = '正しい電話番号をご入力下さい。';
			}

			if($this->validation->input('mobile') and ! preg_match('/^0[0-9]+$/',$this->validation->input('mobile')))
			{
				$this->errors['mobile'] = '正しい電話番号をご入力下さい。';
			}

			if($this->validation->input('mobile') and strlen($this->validation->input('mobile')) != 10 and strlen($this->validation->input('mobile')) != 11)
			{
				$this->errors['mobile'] = '正しい電話番号をご入力下さい。';
			}
		}

		if( ! $this->validation->input('mail') && ! $this->validation->input('mail2'))
		{
			$this->errors['mail'] = 'メールアドレスを入力してください。';
			$this->errors['mail2'] = 'メールアドレスを入力してください。';
		}
		else
		{
			if($this->validation->input('mail') && ! filter_var($this->validation->input('mail'), FILTER_VALIDATE_EMAIL))
			{
				$this->errors['mail'] = 'メールアドレスが正しくありません';
			}

			if($this->validation->input('mail2') && ! filter_var($this->validation->input('mail2'), FILTER_VALIDATE_EMAIL))
			{
				$this->errors['mail2'] = 'メールアドレスが正しくありません';
			}

			if($this->validation->input('mail') && mb_strlen($this->validation->input('mail')) > 50)
			{
				$this->errors['mail'] = 'メールアドレス1(半角英数字)は50数字以内で入力してください';
			}

			if($this->validation->input('mail2') && mb_strlen($this->validation->input('mail2')) > 50)
			{
				$this->errors['mail2'] = 'メールアドレス2(半角英数字)は50数字以内で入力してください';
			}
		}

		if( ! $this->validation->input('occupation_now'))
		{
			$this->errors['occupation_now'] = '現在の職業を入力してください。';
		}

		if($this->errors)
		{
			return false;
		}

		return true;
	}

	public function get_list_errors()
	{
		return $this->errors;
	}

	/*
	 * Save data
	 *
	 * @since 02/11/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public function save_data($post)
	{
		$db = array(
			'name'           => $post['name'],
			'name_kana'      => $post['name_kana'],
			'birthday'       => $post['birthday_year'].'-'.$post['birthday_month'].'-'.$post['birthday_day'],
			'gender'         => $post['gender'],
			'zipcode'        => $post['zipcode_first'].$post['zipcode_last'],
			'addr1'          => $post['addr1'],
			'addr2'          => $post['addr2'],
			'addr3'          => $post['addr3'],
			'mobile'         => $post['mobile'] != null ? $post['mobile'] : null,
			'mobile_home'    => $post['mobile_home'] != null ? $post['mobile_home'] : null,
			'occupation_now' => $post['occupation_now'],
			'notes'          => $post['notes'],
			'mail'           => $post['mail'] != null ? $post['mail'] : null,
			'mail2'          => $post['mail2'] != null ? $post['mail2'] : null,
			'created_at'     => date('Y-m-d H:i:s'),
		);

		return DB::insert(self::$_table_name)->set($db)->execute();
	}

	/*
	 * Config email
	 *
	 * @since 03/11/2015
	 * @author Ha Huu Don <donhh6551@seta-asia.com.vn>
	 */
	public function sendmail($data, $status)
	{
		$subject = '【しごさが】コンシェルジュ登録が完了しました';
		$mailto = array();
		if($status == 1)
		{
			$subject = '【しごさが】コンシェルジュ登録がありました。';
			foreach($data['list_emails'] as $email)
			{
				if($email['mail'])
				{
					$mailto[] = $email['mail'];
				}
			}
		}
		else
		{
			if($data['email'])
			{
				$mailto[] = $data['email'];
			}

			if($data['email2'])
			{
				$mailto[] = $data['email2'];
			}
		}

		if( ! $mailto)
		{
			return false;
		}
		else
		{
			//remove duplicate email
			array_unique($mailto);
		}

		$data['status'] = $status;

		return \Utility::sendmail($mailto, $subject, $data, 'email/register');
	}
}
