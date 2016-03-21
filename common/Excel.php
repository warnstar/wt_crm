<?php
/**
 * Created by PhpStorm.
 * User: wchuang
 * Date: 2016/3/20
 * Time: 16:26
 */

namespace common;


class Excel
{
	private $objPHPExcel ;

	function __construct()
	{
		$this->objPHPExcel = new \PHPExcel();
	}

	public function load(){



		$objPHPExcel = \PHPExcel_IOFactory::load("05featuredemo.xlsx");
		dump($objPHPExcel);
	}

	public function test(){
		
		$objPHPExcel = $this->objPHPExcel;



		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
			->setLastModifiedBy("Maarten Balliauw")
			->setTitle("PHPExcel Test Document")
			->setSubject("PHPExcel Test Document")
			->setDescription("Test document for PHPExcel, generated using PHP classes.")
			->setKeywords("office PHPExcel php")
			->setCategory("Test result file");


		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'Hello')
			->setCellValue('B2', 'world!')
			->setCellValue('C1', 'Hello')
			->setCellValue('D2', 'world!');


		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A4', 'Miscellaneous glyphs')
			->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');


		$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
		$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
		$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);


		$objPHPExcel->getActiveSheet()->setTitle('Simple');


		$objPHPExcel->setActiveSheetIndex(0);




		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$outputFileName = "123.xlsx";

		ob_end_clean();
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header('Content-Disposition:inline;filename="'.$outputFileName.'"');
		header("Content-Transfer-Encoding: binary");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		$objWriter->save('php://output');

		return null;
	}
	
}