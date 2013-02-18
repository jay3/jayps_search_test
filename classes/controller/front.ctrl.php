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

        $config = \Config::load('jayps_search::config', true);

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
                'page_published' => 1,
                'page_context'   => \Nos\Nos::main_controller()->getPage()->page_context,
            ),
            'rows_limit' => 10,
            'order_by' => array('jayps_search_score', 'page_title'),
        ));

        $news = \Nos\BlogNews\News\Model_Post::find('all', array(
            'where' => array(
                array('keywords', $keywords),
                'post_published' => 1,
                'post_context'   => \Nos\Nos::main_controller()->getPage()->page_context,
            ),
            'rows_limit' => 10,
            'order_by'   => array('jayps_search_score', 'post_title'),
        ));

        $monkeys = \Nos\Monkey\Model_Monkey::find('all', array(
            'where' => array(
                array('keywords', $q),
                'monk_published' => 1,
                'monk_context'   => \Nos\Nos::main_controller()->getPage()->page_context,
            ),
            'rows_limit' => 10,
            'order_by' => array('jayps_search_score', 'monk_name'),
        ));

        return \View::forge('front/main', array(
            'pages'     	=> $pages,
            'news'   		=> $news,
            'monkeys'       => $monkeys,
        ), false);
    }
}
