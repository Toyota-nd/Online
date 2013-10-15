<?php
require "chinese-unicode.php";            //匯入剛剛下載的中文化的FPDF
// require_once('../Connections/test.php');   //匯入連結資料庫的語法
//require_once('../require/reportSQL.php');  //匯入報表的SQL語法
// See http://www.fpdf.org/
class Report extends PDFUnicode {
	// Page header
	function Header() {
		$this->AddUniCNShwFont('uni');              //加入中文
		$this->SetFont('uni','',16);                //設定字型與字體大小
		// Logo
		$this->Image('toyota.jpg',10,6,55);
		// Arial bold 15
		$this->SetFont('uni','B',15);
		// Move to the right
		$this->Cell(80);
		// Title
		$this->Cell(50,0,'南都TOYOTA汽車公司測驗成績表簽核報表',0,0,'C');
		// Line break
		$this->Ln(20);
	}

	// Page footer
	function Footer() {
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('uni','I',8);
		// Page number
		$this->Cell(0,10,'頁次 '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

?>
