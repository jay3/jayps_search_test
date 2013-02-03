<?php

namespace JayPS\Search\Test;

use Nos\Controller_Front_Application;

class Controller_Front extends Controller_Front_Application
{
    public function action_test($args = array())
    {
        $q =  !empty($_GET['q']) ? $_GET['q'] : 'monkey chimpa*';

        echo \View::forge('front/form', array(
            'q' => $q,
        ));

        \Config::load('jayps_search::config', 'config');
        $config = \Config::get('config');

        $keywords = \JayPS\Search\Search::generate_keywords($q, array(
            'min_word_len' => $config['min_word_len'],
            'max_keywords' => $config['max_join'],
        ));
        d($keywords);

        \JayPS\Search\Orm_Behaviour_Searchable::init_relations();

        // note: we could add relations to a specific model
        // but for every model used before the controller (ex: noviusos_page::model/page in the template),
        // init_relations() should be call in 'front.start'
        //\JayPS\Search\Orm_Behaviour_Searchable::init_relations('noviusos_monkey::model/monkey');

        $pages = \Nos\Page\Model_Page::find('all', array(
            'where' => array(
                array('keywords', $q),
            ),
            'rows_limit' => 10,
            'order_by' => array('jayps_search_score', 'page_title'),
        ));
        echo \View::forge('front/results', array(
            'title'        => '\Nos\Page\Model_Page::find()',
            'items'        => $pages,
            'field_name'   => 'page_title',
            'field_url'    => 'page_virtual_url',
         ));

        $monkeys = \Nos\Monkey\Model_Monkey::find('all', array(
            'where' => array(
                array('keywords', $q),
            ),
            'rows_limit' => 10,
            /*'order_by' => array(
                array('jayps_search_score'),
                array('monk_name', 'asc')
            ),*/
            'order_by' => array('jayps_search_score', 'monk_name'),
        ));
        echo \View::forge('front/results', array(
            'title'        => '\Nos\Monkey\Model_Monkey::find()',
            'items'        => $monkeys,
            'field_name'   => 'monk_name',
            'url_enhancer' => true,
        ));
    }
}
