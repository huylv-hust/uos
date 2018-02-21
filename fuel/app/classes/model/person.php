<?php

class Model_Person extends \Orm\Model
{
	private $validation;
	private $error = array();
	protected static $_table_name = 'person';
	protected static $_primary_key = array('person_id');


	function __construct()
	{
		\Fuel\Core\Config::set('language', 'jp');
		\Fuel\Core\Lang::load('validation');
		\Fuel\Core\Lang::load('labelfield');
		$this->validation = Validation::instance();
	}
	public function count_data($filters = array())
	{
		$query = $this->_where($filters);
		return count($query->execute());
	}

	public function get_filter_person($filter)
	{
		$select = $this->_where($filter);
		return $select->execute();
	}
	public function _where($filter = array())
	{
		$is_where = DB::select('person.*','m_ss.ss_name','m_partner.branch_name','job.job_id')->from('person')->join('job', 'INNER')->on('job.job_id', '=', 'person.job_id');
		$is_where->join('sssale', 'INNER')->on('job.sssale_id', '=', 'sssale.sssale_id');
		$is_where->join('m_ss', 'INNER')->on('m_ss.ss_id', '=', 'sssale.ss_id');
		$is_where->join('m_partner', 'INNER')->on('m_partner.partner_code', '=', 'm_ss.partner_code');
		$is_where->order_by('person_id', 'desc');

		if (isset($filter['email']) && $filter['email'] != '')
		{
			$is_where->and_where_open();
				$is_where->where('mail_addr1', 'LIKE', '%'.$filter['email'].'%')
				->or_where('mail_addr2', 'LIKE', '%'.$filter['email'].'%');
			$is_where->and_where_close();
		}

		if (isset($filter['name']) && $filter['name'] != '')
		{
			$is_where->and_where_open();
				$is_where->where('person.name', 'LIKE', '%'.$filter['name'].'%');
			$is_where->and_where_close();
		}

		if (isset($filter['phone']) && $filter['phone'] != '')
		{
			$is_where->and_where_open();
				$is_where->where('person.tel', 'LIKE', '%'.$filter['phone'].'%')
				->or_where('person.mobile', 'LIKE', '%'.$filter['phone'].'%');
			$is_where->and_where_close();
		}

		if (isset($filter['ss_name']) && $filter['ss_name'] != '')
		{
			$is_where->and_where_open();
				$is_where->where('ss_name', 'LIKE', '%'.$filter['ss_name'].'%');
			$is_where->and_where_close();
		}

		if (isset($filter['branch_name']) && $filter['branch_name'] != '')
		{
			$is_where->and_where_open();
				$is_where->where('branch_name', 'LIKE', '%'.$filter['branch_name'].'%');
			$is_where->and_where_close();
		}

		if(isset($filter['to_date']) && $filter['to_date'] != '')
		{
			$filter_date = strtotime($filter['to_date']) + 1439 * 60;
			$date_to = date('Y-m-d H:i:s',$filter_date);
		}

		if(isset($filter['from_date']) && isset($filter['to_date']) && $filter['from_date'] != '' && $filter['to_date'] == '')
		{
			$is_where->and_where_open();
				$is_where->where('application_date', '>=', $filter['from_date']);
			$is_where->and_where_close();
		}

		if(isset($filter['to_date']) && $filter['from_date'] == '' && $filter['to_date'] != '')
		{
			$is_where->and_where_open();
				$is_where->and_where('application_date', '<=',$date_to);
			$is_where->and_where_close();
		}

		if (isset($filter['from_date']) && $filter['from_date'] != '' && $filter['to_date'] != '')
		{
			$is_where->and_where_open();
				$is_where->where('application_date', '>=', $filter['from_date']);
				$is_where->and_where('application_date', '<=',$date_to);
			$is_where->and_where_close();
		}

		if (isset($filter['limit']))
		{
			$is_where->limit($filter['limit']);
		}

		if (isset($filter['offset']))
		{
			$is_where->offset($filter['offset']);
		}

		return $is_where;
	}

	public function get_person_data($datas)
	{
		$post = $datas;
		$datas['transportation'] = '';
		$datas['work_type'] = '';
		$datas['application_date'] = null;
		$datas['updated_at'] = date('Y-m-d H:i:s');
		$datas['tel'] = $datas['tel_1'] != '' && $datas['tel_2'] != '' && $datas['tel_3'] != '' ? $datas['tel_1'].'-'.$datas['tel_2'].'-'.$datas['tel_3'] : '';
		$datas['mobile'] = $datas['mobile_1'] != '' && $datas['mobile_2'] != '' && $datas['mobile_3'] != '' ? $datas['mobile_1'].'-'.$datas['mobile_2'].'-'.$datas['mobile_3'] : '';
		for($i = 1; $i <= 3; $i++)
		{
			$datas['license'.$i] = '';
			if(isset($post['license'.$i]))
			{
				foreach($post['license'.$i] as $key => $value)
				{
					$datas['license'.$i] .= ','.$value;
				}

				$datas['license'.$i] .= ',';
			}
		}

		if(isset($post['transportation']))
		{
			foreach($post['transportation'] as $key => $value)
			{
				$datas['transportation'] .= ','.$value;
			}

			$datas['transportation'] .= ',';
		}

		if(isset($post['work_type']))
		{
			foreach($post['work_type'] as $key => $value)
			{
				$datas['work_type'] .= ','.$value;
			}

			$datas['work_type'] .= ',';
		}
		$datas['birthday'] = $post['year'].'-'.$post['month'].'-'.$post['day'];
		$datas['zipcode'] = $post['zipcode1'].$post['zipcode2'];
		return $datas;
	}

	public function validate()
	{
		if( ! $this->validation->input('name'))
		{
			$this->error['name'] = '氏名(全角)を入力してください。';
		}

		if( ! $this->validation->input('name_kana'))
		{
			$this->error['name_kana'] = '氏名(ふりがな)を入力してください。';
		}
		else
		{
			if( ! preg_match('/^([ぁ-ん　]|\s)+$/',$this->validation->input('name_kana')))
			{
				$this->error['name_kana'] = 'ひらがなを入力してください';
			}
		}

		if( ! $this->validation->input('zipcode1') && ! $this->validation->input('zipcode2'))
		{
			$this->error['zipcode'] = '郵便番号を入力してください。';
		}

		if($this->validation->input('zipcode1') != '' && ! is_numeric($this->validation->input('zipcode1')))
		{
			$this->error['zipcode'] = '郵便番号の指定が正しくありません。';
		}

		if($this->validation->input('zipcode2') != '' && ! is_numeric($this->validation->input('zipcode2')))
		{
			$this->error['zipcode'] = '郵便番号の指定が正しくありません。';
		}

		if($this->validation->input('zipcode1') != '' && strlen($this->validation->input('zipcode1')) != 3)
		{
			$this->error['zipcode'] = '郵便番号の指定が正しくありません。';
		}

		if($this->validation->input('zipcode2') != ''  && strlen($this->validation->input('zipcode2')) != 4)
		{
			$this->error['zipcode'] = '郵便番号の指定が正しくありません。';
		}

		if( $this->validation->input('year') == 0 || $this->validation->input('month') == 0 || $this->validation->input('day') == 0)
		{
			$this->error['birthday'] = '生年月日を選択してください。';
		}

		if($this->validation->input('gender') == '')
		{
			$this->error['gender'] = '性別を選択してください。';
		}

		if( ! $this->validation->input('addr1'))
		{
			$this->error['addr1'] = '都道府県を選択してください。';
		}

		if( ! $this->validation->input('addr2'))
		{
			$this->error['addr2'] = '市区町村を入力してください。';
		}

		if( ! $this->validation->input('addr3'))
		{
			$this->error['addr3'] = '以降の住所を入力してください。';
		}

		if(mb_strlen($this->validation->input('addr2')) > 20)
		{
			$this->error['addr2'] = '20文字以内で入力してください。';
		}

		if(mb_strlen($this->validation->input('addr3')) > 20)
		{
			$this->error['addr3'] = '20文字以内で入力してください。';
		}

		if( ! $this->validation->input('mail_addr1') && ! $this->validation->input('mail_addr2'))
		{
			$this->error['mail_addr1'] = 'メールアドレスを入力してください。';
			$this->error['mail_addr2'] = 'メールアドレスを入力してください。';
		}

		if ($this->validation->input('mail_addr1') != '' && filter_var($this->validation->input('mail_addr1'), FILTER_VALIDATE_EMAIL) === false) {
			$this->error['mail_addr1'] = 'メールアドレスが正しくありません';
		}

		if ($this->validation->input('mail_addr2') != '' && filter_var($this->validation->input('mail_addr2'), FILTER_VALIDATE_EMAIL) === false) {
			$this->error['mail_addr2'] = 'メールアドレスが正しくありません';
		}

		if( ! $this->validation->input('occupation_now'))
		{
			$this->error['occupation_now'] = '現在の職業を入力してください。';
		}

		$tel_1 = $this->validation->input('tel_1');
		$tel_2 = $this->validation->input('tel_2');
		$tel_3 = $this->validation->input('tel_3');
		$mobile_1 = $this->validation->input('mobile_1');
		$mobile_2 = $this->validation->input('mobile_2');
		$mobile_3 = $this->validation->input('mobile_3');
		$tel = $tel_1 != '' && $tel_2 != '' && $tel_3 != '' ? $tel_1.$tel_2.$tel_3 : '';
		$mobile = $mobile_1 != '' && $mobile_2 != '' && $mobile_3 != '' ? $mobile_1.$mobile_2.$mobile_3 : '';
		if($tel_1 != '' && ($tel_2 === '' || $tel_3 === ''))
		{
			$this->error['tel'] = '固定電話番号を入力してください。';
		}

		elseif ($tel_2 != '' && ($tel_1 === '' || $tel_3 === ''))
		{
			$this->error['tel'] = '固定電話番号を入力してください。';
		}

		elseif ($tel_3 != '' && ($tel_2 === '' || $tel_1 === ''))
		{
			$this->error['tel'] = '固定電話番号を入力してください。';
		}

		if($mobile_1 != '' && ($mobile_2 === '' || $mobile_3 === ''))
		{
			$this->error['mobile'] = '携帯電話番号を入力してください。';
		}

		elseif ($mobile_2 != '' && ($mobile_1 === '' || $mobile_3 === ''))
		{
			$this->error['mobile'] = '携帯電話番号を入力してください。';
		}

		elseif ($mobile_3 != '' && ($mobile_2 === '' || $mobile_1 === ''))
		{
			$this->error['mobile'] = '携帯電話番号を入力してください。';
		}


		if($tel == '' && $mobile == '')
		{
			$this->error['tel'] = '固定電話番号を入力してください。';
			$this->error['mobile'] = '携帯電話番号を入力してください。';
		}
		else
		{
			if($tel and ! preg_match('/^0[0-9]+$/',$tel))
			{
				$this->error['tel'] = '正しい電話番号をご入力下さい。';
			}

			if($mobile and ! preg_match('/^0[0-9]+$/',$mobile))
			{
				$this->error['mobile'] = '正しい電話番号をご入力下さい。';
			}
		}

		if(mb_strlen($this->validation->input('notes')) > 500)
		{
			$this->error['notes'] = '備考は500文字以内で入力してください';
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
	public function get_mail_data($job_id)
	{
		$data = array();
		$select = DB::select('job.*','m_ss.ss_name','m_partner.branch_name','job.job_id','sssale.sale_type','sssale.sale_name','m_group.name', 'm_partner.department_id')->from('job');
		$select->join('sssale', 'INNER')->on('job.sssale_id', '=', 'sssale.sssale_id');
		$select->join('m_ss', 'INNER')->on('m_ss.ss_id', '=', 'sssale.ss_id');
		$select->join('m_partner', 'INNER')->on('m_partner.partner_code', '=', 'm_ss.partner_code');
		$select->join('m_group', 'INNER')->on('m_group.m_group_id', '=', 'm_partner.m_group_id');
		$select->where('job.job_id',$job_id);

		$result = $select->execute()->as_array();

		if(count($result) <= 0)
		{
			return null;
		}

		$job_phone_number1 = explode(',',$result[0]['phone_number1']);
		$phone_number = $job_phone_number1[0];

		$data['phone_number1'] = $phone_number;
		$data['post_company_name'] = $result[0]['post_company_name'];
		$data['business_description'] = $result[0]['business_description'];
		$data['m_group_name'] = $result[0]['name'];
		$data['branch_name'] = $result[0]['branch_name'];
		$data['ss_name'] = $result[0]['ss_name'];
        $data['sale_type'] = $result[0]['sale_type'];
		$data['sale_name'] = $result[0]['sale_name'];
		$data['job_category'] = $result[0]['job_category'];
		$data['department_id'] = $result[0]['department_id'];

		return $data;

	}
	public function sendmail_user($data, $status)
	{

		$subject = '【しごさが】応募が完了しました';

		$to = $data['email'];
		if($to[0] != null && $to[1] == null)
		{
			$mailto = $to[0];
		}
		elseif($to[0] == null && $to[1] != null)
		{
			$mailto = $to[1];
		}
		else
		{
			$mailto = $data['email'];
		}

		if( ! $to)
		{
			return false;
		}

		$data['status'] = $status;

		return \Utility::sendmail($mailto, $subject, $data, 'email/person_user');

	}

	public function sendmail_department($data)
	{
		$subject = '【しごさが】新しい求人応募がありました。';
		foreach($data['list_emails'] as $email)
		{
			if($email['mail'])
			{
				$mailto[] = $email['mail'];
			}
		}

		//remove duplicate email
		if(isset($mailto))
		{
			$mailto = array_unique($mailto);
		}
		else
		{
			return false;
		}

		$data['bo_url'] = \Fuel\Core\Config::get('bo_url');
		return \Utility::sendmail($mailto, $subject, $data, 'email/person_admin');

	}

	public function get_default_business_user_id($job_id)
	{
		$job_info = DB::select('*')->from('job')->where('job_id', $job_id)->execute()->as_array();
		$job_info = current($job_info);
		$sssale_info = DB::select('*')->from('sssale')->where('sssale_id', $job_info['sssale_id'])->execute()->as_array();
		$sssale_info = current($sssale_info);
		$ss_info = DB::select('*')->from('m_ss')->where('ss_id', $sssale_info['ss_id'])->execute()->as_array();
		$ss_info = current($ss_info);
		if ($ss_info['user_id'])
		{
			return $ss_info['user_id'];
		}
		$partner_info = DB::select('*')->from('m_partner')->where('partner_code', $ss_info['partner_code'])->execute()->as_array();
		$partner_info = current($partner_info);
		return $partner_info['user_id'];
	}
}
