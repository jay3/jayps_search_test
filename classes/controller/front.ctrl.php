<?php

namespace JayPS\Search\Test;

use Nos\Controller_Front_Application;

class Controller_Front extends Controller_Front_Application
{
    public function action_test($args = array())
    {
        $keywords =  !empty($_GET['q']) ? $_GET['q'] : 'monkey chimpa*';

        echo \View::forge('front/form', array(
            'q' => $keywords,
        ));

        $pages = \Nos\Model_Page::find('all', array(
            'where' => array(
                array('keywords', $keywords),
            ),
            'rows_limit' => 50,
        ));
        echo \View::forge('front/results', array(
            'title'        => '\Nos\Model_Page::find()',
            'items'        => $pages,
            'field_name'   => 'page_title',
            'field_url'    => 'page_virtual_url',
         ));

        $monkeys = \Nos\Monkey\Model_Monkey::find('all', array(
            'where' => array(
                array('keywords', $keywords),
            ),
            'rows_limit' => 10,
            'order_by' => array('monk_name' => 'asc')
        ));
        echo \View::forge('front/results', array(
            'title'        => '\Nos\Monkey\Model_Monkey::find()',
            'items'        => $monkeys,
            'field_name'   => 'monk_name',
            'url_enhancer' => true,
        ));
    }
}
