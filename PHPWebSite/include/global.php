<?php

$GLOBALS['TITLE_TEXT'] = 'SAP';
error_reporting(-1);


/** Web Site Constants. */
class WEBSITE {

    const NAME = 'SAP Datasheet';
    const DESC = 'The Best Run SAP Run SAPDatasheet';
    const TITLE = ' - SAP Datasheet - The Best Run SAP Run SAPDatasheet';
    const META_DESC = 'Datasheet for all SAP objects: domain, data element, table, transaction code, etc';

}

/** ABAP Object types and description. */
class ABAP_OTYPE {

    const BMFR_NAME = 'BMFR';
    const BMFR_DESC = 'Application Component';
    const CVERS_NAME = 'CVERS';
    const CVERS_DESC = 'Software Component';
    const DEVC_NAME = 'DEVC';
    const DEVC_DESC = 'Package';
    const DOMA_NAME = 'DOMA';
    const DOMA_DESC = 'Domain';
    const DTEL_NAME = 'DTEL';
    const DTEL_DESC = 'Data Element';
    const FUNC_NAME = 'FUNC';
    const FUNC_DESC = 'Function Module';
    const FUGR_NAME = 'FUGR';
    const FUGR_DESC = 'Function Group';
    const PROG_NAME = 'PROG';
    const PROG_DESC = 'Program';
    const SQLT_NAME = 'SQLT';
    const SQLT_DESC = 'Cluster/Pool Table';
    const TABL_NAME = 'TABL';
    const TABL_DESC = 'Transparent Table';
    const TRAN_NAME = 'TRAN';
    const TRAN_DESC = 'Transaction Code';
    const VIEW_NAME = 'VIEW';
    const VIEW_DESC = 'View';

}

/**
 * HTTP Status Codes.
 * 
 * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html Status Code Definitions
 */
class HTTP_STATUS {

    const STATUS_100 = "HTTP/1.1 100 Continue";
    const STATUS_101 = "HTTP/1.1 101 Switching Protocols";
    const STATUS_200 = "HTTP/1.1 200 OK";
    const STATUS_201 = "HTTP/1.1 201 Created";
    const STATUS_202 = "HTTP/1.1 202 Accepted";
    const STATUS_203 = "HTTP/1.1 203 Non-Authoritative Information";
    const STATUS_204 = "HTTP/1.1 204 No Content";
    const STATUS_205 = "HTTP/1.1 205 Reset Content";
    const STATUS_206 = "HTTP/1.1 206 Partial Content";
    const STATUS_300 = "HTTP/1.1 300 Multiple Choices";
    const STATUS_301 = "HTTP/1.1 301 Moved Permanently";
    const STATUS_302 = "HTTP/1.1 302 Found";
    const STATUS_303 = "HTTP/1.1 303 See Other";
    const STATUS_304 = "HTTP/1.1 304 Not Modified";
    const STATUS_305 = "HTTP/1.1 305 Use Proxy";
    const STATUS_307 = "HTTP/1.1 307 Temporary Redirect";
    const STATUS_400 = "HTTP/1.1 400 Bad Request";
    const STATUS_401 = "HTTP/1.1 401 Unauthorized";
    const STATUS_402 = "HTTP/1.1 402 Payment Required";
    const STATUS_403 = "HTTP/1.1 403 Forbidden";
    const STATUS_404 = "HTTP/1.1 404 Not Found";
    const STATUS_405 = "HTTP/1.1 405 Method Not Allowed";
    const STATUS_406 = "HTTP/1.1 406 Not Acceptable";
    const STATUS_407 = "HTTP/1.1 407 Proxy Authentication Required";
    const STATUS_408 = "HTTP/1.1 408 Request Time-out";
    const STATUS_409 = "HTTP/1.1 409 Conflict";
    const STATUS_410 = "HTTP/1.1 410 Gone";
    const STATUS_411 = "HTTP/1.1 411 Length Required";
    const STATUS_412 = "HTTP/1.1 412 Precondition Failed";
    const STATUS_413 = "HTTP/1.1 413 Request Entity Too Large";
    const STATUS_414 = "HTTP/1.1 414 Request-URI Too Large";
    const STATUS_415 = "HTTP/1.1 415 Unsupported Media Type";
    const STATUS_416 = "HTTP/1.1 416 Requested range not satisfiable";
    const STATUS_417 = "HTTP/1.1 417 Expectation Failed";
    const STATUS_500 = "HTTP/1.1 500 Internal Server Error";
    const STATUS_501 = "HTTP/1.1 501 Not Implemented";
    const STATUS_502 = "HTTP/1.1 502 Bad Gateway";
    const STATUS_503 = "HTTP/1.1 503 Service Unavailable";
    const STATUS_504 = "HTTP/1.1 504 Gateway Time-out";

}
