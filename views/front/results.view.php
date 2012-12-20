<?php
if (!empty($title)) {
    print('<h3>'.$title.'</h3>');
}

show_last_query();

if (count($items)) {
    print('<ul>');
    foreach($items as $item) {
        print('<li>');
        if (!empty($url_enhancer) || !empty($field_url)) {
            $url = '';
            if (!empty($url_enhancer)) {
                $url = $item->url();
            }
            if (!empty($field_url)) {
                $url = $item->$field_url;
            }
            print('<a href="'.$url.'">');
        }
        print('id:'.$item->id . ': <strong>' . $item->$field_name . '</strong>');
        if (!empty($url_enhancer) || !empty($field_url)) {
            print('</a>');
        }
        print('</li>');
    }
    print('</ul>');

}
