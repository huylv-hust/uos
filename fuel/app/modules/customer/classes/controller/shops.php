<?php
/**
 * NamDD6566
 */
namespace Customer;

use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

class Controller_Shops extends \Controller_CustomerBase
{

    public function __construct()
    {
        $this->template = View::forge('customer');
        $this->template->title = '店舗 | しごさが';
        $this->template->head = View::forge('customer/head');
        $this->template->footer = View::forge('customer/footer');
    }

    /**
     * List shop
     */
    public function action_index()
    {
        $login_info = Session::get('login_info');
        if (!$login_info) {
            return Response::redirect(Uri::base() . 'customer');
        }

        $filters = Input::get();
        $sales_shop = new \Model_Saleshop();
        $query_string = empty($filters) ? '' : '?' . http_build_query($filters);
        $filters['customer_id'] = $login_info['customer_id'];
        unset($filters['limit']);
        $data['count'] = $sales_shop->count_data($filters);
        $pagination = \Uospagination::forge('pagination', array(
            'pagination_url' => Uri::base() . 'customer/shops' . $query_string,
            'total_items' => $data['count'],
            'per_page' => Input::get('limit', \Constants::$default_limit_pagination),
            'num_links' => \Constants::$default_num_links,
            'uri_segment' => 'page',
        ));

        $filters['offset'] = $pagination->offset;
        $filters['limit'] = $pagination->per_page;
        $data['list'] = $sales_shop->get_data($filters);
        $data['filters'] = $filters;
        $data['pagination'] = $pagination;
        $this->template->content = View::forge('shop/list', $data);
    }

    /**
     * delete shop
     * @return \Response
     */
    public function action_delete()
    {
        $login_info = Session::get('login_info');
        $sales_shop = new \Model_Saleshop();
        $shop_id = Input::post('shop_id', 0);
        $row_shop = $sales_shop->get_info_data($shop_id);
        if ($row_shop['shop_id'] && $row_shop['customer_id'] == $login_info['customer_id']) {
            if (\Model_Salejob::find_by_shop_id($row_shop['shop_id']) == null) {
                $sales_shop->delete_data($row_shop['shop_id']);
                \Fuel\Core\Session::set_flash('report', \Constants::$message_delete_success);
                return new \Response(1, 200, array());
            } else {
                \Fuel\Core\Session::set_flash('report', '該当する求人情報が登録されているため削除できません');
                return new \Response(0, 200, array());
            }
        } else {
            \Fuel\Core\Session::set_flash('report', \Constants::$message_delete_error);
            return new \Response(0, 200, array());
        }

    }
}
