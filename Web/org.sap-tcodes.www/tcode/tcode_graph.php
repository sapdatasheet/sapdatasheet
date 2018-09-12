<?php

$__WS_ROOT__ = dirname(__FILE__, 3);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 2);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

# Check parameter
$tcode = filter_input(INPUT_GET, ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_ID);
if (empty($tcode)) {
    echo 'ERROR: No parameter provided.';
    exit(0);
}

# Check the TCode exists
$abaptran = ABAPANA_DB_TABLE::ABAPTRAN(strtoupper($tcode));
if (empty($abaptran['TCODE'])) {
    echo 'ERROR: No data found for tcode ' . $tcode;
    exit(0);
}

# Layout of the graph
$layout= strtolower(filter_input(INPUT_GET, ABAP_UI_TCODES_Navigation::GRAPHVIZ_LAYOUT)) ;
if (! in_array($layout, TCodeGraphviz::$LAYOUTS)) {
    $layout = TCodeGraphviz::layout_dot;
}

# Check 
$analytics_list = SITE_UI_TCODE::LoadAnalytics($abaptran);
$output_file_path = (new TCodeGraphviz($abaptran, $analytics_list))->run($layout);
if (GLOBAL_UTIL::IsNotEmpty($output_file_path)) {
    header("Content-Type: image/svg+xml");
    header("Content-Length: " . filesize($output_file_path));
    readfile($output_file_path);
    // unlink($output_file_path);
} else {
    header("Content-Type: html/text");
    header("Content-Length: 0");
}

class TCodeGraphviz {

    const file_prefix = 'sap-tcodes-graphviz-';
    const layout_circo = 'circo';
    const layout_dot = 'dot';        // Suggested
    const layout_fdp = 'fdp';
    const layout_neato = 'neato';
    const layout_sfdp = 'sfdp';      // Suggested
    const layout_twopi = 'twopi';
    const MAX_TCODE_NODE_COUNT = 20;

    public static $LAYOUTS = array(
        self::layout_circo,
        self::layout_dot,
        self::layout_fdp,
        self::layout_neato,
        self::layout_sfdp,
        self::layout_twopi,
    );
    
    private $tcode;
    private $tcode_desc;  // Example: Transaction Code SE11 (Data Dictionary Editor)
    private $abaptran;
    private $analytics_list;
    
    
    function __construct(array $abaptran, array $analytics_list) {
        $this->tcode = $abaptran['TCODE'];
        $this->tcode_desc = SITE_UI_TCODE::Graphviz_tooltip(GLOBAL_ABAP_OTYPE::TRAN_DESC, $this->tcode, html_entity_decode(ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::TRAN_NAME, $this->tcode)));
        $this->abaptran = $abaptran;
        $this->analytics_list = $analytics_list;
    }

    private function digraph_start(): string {
        $digraph = 'digraph "' . $this->tcode_desc . '"' . PHP_EOL;
        $digraph = $digraph . '{' . PHP_EOL;
        $digraph = $digraph . '  edge [fontname="Helvetica",fontsize="10",labelfontname="Helvetica",labelfontsize="10"];' . PHP_EOL;
        $digraph = $digraph . '  node [fontname="Helvetica",fontsize="10",shape=record];' . PHP_EOL;
        $digraph = $digraph . '  rankdir="LR";' . PHP_EOL;

        return $digraph . PHP_EOL;
    }
    
    private function getLink(string $source_id, string $node_id): string {
        return '  ' . $source_id . ' -> ' . $node_id
                . ' [dir="forward",color="midnightblue",fontsize="10",style="solid",fontname="Helvetica"];' . PHP_EOL;
    }

    /**
     * Root node.
     * 
     * Node1 [label="DSIP", tooltip="Transaction Coe DSIP (DataSource InfoProvider Mapping)"  height=0.2,width=0.4,color="#678EB7", fillcolor="#678EB7", style="filled", shape=doubleoctagon, fontcolor="black"];
     */
    private function getNodeRoot(string $node_id): string {
        return '  ' . $node_id . ' [height=0.2, width=0.4, style="filled", color="#FF6600", label="'
                . $this->tcode . '", tooltip="' . $this->tcode_desc . '" fillcolor="#678EB7", shape=doubleoctagon, fontcolor="black"];' . PHP_EOL;
    }

    private function getNode(string $node_id, string $node_label, string $node_tooltip, string $node_type, string $node_newin, string $node_url, string $source_id): string {

        switch ($node_type) {
            case GLOBAL_ABAP_OTYPE::BMFR_NAME:
                $node_type_script = ' fillcolor="#89A532", shape=component, ';
                break;

            case GLOBAL_ABAP_OTYPE::CVERS_NAME:
                $node_type_script = ' fillcolor="#FCA215", shape=box3d, ';
                break;

            case GLOBAL_ABAP_OTYPE::DEVC_NAME:
                $node_type_script = ' fillcolor="#FFEB00", shape=tab, ';
                break;

            case GLOBAL_ABAP_OTYPE::PROG_NAME:
                $node_type_script = ' fillcolor="#00FF99", shape=cds, ';
                break;

            case GLOBAL_ABAP_OTYPE::TRAN_NAME:
                $node_type_script = ' fillcolor="#B9CEDF", shape=box, ';
                break;

            case ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_NAME:
                // Name starts with, example "SE*"
                $node_type_script = ' fillcolor="#FF33CC", shape=signature, ';
                break;

            default:
                $node_type_script = ' fillcolor="white", shape=parallelogram, ';
                break;
        }

        if ($node_newin == SITE_UI_CONST::YES) {
            $node_newin_script = ' target="_blank", ';
        } else {
            $node_newin_script = '';
        }

        $script_node = '  ' . $node_id . ' [height=0.2, width=0.4, style="filled", color="black", label="' . $node_label
                . '", tooltip="' . $node_tooltip . '"' . $node_type_script
                . $node_newin_script . ' URL="' . $node_url . '"];' . PHP_EOL;

        $script_link = $this->getLink($source_id, $node_id);

        return $script_node . $script_link . PHP_EOL;
    }

    public function process(): string {
        $graphviz_script = $this->digraph_start();

        // Root node
        $graphviz_root_id = SITE_UI_TCODE::Graphviz_id(GLOBAL_ABAP_OTYPE::TRAN_NAME, $this->tcode);
        $graphviz_script = $graphviz_script . $this->getNodeRoot($graphviz_root_id) . PHP_EOL;

        // Loop on every Related Objects
        foreach ($this->analytics_list as $analytics) {
            $node_id = $analytics[SITE_UI_CONST::GRAPHVIZ_NODE_ID];
            $node_label = $analytics[SITE_UI_CONST::JSON_NAME];
            $node_tooltip = $analytics[SITE_UI_CONST::JSON_TILE];
            $node_type = $analytics[SITE_UI_CONST::KEY_OTYPE];
            $node_newin = $analytics[SITE_UI_CONST::JSON_NEW_WINDOW];
            $node_url = $analytics[SITE_UI_CONST::JSON_URL];
            $source_id = $analytics[SITE_UI_CONST::GRAPHVIZ_SOURCE];

            $graphviz_script = $graphviz_script . $this->getNode($node_id, $node_label, $node_tooltip, $node_type, $node_newin, $node_url, $source_id);

            if (is_array($analytics[SITE_UI_CONST::KEY_ARRAY_DATA])) {
                $data_index = 0;
                foreach ($analytics[SITE_UI_CONST::KEY_ARRAY_DATA] as $tcode_item) {
                    $data_index++;
                    // We only add limited number of tcodes to the diagram
                    if ($data_index > self::MAX_TCODE_NODE_COUNT) {
                        break;
                    }

                    $tcode_node_id = SITE_UI_TCODE::Graphviz_id(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode_item['TCODE']);
                    $tcode_node_label = $tcode_item['TCODE'];
                    $tcode_node_tooltip = SITE_UI_TCODE::Graphviz_tooltip(GLOBAL_ABAP_OTYPE::TRAN_DESC, $tcode_item['TCODE'], html_entity_decode(ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode_item['TCODE'])));
                    $tcode_node_type = GLOBAL_ABAP_OTYPE::TRAN_NAME;
                    $tcode_node_newin = SITE_UI_CONST::YES;
                    $tcode_node_url = ABAP_UI_TCODES_Navigation::TCode($tcode_item['TCODE'], TRUE);
                    $tcode_source_id = $node_id;
                    
                    if ($graphviz_root_id == $tcode_node_id) {
                        // If the TCode is the same as the root TCode
                        $graphviz_script = $graphviz_script . $this->getLink($tcode_source_id, $tcode_node_id);
                        continue;
                    }

                    $graphviz_script = $graphviz_script . $this->getNode($tcode_node_id, $tcode_node_label, $tcode_node_tooltip, $tcode_node_type, $tcode_node_newin, $tcode_node_url, $tcode_source_id);
                }
            }
        }

        // Tail
        $graphviz_script = $graphviz_script . '}' . PHP_EOL;
        return $graphviz_script;
    }

    /**
     * Execute the graphviz command, and return the result.
     *
     * @return string Empty string ('') if failed, else the output file full path.
     */
    public function run(string $layout = self::layout_dot): string {
        // Prepare the Graphviz file
        $graphviz_script = $this->process();

        // Execute the Graphviz command:
        //  - circo tcode.dot -Tsvg -o tcode-circo.svg
        //  - dot   tcode.dot -Tsvg -o tcode-dot.svg
        //  - fdp   tcode.dot -Tsvg -o tcode-fdp.svg
        //  - neato tcode.dot -Tsvg -o tcode-neato.svg
        //  - sfdp  tcode.dot -Tsvg -o tcode-sfdp.svg
        //  - twopi tcode.dot -Tsvg -o tcode-twopi.svg

        $temp_dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR;
        $graphviz_filename = self::file_prefix . getmypid();
        $graphviz_filename_dot = $graphviz_filename . '.dot';
        $graphviz_filename_svg = $graphviz_filename . '.svg';

        file_put_contents($temp_dir . $graphviz_filename_dot, $graphviz_script);

        $cmd = 'cd ' . $temp_dir . ' && ' . $layout . ' ' . $graphviz_filename_dot . ' -Tsvg -o ' . $graphviz_filename_svg;
        shell_exec($cmd);
        // unlink($temp_dir . $graphviz_filename_dot);

        $tempOut = $temp_dir . $graphviz_filename_svg;
        if (file_exists($tempOut) && filesize($tempOut) > 0) {
            return $tempOut;
        } else {
            return "";
        }
    }

}
