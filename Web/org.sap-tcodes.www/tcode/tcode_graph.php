<?php

$__WS_ROOT__ = dirname(__FILE__, 3);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 2);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

# Check parameter
$tcode = filter_input(INPUT_GET, 'id');
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

# Check 
$analytics_list = SITE_UI_TCODE::LoadAnalytics($abaptran);
$output_file_path = (new TCodeGraphviz($abaptran, $analytics_list))->run();
if (GLOBAL_UTIL::IsNotEmpty($output_file_path)) {
    header("Content-Type: image/svg+xml");
    header("Content-Length: " . filesize($output_file_path));
    readfile($output_file_path);
    
    unlink($output_file_path);
} else {
    header("Content-Type: " . $content_type);
    header("Content-Length: 0");
}


class TCodeGraphviz {

    const file_prefix = 'sap-tcodes-graphviz-';
    const layout_circo = 'circo';
    const layout_dot = 'dot';
    const layout_fdp = 'fdp';
    const layout_neato = 'neato';
    const layout_sfdp = 'sfdp';
    const layout_twopi = 'twopi';
    
    private $tcode;
    private $tcode_desc;  // Example: Transaction Code SE11 (Data Dictionary Editor)
    private $abaptran;
    private $analytics_list;

    function __construct(array $abaptran, array $analytics_list) {
        $this->tcode = $abaptran['TCODE'];
        $this->tcode_desc = GLOBAL_ABAP_OTYPE::TRAN_DESC . ' ' . $this->tcode . ' (' . html_entity_decode(ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::TRAN_NAME, $this->tcode)) . ')';
        $this->abaptran = $abaptran;
        $this->analytics_list = $analytics_list;
    }

    private function digraph_start(): string {
        $digraph = 'digraph "' . $this->tcode_desc . '"' . PHP_EOL;
        $digraph = $digraph . '{' . PHP_EOL;
        $digraph = $digraph . '  edge [fontname="Helvetica",fontsize="10",labelfontname="Helvetica",labelfontsize="10"];' . PHP_EOL;
        $digraph = $digraph . '  node [fontname="Helvetica",fontsize="10",shape=record];' . PHP_EOL;
        $digraph = $digraph . '  rankdir="LR";' . PHP_EOL;
        
        return $digraph;
    }

    /**
     * Root node.
     * 
     * Node1 [label="DSIP", tooltip="Transaction Coe DSIP (DataSource InfoProvider Mapping)"  height=0.2,width=0.4,color="#678EB7", fillcolor="#678EB7", style="filled", shape=doubleoctagon, fontcolor="black"];
     */
    private function getNodeRoot(string $node_id) {
        return $node_id . ' [label="' . $this->tcode . '", tooltip="' . $this->tcode_desc
                . '" height=0.2,width=0.4,color="#678EB7", fillcolor="#678EB7", style="filled", shape=doubleoctagon, fontcolor="black"];' . PHP_EOL;
    }

    private function getNode(string $node, string $label, string $tooltip, string $url) {
        
    }

    public function process(): string {
        $graphviz_script = $this->digraph_start();

        $graphviz_root_id = SITE_UI_TCODE::Graphviz_id(GLOBAL_ABAP_OTYPE::TRAN_NAME, $this->tcode);
        $graphviz_script = $graphviz_script . $this->getNodeRoot($graphviz_root_id);

        
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
        unlink($temp_dir . $graphviz_filename_dot);
     
        $tempOut = $temp_dir . $graphviz_filename_svg;
        if (file_exists($tempOut) && filesize($tempOut) > 0) {
            return $tempOut;
        } else {
            return "";
        }
    }

}
