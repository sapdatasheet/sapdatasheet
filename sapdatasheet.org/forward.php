<?php
/*
 * This site address is http://sapdatasheet.org
 * We need to redirect all traffic to http://www.sapdatasheet.org
 */

$http_host = $_SERVER[HTTP_HOST];
if (strlen(trim($http_host)) <= 0) {
    echo 'Bad Request: there is no Host field in the header';
    exit();
}

if (strtolower($http_host) === 'sapdatasheet.org') {
    $new_url = 'http://www.sapdatasheet.org' . $_SERVER[REQUEST_URI];

    //  Redirect
    header("HTTP/1.1 301 Moved Permanently");
    header('Location: ' . $new_url);
    exit();
} else {
    echo '<h1>DNS Error</h1>';    
    echo '</p>There is an DNS error, you can click the following link to access the page you want:</p>';
    $new_url = 'http://166.63.124.31' . $_SERVER[REQUEST_URI];

    echo '<a href="' . $new_url . '">' . $new_url .'</a>';
}



