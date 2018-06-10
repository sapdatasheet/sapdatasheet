<?php

$GLOBALS['TITLE_TEXT'] = 'SAP';
error_reporting(-1);

/** ABAP Object types and description. */
class GLOBAL_ABAP_ICON {

    const _METHOD_PREFIX_OTYPE = 'getIcon4Otype';

    /** All avialbe Icon OTypes   */
    public static $_METHOD_OTYPES = array(
        GLOBAL_ABAP_OTYPE::BMFR_NAME => GLOBAL_ABAP_OTYPE::BMFR_DESC,
        GLOBAL_ABAP_OTYPE::CLAS_NAME => GLOBAL_ABAP_OTYPE::CLAS_DESC,
        GLOBAL_ABAP_OTYPE::CUS0_NAME => GLOBAL_ABAP_OTYPE::CUS0_DESC,
        GLOBAL_ABAP_OTYPE::CVERS_NAME => GLOBAL_ABAP_OTYPE::CVERS_DESC,
        GLOBAL_ABAP_OTYPE::DEVC_NAME => GLOBAL_ABAP_OTYPE::DEVC_DESC,
        GLOBAL_ABAP_OTYPE::DOMA_NAME => GLOBAL_ABAP_OTYPE::DOMA_DESC,
        GLOBAL_ABAP_OTYPE::DTEL_NAME => GLOBAL_ABAP_OTYPE::DTEL_DESC,
        GLOBAL_ABAP_OTYPE::DTF_NAME => GLOBAL_ABAP_OTYPE::DTF_DESC,
        GLOBAL_ABAP_OTYPE::FUGR_NAME => GLOBAL_ABAP_OTYPE::FUGR_DESC,
        GLOBAL_ABAP_OTYPE::FUNC_NAME => GLOBAL_ABAP_OTYPE::FUNC_DESC,
        GLOBAL_ABAP_OTYPE::INTF_NAME => GLOBAL_ABAP_OTYPE::INTF_DESC,
        GLOBAL_ABAP_OTYPE::MENU_NAME => GLOBAL_ABAP_OTYPE::MENU_DESC,
        GLOBAL_ABAP_OTYPE::MSAG_NAME => GLOBAL_ABAP_OTYPE::MSAG_DESC,
        GLOBAL_ABAP_OTYPE::NN_NAME => GLOBAL_ABAP_OTYPE::NN_DESC,
        GLOBAL_ABAP_OTYPE::OM_NAME => GLOBAL_ABAP_OTYPE::OM_DESC,
        GLOBAL_ABAP_OTYPE::PFCG_NAME => GLOBAL_ABAP_OTYPE::PFCG_DESC,
        GLOBAL_ABAP_OTYPE::PROG_NAME => GLOBAL_ABAP_OTYPE::PROG_DESC,
        GLOBAL_ABAP_OTYPE::RZ10_NAME => GLOBAL_ABAP_OTYPE::RZ10_DESC,
        GLOBAL_ABAP_OTYPE::SEOC_NAME => GLOBAL_ABAP_OTYPE::SEOC_DESC,
        GLOBAL_ABAP_OTYPE::SHLP_NAME => GLOBAL_ABAP_OTYPE::SHLP_DESC,
        GLOBAL_ABAP_OTYPE::SQLT_NAME => GLOBAL_ABAP_OTYPE::SQLT_DESC,
        GLOBAL_ABAP_OTYPE::SU21_NAME => GLOBAL_ABAP_OTYPE::SU21_DESC,
        GLOBAL_ABAP_OTYPE::TABL_NAME => GLOBAL_ABAP_OTYPE::TABL_DESC,
        GLOBAL_ABAP_OTYPE::TRAN_NAME => GLOBAL_ABAP_OTYPE::TRAN_DESC,
        GLOBAL_ABAP_OTYPE::VIEW_NAME => GLOBAL_ABAP_OTYPE::VIEW_DESC,
    );

    const ABAP = 's_b_abap.gif';
    const ABAPLOCAL = 's_b_abal.gif';
    const ALERT = 's_b_alet.gif';
    const ANALYTICS = 's_b_area.gif';
    const CONNECT = 's_connec.gif';
    const DATE = 's_t_date.gif';
    const DESCRIPTION = 's_wdvlab.gif';
    const DISPLAY_MORE = 's_bgmore.gif';
    const DISPLAY_TEXT = 's_b_txdp.gif';
    const DISPLAY_TREE = 's_distre.gif';
    const FIELD = 's_simfld.gif';
    const FILE_PDF = 's_x__pdf.gif';
    const FILE_XLSX = 's_x__xlv.gif';
    const FOLDER = 's_folder.gif';
    const FOREIGN_KEY = 's_b_fkey.gif';
    const HEADER = 's_b_head.gif';
    const HISTORY = 's_b_rkhi.gif';
    const HOME = 's_b_life.gif';
    const IINCLUDE = 's_incobj.gif';
    const LIGHT_GREEN = 's_s_tl_g.gif';
    const LIGHT_RED = 's_s_tl_r.gif';
    const LIGHT_OUT = 's_outlig.gif';
    const LIGHT_YELLOW = 's_s_tl_y.gif';
    const MAINTENANCE_STATUS = 's_transl.gif';
    const NAMEPREFIX = 's_b_renm.gif';
    const OO_CLASS_ATTRIBUTE = 's_b_klat.gif';
    const OO_CLASS_FRIENDS = 's_manfem.gif';
    const OO_CLASS_EVENT = 's_b_clev.gif';
    const OO_CLASS_METHOD = 's_b_klme.gif';
    const OO_CONNECTION = 's_b_conn.gif';
    const OO_CONSTANT = 's_b_kons.gif';
    const OO_EVENT = 's_b_even.gif';
    const OO_INHERITANCE = 's_b_verb.gif';
    const ORDER = 's_b_pvre.gif';
    const OTYPE_BMFR = 's_b_tree.gif';
    const OTYPE_CLAS = 's_b_clas.gif';
    const OTYPE_CUS0 = 's_b_tsak.gif';
    const OTYPE_CVERS = 's_instal.gif'; // 's_wdcomp.gif';
    const OTYPE_DEVC = 's_pckstd.gif';
    const OTYPE_DOMA = 's_elemen.gif';
    const OTYPE_DTEL = 's_struct.gif';
    const OTYPE_DTF = 's_struct.gif';
    const OTYPE_FUGR = 's_b_objc.gif';
    const OTYPE_FUNC = 's_b_meth.gif';
    const OTYPE_INTF = 's_b_intf.gif';
    const OTYPE_MENU = 's_f_sapm.gif';
    const OTYPE_MSAG = 's_messag.gif';
    const OTYPE_NN = 's_x__msg.gif';
    const OTYPE_OM = 's_b_klme.gif';
    const OTYPE_PFCG = 's_actgro.gif';
    const OTYPE_PROG = 's_b_sumi.gif';
    const OTYPE_RZ10 = 's_perset.gif';
    const OTYPE_SEOC = 's_b_clas.gif';
    const OTYPE_SHLP = 's_f4help.gif';
    const OTYPE_SQLT = 's_bwdata.gif';
    const OTYPE_SU21 = 's_x_role.gif';
    const OTYPE_TABL = 's_b_tvar.gif';
    const OTYPE_TRAN = 's_b_exec.gif';
    const OTYPE_VIEW = 's_b_bwrv.gif';
    const PARAMETER = 's_x__eff.gif';
    const PARAMETER_CHANGING = 's_b_parc.gif';
    const PARAMETER_EXPORT = 's_b_pare.gif';
    const PARAMETER_IMPORT = 's_b_pari.gif';
    const PARAMETER_RESULT = 's_b_parr.gif';
    const PARAMETER_TABLE = 's_b_part.gif';
    const PROCESS_TYPE = 's_roreso.gif';
    const RELATION = 's_psrela.gif';
    const RFC = 's_clbltr.gif';
    const SAPGUI = 's_logsap.gif';
    const SYSTEM_HELP = 's_f_help.gif';
    const TIME = 's_t_time.gif';
    const WHERE_USED_LIST = 's_b_book.gif';
    const WHERE_USING_LIST = 's_assign.gif';
    const WORK_CENTER = 's_b_work.gif';

    public static function getIcon4Abap(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::ABAP, $fullUrl);
    }

    public static function getIcon4Abaplocal(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::ABAPLOCAL, $fullUrl);
    }

    public static function getIcon4Alert(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::ALERT, $fullUrl);
    }

    public static function getIcon4Analytics(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::ANALYTICS, $fullUrl);
    }

    public static function getIcon4Connect(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::CONNECT, $fullUrl);
    }

    public static function getIcon4Date(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::DATE, $fullUrl);
    }

    public static function getIcon4Description(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::DESCRIPTION, $fullUrl);
    }

    public static function getIcon4DisplayMore(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::DISPLAY_MORE, $fullUrl);
    }

    public static function getIcon4DisplayText(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::DISPLAY_TEXT, $fullUrl);
    }

    public static function getIcon4DisplayTree(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::DISPLAY_TREE, $fullUrl);
    }

    public static function getIcon4Field(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::FIELD, $fullUrl);
    }

    public static function getIcon4FilePDF(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::FILE_PDF, $fullUrl);
    }

    public static function getIcon4FileXLSX(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::FILE_XLSX, $fullUrl);
    }

    public static function getIcon4Folder(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::FOLDER, $fullUrl);
    }

    public static function getIcon4ForeignKey(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::FOREIGN_KEY, $fullUrl);
    }

    public static function getIcon4Header(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::HEADER, $fullUrl);
    }

    public static function getIcon4History(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::HISTORY, $fullUrl);
    }

    public static function getIcon4Home(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::HOME, $fullUrl);
    }

    public static function getIcon4Include(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::IINCLUDE, $fullUrl);
    }

    public static function getIcon4LightGreen(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::LIGHT_GREEN, $fullUrl);
    }

    public static function getIcon4LightOut(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::LIGHT_OUT, $fullUrl);
    }

    public static function getIcon4LightRed(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::LIGHT_RED, $fullUrl);
    }

    public static function getIcon4LightYellow(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::LIGHT_YELLOW, $fullUrl);
    }

    public static function getIcon4MaintenanceStatus(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::MAINTENANCE_STATUS, $fullUrl);
    }

    public static function getIcon4NamePrefix(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::NAMEPREFIX, $fullUrl);
    }

    public static function getIcon4OOClassAttribute(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OO_CLASS_ATTRIBUTE, $fullUrl);
    }

    public static function getIcon4OOClassEvent(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OO_CLASS_EVENT, $fullUrl);
    }

    public static function getIcon4OOClassFriend(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OO_CLASS_FRIENDS, $fullUrl);
    }

    public static function getIcon4OOClassMethod(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OO_CLASS_METHOD, $fullUrl);
    }

    public static function getIcon4OOConnection(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OO_CONNECTION, $fullUrl);
    }

    public static function getIcon4OOConstant(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OO_CONSTANT, $fullUrl);
    }

    public static function getIcon4OOEvent(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OO_EVENT, $fullUrl);
    }

    public static function getIcon4OOInheritance(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OO_INHERITANCE, $fullUrl);
    }

    public static function getIcon4Order(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::ORDER, $fullUrl);
    }

    public static function getIcon4Otype(string $otype, bool $fullUrl = FALSE): string {
        if (array_key_exists(strtoupper($otype), GLOBAL_ABAP_ICON::$_METHOD_OTYPES)) {
            $methodName = GLOBAL_ABAP_ICON::_METHOD_PREFIX_OTYPE . $otype;
            return GLOBAL_ABAP_ICON::$methodName($fullUrl);
        } else {
            return GLOBAL_ABAP_ICON::getIcon4Abap($fullUrl);
        }
    }

    public static function getIcon4OtypeBMFR(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_BMFR, $fullUrl);
    }

    public static function getIcon4OtypeCLAS(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_CLAS, $fullUrl);
    }

    public static function getIcon4OtypeCUS0(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_CUS0, $fullUrl);
    }

    public static function getIcon4OtypeCVERS(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_CVERS, $fullUrl);
    }

    public static function getIcon4OtypeDEVC(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_DEVC, $fullUrl);
    }

    public static function getIcon4OtypeDOMA(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_DOMA, $fullUrl);
    }

    public static function getIcon4OtypeDTEL(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_DTEL, $fullUrl);
    }

    public static function getIcon4OtypeDTF(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_DTF, $fullUrl);
    }

    public static function getIcon4OtypeFUGR(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_FUGR, $fullUrl);
    }

    public static function getIcon4OtypeFUNC(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_FUNC, $fullUrl);
    }

    public static function getIcon4OtypeINTF(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_INTF, $fullUrl);
    }

    public static function getIcon4OtypeMENU(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_MENU, $fullUrl);
    }

    public static function getIcon4OtypeMSAG(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_MSAG, $fullUrl);
    }

    public static function getIcon4OtypeNN(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_NN, $fullUrl);
    }

    public static function getIcon4OtypeOM(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_OM, $fullUrl);
    }

    public static function getIcon4OtypePFCG(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_PFCG, $fullUrl);
    }

    public static function getIcon4OtypePROG(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_PROG, $fullUrl);
    }

    public static function getIcon4OtypeRZ10(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_RZ10, $fullUrl);
    }

    public static function getIcon4OtypeSEOC(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_SEOC, $fullUrl);
    }

    public static function getIcon4OtypeSHLP(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_SHLP, $fullUrl);
    }

    public static function getIcon4OtypeSQLT(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_SQLT, $fullUrl);
    }

    public static function getIcon4OtypeSU21(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_SU21, $fullUrl);
    }

    public static function getIcon4OtypeTABL(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_TABL, $fullUrl);
    }

    public static function getIcon4OtypeTRAN(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_TRAN, $fullUrl);
    }

    public static function getIcon4OtypeVIEW(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::OTYPE_VIEW, $fullUrl);
    }

    public static function getIcon4Parameter(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::PARAMETER, $fullUrl);
    }

    public static function getIcon4ParameterChanging(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::PARAMETER_CHANGING, $fullUrl);
    }

    public static function getIcon4ParameterExport(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::PARAMETER_EXPORT, $fullUrl);
    }

    public static function getIcon4ParameterImport(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::PARAMETER_IMPORT, $fullUrl);
    }

    public static function getIcon4ParameterResult(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::PARAMETER_RESULT, $fullUrl);
    }

    public static function getIcon4ParameterTable(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::PARAMETER_TABLE, $fullUrl);
    }

    public static function getIcon4ProcessType(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::PROCESS_TYPE, $fullUrl);
    }

    public static function getIcon4Relation(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::RELATION, $fullUrl);
    }

    public static function getIcon4Rfc(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::RFC, $fullUrl);
    }

    public static function getIcon4Sapgui(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::SAPGUI, $fullUrl);
    }

    public static function getIcon4SystemHelp(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::SYSTEM_HELP, $fullUrl);
    }

    public static function getIcon4Time(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::TIME, $fullUrl);
    }

    public static function getIcon4WIL(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::WHERE_USING_LIST, $fullUrl);
    }

    public static function getIcon4WUL(bool $fullUrl = FALSE): string {
        return GLOBAL_ABAP_ICON::getIconLink(GLOBAL_ABAP_ICON::WHERE_USED_LIST, $fullUrl);
    }

    /**
     * Get Icon image link.
     * Examples:
     * <pre>
     *   <img src='/abap/icon/s_b_area.gif'>
     *   <img src='https://www.sapdatasheet.org/abap/icon/s_b_area.gif'>
     * </pre>
     */
    public static function getIconLink(string $fname, bool $fullUrl = FALSE): string {
        $location = GLOBAL_ABAP_ICON::getIconURL($fname, $fullUrl);
        return "<img src='" . $location . "'> "; // Note. the last space ' ' is on purpose, do not delete it
    }

    /**
     * Get Icon image URL.
     * Examples:
     * <pre>
     *   '/abap/icon/s_b_area.gif'
     *   'https://www.sapdatasheet.org/abap/icon/s_b_area.gif'
     * </pre>
     */
    public static function getIconURL(string $fname, bool $fullUrl = FALSE): string {
        $location = '/abap/icon/' . $fname;
        if ($fullUrl == TRUE) {
            $location = GLOBAL_WEBSITE::SAPDS_ORG_URL . $location;
        }
        return $location;
    }

}

/** ABAP Object types and description. */
class GLOBAL_ABAP_OTYPE {

    const BMFR_NAME = 'BMFR';
    const BMFR_DESC = 'Application Component';
    const CLAS_NAME = 'CLAS';
    const CLAS_DESC = 'Class';
    const CUS0_NAME = 'CUS0';
    const CUS0_DESC = 'IMG Activity';
    const CVERS_NAME = 'CVERS';
    const CVERS_DESC = 'Software Component';
    const DEVC_NAME = 'DEVC';
    const DEVC_DESC = 'Package';
    const DOMA_NAME = 'DOMA';
    const DOMA_DESC = 'Domain';
    const DTEL_NAME = 'DTEL';
    const DTEL_DESC = 'Data Element';
    const FUGR_NAME = 'FUGR';
    const FUGR_DESC = 'Function Group';
    const FUNC_NAME = 'FUNC';
    const FUNC_DESC = 'Function Module';
    const INTF_NAME = 'INTF';
    const INTF_DESC = 'Interface';
    const MENU_NAME = 'MENU';
    const MENU_DESC = 'SAP Menu';
    const MSAG_NAME = 'MSAG';
    const MSAG_DESC = 'Message Class';
    const PROG_NAME = 'PROG';
    const PROG_DESC = 'Program';
    const SEOC_NAME = 'SEOC';                     // Dummy Type for SEO Class/Interface
    const SEOC_DESC = 'Class or Interface';       // Dummy Type for SEO Class/Interface
    const SQLT_NAME = 'SQLT';
    const SQLT_DESC = 'Table Cluster/Pool';
    const TABL_NAME = 'TABL';
    const TABL_DESC = 'Table';
    const TRAN_NAME = 'TRAN';
    const TRAN_DESC = 'Transaction Code';
    const VIEW_NAME = 'VIEW';
    const VIEW_DESC = 'View';
    const SHLP_NAME = 'SHLP';
    const SHLP_DESC = 'Search Help';
    const SU21_NAME = 'SU21';
    const SU21_DESC = 'Authorization Object';
    const PFCG_NAME = 'PFCG';
    const PFCG_DESC = 'Role';
    const RZ10_NAME = 'RZ10';
    const RZ10_DESC = 'NetWeaver Profile';
    const DTF_NAME = 'DTF';
    const DTF_DESC = 'Table/Structure Field';
    const NN_NAME = 'NN';
    const NN_DESC = 'Message Number';
    const OM_NAME = 'OM';
    const OM_DESC = 'Class Method';

    /**
     * Supported base object type.
     */
    public static $OTYPES = array(
        GLOBAL_ABAP_OTYPE::BMFR_NAME => GLOBAL_ABAP_OTYPE::BMFR_DESC,
        GLOBAL_ABAP_OTYPE::CLAS_NAME => GLOBAL_ABAP_OTYPE::CLAS_DESC,
        GLOBAL_ABAP_OTYPE::CUS0_NAME => GLOBAL_ABAP_OTYPE::CUS0_DESC,
        GLOBAL_ABAP_OTYPE::CVERS_NAME => GLOBAL_ABAP_OTYPE::CVERS_DESC,
        GLOBAL_ABAP_OTYPE::DEVC_NAME => GLOBAL_ABAP_OTYPE::DEVC_DESC,
        GLOBAL_ABAP_OTYPE::DOMA_NAME => GLOBAL_ABAP_OTYPE::DOMA_DESC,
        GLOBAL_ABAP_OTYPE::DTEL_NAME => GLOBAL_ABAP_OTYPE::DTEL_DESC,
        GLOBAL_ABAP_OTYPE::FUNC_NAME => GLOBAL_ABAP_OTYPE::FUNC_DESC,
        GLOBAL_ABAP_OTYPE::FUGR_NAME => GLOBAL_ABAP_OTYPE::FUGR_DESC,
        GLOBAL_ABAP_OTYPE::INTF_NAME => GLOBAL_ABAP_OTYPE::INTF_DESC,
        //ABAP_OTYPE::MENU_NAME => ABAP_OTYPE::MENU_DESC,
        GLOBAL_ABAP_OTYPE::MSAG_NAME => GLOBAL_ABAP_OTYPE::MSAG_DESC,
        GLOBAL_ABAP_OTYPE::PROG_NAME => GLOBAL_ABAP_OTYPE::PROG_DESC,
        GLOBAL_ABAP_OTYPE::SHLP_NAME => GLOBAL_ABAP_OTYPE::SHLP_DESC,
        GLOBAL_ABAP_OTYPE::SQLT_NAME => GLOBAL_ABAP_OTYPE::SQLT_DESC,
        GLOBAL_ABAP_OTYPE::TABL_NAME => GLOBAL_ABAP_OTYPE::TABL_DESC,
        GLOBAL_ABAP_OTYPE::TRAN_NAME => GLOBAL_ABAP_OTYPE::TRAN_DESC,
        GLOBAL_ABAP_OTYPE::VIEW_NAME => GLOBAL_ABAP_OTYPE::VIEW_DESC,
    );

    /**
     * Other object types.
     */
    public static $OTYPES_OTHER = array(
        GLOBAL_ABAP_OTYPE::DTF_NAME => GLOBAL_ABAP_OTYPE::DTF_DESC,
        GLOBAL_ABAP_OTYPE::NN_NAME => GLOBAL_ABAP_OTYPE::NN_DESC,
        GLOBAL_ABAP_OTYPE::OM_NAME => GLOBAL_ABAP_OTYPE::OM_DESC,
    );

    /**
     * Get Object Type Description.
     *
     * @param string $oType Object type, example: DOMA, DTEL, TABL
     * @return string Object type description, example: 'Domain', 'Data element'
     */
    public static function getOTypeDesc(string $oType): string {
        if (array_key_exists($oType, GLOBAL_ABAP_OTYPE::$OTYPES)) {
            return GLOBAL_ABAP_OTYPE::$OTYPES[$oType];
        } else if (array_key_exists($oType, GLOBAL_ABAP_OTYPE::$OTYPES_OTHER)) {
            return GLOBAL_ABAP_OTYPE::$OTYPES_OTHER[$oType];
        } else {
            return $oType;
        }
    }

}

class GLOBAL_BUFFER {

    private static $buffer = array();

    /**
     * Buffer key prefix for sap-tcodes.com UI Navigation link for Component.
     */
    const KEYPREFIX_TCODES_UINAV_COMP = 'tcodeunc-';

    /**
     * Buffer key prefix for sap-tcodes.com UI Navigation link for Module.
     */
    const KEYPREFIX_TCODES_UINAV_MODULE = 'tcodeunm-';

    /**
     * Buffer key prefix for DB Table.
     */
    const KEYPREFIX_DB = 'db';


    /**
     * Get a value from the global buffer.
     *
     * @return string Value of the key, or default if the key does not exist
     */
    public static function Get(string $key, $default = NULL) {
        if (GLOBAL_UTIL::IsEmpty($key)) {
            return NULL;
        }

        if (array_key_exists($key, GLOBAL_BUFFER::$buffer)) {
            return GLOBAL_BUFFER::$buffer[$key];
        } else {
            return $default;
        }
    }
    
    /**
     * Set a value to the global buffer.
     *
     * @return int 0 - Succeed; -1 - invalid input
     */
    public static function Set(string $key, $value): int {
        if (GLOBAL_UTIL::IsEmpty($key)) {
            return -1;
        }

        GLOBAL_BUFFER::$buffer[$key] = $value;
        return 0;
    }

}

/**
 * HTTP Status Codes.
 *
 * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html Status Code Definitions
 */
class GLOBAL_HTTP_STATUS {

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

class GLOBAL_UTIL {

    const SAP_DESC_LANGU = 'SAP_DESC_LANGU';

    /**
     * Clear an object id for URL.
     */
    public static function Clear4Url(string $id): string {
        if (GLOBAL_UTIL::Contains($id, '/')) {
            $id_cleared = htmlentities($id, ENT_QUOTES, "UTF-8");
        } else {
            $id_cleared = urlencode($id);
        }

        return strtolower($id_cleared);
    }

    /**
     * Check if an string contains a needle.
     *
     * @return BOOLEAN TRUE if the string conains the needle, else return FALSE
     * @link http://stackoverflow.com/questions/4366730/check-if-string-contains-specific-words
     */
    public static function Contains(string $haystack, string $needle): bool {
        if (strpos($haystack, $needle) !== false) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Echo spaces.
     *
     * @param int $count Number of spaces to echo
     */
    public static function EchoSpace(int $count = 1) {
        while ($count > 0) {
            echo '&nbsp;';
            $count--;
        }
    }

    /**
     * @link http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php/834355#834355
     */
    public static function EndsWith(string $haystack, string $needle): bool {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * Change the un-recognized slash ('/') character as '_'.
     *
     * @param string $name The table name to be escaped
     */
    public static function SlashEscape(string $name): string {
        return str_replace('/', '_', $name);
    }
    
    public static function SlashClear(string $name): string {
        return str_replace('/', '', $name);
    }

    /**
     * Show file size in bytes into human readable format.
     */
    public static function FormatSizeUnits(int $bytes): string {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function IsEmpty(string $string = null): bool {
        return !GLOBAL_UTIL::IsNotEmpty($string);
    }

    /**
     * Check if the string is empty or not.
     */
    public static function IsNotEmpty(string $string = null): bool {
        if (strlen(trim($string)) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @link http://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php/834355#834355
     */
    public static function StartsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * Update the $GLOBALS['SAP_DESC_LANGU'] variable based on HTTP cookie value.
     */
    public static function UpdateSAPDescLangu() {
        if (empty($_COOKIE['sap-desc-langu']) === FALSE and strlen($_COOKIE['sap-desc-langu']) == 1) {
            switch ($_COOKIE['sap-desc-langu']) {
                case "N": case "E": case "F": case "D": case "I":
                case "J": case "3": case "L": case "P": case "R":
                case "1": case "S": case "M": case "T":
                    $sap_desc_langu = $_COOKIE['sap-desc-langu'];
                    break;

                default:
                    $sap_desc_langu = "E";
                    break;
            }
        } else {
            $sap_desc_langu = "E";
        }
        $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] = $sap_desc_langu;
    }

}

class GLOBAL_WEBSITE {

    const SAPDS_ORG_DESC = 'The Best Online SAP Object Repository';
    const SAPDS_ORG_META_DESC = 'SAP Datasheet for all ABAP objects: Tables, Transaction codes, Implementation Guide (IMG), Function modules, Domains, Data elements, Views, Class and Interfaces, ABAP Report, SAP Menu, etc';
    const SAPDS_ORG_NAME = 'SAP Datasheet';
    const SAPDS_ORG_TITLE = ' - SAP Datasheet - The Best Online SAP Object Repository';
    const SAPDS_ORG_URL = "https://www.sapdatasheet.org";
    const SAPDS_ORG_URL_DISPLAY = 'www.SAPDatasheet.org';

    const SAP_TABLES_ORG_DESC = 'The Best online document for SAP ABAP Tables';
    const SAP_TABLES_ORG_META_DESC = 'Document for All SAP Tables, including table basic information, relationship diagrams, books, etc';
    const SAP_TABLES_ORG_NAME = 'SAP Tables';
    const SAP_TABLES_ORG_TITLE = ', sap-tables.org - The Best online document for SAP ABAP Tables';
    const SAP_TABLES_ORG_URL = 'https://www.sap-tables.org';
    const SAP_TABLES_ORG_URL_DISPLAY = 'www.SAP-Tables.org';

    const SAP_TCODES_ORG_DESC = 'The Best Online SAP Transaction Code Analytics';
    const SAP_TCODES_ORG_NAME = 'SAP TCodes';
    const SAP_TCODES_ORG_TITLE = ' - SAP TCodes - The Best Online SAP Transaction Code Analytics';
    const SAP_TCODES_ORG_URL = "https://www.sap-tcodes.org";
    const SAP_TCODES_ORG_URL_DISPLAY = 'www.SAP-TCodes.org';
}
