<?php

/**
 * @author NamDD6566 <namdd6566@seta-asia.com.vn>
 * @package Model
 */
class Model_Saleperson extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'sale_person';
    protected static $_primary_key = 'person_id';
    private $error = array();
    protected static $_properties = array(
        'person_id',
        'plan_code',
        'person_name',
        'person_kana',
        'birthday',
        'gender',
        'application_time',
        'job_id',
        'zipcode',
        'prefecture_id',
        'city',
        'town',
        'tel',
        'mobile',
        'mail_addr1',
        'mail_addr2',
        'occupation_now',
        'note',
        'result',
        'result_time',
        'hire_date',
        'reject_reason',
        'is_read',
        'created_at',
        'updated_at',
    );
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property' => 'created_at',
            'overwrite' => true,
        ),
    );

    public $fields = array();

    function __construct()
    {
        \Fuel\Core\Config::set('language', 'jp');
        \Fuel\Core\Lang::load('label');
    }

    /**
     * @return array|string
     * @throws FuelException
     */
    public function validate()
    {

        $validation = \Fuel\Core\Validation::forge('saleperson');
        $validation->add_callable('myrules');
        //$validation->add_field('plate_no',\Fuel\Core\Lang::get('plate_no'),'required|kana|valid_string[numeric]|exact_length[4]');
        $validation->add_field('person_kana', \Fuel\Core\Lang::get('person_kana'), 'required|kana|max_length[50]');
        $validation->add_field('gender', \Fuel\Core\Lang::get('gender'), 'required');
        $validation->add_field('application_time_d', \Fuel\Core\Lang::get('application_date'), 'required|valid_date[Y-m-d]');
        $validation->add_field('mail_addr1', \Fuel\Core\Lang::get('mail1_addr1'), 'required|valid_email|max_length[255]');
        $validation->add_field('mail_addr2', \Fuel\Core\Lang::get('mail1_addr2'), 'valid_email|max_length[255]');
        $validation->add_field('person_name', \Fuel\Core\Lang::get('person_name'), 'max_length[50]');
        $validation->add_field('zipcode1', \Fuel\Core\Lang::get('zipcode1'), 'valid_string[numeric]|valid_string[numeric]|exact_length[3]')->add_rule('required_zipcode', [$validation->input('zipcode2')]);
        $validation->add_field('zipcode2', \Fuel\Core\Lang::get('zipcode2'), 'valid_string[numeric]|valid_string[numeric]|exact_length[4]')->add_rule('required_zipcode', [$validation->input('zipcode1')]);
        $validation->add_field('city', \Fuel\Core\Lang::get('city'), 'max_length[10]');
        $validation->add_field('town', \Fuel\Core\Lang::get('town'), 'max_length[50]');
        $validation->add_field('tel1', \Fuel\Core\Lang::get('tel1'), 'valid_string[numeric]|max_length[5]')->add_rule('required_tel', [$validation->input('tel2'), $validation->input('tel3')]);
        $validation->add_field('tel2', \Fuel\Core\Lang::get('tel2'), 'valid_string[numeric]|max_length[4]')->add_rule('required_tel', [$validation->input('tel1'), $validation->input('tel3')]);
        $validation->add_field('tel3', \Fuel\Core\Lang::get('tel3'), 'valid_string[numeric]|max_length[4]')->add_rule('required_tel', [$validation->input('tel1'), $validation->input('tel2')]);
        $validation->add_field('mobile1', \Fuel\Core\Lang::get('mobile1'), 'valid_string[numeric]|max_length[5]')->add_rule('required_mobile', [$validation->input('mobile2'), $validation->input('mobile3')]);
        $validation->add_field('mobile2', \Fuel\Core\Lang::get('mobile2'), 'valid_string[numeric]|max_length[4]')->add_rule('required_mobile', [$validation->input('mobile1'), $validation->input('mobile3')]);
        $validation->add_field('mobile3', \Fuel\Core\Lang::get('mobile3'), 'valid_string[numeric]|max_length[4]')->add_rule('required_mobile', [$validation->input('mobile1'), $validation->input('mobile2')]);

        if (!$validation->run()) {
            $this->error = $validation->error_message();
        }

        if($validation->input('birthday_y') && $validation->input('birthday_m') && $validation->input('birthday_d')) {
            if (!checkdate((int)$validation->input('birthday_m'), (int)$validation->input('birthday_d'), (int)$validation->input('birthday_y'))) {
                $this->error['birthday'] = '✕ 生年月日の指定が正しくありません';
            }
        } else {
            $this->error['birthday'] = '✕ 生年月日は必須です';
        }

        if (count($this->error))
            return false;

        return true;
    }

    /**
     * @return array
     */
    public function get_errors()
    {
        return $this->error;
    }

    /**
     * author HuyLV6635
     * action validate form input
     * @return array|bool|string
     */
    public function validation_form()
    {
        $validation = \Fuel\Core\Validation::forge('customer');
        $validation->add_callable('myrules');
        $validation->add_field('person_name', \Fuel\Core\Lang::get('person_name'), 'max_length[50]');
        $validation->add_field('person_kana', \Fuel\Core\Lang::get('person_kana'), 'kana|required|max_length[50]');
        $validation->add_field('year', \Fuel\Core\Lang::get('year'), 'required');
        $validation->add_field('month', \Fuel\Core\Lang::get('month'), 'required');
        $validation->add_field('day', \Fuel\Core\Lang::get('day'), 'required');
        $validation->add_field('gender', \Fuel\Core\Lang::get('gender'), 'required');
        $validation->add_field('zipcode1', \Fuel\Core\Lang::get('zipcode1'), 'required|valid_string[numeric]|exact_length[3]');
        $validation->add_field('zipcode2', \Fuel\Core\Lang::get('zipcode2'), 'required|valid_string[numeric]|exact_length[4]');
        $validation->add_field('prefecture_id', \Fuel\Core\Lang::get('prefecture_id'), 'required');
        $validation->add_field('city', \Fuel\Core\Lang::get('city'), 'required|max_length[10]');
        $validation->add_field('town', \Fuel\Core\Lang::get('town'), 'required|max_length[50]');
        //set data
        $tel1 = \Fuel\Core\Input::post('tel1');
        $tel2 = \Fuel\Core\Input::post('tel2');
        $tel3 = \Fuel\Core\Input::post('tel3');
        $mobile1 = \Fuel\Core\Input::post('mobile1');
        $mobile2 = \Fuel\Core\Input::post('mobile2');
        $mobile3 = \Fuel\Core\Input::post('mobile3');
        /*
            rule data_other is check not tell and not mobile
            rule required_fax is check if have tel1 must have tel2 and tel3
        */
        $validation->add_field('tel1', \Fuel\Core\Lang::get('tel1'), 'valid_string[numeric]|max_length[5]')
            ->add_rule('required_fax', [$tel2, $tel3])
            ->add_rule('data_other', [$tel2, $tel3, $mobile1, $mobile2, $mobile3]);
        $validation->add_field('tel2', \Fuel\Core\Lang::get('tel2'), 'valid_string[numeric]|max_length[4]')
            ->add_rule('required_fax', [$tel1, $tel3])
            ->add_rule('data_other', [$tel1, $tel3, $mobile1, $mobile2, $mobile3]);
        $validation->add_field('tel3', \Fuel\Core\Lang::get('tel3'), 'valid_string[numeric]|max_length[4]')
            ->add_rule('required_fax', [$tel1, $tel2])
            ->add_rule('data_other', [$tel1, $tel2, $mobile1, $mobile2, $mobile3]);

        $validation->add_field('mobile1', \Fuel\Core\Lang::get('mobile1'), 'valid_string[numeric]|max_length[5]')
            ->add_rule('required_fax', [$mobile2, $mobile3])
            ->add_rule('data_other', [$tel1, $tel2, $tel3, $mobile2, $mobile3]);

        $validation->add_field('mobile2', \Fuel\Core\Lang::get('mobile2'), 'valid_string[numeric]|max_length[4]')
            ->add_rule('required_fax', [$mobile1, $mobile3])
            ->add_rule('data_other', [$tel1, $tel2, $tel3, $mobile1, $mobile3]);

        $validation->add_field('mobile3', \Fuel\Core\Lang::get('mobile3'), 'valid_string[numeric]|max_length[4]')
            ->add_rule('required_fax', [$mobile1, $mobile2])
            ->add_rule('data_other', [$tel1, $tel2, $tel3, $mobile1, $mobile2]);

        $validation->add_field('mail_addr1', \Fuel\Core\Lang::get('mail_addr1'), 'valid_email|max_length[255]')
            ->add_rule('data_other', [\Fuel\Core\Input::post('mail_addr2')]);
        $validation->add_field('mail_addr2', \Fuel\Core\Lang::get('mail_addr2'), 'valid_email|max_length[255]')
            ->add_rule('data_other', [\Fuel\Core\Input::post('mail_addr1')]);

        $validation->add_field('occupation_now', \Fuel\Core\Lang::get('occupation_now'), 'required');

        return !$validation->run() ? $validation->error_message() : true;
    }

    /**
     * author HuyLv6635
     * Condition get data
     * @param $filters
     * @return $this
     */
    private function get_where($filters)
    {
        $query = \Fuel\Core\DB::select(
            'sale_person.*',
            'sale_job.job_name',
            'sale_job.job_id',
            'sale_shop.shop_id',
            'sale_shop.shop_name',
            'sale_customer.customer_id',
            'sale_customer.company_name'
        )->from(self::$_table_name);
        $query->join('sale_job', 'LEFT')->on('sale_person.job_id', '=', 'sale_job.job_id');
        $query->join('sale_shop', 'LEFT')->on('sale_shop.shop_id', '=', 'sale_job.shop_id');
        $query->join('sale_customer', 'LEFT')->on('sale_customer.customer_id', '=', 'sale_shop.customer_id');

        if (isset($filters['customer_id']) && $filters['customer_id']) {
            $query->where('sale_customer.customer_id', '=', $filters['customer_id']);
        }
        if (isset($filters['person_id']) && $filters['person_id']) {
            $query->where('sale_person.person_id', '=', $filters['person_id']);
        }
        if (isset($filters['is_read'])) {
            $query->where('sale_person.is_read', '=', $filters['is_read']);
        }
        if (isset($filters['keyword']) && $filters['keyword']) {
            $arr_keyword = array_filter(preg_split('/\s|\s+|　/', trim($filters['keyword'])));
            $query->and_where_open();
            foreach ($arr_keyword as $k => $v) {
                $query->where(
                    \Fuel\Core\DB::expr('CONCAT(
                    sale_person.person_name,
                    sale_person.person_kana,
                    sale_person.mail_addr1,
                    IF(sale_person.mail_addr2 IS NULL, "", sale_person.mail_addr2),
                    IF(sale_person.tel IS NULL, "",REPLACE(sale_person.tel, "-", "")),
                    IF(sale_person.mobile IS NULL, "",REPLACE(sale_person.mobile, "-", "")))'),
                    'LIKE', '%' . $v . '%'
                );
            }
            $query->and_where_close();
        }
        if (isset($filters['limit']) && $filters['limit']) {
            $query->limit($filters['limit']);
        }
        if (isset($filters['offset']) && $filters['offset']) {
            $query->offset($filters['offset']);
        }
        $query->order_by(self::$_primary_key, 'desc');

        return $query;
    }

    /**
     * author HuyLV6635
     * Set data before save
     * @param array $data
     */
    public function set_data($data = array())
    {
        $fields = array();
        $data['birthday'] = $data['year'] . '-' . $data['month'] . '-' . $data['day'];
        $data['zipcode'] = $data['zipcode1'] . $data['zipcode2'];
        if (isset($data['tel1']) && $data['tel1'] != '') {
            $data['tel'] = $data['tel1'] . '-' . $data['tel2'] . '-' . $data['tel3'];
        }
        if (isset($data['mobile1']) && $data['mobile1'] != '') {
            $data['mobile'] = $data['mobile1'] . '-' . $data['mobile2'] . '-' . $data['mobile3'];
        }
        $data['mail_addr1'] = strtolower($data['mail_addr1']);
        $data['mail_addr2'] = strtolower($data['mail_addr2']);
        $data['plan_code'] = 'employment';

        foreach ($data as $k => $v) {
            if (in_array($k, self::$_properties)) {
                $fields[$k] = trim($v) != '' ? trim($v) : null;
            }
        }

        $this->fields = $fields;
    }

    /**
     * Get data
     * @param array $filters
     * @return mixed
     */
    public function get_data($filters = [])
    {
        $query = $this->get_where($filters);
        return $query->execute()->as_array();
    }

    /**
     * @param $data
     * @param int $id
     * @return bool
     */
    public function save_data($data, $id = 0)
    {
        if ($id == 0) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['application_time'] = date('Y-m-d H:i:s');
            $obj = static::forge();
            $obj->set($data);
            $res = $obj->save();
            return $res['0'];
        }
        $obj = static::forge()->find_by_pk($id);
        if (count($obj)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $obj->set($data);
            $obj->is_new(false);
            return $obj->save();
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete_data($id)
    {
        $obj = static::forge()->find_by_pk($id);
        if (count($obj)) {
            return $obj->delete();
        }

        return false;
    }

    /**
     * @param $id
     * @return array
     */
    public function get_info_data(&$id)
    {
        $obj = static::forge()->find_by_pk($id);
        if ($obj !== null) {
            $id = $obj->_data['person_id'];
            return $obj->_data;
        }
        $id = 0;
        return array_fill_keys(self::$_properties, null);
    }

    /**
     * author HuyLV6635
     * @param array $filters
     * @return int
     */
    public function count_data($filters = array())
    {
        $query = $this->get_where($filters);
        return count($query->execute());
    }

    /**
     * author HuyLV6635
     * action Save data person and Send mail
     * @param $data
     * @return bool
     */
    public function save_data_send_email($data)
    {
        try {
            \Fuel\Core\DB::start_transaction();

            // Save person
            if (!$person_id = $this->save_data($data)) {
                return false;
            }

            // Data constant
            $str_time = time();
            $now = date('Y-m-d H:i:s', $str_time);
            $mail_from = \Fuel\Core\Config::get('mail_from') . ',' . \Fuel\Core\Config::get('mail_from_name');

            // Set data customer (Send mail to Customer)
            $job = new Model_Salejob();
            $data_job= $job->get_data(['job_id' => $data['job_id']])[0];
            $shop = Model_Saleshop::find_by_pk($data_job['shop_id']);
            $customer = Model_Salecustomer::find_by_pk($shop->customer_id);

            // Set data person (Send mail to Person)
            $data_person = [
                'send_time'  => $now,
                'mail_to'    => implode(',', [$data['mail_addr1'], $data['mail_addr2']]),
                'mail_from'  => $mail_from,
                'subject'    => '応募完了のお知らせ',
                'body'       => \Fuel\Core\View::forge('email/customer_job_entry', [
                    'time' => $str_time,
                    'job_id' => $data['job_id'],
                    'person_name'  => $data['person_name'],
                    'company_name'  => $data_job['company_name'],
                    'shop_name'     => $data_job['shop_name'],
                    'job_name'      => $data_job['job_name'],
                    'address'       => Constants::$addr1[$shop->prefecture_id] . $shop->city . $shop->town,
                    'tel'           => $customer->tel,
                    'baseUrl'       => \Fuel\Core\Uri::base(),
                ]),
                'created_at' => $now,
                'updated_at' => $now
            ];

            $data_email = [
                    'company_name' => $data_job['company_name'],
                    'shop_name'     => $data_job['shop_name'],
                    'job_name'      => $data_job['job_name'],
                    'person_name'   => $data['person_name'],
                    'person_id'     => $person_id,
                    'baseUrl'           => \Fuel\Core\Uri::base()
            ];

            $data_customer = [
                'send_time'  => $now,
                'mail_to'    => $data_job['email'],
                'mail_from'  => $mail_from,
                'subject'    => \Constants::$subject_mail_to_admin_form,
                'body'       => render('email/customer.php', $data_email),
                'created_at' => $now,
                'updated_at' => $now
            ];

            $queue_obj = new \Model_Mailqueue();
            if ($queue_obj->save_data_after_confirm_person($data_person, $data_customer)) {
                \Fuel\Core\DB::commit_transaction();
                return true;
            }

            \Fuel\Core\DB::rollback_transaction();
            return false;
        } catch (Exception $e) {
            \Fuel\Core\Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * author HuyLv6635
     * action Update is_read when open edit person
     * @param $id
     * @param $is_read
     * @return bool
     */
    static function update_isread($id, $is_read)
    {
        if ($obj = Model_Saleperson::find_by_pk($id)) {
            $obj->is_new(false);
            $data = [
                'is_read' => $is_read,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $obj->set($data);
            return $obj->save();
        }
        return false;
    }
}
