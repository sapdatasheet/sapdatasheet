<?php

//
// This is the dispatcher for those URIs does not match any real file
// This is the so called 'Front Controller pattern'.
//
// See the following web page for details:
//   http://en.wikipedia.org/wiki/Front_Controller_pattern
//
// Related links
//   http://php.net/manual/en/function.preg-match.php
//   http://stackoverflow.com/questions/16388959/url-rewriting-with-php
//
// ABAP URI analysis example
//   http://localhost/abap/bmfr/
//   http://localhost/abap/bmfr/index-top.html
//   http://localhost/abap/bmfr/index.php?index=top
//   http://localhost/abap/bmfr/index-a.html
//   http://localhost/abap/doma/index-a-3.html
//   http://localhost/abap/bmfr/index.php?index=a
//   http://localhost/abap/bmfr/HLB0009009.html
//   http://localhost/abap/bmfr/bmfr.php?id=HLB0009009

$__WS_ROOT__ = dirname(__FILE__, 2);
require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');


$requri = html_entity_decode(strtolower($_SERVER['REQUEST_URI']));
unset($target);

$abap_uris = array(
    array("clas", '/abap/clas/index.html', '/abap/clas/index-', '/abap/clas/'),
    array("cus0", '/abap/cus0/index.html', '/abap/cus0/index-', '/abap/cus0/'),
    array("cvers", '/abap/cvers/index.html', '/abap/cvers/index-', '/abap/cvers/'),
    array("bmfr", '/abap/bmfr/index.html', '/abap/bmfr/index-', '/abap/bmfr/'),
    array("devc", '/abap/devc/index.html', '/abap/devc/index-', '/abap/devc/'),
    array("doma", '/abap/doma/index.html', '/abap/doma/index-', '/abap/doma/'),
    array("dtel", '/abap/dtel/index.html', '/abap/dtel/index-', '/abap/dtel/'),
    array("fugr", '/abap/fugr/index.html', '/abap/fugr/index-', '/abap/fugr/'),
    array("func", '/abap/func/index.html', '/abap/func/index-', '/abap/func/'),
    array("intf", '/abap/intf/index.html', '/abap/intf/index-', '/abap/intf/'),
    array("prog", '/abap/prog/index.html', '/abap/prog/index-', '/abap/prog/'),
    array("shlp", '/abap/shlp/index.html', '/abap/shlp/index-', '/abap/shlp/'),
    array("sqlt", '/abap/sqlt/index.html', '/abap/sqlt/index-', '/abap/sqlt/'),
    array("tran", '/abap/tran/index.html', '/abap/tran/index-', '/abap/tran/'),
    array("view", '/abap/view/index.html', '/abap/view/index-', '/abap/view/'),
);

// - Hacker URL
if ($requri === '/wp/wp-admin/' || $requri === '/wp-admin/' || $requri === '/test/wp-admin/' || $requri === '/blog/wp-admin/') {
    $target = $__WS_ROOT__ . '/common-php/library/page404.php';

// - Root path
} else if ($requri === '/') {
    $target = 'index.php';

// - ALL other URL
//   http://localhost/abap/
//   http://localhost/abap/cvers/
//   http://localhost/abap/prog/
} else if (GLOBAL_UTIL::StartsWith($requri, '/') && GLOBAL_UTIL::EndsWith($requri, '/')) {
    $target = substr($requri, 1) . 'index.php';

// - TABL - Tables (Transparent, Cluster, Pool)
//   http://localhost/abap/tabl/
//   http://localhost/abap/tabl/index-pool.html
//   http://localhost/abap/tabl/index.php?index=pool
//   http://localhost/abap/tabl/index-a.html
//   http://localhost/abap/tabl/index.php?index=a
//   http://localhost/abap/tabl/A002-TAXK1.html
//   http://localhost/abap/tabl/field.php?table=A002&field=TAXK1
//   http://localhost/abap/tabl/bkpf-0090.html
//   http://localhost/abap/tabl/field.php?table=BKPF&position=0090
//   http://localhost/abap/tabl/bkpf.html
//   http://localhost/abap/tabl/tabl.php?id=bkpf
} else if ($requri === '/abap/tabl/index.html') {
    $target = 'abap/tabl/index.php';
} else if (GLOBAL_UTIL::StartsWith($requri, '/abap/tabl/index-') && GLOBAL_UTIL::EndsWith($requri, '.html')) {
    $index_fname = substr($requri, 17, -5);

    // Copied from bellow - TODO Create a function/module for this
    $index_parts = explode('-', $index_fname);
    if (count($index_parts) == 2 && is_numeric($index_parts[1])) {
        $index = $index_parts[0];
        $index_page = $index_parts[1];
    } else {
        $index = $index_fname;
        $index_page = ABAP_DB_CONST::INDEX_PAGE_1;               // Default to page 1
    }

    $target = 'abap/tabl/index.php';
} else if (GLOBAL_UTIL::StartsWith($requri, '/abap/tabl/') && GLOBAL_UTIL::EndsWith($requri, '.html')) {
    $TablURI = substr($requri, 11, -5);
    if (strpos($TablURI, '-') !== false) {
        list($Table, $FldPos) = explode('-', $TablURI, 2);
        if (ctype_digit($FldPos) === true) {
            $Position = $FldPos;
        } else {
            $Field = $FldPos;
        }
        $target = 'abap/tabl/field.php';
    } else {
        $ObjID = $TablURI;
        $target = 'abap/tabl/tabl.php';
    }

// - MSAG - Messages (T100 Messages)
//   http://localhost/abap/msag/index.html
//   http://localhost/abap/msag/a3.html
//   http://localhost/abap/msag/a3-001.html
//   http://localhost/abap/msag/a3-012.html
} else if ($requri === '/abap/msag/index.html') {
    $target = 'abap/msag/index.php';
} else if (GLOBAL_UTIL::StartsWith($requri, '/abap/msag/index-') && GLOBAL_UTIL::EndsWith($requri, '.html')) {
    $index_fname = substr($requri, 17, -5);

    // Copied from bellow - TODO merge the logic for msag/tabl to the central table
    $index_parts = explode('-', $index_fname);
    if (count($index_parts) == 2 && is_numeric($index_parts[1])) {
        $index = $index_parts[0];
        $index_page = $index_parts[1];
    } else {
        $index = $index_fname;
        $index_page = ABAP_DB_CONST::INDEX_PAGE_1;               // Default to page 1
    }
    
    $target = 'abap/msag/index.php';
} else if (GLOBAL_UTIL::StartsWith($requri, '/abap/msag/') && GLOBAL_UTIL::EndsWith($requri, '.html')) {
    $MsagURI = substr($requri, 11, -5);
    if (GLOBAL_UTIL::EndsWith($MsagURI, '-')) {
        // In case the message class name ends with '-'. Example: 'C-'
        $ObjID = $MsagURI;
        $target = 'abap/msag/msag.php';
    } else if (strpos($MsagURI, '-') !== false) {
        // We cannot use explode(), becaus we have the case: 'C--041', where 'C-' is the message class
        //list($ObjID, $MsgNr) = explode('-', $MsagURI, 2);
        $lastpos_msgnr = strrpos($MsagURI, '-');
        $ObjID = substr($MsagURI, 0, $lastpos_msgnr);
        $MsgNr = substr($MsagURI, $lastpos_msgnr + 1);
        $target = 'abap/msag/msgnr.php';
    } else {
        $ObjID = $MsagURI;
        $target = 'abap/msag/msag.php';
    }
} else if (GLOBAL_UTIL::StartsWith($requri, '/abap/')) {
    foreach ($abap_uris as $abap_uri) {
        if ($requri === $abap_uri[1]) {
            $target = 'abap/' . $abap_uri[0] . '/index.php';
            break;
        } else if (GLOBAL_UTIL::StartsWith($requri, $abap_uri[2]) && GLOBAL_UTIL::EndsWith($requri, '.html')) {
            $index_fname = substr($requri, strlen($abap_uri[2]), -5);

            $index_parts = explode('-', $index_fname);
            if (count($index_parts) == 2 && is_numeric($index_parts[1])) {
                $index = $index_parts[0];
                $index_page = $index_parts[1];
            } else {
                $index = $index_fname;
                $index_page = ABAP_DB_CONST::INDEX_PAGE_1;               // Default to page 1
            }

            $target = 'abap/' . $abap_uri[0] . '/index.php';
            break;
        } else if (GLOBAL_UTIL::StartsWith($requri, $abap_uri[3]) && GLOBAL_UTIL::EndsWith($requri, '.html')) {
            $ObjID = substr($requri, strlen($abap_uri[3]), -5);
            $target = 'abap/' . $abap_uri[0] . '/' . $abap_uri[0] . '.php';
            break;
        }
    }
} else if ($requri === '/wul/abap/') {
    $index = 1;
    $target = 'wul/abap/index.php';
} else if (GLOBAL_UTIL::StartsWith($requri, '/wul/abap/index-') && GLOBAL_UTIL::EndsWith($requri, '.html')) {
    $index = substr($requri, 16, -5);
    $target = 'wul/abap/index.php';
} else if (GLOBAL_UTIL::StartsWith($requri, '/wul/abap/') && GLOBAL_UTIL::EndsWith($requri, '.html')) {
//                                           1234567890                                      12345
//
//  - Example URI
//    /wul/abap/
//    /wul/abap/doma/mandt/dtel.html
//    /wul/abap/prog/FGRWEF40_SET_RRD-MAX_DSUM/prog.html
//    /wul/abap/prog/FGRWEF40_SET_RRD-MAX_DSUM/prog-3.html
//    /wul/abap/clas//1BCWDY/H1UU15C38KAMHG7PW3WH/clas.html
//    /wul/abap/clas//1BCWDY/H1UU15C38KAMHG7PW3WH/clas-1.html
//    /wul/abap/clas//1BCWDY/H1UU15C38KAMHG7PW3WH/clas-3.html
//    /wul/abap/dtel/mandt/prog.html
//    /wul/abap/dtf//ain/structure-field/prog.html
//    /wul/abap/nn/s01-001/prog.html
//    /wul/abap/tran/MC=1/prog.html
//    /wul/abap/tran/MC=1/prog-11.html
//             |                 |
//              12345    12345
//              dpSrcOType     dpPage
//                   dpSrcOName
//                        dpOType
//
    // Remvoe the left part '/wul/abap/' (length = 10)
    // Remove right part '.html' (length = 5)
    $restUri = substr($requri, 10);
    $restUri = strtoupper(substr($restUri, 0, strlen($restUri) - 5));

    // The Rest URI at least have 10 charactors
    //    tran/MC=1/prog-11
    //    12345    67890
    if (strlen($restUri) > 10) {

        $items = explode('/', $restUri);
        $itemsCount = count($items);

        // There should at lest 3 items
        if ($itemsCount >= 3) {
            $dpSrcOType = array_shift($items);
            $itemLast = array_pop($items);
            $itemLastLen = strlen($itemLast);

            // Only left the middle part of the URI
            $dpMiddle = substr($restUri, strlen($dpSrcOType) + 1);
            $dpMiddle = substr($dpMiddle, 0, strlen($dpMiddle) - $itemLastLen - 1);
            $middleLastPos = strrpos($dpMiddle, '-');
            if ($middleLastPos === FALSE) {
                $dpSrcOName = $dpMiddle;
                $dpSrcSubobj = '';
            } else {
                $dpSrcOName = substr($dpMiddle, 0, $middleLastPos);
                $dpSrcSubobj = substr($dpMiddle, $middleLastPos + 1);
            }

            $lastItems = explode('-', $itemLast);
            $lastItemsCount = count($lastItems);
            if ($lastItemsCount == 1) {
                $dpOType = $itemLast;
                $dpPage = 1;
            } else if ($lastItemsCount == 2) {
                $dpOType = $lastItems[0];
                $dpPage = $lastItems[1];
            }

            $target = 'wul/abap/wul.php';
        }

        /*
          echo '$dpSrcOType  = ' . $dpSrcOType . '<br />';
          echo '$dpMiddle    = ' . $dpMiddle . '<br />';
          echo '$dpSrcOName  = ' . $dpSrcOName . '<br />';
          echo '$dpSrcSubobj = ' . $dpSrcSubobj . '<br />';
          echo '$dpOType     = ' . $dpOType . '<br />';
          echo '$dpPage      = ' . $dpPage . '<br />';
          echo '$target      = ' . $target . '<br />';
          // exit();
         */
    }
} else if ($requri === '/wil/abap/') {
    $index = 1;
    $target = 'wil/abap/index.php';
} else if (GLOBAL_UTIL::StartsWith($requri, '/wil/abap/index-') && GLOBAL_UTIL::EndsWith($requri, '.html')) {
    $index = substr($requri, 16, -5);
    $target = 'wil/abap/index.php';
} else if (GLOBAL_UTIL::StartsWith($requri, '/wil/abap/') && GLOBAL_UTIL::EndsWith($requri, '.html')) {
//                                           1234567890                                      12345
//
//  - Example URI
//    /wil/abap/
//    /wil/abap/dtel/mandt/doma.html
//    /wil/abap/prog/FGRWEF40_SET_RRD-MAX_DSUM/prog.html
//    /wil/abap/prog/FGRWEF40_SET_RRD-MAX_DSUM/prog-3.html
//    /wil/abap/clas//1BCWDY/H1UU15C38KAMHG7PW3WH/clas.html
//    /wil/abap/clas//1BCWDY/H1UU15C38KAMHG7PW3WH/clas-1.html
//    /wil/abap/clas//1BCWDY/H1UU15C38KAMHG7PW3WH/clas-3.html
//    /wil/abap/prog/mandt/dtel.html
//    /wil/abap/prog//ain/structure-field/dtf.html
//    /wil/abap/tran/MC=1/prog.html
//    /wil/abap/tran/MC=1/prog-11.html
//             |                 |
//              12345    12345
//              dpSrcOType     dpPage
//                   dpSrcOName
//                        dpOType
//
    // Remvoe the left part '/wil/abap/' (length = 10)
    // Remove right part '.html' (length = 5)
    $restUri = substr($requri, 10);
    $restUri = strtoupper(substr($restUri, 0, strlen($restUri) - 5));

    // The Rest URI at least have 10 charactors
    //    tran/MC=1/prog-11
    //    12345    67890
    if (strlen($restUri) > 10) {

        $items = explode('/', $restUri);
        $itemsCount = count($items);

        // There should at lest 3 items
        if ($itemsCount >= 3) {
            $dpOType = array_shift($items);
            $itemLast = array_pop($items);
            $itemLastLen = strlen($itemLast);

            // Only left the middle part of the URI, as the object name
            $dpOName = substr($restUri, strlen($dpOType) + 1);
            $dpOName = substr($dpOName, 0, strlen($dpOName) - $itemLastLen - 1);

            $lastItems = explode('-', $itemLast);
            $lastItemsCount = count($lastItems);
            if ($lastItemsCount == 1) {
                $dpSrcOType = $itemLast;
                $dpPage = 1;
            } else if ($lastItemsCount == 2) {
                $dpSrcOType = $lastItems[0];
                $dpPage = $lastItems[1];
            }

            $target = 'wil/abap/wil.php';
        }

        /*
          echo '$dpOType    = ' . $dpOType . '<br />';
          echo '$dpOName    = ' . $dpOName . '<br />';
          echo '$dpSrcOType = ' . $dpSrcOType . '<br />';
          echo '$dpPage     = ' . $dpPage . '<br />';
          echo '$target     = ' . $target . '<br />';
          // exit();
         */
    }
}

// Decode object-id in case of spcial characters
if (empty($ObjID) === FALSE) {
    if (GLOBAL_UTIL::Contains($ObjID, '%')) {
        $ObjID = urldecode($ObjID);
    }
}

$target_valid = FALSE;
if (isset($target) && GLOBAL_UTIL::IsNotEmpty($target)) {
    // Avoid Hacking URI
    if ($target == 'index.php' || GLOBAL_UTIL::StartsWith($target, 'abap') || GLOBAL_UTIL::StartsWith($target, 'wil') || GLOBAL_UTIL::StartsWith($target, 'wul')) {
        $target_valid = TRUE;
    }
}
if ($target_valid == FALSE) {
    error_log('dispatcher: Attention!!! Invalid URI Found - ' . $requri);
    $target = $__WS_ROOT__ . '/common-php/library/page404.php';
}

// Logging for Security Audit
error_log('dispatcher: [' . $requri . '] --> [' . $target . ']');

//  Navigation
include $target;
exit();
