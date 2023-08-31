<?php

if(isset($_POST["eindex"])){
        require_once "../../tcpdf/tcpdf.php";
    require_once "dbconn.inc.php";
    session_start();


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $ID = $_SESSION["userId"];

    ////////////////// DATA NAME


    $sqlName = "SELECT user_name FROM users WHERE user_id='$ID';";
    $resultName = $conn->query($sqlName);
    $name;
    if ($resultName->num_rows > 0) {
    // output data of each row
    while($rowName = $resultName->fetch_assoc()) {
        $name = $rowName['user_name'];
    }
    }

    ////////////////// DATA GRADES


    $subjects = array('History', 'Math', 'English', 'Geography');
    $grades;
   
    for($s=0; $s<count($subjects); $s++){
        for($v=0;$v<=2;$v++){
            $sqlGrades = "SELECT * FROM grades WHERE user_id='$ID' AND subject='$subjects[$s]' AND grade_value='$v';";
            $resultGrades = $conn->query($sqlGrades);
            
            if ($resultGrades->num_rows > 0) {
                // output data of each row
                while($rowGrades = $resultGrades->fetch_assoc()) {
                    $date = date("d.m.", strtotime($rowGrades["grade_date"]));
                    
                    $grades[$s][$v][] = array($rowGrades['grade'], $date);
                   
                };
            } else {
                $grades[$s][$v][] = array("", "");
            };
        };  
    };


    ////////////////// DATA RATING PLUS


    $sqlRP = "SELECT * FROM rating WHERE user_id='$ID' AND rate_status=1;";
    $resultRP = $conn->query($sqlRP);
    $rate_plus;
    $rate_plus_date;

    if ($resultRP->num_rows > 0) {
    
    while($rowRP = $resultRP->fetch_assoc()) {
        $rate_plus[] = $rowRP['rate_text'];
        $orgDate = $rowRP['rate_date'];
        $newDate = date("d.m.", strtotime($orgDate));
        $rate_plus_date[] = $newDate;
    }
    } else {
        $rate_plus[] = "";
        $rate_plus_date[] = "";
    }


    ////////////////// DATA RATING MINUS

    $sqlRM = "SELECT * FROM rating WHERE user_id='$ID' AND rate_status=2;";
    $resultRM = $conn->query($sqlRM);
    $rate_minus;
    $rate_minus_date;

    if ($resultRM->num_rows > 0) {
    
    while($rowRM = $resultRM->fetch_assoc()) {
        $rate_minus[] = $rowRM['rate_text'];
        $orgDate = $rowRM['rate_date'];
        $newDate = date("d.m.", strtotime($orgDate));
        $rate_minus_date[] = $newDate;
    }
    } else {
        $rate_minus[] = "";
        $rate_minus_date[] = "";
    }

  ////////////////// DATA APOLOGIES

  $sqlA = "SELECT * FROM apology WHERE user_id='$ID';";
  $resultA = $conn->query($sqlA);
  
  $apologyTxt;
  $apologyDate;

  if ($resultA->num_rows > 0) {
  
  while($rowA = $resultA->fetch_assoc()) {
      $apologyTxt[] = $rowA['apology_txt'];
      $orgDate = $rowA['apology_date'];
      $newDate = date("d.m.", strtotime($orgDate));
      $apologyDate[] = $newDate;
  }
  } else {
    $apologyTxt[] = "";
    $apologyDate[] = "";
  }




    // Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF {

        //Page header
        public function Header() {
            // Logo
            $image_file = '../icons/logo.jpg';
            $this->Image($image_file, 5, 5, 30, '', 'JPG', '', 'M', false, 300, 'L', false, false, 0, false, false, false);
            // Set font
            $this->SetFont('times', 'B', 12);
            // Title
            $this->Cell(90, 15, 'automatically generated index', 0, 0, 'R', 0, '', 0, false, 'C', 'C');
        }

        // Page footer
        public function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('times', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('[SCHOOL NAME]');
    $pdf->SetTitle('E-index');
    $pdf->SetSubject($name);;


    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);


    // ---------------------------------------------------------




    // add a page
    $pdf->AddPage('P','A5');

    $pdf->Cell(128, 59, '', 0, 1, 'C', 0, '', 0,FALSE,'T','C');
    $pdf->SetFont('times', 'B', 25);
    $pdf->Cell(128, 40, 'Index', 0, 1, 'C', 0, '', 0,FALSE,'T','C');
    $pdf->SetFont('times', 'B', 15);
    $pdf->Cell(128, 40, $name, 0, 1, 'C', 0, '', 0,FALSE,'T','C');
    $pdf->Cell(128, 40, '', 0, 1, 'C', 0, '', 0,FALSE,'T','C');




    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);


    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


    // ---------------------------------------------------------
    /////////////// apologies

    

    $pdf->setPrintHeader(true);

    $pdf->AddPage('P', 'A5');
    $pdf->SetFont('times', 'B', 25);
    $pdf->Cell(128,15, 'Apologies', 0, 1, 'C', 0, '', 0, FALSE, 'T', 'C');
    $pdf->Cell(128,15, '', 0, 1, 'C', 0, '', 0, FALSE, 'T', 'C');
    $pdf->SetFont('times', '', 15);
    for($a=0; $a<count($apologyTxt); $a++){
        $pdf->writeHTMLCell(20, 10, '', '', "<p>".$apologyDate[$a]."</p>", 0, 0, 0, true, 'L', true);
        $pdf->writeHTMLCell(108, 10, '', '', "<p>".$apologyTxt[$a]."</p>", 0, 1, 0, true, 'L', true);
        // $pdf->Cell(20,15, $apologyDate[$a], 0, 0, 'L', 0, '', 1, FALSE, 'T', 'C');
        // $pdf->Cell(108,15, $apologyTxt[$a], 0, 1, 'L', 0, '', 1, FALSE, 'T', 'C');
    }

    $pdf->setPrintFooter(true);


// add pages with grades
    
    for($i=0; $i<count($subjects); $i++){
        $pdf->AddPage('P', 'A5');
        $subName = $subjects[$i];
        $pdf->SetFont('times', '', 25);
        $pdf->Cell(128, 15, $subName, 0, 1, 'C', 0, '', 0,FALSE,'T','C');
        
        $result0 = $grades[$i][0];
        $result1 = $grades[$i][1];
        $result2 = $grades[$i][2];

        

        $pdf->SetFont('times', '', 15);
        
        $gradeString0 = "<table>";
        $gradeString1 = "<table>";
        $gradeString2 = "<table>";

        $gradeAvg0;
        $gradeAvg1;
        $gradeAvg2;
        $gradeAvg3;

        $pdf->SetFont('times', '', 18);
        
        foreach($result0 as $gr){
            $gradeString0 .= "<tr><td><small>".$gr[1]."</small></td><td>".$gr[0]."</td></tr>";
            if(!empty($gr[0])){
                ${"gradeAvg".$i}[] = $gr[0];
            }
            
        }
        foreach($result1 as $gr){
            $gradeString1 .= "<tr><td><small>".$gr[1]."</small></td><td>".$gr[0]."</td></tr>";
            // array_push($gradeAvg, $gr[0]);
            if(!empty($gr[0])){
                ${"gradeAvg".$i}[] = $gr[0];
            }
        }
        foreach($result2 as $gr){
            $gradeString2 .= "<tr><td><small>".$gr[1]."</small></td><td>".$gr[0]."</td></tr>";
            // array_push($gradeAvg, $gr[0]);
            if(!empty($gr[0])){
                ${"gradeAvg".$i}[] = $gr[0];
            }
        }

        $gradeString0 .= "</table>";
        $gradeString1 .= "</table>";
        $gradeString2 .= "</table>";

/////////////////////////////////////////
            
        $pdf->SetFillColor(255, 255, 127);
        $pdf->Cell(40, 15, 'Verbal', 1, 0, 'C', 0, '', 1,FALSE,'T','C');
        $pdf->Cell(40, 15, 'Exam', 1, 0, 'C', 0, '', 1,FALSE,'T','C');
        $pdf->Cell(40, 15, "HomeWork", 1, 1, 'C', 0, '', 1,FALSE,'T','C');
        
        $pdf->writeHTMLCell(40, 70, '', '', $gradeString0, 1, 0, 0, true, 'J', true);
        $pdf->writeHTMLCell(40, 70, '', '', $gradeString1, 1, 0, 0, true, 'J', true);
        $pdf->writeHTMLCell(40, 70, '', '', $gradeString2, 1, 1, 0, true, 'J', true);
            
        if (!empty(${"gradeAvg".$i})) {
            $gradeCount = count(${"gradeAvg".$i});
            $gradeSum = array_sum(${"gradeAvg".$i});
            ${"average".$i} = $gradeSum / $gradeCount;
            
            $pdf->Cell(40, 15, "Average", 1, 1, 'C', 0, '', 1,FALSE,'T','C');
            $pdf->Cell(40, 30, number_format(${"average".$i}, 2), 1, 0, 'C', 1, '', 0,FALSE,'T','C');
        }
        
        $subject_img = '../subjects/'.$i.'.jpg';
        $pdf->Image($subject_img, '', 130, '', 40, 'JPG', '', 'M', false, 300, 'R', false, false, 0, false, false, false);
    
    }
   

    $pdf->AddPage();
    $pdf->SetFont('times', '', 25);
    $pdf->Cell(128,15, 'Positive rating', 0, 1, 'C', 0, '', 0, FALSE, 'T', 'C');
    $pdf->Cell(128,15, '', 0, 1, 'C', 0, '', 0, FALSE, 'T', 'C');
    $pdf->SetFont('times', '', 15);
    for($rp=0; $rp<count($rate_plus); $rp++){
        $pdf->writeHTMLCell(20, 10, '', '', "<p>".$rate_plus_date[$rp]."</p>", 0, 0, 0, true, 'L', true);
        $pdf->writeHTMLCell(108, 10, '', '', "<p>".$rate_plus[$rp]."</p>", 0, 1, 0, true, 'L', true);
        // $pdf->Cell(20,15, $rate_plus_date[$rp], 0, 0, 'L', 0, '', 1, FALSE, 'T', 'C');
        // $pdf->Cell(108,15, $rate_plus[$rp], 0, 1, 'L', 0, '', 1, FALSE, 'T', 'C');
    }

    $pdf->AddPage();
    $pdf->SetFont('times', '', 25);
    $pdf->Cell(128,15, 'Negative rating', 0, 1, 'C', 0, '', 0, FALSE, 'T', 'C');
    $pdf->Cell(128,15, '', 0, 1, 'C', 0, '', 0, FALSE, 'T', 'C');
    $pdf->SetFont('times', '', 15);
    for($rm=0; $rm<count($rate_minus); $rm++){
        $pdf->writeHTMLCell(20, 10, '', '', "<p>".$rate_minus_date[$rm]."</p>", 0, 0, 0, true, 'L', true);
        $pdf->writeHTMLCell(108, 10, '', '', "<p>".$rate_minus[$rm]."</p>", 0, 1, 0, true, 'L', true);
        
        // $pdf->Cell(20,15, $rate_minus_date[$rm], 0, 0, 'L', 0, '', 1, FALSE, 'T', 'C');
        // $pdf->Cell(108,15, $rate_minus[$rm], 0, 1, 'L', 0, '', 1, FALSE, 'T', 'C');
    }

    // ---------------------------------------------------------

    //Close and output PDF document
    $pdf->Output('E-Index '.$name.'.pdf' , 'I');
} else {
    header("location: ../profile.php");
}





