<?php

require_once 'global.php';

class ABAP_Navigation {

    public static function GetURLAppComp($appcompID, $appcomp, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::BMFR_NAME, $appcompID, $appcomp, $desc);
    }

    public static function GetURLDomain($domain, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DOMA_NAME, $domain, $domain, $desc);
    }

    public static function GetURLDomainValue($domain, $domainValue, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DOMA_NAME, $domain, $domainValue, $desc);
    }

    public static function GetURLSoftComp($compName, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::CVERS_NAME, $compName, $compName, $desc);
    }

    private static function GetURL($objtype, $objname, $value, $title) {
        $objtype = strtolower($objtype);
        $result = "";
        if (!empty($objname)) {
            $sTitle = (empty($title)) ? $value : $title;
            $result = "<a href=\"/abap/" . $objtype . "/" . $objtype . ".php?id=" . $objname . "\" title=\"" . $sTitle . "\"> " . $value . " </a>";
        }
        return $result;
    }

}

class ABAP_Redirect {

    public static function Redirect404() {
        header(HTTP_STATUS::STATUS_404);
        header("Location: /abap/page404.php");
    }

}


