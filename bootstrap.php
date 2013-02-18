<?php

\Event::register_function('config|jayps_search::config', function(&$config) {
    //d('chargement de config|jayps_search::config');
    $config['observed_models']['noviusos_monkey::model/monkey'] = array(
        'primary_key' => 'monk_id',
        'config_behaviour' => array(
            'fields' => array('monk_name', 'monk_summary', 'wysiwyg_content'),
            //'debug' => true,
        ),
    );

    // if you want to observe pages, you need to either:
    // * add in you global boostrap \Module::load('jayps_search_test');
    // OR
    // * move this in your global bootstrap
    // this is necessary because pages are loaded in front before this application

    $config['observed_models']['noviusos_page::model/page'] = array(
        'primary_key' => 'page_id',
        'config_behaviour' => array(
            'fields' => array('page_title', 'wysiwyg_content', 'page_meta_title', 'page_meta_description', 'page_meta_keywords'),
            //'debug' => true,
        ),
    );

    $config['observed_models']['noviusos_news::model/post'] = array(
        'primary_key' => 'post_id',
        'config_behaviour' => array(
            'fields' => array('post_title', 'wysiwyg_content'),
        ),
    );

    //$config['min_word_len'] = 4;
    $config['debug'] = true;
});

\JayPS\Search\Orm_Behaviour_Searchable::init();
\Event::register_function('front.start', function() {
    // add models you want to use in your search and that are used in your template before your search enhancer
    // for example: noviusos_page::model/page

    //\JayPS\Search\Orm_Behaviour_Searchable::init_relations('noviusos_page::model/page');
    //\JayPS\Search\Orm_Behaviour_Searchable::init_relations('noviusos_news::model/post');

    \JayPS\Search\Orm_Behaviour_Searchable::init_relations();
});

function d($o, $line_number = 1) {
    if ($line_number > 0) {
        $trace = debug_backtrace();
    }
    print('<div style="border:1px solid #FF0000; background-color: #FFCCCC; width:95%; height: auto; overflow: auto">');
    $print_line_numbers = count($trace) > 1 && $line_number > 1;
    for($i = 0; $i < count($trace) && $i < $line_number; $i++) {
        print('<div style="color:#FF0000; font-weight:bold;">');
        if ($print_line_numbers) {
            print(($i+1).': ');
        }
        if (!empty($trace[$i]['file']) && !empty($trace[$i]['line'])) {
            print($trace[$i]['file'].':'.$trace[$i]['line']);
        } else {
            print($trace[$i]['class'].'::'.$trace[$i]['function']);
        }
        print('</div>');
    }
    print('<xmp>');
    print_r($o);
    print('</xmp>');
    print('</div>');
}

function show_last_query() {
    $sql = str_replace('`', '', \DB::last_query());
    $sql = preg_replace('/(FROM|LEFT|WHERE|GROUP|ORDER|LIMIT)/', "\n $1", $sql);
    //$sql = preg_replace('/([A-Z]+)/', "<b>$1</b>", $sql);
    d(($sql));
}
