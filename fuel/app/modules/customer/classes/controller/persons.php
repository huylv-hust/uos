<?php
namespace Customer;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * author HuyLV6635
 * Class Controller_Persons
 * @package Customer
 */
class Controller_Persons extends \Controller_CustomerBase
{
    /**
     * list sale persons
     */
    public function action_index()
    {
        $login_info = Session::get('login_info');
        $filters = Input::get();
        $query_string = empty($filters) ? '' : '?' . http_build_query($filters);
        Session::set('persons_url', Uri::base() . 'customer/persons' . $query_string);
        $sale_person_obj = new \Model_Saleperson();
        $filters['customer_id'] = $login_info['customer_id'];
        unset($filters['limit']);
        $count_sale_person = $sale_person_obj->count_data($filters);
        $pagination = \Uospagination::forge('pagination', array(
            'pagination_url' => Session::get('persons_url'),
            'total_items' => $count_sale_person,
            'per_page' => Input::get('limit', \Constants::$default_limit_pagination),
            'num_links' => \Constants::$default_num_links,
            'uri_segment' => 'page',
        ));
        $filters['offset'] = $pagination->offset;
        $filters['limit'] = $pagination->per_page;
        $sale_persons = $sale_person_obj->get_data($filters);
        $this->template->title = '求人リスト | しごさが';
        $this->template->content = View::forge('person/list', compact('sale_persons', 'pagination', 'count_sale_person'));
    }

    public function action_change_result() {
        $url = Session::get('persons_url') ? Session::get('persons_url') : Uri::base() . 'customer/persons';
        if (Input::method() == 'POST') {
            $customer_id = Session::get('login_info')['customer_id'];
            $obj = new \Model_Saleperson();
            // customer_id and person_id
            $id = [
                'customer_id' => $customer_id,
                'person_id'   => Input::get('person_id')
            ];
            if ($obj->count_data($id) == 1) {
                // data update
                if (Input::get('type') == 'employment') {
                    $data = [
                        'result'      => \Constants::$result_person['employment'],
                        'hire_date'   => Input::post('working_days'),
                        'result_time' => date('Y-m-d H:i:s')
                    ];
                } elseif (Input::get('type') == 'reject') {
                    $data = [
                        'result'      => \Constants::$result_person['reject'],
                        'reject_reason'   => Input::post('reject_reason'),
                        'result_time' => date('Y-m-d H:i:s')
                    ];
                }
                // save data
                if (isset($data) && $obj->save_data($data, Input::get('person_id'))) {
                    Session::set_flash('success', '保存しました');
                    return Response::redirect($url);
                }
            }
            Session::set_flash('error', '失敗しました');
        }
        return Response::redirect($url);
    }

}
