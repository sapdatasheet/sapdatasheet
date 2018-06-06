<?php


class SITE_UI_TABLES {
    const HTTP_GET_TABLE = 'table';
    const HTTP_GET_FORMAT = 'format';
    
    const URI_PREFIX_TABLE = '/table/';
    const URI_SUFFIX_ERD_PDF = '/erd.pdf';
    const URI_SUFFIX_ERD_PNG = '/erd.png';
    const URI_SUFFIX_HTML = '.html';

    public static function uri_table_erd_pdf(string $table_name) : string{
        return self::URI_PREFIX_TABLE . strtolower($table_name) . self::URI_SUFFIX_ERD_PDF; 
    }

    public static function uri_table_erd_png(string $table_name) : string{
        return self::URI_PREFIX_TABLE . strtolower($table_name) . self::URI_SUFFIX_ERD_PNG; 
    }

    public static function url_table(string $table_name, bool $with_domain = FALSE) : string {
        $url = self::URI_PREFIX_TABLE . GLOBAL_UTIL::Clear4Url($table_name) . self::URI_SUFFIX_HTML;
        return ($with_domain) ? GLOBAL_WEBSITE::SAP_TABLES_ORG_URL . $url : $url;
    }
}