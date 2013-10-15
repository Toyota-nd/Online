<?php
	//require_once('C:\AppServ\php5\library\Zend\Pdf.php'); 
class Application_Model_Report {

protected $pdf;

public function __construct() {
}	
public function setLayout($row) {	
	try {
		// create PDF
		$this->pdf = new Zend_Pdf();
		// create A4 page
		$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
		// define font resource
		$font = Zend_Pdf_Font::fontWithPath('kaiu.ttf');
		// define image resource
		$image = Zend_Pdf_Image::imageWithPath('images/toyota.jpg'); 
		$page->drawImage($image, 0, 800, 250, 845); //($image, left, bottom, right, top)
		  
		$trow = array();

		//設定表格的寬度
		$fields = $row['param'];
		$start = 5;
		for ($i = 0; $i < count($fields); $i++) {
			$w[] = $start;
			$start += $fields[$i]/2.1;
		}
		//
		for ($i = 0; $i < count($row); $i++) {
			$trow[$i] = $row[$i];
		}
		//設定表格的高度
		//迴圈
		$h = 750;
		for ($j = 0; $j < count($trow); $j++){	
			$h = $h-18;
			for( $i=0; $i< count($trow[$j]); $i++){
			$page->setFont($font, 11)
				->setLineWidth(1)
				->drawLine(0, $h-3, 600, $h-3)    //線條
				->drawText($trow[$j][$i],$w[$i],$h,'UTF-8');     //將資料放入表格內
			}; 
		}
		// set font for page
		// write text to page
		$page->setFont($font, 16)
			->drawText($row['title'].'報表',260,780, 'UTF-8')//標題文字
			->setLineWidth(1)//線條粗細
			->drawLine(0, 120, 600, 120)    //線條
			->setFillColor(Zend_Pdf_Color_Html::color('#990000'))//修改字型顏色
			->drawText('經辦',0,100, 'UTF-8')//->drawText('文字',寬,高,'UTF-8')
			->drawText('會計',100,100, 'UTF-8')
			->drawText('主管',190,100, 'UTF-8')
			->drawText('經理',280,100, 'UTF-8')
			->drawText('副總經理',360,100, 'UTF-8')
			->drawText('總經理',490,100, 'UTF-8');
		//頁碼
			$pageCount = count($pdf->pages)+1;
			$page->drawText('第'.$pageCount.'頁', 280, 5, 'UTF-8');                      

		  // add page to document
		  $this->pdf->pages[] = $page;
		  // save as file
		  $pdfString = $this->pdf->render();
		 // $this->pdf->save('example.pdf');    //不存檔
		} catch (Zend_Pdf_Exception $e) {
			$fid = fopen('debug.php','a');fwrite($fid, $e->getMessage() . "\n");fclose($fid);
			die ('PDF error: ' . $e->getMessage());  
		} catch (Exception $e) {
			$fid = fopen('debug.php','a');fwrite($fid, $e->getMessage() . "\n");fclose($fid);			
			die ('Application error: ' . $e->getMessage());    
	}
	return $pdfString;	
}
} //class
?>