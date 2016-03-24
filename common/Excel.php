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

	public function import_data(){
		$data = [];
		if($_FILES){
			$i = 0;
			foreach($_FILES as $k=>$v){
				$objPHPExcel = \PHPExcel_IOFactory::load($_FILES[$k]['tmp_name']);

				$sheet = $objPHPExcel->getSheet(0); // 读取第一個工作表
				$highestRow = $sheet->getHighestRow(); // 取得总行数
				$highestColumm = $sheet->getHighestColumn(); // 取得总列数


				/** 循环读取每个单元格的数据 */
				$dataset = [];
				for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
					for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
						$dataset[$row][$column] = $sheet->getCell($column.$row)->getValue();

					}
				}
				if($dataset){
					$data[] = $dataset;
				}
			}
		}

		/**
		 * 当只有一个excel传入时候，返回单个数组（一个表的数据）
		 */
		if($data){
			if(count($data) == 1){
				$data = array_shift($data);
			}
		}

		return $data;
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

	public function export_data($source = [],$title = [],$file_name = ""){
		if(!$file_name){
			$file_name = date("Y-m-d",time());
		}

		//测试数据
//		$title = ["青龙","白虎","朱雀","炫舞"];
//		$source = [
//			['A','B','C',"D",],
//			['as','dd','ss','ww'],
//			['qq','ww','ee','tt']
//		];

		$objPHPExcel = $this->objPHPExcel;

		$objPHPExcel->getProperties()->setCreator("XX");//作者


		$row_flag = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
		$row_flag =  explode(',',$row_flag);


		/**
		 * 设置表头 第1行
		 */
		if($title) foreach($title as $k=>$v){
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($row_flag[$k] . 1, $v);
		}


		$num = 1;
		foreach($source as $k => $v) {
			$num = $num + 1;//第二行开始
			if ($v) foreach ($title as $kk => $vv) {
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($row_flag[$kk] . $num, $v[$kk]);
			}
		}

		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$outputFileName = $file_name . ".xlsx";

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