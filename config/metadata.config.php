<?php
return array(
    'name'    => 'JayPS Search Test',
    'version' => '0.1',
    'provider' => array(
        'name' => 'JayPS',
    ),
    'namespace' => 'JayPS\Search\Test',
    'launchers' => array(
    ),
    'enhancers' => array(
        'jayps_search_test' => array(
            'title' => 'JayPS Search Test',
            'desc'  => 'A small enhancer to test the application jayps_search',
            'iconUrl' => 'static/apps/jayps_search_test/img/16/jayps.png',
            'urlEnhancer' => 'jayps_search_test/front/test',
            'previewUrl' => 'admin/jayps_search_test/application/preview',
        ),
    ),
    'templates' => array(
    ),
);
