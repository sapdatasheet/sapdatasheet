<?php
//
// Wrapper for the ERD tool - https://github.com/BurntSushi/erd
//

/**
 * E-R Diagram wrapper.
 */
class ERD {
    protected $table_name;
    protected $output_fmt;
    
    /**
     * Constructor of an ERD project.
     * 
     * @param string $table_name ABAP Database Table name
     * @param string $output_fmt ERD output file format, example: png | pdf
     */
    function __construct(string $table_name, string $output_fmt) {
        $this->table_name  = $table_name;
        $this->output_fmt  = $output_fmt;
    }
    
    private function process_header() {
        
    }
    
    private function process_entity() {
        // Generate the entity for the main Table
        
        // Generate the entities for the check tables
        
    }
    
    private function process_entity_checktables() {
        
    }
    
    private function process_relationship() {
        
    }
    
    /**
     * Execute the ERD command, and return the result.
     */
    public function run() : string {
        // Prepare the ER file
        $this->process_header();
        $this->process_entity();
        $this->process_entity_checktables();
        $this->process_relationship();
        
        // Execute the ER command


        // Return the result
        
    }
}

/**
 * ERD supported output file formats.
 */
class ERD_FMT {
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
}
