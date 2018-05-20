<?php

$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

require_once ($__ROOT__ . '/include/3rdparty/tcpdf/tcpdf_import.php');

// References
//
// Page Header Line
//   http://fpdf.org/en/script/script86.php
// Table of contents
//   http://fpdf.org/en/script/script73.php
//   http://www.tcpdf.org/examples/example_045.pdf
// Named destinations for Table of Content
//   http://fpdf.org/en/script/script99.php
// Table wrap long text
//   http://fpdf.org/en/script/script3.php
// Complex alignment with Multicell()
//   http://www.tcpdf.org/examples/example_020.pdf


GLOBAL_UTIL::UpdateSAPDescLangu();

// extend TCPF with custom functions
class MYPDF extends TCPDF {

    const ROW_HEIGHT = 5.4;

    var $module_l2;
    var $tableAligns;
    var $tableHeaders;
    var $tableWidths;

    /**
     * Print a table header.
     */
    function TableHeader() {
        if (strlen(trim($this->module_l2)) > 0) {
            $this->writeHTML($this->module_l2, true, false, true, false, '');
            $this->Ln(1);
        }

        $this->SetFillColor(255, 128, 0);
        $h = MYPDF::ROW_HEIGHT;
        for ($i = 0; $i < count($this->tableHeaders); $i++) {
            $w = $this->tableWidths[$i];
            $a = isset($this->tableAligns[$i]) ? $this->tableAligns[$i] : 'L';

            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();

            // Draw the border
            $this->Rect($x, $y, $w, $h);

            // Print the text
            $this->writeHTMLCell(
                    $w, 5, $x, $y, $this->tableHeaders[$i], 0, 1, true, true, $a);

            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    /**
     * Print a table row.
     */
    function TableRow($data) {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->CalcLineNumbers($this->tableWidths[$i], $data[$i]['text']));
        }
        $h = MYPDF::ROW_HEIGHT * $nb;

        // Issue a page break first if needed
        $pageBreak = $this->CheckPageBreak($h);
        if ($pageBreak == TRUE) {
            $this->TableHeader();
        }

        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->tableWidths[$i];
            $a = isset($this->tableAligns[$i]) ? $this->tableAligns[$i] : 'L';

            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();

            // Draw the border
            $this->Rect($x, $y, $w, $h);

            // Print the text
            $this->writeHTMLCell(
                    $w, 5, $x, $y, $data[$i]['html'], 0, 1, false, true, $a);

            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    /**
     * Set the array of column alignments.
     */
    function TableSetAligns($a) {
        $this->tableAligns = $a;
    }

    /**
     * Set the array of column alignments.
     */
    function TableSetHeaders($h) {
        $this->tableHeaders = $h;
    }

    /**
     * Set the array of column widths.
     */
    function TableSetWidths($w) {
        $this->tableWidths = $w;
    }

    /**
     * Calcuation line numbers.
     * This method is designed for non HTML texts.
     */
    private function CalcLineNumbers($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        //$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $wmax = ($w - 2 * $this->cell_padding['L']) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[ord($c)];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }

        return $nl;
    }

    /**
     * Page footer.
     * 
     * @see https://tcpdf.org/examples/example_003/
     */
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// ---------------------------------------------------------
// Load data

if (php_sapi_name() == 'cli') {
    $module_l1 = strtoupper($argv[1]);
} else {
    exit("Application Module is expected as the parameter.");
}

$module_l1_text = ABAPANA_DB_TABLE::ABAPBMFRL1_TEXT($module_l1);
$module_l2_list = SITE_UI_ANALYTICS::AnaModuleL2_DB2UI($module_l1);
asort($module_l2_list);

// ---------------------------------------------------------
// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(SITE_GLOBAL::URL_DISPLAY);
$pdf->SetTitle(SITE_GLOBAL::NAME . ' - ' . SITE_GLOBAL::DESC);
$pdf->SetSubject($module_l1 . ' - ' . $module_l1_text);
$pdf->SetKeywords($module_l1_text);

// set default header data
$pdf->SetHeaderData(
        null, 0, SITE_GLOBAL::NAME, SITE_GLOBAL::DESC
        . '                                                            '
        . GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------
// The Book Front Cover
// remove default header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = dirname(__FILE__) . '/book.jpg';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

// Print a text
$pdf->Ln(10);
$html = '<span style="color:white;text-align:center;font-weight:bold;font-size:40pt;">'
        . SITE_GLOBAL::NAME
        . '</span>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(20);

$html = '<span style="color:white;text-align:center;font-weight:bold;font-size:60pt;">'
        . $module_l1_text
        . '</span>';
$pdf->writeHTML($html, true, false, true, false, '');

// Botton Web Site
$html = '<span style="color:white;text-align:center;font-weight:bold;font-size:20pt;">'
        . SITE_GLOBAL::URL_DISPLAY
        . '</span>';
$pdf->writeHTMLCell(0, 0, 0, 260, $html);

// ---------------------------------------------------------
// Data Source Version

$pdf->AddPage();

$pdf->SetFont('courierB', '', 16);
$pdf->Ln(50);
$pdf->writeHTML('This Book is Based on:', true, false, true, false, '');
$pdf->Ln(4);
$pdf->writeHTML('SAP ERP 6 EhP 7', true, false, true, false, '');
$pdf->Ln(1);
$pdf->writeHTML('SAP CRM 7 EhP 3 SR2', true, false, true, false, '');
$pdf->Ln(1);
$pdf->writeHTML('SAP SRM 7 EhP 3 SR2', true, false, true, false, '');
$pdf->Ln(1);
$pdf->writeHTML('SAP Solution Manager 7.1 SR1', true, false, true, false, '');
$pdf->Ln(1);
$pdf->writeHTML('SAP Basis 7.40 SP08', true, false, true, false, '');

// ---------------------------------------------------------
// The Book Title Page

$pdf->AddPage();

// Bookmark
$title = 'SAP TCodes in Module ' . $module_l1 . ' - ' . $module_l1_text;
$pdf->Bookmark($title, 1, 0, '', '', array(128, 0, 0));

// Print Header
$pdf->SetFont('courierB', '', 36);
$html = '<span style="color:blue;">' . SITE_GLOBAL::NAME . '</span>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(3);

$html = '<span stroke="0.2" fill="true" strokecolor="yellow" color="blue" style="font-family:helvetica;font-weight:bold;font-size:21pt;">'
        . SITE_GLOBAL::DESC
        . '</span>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(40);

// Print Module Name
$pdf->SetFont('courierB', '', 36);
$html = '<span style="background-color:yellow;color:blue;">'
        . $module_l1_text
        . '</span>';
$pdf->writeHTML($html, true, false, true, false, '');

// Print Bottom
$html = '<span stroke="0.2" fill="true" strokecolor="yellow" color="blue" style="font-family:helvetica;font-weight:bold;font-size:21pt;text-align:center;">'
        . SITE_GLOBAL::URL_DISPLAY
        . '</span>';
$pdf->writeHTMLCell(0, 0, 0, 260, $html);


// ---------------------------------------------------------
// Terms

$pdf->AddPage();
$pdf->Ln(30);

$pdf->SetFont('times', '', 14);

$html = 'This book is based on <a href="' . GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . '">our</a> knowledge of SAP system, and it is constantly reviewed to avoid errors; '
        . 'well we cannot warrant full correctness of all content. '
        . 'Use the information and content on this book at your own risk.';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Ln(10);
$pdf->writeHTML('Published by:', true, false, true, false, '');
$pdf->Ln(2);
$pdf->writeHTML('book@sap-tcodes.org', true, false, true, false, '');
$pdf->Ln(1);
$pdf->writeHTML(SITE_GLOBAL::URL_DISPLAY, true, false, true, false, '');

$pdf->Ln(1);
date_default_timezone_set('UTC');
$html = 'Generated at <span style="color:blue;">' . date(DATE_RFC2822) . '</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 14);

$pdf->Ln(10);
$pdf->writeHTML('Copyleft &copy; ' . date("Y") . SITE_GLOBAL::URL_DISPLAY, true, false, true, false, '');
$pdf->Ln(2);
$pdf->writeHTML('This book is delivered under <a href="https://en.wikipedia.org/wiki/MIT_License">MIT License</a>, as bellow', true, false, true, false, '');
$pdf->Ln(2);
$html = 'Permission is hereby granted, free of charge,'
        . ' to any person obtaining a copy of this book and associated documentation files (the "Book"),'
        . ' to deal in the Book without restriction,'
        . ' including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,'
        . ' and/or sell copies of the Book,'
        . ' and to permit persons to whom the Book is furnished to do so, subject to the following conditions:';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(2);
$html = 'The above copyleft notice and this permission notice shall be included in all copies or substantial portions of the Book.';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(2);
$html = 'THE BOOK IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,'
        . ' INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.'
        . ' IN NO EVENT SHALL THE AUTHORS OR COPYLEFT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,'
        . ' WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,'
        . ' OUT OF OR IN CONNECTION WITH THE BOOK OR THE USE OR OTHER DEALINGS IN THE BOOK.';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('times', '', 12);

$pdf->Ln(10);
$html = 'SAP and the SAP logo are registered trademarks of <a href="http://www.sap.com">SAP SE</a>.';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Ln(1);
$html = 'This book is <strong>not</strong> sponsored by, affiliated with, or approved by <a href="http://www.sap.com">SAP SE</a>.';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Ln(1);
$html = '<a href="http://www.sap.com">SAP SE</a> is <strong>not</strong> the publisher of this book and is not responsible for it under any aspect of press law.';
$pdf->writeHTML($html, true, false, true, false, '');


// ---------------------------------------------------------
// TCode Tables by Level 2 Module

$pdf->setPrintHeader(true);

// Table Settings
$pdf->SetFillColor(255, 255, 200);
$pdf->TableSetAligns(array('R', 'L', 'L', 'L'));
$pdf->TableSetWidths(array(16, 30, 80, 24, 24));
$pdf->TableSetHeaders(array(
    '# ', 'T-Code', 'Description', 'Module', 'Component'));

foreach ($module_l2_list as $module_l2_item) {

    // Load Data
    $module_level = ABAPANA_DB_TABLE::ABAPBMFR_POSID_LEVEL($module_l2_item[SITE_UI_CONST::KEY_LABEL]);
    if ($module_level == 1) {
        $tcode_list = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(
                        ABAPANA_DB_TABLE::ABAPTRAN_APPLPOSID, $module_l2_item[SITE_UI_CONST::KEY_LABEL], FALSE);
    } else {
        $tcode_list = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(
                        ABAPANA_DB_TABLE::ABAPTRAN_PS_POSID_L2, $module_l2_item[SITE_UI_CONST::KEY_LABEL], FALSE);
    }

    $pdf->AddPage();
    $pdf->setPrintFooter(true);

    // Module Header
    $pdf->Ln(5);

    $bookmark = 'SAP TCodes in Module ' . $module_l2_item[SITE_UI_CONST::KEY_LABEL]
            . ' - ' . $module_l2_item[SITE_UI_CONST::KEY_ABAP_DESC];
    $pdf->Bookmark($bookmark, 1, 0, '', '', array(128, 0, 0));

    $pdf->SetFont('courierB', '', 16);
    $html = '<span style="color:blue;">' . 'SAP TCodes in Module' . '</span>';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Ln(31);

    $pdf->SetFont('courierB', '', 32);
    $html = '<span style="color:blue;">' . $module_l2_item[SITE_UI_CONST::KEY_LABEL] . '</span>';
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Ln(9);

    $pdf->SetFont('courierB', '', 24);
    $html = '<span style="color:blue;">' . $module_l2_item[SITE_UI_CONST::KEY_ABAP_DESC] . '</span>';
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->AddPage();
    $pdf->module_l2 = $module_l2_item[SITE_UI_CONST::KEY_LABEL]
            . ' - ' . $module_l2_item[SITE_UI_CONST::KEY_ABAP_DESC];

    // Module Table
    $pdf->SetFont('times', '', 12);
    $counter = 0;
    $pdf->TableHeader();
    foreach ($tcode_list as $tcode_item) {
        $counter++;

        $tcode_url = ABAP_UI_TCODES_Navigation::TCode($tcode_item['TCODE'], TRUE);
        $tcode_text = htmlentities(ABAP_DB_TABLE_TRAN::TSTCT($tcode_item['TCODE']));
        $tcode_desc = (strlen(trim($tcode_text)) > 0) ? $tcode_text : '(No description)';
        $module_url = ABAP_UI_TCODES_Navigation::AnalyticsModulePath($tcode_item['APPLPOSID'], TRUE);
        $comp_url = ABAP_UI_TCODES_Navigation::AnalyticsCompPath($tcode_item['SOFTCOMP'], TRUE);

        $rowData = array(
            array('text' => number_format($counter),
                'html' => number_format($counter),),
            array('text' => $tcode_item['TCODE'],
                'html' => '<a href="' . $tcode_url . '">' . $tcode_item['TCODE'] . '</a>',),
            array('text' => $tcode_desc,
                'html' => $tcode_desc,),
            array('text' => $tcode_item['APPLPOSID'],
                'html' => '<a href="' . $module_url . '">' . $tcode_item['APPLPOSID'] . '</a>',),
            array('text' => $tcode_item['SOFTCOMP'],
                'html' => '<a href="' . $comp_url . '">' . $tcode_item['SOFTCOMP'] . '</a>',),
        );
        $pdf->TableRow($rowData);
    }
}

// ---------------------------------------------------------
// Book back cover

$pdf->setPrintHeader(false);
$pdf->AddPage();
$pdf->setPrintFooter(false);

// Print Bottom
$html = '<span stroke="0.2" fill="true" strokecolor="yellow" color="blue" style="font-family:helvetica;font-weight:bold;font-size:21pt;text-align:center;">'
        . SITE_GLOBAL::URL_DISPLAY
        . '</span>';
$pdf->writeHTMLCell(0, 0, 0, 260, $html);


// ---------------------------------------------------------
// Add a new page for Table of Content

$pdf->addTOCPage();

// Write the ToC title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->MultiCell(0, 0, 'Table of Content', 0, 'C', 0, 1, '', '', true, 0);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 12);

// Add a simple Table Of Content
$pdf->addTOC(5, 'courier', '.', 'Table of Content', 'B', array(128, 0, 0));

// end of ToC page
$pdf->endTOCPage();


// ---------------------------------------------------------
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------
// PDF Document Output
$pdf->Output();
