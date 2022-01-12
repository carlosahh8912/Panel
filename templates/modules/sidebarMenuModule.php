<?php

$uri = explode('/',$_SERVER['HTTP_REFERER']);
$slug = $uri[3];
if($slug == ''){
    $slug = 'home';
}
echo create_menu($data, $slug);