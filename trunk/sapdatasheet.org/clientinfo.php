Client info <br>
<?php

print_r($_SERVER);

/* 
 * Show client headers.
 */

foreach (getallheaders() as $name => $value) {
    echo "$name: $value";
    echo '<br />';
}

echo '<br />';
echo $_SERVER['SERVER_ADDR'];
