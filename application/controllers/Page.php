<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page extends CI_Controller {
	function __construct()	{
		parent::__construct();
		$this->output->enable_profiler(true);		
	}
	function test_while(){
		$i = 0;
		while(true){
			//sleep(1);
			echo $i++."_";
			
			
			//if($i >= 5) continue;
			if($i >= 13) break;
		}
	}

	function vv(){
		$create_domain_result['msg'] = "출력완료!";
		$key = "master";
		${$key} = $create_domain_result['msg'];

		echo "master 으로 key 호출 ... ".$master;
	}
	function th(){
			$a = 5; echo $a >0 ? 0 : 1;

			echo ($a);
	}
	function v(){
		echo CI_VERSION;
		echo "it real server";
	}
	
	function index(){
		echo $_SERVER['HTTP_USER_AGENT'];
		echo "<hr>";
		echo $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");  
		
		$m = array("iPhone","Android","webOS","BlackBerry","iPod");		
		foreach($m as $val) if(strpos($_SERVER['HTTP_USER_AGENT'], $val)) $agent = $val;

		if(isset($agent)){			
			//include_once 'header_m.htm';
			echo "ajent == ".$agent;
		}
		else{
			
			//include_once 'header.htm';
		}



 	}//end index
 	
 	function sha(){
 		$txt = $this->input->get('txt');
		echo hash('sha512', $txt);
		//$pass = hash("sha512", $pass);
 	}
	
	function uniqid(){
		echo uniqid();
	}
	
	function login(){
		
		$this->load->view("page_login_v");
	}
	function ten(){
		$this->load->view("page/ten_v");
	}
	
	//테섭 인터넷 쿠폰 테스트
	function test_coupon(){
		
	}

	function info(){
		phpinfo();
	}
	
	function facebook(){
		
	}

	function str(){
		$uu = "http://test.thedays.co.kr:89/";
		echo $url = str_replace(":89","",$uu);
		echo BASE_URL;
		
	}

	function xls_down(){
//		dirname(__FILE__) . APPPATH.'/libraries/PHPExcel.php';
//		dirname(__FILE__) . APPPATH.'/libraries/PHPExcel/IOFactory.php';
		//$this->load->library("PHPExcel");
		//$objPHPExcel = new PHPExcel();

		error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);

        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        /** Include PHPExcel */
        $this->load->library('PHPExcel');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("MokNathal")
                                     ->setLastModifiedBy("MokNathal")
                                     ->setTitle("STAFF REPORT")
                                     ->setSubject("STAFF REPORT")
                                     ->setDescription("STAFF REPORT")
                                     ->setKeywords("STAFF REPORT")
                                     ->setCategory("STAFF REPORT");



        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->setActiveSheetIndex(0)
                    ->getCell('A1')->setValue("Name of staff:aaaaaa Lname");
        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setWrapText(true);       

        $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');
        $objPHPExcel->setActiveSheetIndex(0)
                    ->getCell('A2')->setValue("Group:Sunday Holiday Plan");
        $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setWrapText(true);       

        $objPHPExcel->getActiveSheet()->mergeCells('A3:F3');
        $objPHPExcel->setActiveSheetIndex(0)
                    ->getCell('A3')->setValue("Login Details");
        $objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setWrapText(true);           

        $objPHPExcel->getActiveSheet()->mergeCells('A4:F4');
        $objPHPExcel->setActiveSheetIndex(0)
                    ->getCell('A4')->setValue("Checkin time:09:05:00am");
        $objPHPExcel->getActiveSheet()->getStyle('A4:F4')->getAlignment()->setWrapText(true);           

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A5', 'Year')
                     ->setCellValue('B5', 'Month')
                     ->setCellValue('C5', 'Day')
                     ->setCellValue('D5', 'Login Time')
                      ->setCellValue('E5', 'Logout Time')
                       ->setCellValue('F5', 'Login Status');

        $objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);

        $i=6;
        $uri_year=2071;
        $uri_month=4;
        for($j=1;$j<=30;$j++)
        {
        $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$i, $uri_year)
                         ->setCellValue('B'.$i, $uri_month)
                         ->setCellValue('C'.$i, $j);

                $i++;

        }
        foreach(range('A','F') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Trasaction List');


        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=".$uri_year."-".$uri_month."_staff_report.xlsx\"");
        header("Cache-Control: max-age=0");

        $objWriter->save("php://output");


	}

	

}

