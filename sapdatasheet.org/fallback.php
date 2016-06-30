<?php

$fb_requri = html_entity_decode(strtolower($_SERVER['REQUEST_URI']));

// - Hacker URL
if ($fb_requri === '/wp/wp-admin/'
 || $fb_requri === '/wp-admin/'
 || $fb_requri === '/test/wp-admin/'
 || $fb_requri === '/blog/wp-admin/') {

    $uri = 'https://www.sapdatasheet.org/';
} else {

// - Normal URL
    $uri = 'https://www.sapdatasheet.org' . $fb_requri;
}

header('HTTP/1.1 301 Moved Permanently');
header('Location: ' . $uri);
