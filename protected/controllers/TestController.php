<?php
/**
 * Created by PhpStorm.
 * User: xlxu
 * Date: 14-9-2
 * Time: 下午11:49
 */
class TestController extends EbuptController{
    public $model ;
    public $layout = '';
    public function filters() {
        //return array('accessControl',);
    }

    public function accessRules(){
        /*  return array(
              array('deny',
                  'actions'=>array('create'),
                  'users'=>array('Guest','test','guest'),
              ),
              array('deny',
                  'actions'=>array('create'),
                  'expression'=>array($this,'isNotAdmin'),
              ),
          );*/
    }
    //网站主页 暂时定为登陆页面，功能最简答出发
    public function actionIndex(){
        //$recordFilesBaseDir = Yii::app()->params['recordFilesBaseDir'];
        //$allNames = AsmacConstants::getAllFilesWithoutSub($recordFilesBaseDir);
       if( isset($_GET["chuFaSheFen"]) && trim($_GET["chuFaSheFen"]) != "-1" && trim($_GET["chuFaSheFen"]) != "all" && $_GET["chuFaSheFen"]!="null"){
                $province_name = trim($_GET['chuFaSheFen']);
            } 
        var_dump($province_name);
        //$this->renderSmarty('test/index.html', array('model' => $model));
    }


    public function actionTest(){
        $phpExlWriter = Yii::app()->phpExlWriter;
        $objPHPExcel = $phpExlWriter->getExcelObj();
        $objPHPExcel->getProperties()->setCreator("Ebupt Bi")
            ->setLastModifiedBy("Ebupt Bi")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");


// Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '序号')
            ->setCellValue('B1', '省份')
            ->setCellValue('C1', '号码')
            ->setCellValue('D1', '拦截次数')
            ->setCellValue('E1', '场景');

        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true)->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

//$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(PHPExcel_Cell_DataType::TYPE_STRING); setWidth(15);
//$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

        $start = 2 ;
        $data  = array();
        $data[]  = array(
            'name' =>"北京" ,
            "numbers"=>array('00001011185','000001011185','000088640010086','00009912333','000011185'),
            "times"=> array( 34869, 23323, 3424 ,3132 ,1080 ),
            "descs"=> array( '冒充中国邮政','冒充中国邮政','冒充10086','冒充社保局','冒充中国邮政')
        );
        $data[]  = array(
            'name' =>"福建" ,
            "numbers"=>array('11111011185','011101011185','111118640010086','111912333','1111185'),
            "times"=> array( 3114869, 1123323, 311424 ,311132 ,111080 ),
            "descs"=> array( '111111冒充中国邮政','111冒充中国邮政','冒111充10086','冒充社111保局','冒充中111国邮政')
        );
//mergeCells('B1:C22');
        foreach($data as $item){
            $ender = $start + 4 ;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$start.':A'.$ender);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $start, (int)($start/5 + 1));
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$start.':B'.$ender);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $start, $item['name']);
            for($i = $start ,$j = 0; $i <= $ender ; $i ++,$j++){
                $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $i, $item['numbers'][$j],PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode("@");
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item['times'][$j]);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item['descs'][$j]);
            }
            $start += 5;
        }
// Miscellaneous glyphs, UTF-8

// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);

        $outputFileName = "Test.xls";
//
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter = $phpExlWriter->getWriter($objPHPExcel);
//$objWriter->save($outputFileName);

// Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$outputFileName.'"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter->save('php://output');

    }


}
