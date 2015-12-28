FUNCTION YAKB_WHERE_USED_LIST.
*"----------------------------------------------------------------------
*"*"Local Interface:
*"  IMPORTING
*"     VALUE(OBJ_TYPE) TYPE  TROBJTYPE
*"     VALUE(OBJ_NAME) TYPE  SOBJ_NAME
*"     VALUE(SUBOBJ) TYPE  EU_CRO_OBJ OPTIONAL
*"  EXPORTING
*"     VALUE(REFERENCES) TYPE  YWUL_TT
*"----------------------------------------------------------------------
*{   INSERT         AS1K900004                                        1

* Result:
*
*
  "* Used object:
*  OBJ_TYPE
*  OBJ_NAME
*  SUB_TYPE
*  SUB_NAME
*
  "* DEVC, DLVUNIT, PACKET
*  APPL_NAME
*  APPL_DLVUNIT
*  APPL_PACKET
*
  "* Responsible person of DEVC
*  CHANGED_BY
*
  "* Unused
*  CHANGED_ON
*  APPL_TYPE
*  CHANGED_AT
*  SEVERITY
*  STATE
*  DISTRIBUTED


  DATA: objecttype      TYPE seu_obj,
        tadir_name      TYPE sobj_name,
        trobj_name1     TYPE trobj_name,
        trobj_name2     TYPE trobj_name,
        found           TYPE c,
        wa              TYPE akb_except,
        ls_rsfind       TYPE RSFIND,
        objects         TYPE TABLE OF rsfind,
        usage           TYPE TABLE OF rsfindlst,
        used_object     TYPE rsfindlst,
        devclass        TYPE devclass,
        srcsystem       TYPE srcsystem,
        euobj           TYPE euobjedit,
        progname        TYPE progname,
        is_intf         TYPE seoclstype,
        ls_ywul         TYPE YWUL.

  REFRESH references.

  CASE obj_type.
    WHEN 'CPRI' OR 'CPRO' OR 'CPUB' OR 'CLSD'.
      wa-obj_type = 'CLAS'.
      wa-obj_name = obj_name.

      PERFORM get_packet
                  USING
                     'CLAS'
                     obj_name
                  CHANGING
                     euobj-tadir
                     tadir_name
                     devclass
                     srcsystem
                     wa-changed_by
                     wa-appl_dlvunit
                     wa-appl_packet
                     found.

      wa-appl_name = devclass.

      CLEAR ls_ywul.
      MOVE-CORRESPONDING wa to ls_ywul.
      INSERT ls_ywul INTO TABLE references.

    WHEN OTHERS.
      IF subobj is SUPPLIED and subobj is NOT INITIAL.
        CLEAR ls_rsfind.
        ls_rsfind-encl_obj = obj_name.
        ls_rsfind-object = subobj.
        APPEND ls_rsfind TO objects.
      ELSE.
        APPEND obj_name TO objects.
      ENDIF.

      objecttype = obj_type.

      CALL FUNCTION 'RS_EU_CROSSREF'
        EXPORTING
          i_find_obj_cls               = objecttype
          i_answer                     = ' '
          no_dialog                    = 'X'
          expand_source_in_batch_mode  = ' '
          expand_source_in_online_mode = ' '
        TABLES
          i_findstrings                = objects
          o_founds                     = usage
        EXCEPTIONS
          not_executed                 = 1
          not_found                    = 2
          illegal_object               = 3
          no_cross_for_this_object     = 4
          batch                        = 5
          batchjob_error               = 6
          wrong_type                   = 7
          object_not_exist             = 8
          OTHERS                       = 9.
      CHECK sy-subrc = 0.

      LOOP AT usage INTO used_object.
        CLEAR ls_ywul.
        MOVE-CORRESPONDING used_object to ls_ywul.
        MOVE used_object-program to ls_ywul-program_2.
        MOVE used_object-compress to ls_ywul-compress_2.
        MOVE used_object-last TO ls_ywul-last_2.

        CLEAR wa.

        SELECT SINGLE * FROM euobjedit INTO euobj
               WHERE type = used_object-object_cls.

        CHECK sy-subrc = 0.
        MOVE-CORRESPONDING euobj TO ls_ywul.

        CASE euobj-tadir.
          WHEN 'PROG'.
            progname = used_object-object.

            CALL FUNCTION 'RS_PROGNAME_DECIDER'
              EXPORTING
                include            = progname
              IMPORTING
                object             = wa-obj_type
                obj_name           = trobj_name1
                enclosing_object   = euobj-tadir
                enclosing_obj_name = trobj_name2
              EXCEPTIONS
                not_decideable     = 1
                OTHERS             = 2.
            CHECK sy-subrc = 0.

            wa-obj_name  = trobj_name1.
            tadir_name   = trobj_name2.

            IF wa-obj_type = 'REPS' AND wa-obj_name = tadir_name.
              wa-obj_type = 'PROG'.
            ELSEIF wa-obj_type = ''.
              wa-obj_type = euobj-tadir.
              wa-obj_name = trobj_name2.
            ENDIF.

          WHEN 'FUGR'.
            IF euobj-e071 = ''.
              wa-obj_type = euobj-tadir.
              wa-obj_name = used_object-encl_objec.
            ELSE.
              wa-obj_type = euobj-e071.
              wa-obj_name = used_object-object.
            ENDIF.

          WHEN 'CLAS' OR 'INTF'.
            wa-obj_type = euobj-tadir.
            wa-obj_name = used_object-encl_objec.
            wa-sub_type = euobj-e071.
            wa-sub_name = used_object-object.

            SELECT SINGLE clstype FROM  seoclass INTO is_intf
                   WHERE clsname = used_object-encl_objec.
            CHECK sy-subrc = 0.

            IF is_intf = 1.
              euobj-tadir = 'INTF'.
            ELSE.
              euobj-tadir = 'CLAS'.
            ENDIF.

            wa-obj_type = euobj-tadir.

*         Some class types do not have an TADIR_TYPE in EUOBJEDIT...
          WHEN ''.
            CHECK euobj-editor = 'CLASS'.

            wa-obj_name = used_object-object.

            SELECT SINGLE clstype FROM  seoclass INTO is_intf
                   WHERE clsname = used_object-object.
            CHECK sy-subrc = 0.

            IF is_intf = 1.
              euobj-tadir = 'INTF'.
            ELSE.
              euobj-tadir = 'CLAS'.
            ENDIF.

            wa-obj_type = euobj-tadir.

          WHEN 'TABL' OR 'VIEW'.
            wa-obj_type = euobj-tadir.
            wa-obj_name = used_object-encl_objec.
            wa-sub_type = euobj-e071.
            wa-sub_name = used_object-object.

          WHEN OTHERS.
            wa-obj_name = used_object-object.
            wa-obj_type = euobj-tadir.
        ENDCASE.

        MOVE-CORRESPONDING wa to ls_ywul.

        READ TABLE references INTO ls_ywul WITH KEY
          appl_type = wa-obj_type appl_name = wa-obj_name.

        IF sy-subrc > 2.
          PERFORM get_packet
                      USING
                         ls_ywul-obj_type
                         ls_ywul-obj_name
                      CHANGING
                         euobj-tadir
                         tadir_name
                         devclass
                         srcsystem
                         ls_ywul-changed_by
                         ls_ywul-appl_dlvunit
                         ls_ywul-appl_packet
                         found.
          ls_ywul-appl_name = devclass.
          INSERT ls_ywul INTO TABLE references.
        ENDIF.

      ENDLOOP.
  ENDCASE.

*}   INSERT
ENDFUNCTION.
