<?php
namespace Customer;

use Fuel\Core\Controller;
use Fuel\Core\Response;

class Controller_Guide extends Controller
{

    public function action_index()
    {
        return new Response(
            \Model_Cache::getBin('sales-guide'),
            200,
            ['Content-Type' => 'application/pdf']
        );
    }

}
