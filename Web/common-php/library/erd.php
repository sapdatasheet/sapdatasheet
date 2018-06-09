<?php

$__COMMON_ROOT__ = dirname(__FILE__, 2);
require_once($__COMMON_ROOT__ . '/library/global.php');
require_once($__COMMON_ROOT__ . '/library/abap_db.php');


/**
 * E-R Diagram wrapper based on https://github.com/BurntSushi/erd.
 */
class ERD {

    const file_prefix = 'sap-tables-erd-';
    const file_extension = '.er';
    const dd03l_scope_erd = 'erd';
    const dd03l_scope_pk = 'pk';

    protected $output_fmt;
    protected $table_name;
    protected $db_dd02l;
    protected $db_dd02t;

    /**
     * Constructor of an ERD project.
     *
     * @param string $output_fmt ERD output file format, example: png | pdf
     * @param string $table_name ABAP Database Table name
     */
    function __construct(string $output_fmt, string $table_name) {
        if (in_array($output_fmt, ERD_Format::enabledFormats()) == FALSE) {
            throw new Exception('Unrecognized output format: (' . $output_fmt . ')');
        }

        $this->db_dd02l = ABAP_DB_TABLE_TABL::DD02L(strtoupper($table_name));
        if (empty($this->db_dd02l) || empty($this->db_dd02l['TABNAME'])) {
            throw new Exception('Unrecognized table name: (' . $table_name . ')');
        }

        $this->output_fmt = $output_fmt;
        $this->table_name = $this->db_dd02l['TABNAME'];
        $this->db_dd02t = $this->clean_desc(ABAP_DB_TABLE_TABL::DD02T($this->table_name));
    }
    
    private function clean_desc(string $desc = NULL) : string {
        if (GLOBAL_UTIL::IsNotEmpty($desc)) {
            return str_replace('"', "'", $desc);
        } else {
            return "";
        }
    }

    /**
     * Convert an ABAP Card value to an ERD cardinality value.
     * 
     * @param string $abap_card ABAP DDIC cardinality value, it could be NULL.
     */
    private function card2cardinality(string $abap_card = NULL) {
        switch ($abap_card) {
            case ABAP_DB_CONST::DOMAINVALUE_CARD_CN:
                $result = ERD_Keyword::cardinality_0_or_more;
                break;
            case ABAP_DB_CONST::DOMAINVALUE_CARD_C:
                $result = ERD_Keyword::cardinality_0_or_1;
                break;
            case ABAP_DB_CONST::DOMAINVALUE_CARD_N:
                $result = ERD_Keyword::cardinality_1_or_more;
                break;
            case ABAP_DB_CONST::DOMAINVALUE_CARD_1:
                $result = ERD_Keyword::cardinality_exactly_1;
                break;

            default:
                $result = ERD_Keyword::cardinality_0_or_more;
                break;
        }

        return $result;
    }

    public function process(): string {
        $er_file = $this->process_header()
                . $this->process_entities()
                . $this->process_relationship();
        return $er_file;
    }

    private function process_header(): string {
        $title = ERD_Keyword::title(
                        'SAP ABAP table ' . $this->table_name . ' {' . $this->db_dd02t . '}', 20);
        return $title . PHP_EOL . PHP_EOL;
    }

    private function process_entities(): string {

        $entities = '# Entities' . PHP_EOL . PHP_EOL;

        // Primary table
        $entities = $entities . $this->process_entity($this->table_name, self::dd03l_scope_erd);

        // Check tables
        foreach (ABAP_DB_TABLE_TABL::DD08L_Erd($this->table_name) as $dd08l) {
            // Whent FK table is current table itself, we ignore it
            if ($dd08l['CHECKTABLE'] != $this->table_name) {
                $entities = $entities . $this->process_entity($dd08l['CHECKTABLE'], self::dd03l_scope_pk);
            }
        }

        return $entities;
    }

    private function process_entity(string $table_name, $scope = self::dd03l_scope_erd): string {
        // Generate the entity for the main Table

        if ($scope == self::dd03l_scope_pk) {
            $dd03l_list = ABAP_DB_TABLE_TABL::DD03L_PK($table_name);
            $bgcolor = ERD_Keyword::bgcolor('#d0e0d0');
        } else {
            $dd03l_list = ABAP_DB_TABLE_TABL::DD03L_Erd($table_name);
            $bgcolor = ERD_Keyword::bgcolor('tomato');
        }

        $entity = ERD_Keyword::entity(GLOBAL_UTIL::SlashEscape($table_name)) . $bgcolor . PHP_EOL;
        foreach ($dd03l_list as $dd03l) {
            $pk = ($dd03l['KEYFLAG'] == 'X') ? ERD_Keyword::column_pk : '';
            $fk = (strlen(trim($dd03l['CHECKTABLE'])) > 1) ? ERD_Keyword::column_fk : '';
            $label = ERD_Keyword::label($dd03l['DATATYPE'] . ' (' . $dd03l['LENG'] . ')');

            $fieldName = GLOBAL_UTIL::SlashEscape($dd03l['FIELDNAME']);
            $column = $pk . $fk . $fieldName . $label . PHP_EOL;
            $entity = $entity . $column;
        }

        return $entity . PHP_EOL;
    }

    private function process_relationship(): string {
        $relation = '# Relationships' . PHP_EOL . PHP_EOL;

        foreach (ABAP_DB_TABLE_TABL::DD05S_DD08L_DD03L($this->table_name) as $dd08l_dd05s_item) {
            $conn = ERD_Keyword::relation(
                            $this->card2cardinality($dd08l_dd05s_item['CARDLEFT']), $this->card2cardinality($dd08l_dd05s_item['CARD']));
            $label = $dd08l_dd05s_item['TABNAME'] . '-' . $dd08l_dd05s_item['FIELDNAME']
                    . ' = ' . $dd08l_dd05s_item['CHECKTABLE'] . '-' . $dd08l_dd05s_item['CHECKFIELDNAME'];

            $row = GLOBAL_UTIL::SlashEscape($dd08l_dd05s_item['TABNAME']) . $conn . GLOBAL_UTIL::SlashEscape($dd08l_dd05s_item['CHECKTABLE'])
                    . ERD_Keyword::label($label);
            $relation = $relation . $row . PHP_EOL;
        }

        return $relation;
    }

    /**
     * Execute the ERD command, and return the result.
     *
     * @return string Empty string ('') if failed, else the output file full path.
     */
    public function run(): string {
        // Prepare the ER file
        $er_file = $this->process();

        // Execute the ER command:
        //  - echo "abc" | erd -f png
        //  - erd -i something.er -o something.dot

        $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR;
        $fname = self::file_prefix . getmypid();

        $tempFileEr = $fname . self::file_extension;
        $tempFileOutput = $fname . '.' . $this->output_fmt;
        file_put_contents($tempDir . $tempFileEr, $er_file);

        $cmd = 'cd ' . $tempDir . ' && erd -i ' . $tempFileEr . ' -o ' . $tempFileOutput;
        shell_exec($cmd);
        unlink($tempDir . $tempFileEr);

        $tempFileOutputFullname = $tempDir . $tempFileOutput;
        if (file_exists($tempFileOutputFullname) && filesize($tempFileOutputFullname) > 0) {
            return $tempFileOutputFullname;
        } else {
            return "";
        }
    }

}

/**
 * ERD supported output file formats.
 */
class ERD_Format {

    const bmp = 'bmp';
    const dot = 'dot';
    const eps = 'eps';
    const gif = 'gif';
    const jpg = 'jpg';
    const pdf = 'pdf';
    const plain = 'plain';
    const png = 'png';
    const ps = 'ps';
    const ps2 = 'ps2';
    const svg = 'svg';
    const tiff = 'tiff';

    /**
     * We only enable limited export file formats as of now.
     */
    public static function enabledFormats(): array {
        return array(self::pdf, self::png);
    }

}

/**
 * ERD Keywrods
 */
class ERD_Keyword {

    const bgcolor = 'bgcolor';
    const comment = '# ';
    const column_fk = '+';
    const column_pk = '*';
    const label = 'label';
    const title = 'title';
    const size = 'size';
    const cardinality_0_or_1 = '?';
    const cardinality_exactly_1 = '1';
    const cardinality_0_or_more = '*';
    const cardinality_1_or_more = '+';

    public static function bgcolor(string $color): string {
        return ' {' . self::bgcolor . ': "' . $color . '"}';
    }

    public static function entity(string $entity_name): string {
        return '[' . $entity_name . ']';
    }

    public static function label(string $label): string {
        return ' {' . self::label . ': "' . $label . '"}';
    }

    /**
     * Generate a relation text. The <code>$left</code> or <code>$right</code> is one of the cardinality.
     */
    public static function relation(string $left, string $right): string {
        return ' ' . $left . '--' . $right . ' ';
    }

    public static function title(string $lable, int $size): string {
        return self::title . ' {' . self::label . ': "' . $lable . '", size: "' . $size . '"}';
    }

}
