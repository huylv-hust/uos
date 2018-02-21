<?php
/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Mss
 * @package Model
 */
class Model_Contact extends \Fuel\Core\Model_Crud
{
	private $validation;
	private $error = array();
	protected static $_table_name = 'contact';
	protected static $_primary_key = 'contact_id';

	protected static $_properties = array(
		'contact_id',
		'name',
		'name_kana',
		'mobile',
		'mail',
		'content',
		'created_at',
	);
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events'          => array('before_insert'),
			'mysql_timestamp' => true,
			'property'        => 'created_at',
			'overwrite'       => true,
		),
	);

	function __construct()
	{
		$this->validation = Validation::instance();
	}

	public static function _set($data = [])
	{
		$fields = array();
		foreach ($data as $k => $v)
		{
			if(in_array($k,self::$_properties))
			{
				$fields[$k] = ($v != '') ? $v : null;
			}
		}

		return $fields;
	}

	public function validate()
	{

		if( ! $this->validation->input('name'))
		{
			$this->error['name'] = '氏名(全角)を入力してください。';
		}

		if(mb_strlen($this->validation->input('name')) > 50)
			$this->error['name'] = '氏名(全角)は50文字以内で入力してください';

		if( ! $this->validation->input('name_kana'))
		{
			$this->error['name_kana'] = '氏名(ふりがな)を入力してください。';
		}
		else
		{
			if( ! preg_match('/^([ぁ-ん+一]|\s)+$/',$this->validation->input('name_kana')))
				$this->error['name_kana'] = 'ひらがなを入力してください';
			elseif(mb_strlen($this->validation->input('name_kana')) > 50)
				$this->error['name_kana'] = '50文字以内で入力してください';
		}

		if( ! $this->validation->input('mobile'))
		{
			$this->error['mobile'] = '電話番号を入力してください。';
		}
		else
		{
			if( ! preg_match('/^0[0-9]+$/',$this->validation->input('mobile')))
				$this->error['mobile'] = '正しい電話番号をご入力下さい';
			elseif(strlen($this->validation->input('mobile')) != 10 and strlen($this->validation->input('mobile')) != 11)
				$this->error['mobile'] = '正しい電話番号をご入力下さい';
		}

		if( ! $this->validation->input('mail'))
		{
			$this->error['mail'] = 'メールアドレスを入力してください。';
		}
		else
		{
			if( ! filter_var($this->validation()->input('mail'),FILTER_VALIDATE_EMAIL))
			{
				$this->error['mail'] = 'メールアドレスが正しくありません';
			}
		}

		if( ! $this->validation->input('content'))
		{
			$this->error['content'] = 'お問い合わせ内容を入力してください。';
		}
		else
		{
			if(strlen($this->validation->input('content')) >= 65536)
			{
				$this->error['content'] = 'お問い合わせ内容65536文字以内で入力してください';
			}
		}

		if($this->error)
		{
			return false;
		}

		return true;
	}

	public function get_list_error()
	{
		return $this->error;
	}

	public function save_data($data = array())
	{
		if( ! isset($data))
		{
			return false;
		}
		$data_field = self::_set($data);
		$data_field['created_at'] = date('Y-m-d H:i:s');
		$contact = new Model_Contact();
		$contact->set($data_field);
		if($contact->save())
		{
			return $contact;
		}

		return false;
	}

	public function send_mail($data = array())
	{
		$user = new Model_Muser();
		\Utility::sendmail($data['email'],'【しごさが】お問い合わせありがとうございます',$data,'mail/contact-thanks');

		if($emails = $user->get_list_user_email() and ! empty($emails))
		{
			foreach($emails as $email)
			{
				$listmail[] = $email['mail'];
			}
			$data['bo_url'] = \Fuel\Core\Config::get('bo_url');
			\Utility::sendmail($listmail,'【しごさが】お問い合わせがありました',$data,'mail/contact-notice');
		}

	}


}
