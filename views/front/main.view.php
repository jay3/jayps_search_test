<?php

echo \View::forge('front/results', array(
    'title'      => '\Nos\Page\Model_Page::find()',
    'items'      => $pages,
    'field_name' => 'page_title',
    'field_url'  => 'page_virtual_url',
), false);

echo \View::forge('front/results', array(
    'title'        => '\Nos\BlogNews\News\Model_Post::find()',
    'items'        => $news,
    'field_name'   => 'post_title',
    'url_enhancer' => true,
), false);

echo \View::forge('front/results', array(
    'title'        => '\Nos\Monkey\Model_Monkey::find()',
    'items'        => $monkeys,
    'field_name'   => 'monk_name',
    'url_enhancer' => true,
), false);