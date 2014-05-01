<?php 
 ini_set('display_errors', '1');
require_once(FS_PATH . "php/mpdf/mpdf.php");

$margin_left = '10';
$margin_right = '10';
$margin_top = '5';
$margin_bottom = '28';
$margin_header = '10';
$margin_footer = '5';

$mpdf=new mPDF('', 'A4', '', '', $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer);
$mpdf->setAutoTopMargin = "stretch";

$tableTracker = 0;
$repCount = 0;


$database = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_BASE);
$css = "";
$css .= "body { font-family:sans-serif;}\n";
$css .= ".right-image {float:right; width:300px;margin-left:20px;}\n";
$css .= "h4 {color:#5e3229;}\n";
$css .= "h3 {color:#5e3229;}\n";
$css .= "h2 {color:#5e3229;}\n";
$css .= "h1 {color:#5e3229;}\n";
$css .= "img {width:80%;margin-left:10%;}\n";
$css .= "div {page-break-inside: avoid;}\n"; 
$css .= ".content { margin-left:30px}\n";
$css .= ".maint {border-collapse:collapse;}\n";
$css .= ".mainttd {border:1px solid #000;}\n";
$mpdf->WriteHTML($css,1);

//$mpdf->setHTMLHeader('{PAGENO}<div style="float:left;"><img src="http://csog.carney.com/media/site-images/logo.gif"></div>');
//----------Header----------------
$sql = "SELECT * FROM projects WHERE id = $projectID";
$result = $database->query($sql);
if($result->num_rows >= 1)
{
  $answers = $result->fetch_assoc();
  $html = "";
  $html = "<div style='color:#5e3220;'>";
  $html .= "Project name: " . $answers['name'] . "<br /> ";
  $html .= "Project address: " . $answers['systemStreetAddress'] . "<br />";
  $html .= "<div style='border-bottom:1px solid #5e3229;width:34%;height:5px;min-height:5px;'></div>";
  //$html .= '<img src="/media/site-images/pdfheader-dash.png" />';
  $html .= $answers['date'];
  $html .= "</div>";
  $mpdf->setHTMLHeader($html);
}

$mpdf->setHTMLFooter('<div style="color:#5e3229"><img style="margin-left:0;width:700px;" src="/media/site-images/footer-image2.png" /><span float="right">p{PAGENO}</span></div> ');


$html = "";
$mpdf->WriteHTML($html,2);

//----------Cover Page------------

$sql = "SELECT * FROM projects WHERE id = $projectID";
$result = $database->query($sql);
if($result->num_rows >= 1)
{
  $answers = $result->fetch_assoc();
  $html = "";
  $html .= "<div style='padding-top:100px;'>";
  $html .= "<img src='".WS_URL."media/uploads/{$answers['file']}'>";
  $html .= "<h1>System Name or Brand: " . $answers['name'] . "</h1>";
  $html .= "<p>This owner's manual is customized to your septic system. It is designed to help you understand your system well enough to perform basic owner maintenance and know when you need service.</p>";
  $html .= "</div>";

}
$mpdf->WriteHTML($html,2);
$mpdf->AddPage();

//---------Disclaimer------------
$html = "<h2>Homeowner’s Guide Disclaimer</h2><div class='content'><p>This Homeowner’s Guide is intended for information purposes only and is provided as a public service. While the University of Minnesota has made reasonable efforts to ensure the accuracy of the information provided in this homeowner’s guide, it is not responsible for any damages resulting from reliance on the information. Please consult a septic professional or permitting agency if you have specific questions about your system and its management needs. The University of Minnesota reserves the right to make additions, changes, or corrections to this guide at any time and without notice.</p></div>";

$mpdf->WriteHTML($html,2);
$mpdf->AddPage();

//----------Introduction----------

$html = "";
$html .= '<h2>Introduction</h2><h3>This community septic system owner’s guide will help you:</h3>';
$html .= '<div class="content"><ol><li>understand the basic principles of how your septic system works,</li><li>learn how to operate your system efficiently and effectively,</li><li>know how to maintain the system to prevent costly repairs and water contamination,</li><li>resolve problems with the system, and</li><li>know where to go if you need more information or assistance.</li></ol></div>';
$html .= '<h3>Health and Safety – Why We Need Good Wastewater Treatment</h3>';
$html .= '<div class="content"><p><img class="right-image" src="'.WS_URL.'media/intro1.png">A wastewater system is professionally designed to treat wastewater for a specific home, business or group of properties. Proper treatment of wastewater recycles water back into the natural environment with reduced health risks to humans and animals and also prevents surface and groundwater contamination as shown in the figure.</p><p>Wastewater management involves:</p><ul><li>Collection and transport of wastewater from the source to a treatment process,</li><li>Removal of all or most of the waste products that are suspended and/or dissolved in the water,</li><li>Returning the water back to the environment, and</li><li>Returning the water back to the environment, and</li><li>Management of these processes to ensure that a wastewater system is fully functional.<li></ul><p><img class="right-image" src="'.WS_URL.'media/intro2.png">The primary goal of all wastewater management systems is to remove waste products from water and to safely return the water back into the environment. Every day, society generates a significant volume of wastewater because we depend on water to transport wastes away from our bodies, our clothes, and our homes. Once water comes in contact with waste products, the water becomes wastewater.  It contains pathogens (viruses and bacteria), solids, nutrients and other waste products we add into the system as demonstrated in the diagram.  This wastewater can impact the quality of ground and surface water resources. Used water does not simply go away. We must clean it before we can safely recycle it back into the natural environment. Proper handling and treatment of wastewater will protect our waters and ourselves from contamination.</p></div>';
$html .= '<h3>Risks to Human and Animal Health</h3><div class="content"><p>It is unhealthy for humans, pets, and wildlife to drink or come in contact with surface or groundwater contaminated with wastewater.  Inadequate treatment of wastewater allows bacteria, viruses, and other disease-causing pathogens to enter surface and groundwater. Hepatitis, dysentery, and other diseases may result from pathogens in drinking water. Disease-causing organisms may make lakes or streams unsafe for recreation. Flies and mosquitoes that are attracted to and breed in wet areas where wastewater reaches the surface may also spread disease.</p><p>Inadequate treatment of wastewater can raise the nitrate levels in groundwater. High concentrations of nitrate in drinking water are a special risk to infants. Nitrate affects the ability of an infant’s blood to carry oxygen, a condition called methemoglobinemia (blue-baby syndrome).</p></div>';
$html .= '<h3>Risks to the Environment</h3><div class="content"><p>A septic system that fails to fully treat wastewater also allows excess nutrients (phosphorus and nitrogen) to reach nearby lakes and streams, promoting algae and plant growth. Algal blooms and abundant weeds may make the lake unpleasant for swimming and boating, and can affect water quality for fish and wildlife habitat. 
Many synthetic cleaning products, pharmaceuticals, and other chemicals used in the house can be toxic to humans, pets, and wildlife. If allowed to enter a septic system, these products may reach groundwater or nearby surface water.</p></div>';
$html .= '<h3>Treatment Options</h3><div class="content"><p>There are two primary methods to treat and disperse wastewater back into the environment – centralized and decentralized.  It is easy to describe a centralized approach to wastewater management – all the community’s wastewater drains to a common collection network and is transferred to a centralized treatment and disposal facility.  With a decentralized approach, the wastewater treatment infrastructure is distributed across a community. This may be accomplished by building individual onsite septic systems, having small residential clusters of homes on shared systems, and/or by some combination of both to serve multiple wastewater management zones.  This guide will focus on YOUR decentralized septic system.</p><p><img class="right-image" src="'.WS_URL.'media/intro3.png">A properly designed, installed, operated and maintained septic system will provide economical and effective wastewater treatment.  Pathogens and solids are removed and destroyed by filtration and naturally occurring microscopic organisms. Nutrients are removed, absorbed by soil particles or taken up by plants.</p></div>';

$mpdf->Bookmark("I. Introduction",0);
$mpdf->WriteHTML($html,2);
$mpdf->AddPage();


//------Organization---------
$html = "";
$html .= "<h2>Organization of the System</h2>";
$html .= "<h3>Here is What We Know</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 1 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
} 

$html .= "<h3>Sources of Drinking Water</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 2 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$mpdf->WriteHTML($html,2);
$html = "";

$html .= "<h3>Additional Assistance & Disclaimer</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 3 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$mpdf->Bookmark("II. Organization of the System",0);
$mpdf->WriteHTML($html,2);
$mpdf->AddPage();

//-Wastewater Treatment System-
$html = "";
$html .= "<h2>Wastewater Treatment System</h2>";
$html .= "<h3>Wastewater Treatment System</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 4 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
} 

$html .= "<h3>Location</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 5 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$mpdf->Bookmark("III. The Wastewater Treatment System",0);
$mpdf->WriteHTML($html,2);
$mpdf->AddPage();

//----------Section 6------
$html = "";
$html .= "<h2>Expenses</h2>";
$html .= "<h3>Location</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 7 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$mpdf->Bookmark("IV. Expenses",0);
$mpdf->WriteHTML($html,2);
$mpdf->AddPage();

//-Wastewater Treatment Plumbing-
$html = "";
$html .= "<h2>V. Wastewater Treatment Plumbing</h2>";
$html .= "<h3>Wastewater Treatment Plumbing</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 8 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$html .= "<h3>Non Sewage Discharges</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 9 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$html .= "<h3>Water Treatment Devices</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 10 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$html .= "<h3>Access</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 11 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$html .= "<h3>Operation & Maintenance</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 12 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$mpdf->Bookmark("V. Wastewater Treatment Plumbing",0);
$mpdf->WriteHTML($html,2);
$mpdf->AddPage();

$html = "";
$html .= "<h2>Collection Types</h2>";

$html .= "<h3>Collection Types</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 13 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$html .= "<h3>Location</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 14 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}

$html .= "<h3>Operation & Maintenance</h3>";
$sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 15 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  while($answer = $result->fetch_assoc())
  {
    include(FS_PATH . "php/pdfTemplateOutputer.php");
  }
}


$mpdf->Bookmark("VI. Collection Types",0);
$mpdf->WriteHTML($html,2);
$mpdf->AddPage();

$html = "";
$sql = "Select question.hint, question.questionTitle, question.template, question.question, question.id, answer.answer from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 100000 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);
if($result->num_rows >= 1)
{
  $result = $result->fetch_assoc();
  $tmp = explode(";+;+;",$result['answer']);
  $result['answer'] = $tmp[1];
} 

$repTotal = $result['answer'];

if($repTotal > 0)
{

  $html .= "<h2>Holding Tanks</h2>";

  $sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 16 ORDER BY question.priority ASC, question.id ASC";

  $result = $database->query($sql);

  $ansArray = array();
  if($result->num_rows >= 1)
  {


      $answers = $result;
      $ii = 0;
      while($question = $answers->fetch_assoc())
      {
        $repArray = array();
        $i = 0;
        $answerArray = explode(";#;#;",$question['answer']);
        $fileArray = explode(";#;#;",$question['file']);

        while ($i < $repTotal)
        {
          $repArray[$i]['pdfOutput'] = $question['pdfOutput'];
          $repArray[$i]['file'] = $fileArray[$i];
          $repArray[$i]['questionTitle'] = $question['questionTitle'];
          $repArray[$i]['template'] = $question['template'];
          $repArray[$i]['answer'] = $answerArray[$i];
          $i++;
        }
        $ansArray[$ii] = $repArray;
        $ii++;
      }

    $tankNumber = 1;
    $repCount = 0;
    while($repCount < $repTotal)
    {
      $html .= "<h3>Holding Tank #".$tankNumber++."</h3>";
      foreach($ansArray as $ans)
      {
        $answer = array();
        $answer['questionTitle'] = $ans[$repCount]['questionTitle'];
        $answer['pdfOutput'] = $ans[$repCount]['pdfOutput'];
        $answer['answer'] = $ans[$repCount]['answer'];
        $answer['file'] = $ans[$repCount]['file'];
        $answer['template'] = $ans[$repCount]['template'];
    

     
        include(FS_PATH . "php/pdfTemplateOutputer.php");
       
        
      }
      $repCount++;
    }
  }

  $mpdf->WriteHTML($html,2);
  $mpdf->AddPage();
}

$repCount = 0;

$html = "";
$sql = "Select question.hint, question.questionTitle, question.template, question.question, question.id, answer.answer from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 100001 ORDER BY question.priority ASC, question.id ASC";
$result = $database->query($sql);
if($result->num_rows >= 1)
{
  $result = $result->fetch_assoc();
  $tmp = explode(";+;+;",$result['answer']);
  $result['answer'] = $tmp[1];
} 

$repTotal = $result['answer'];

if($repTotal > 0)
{

  $html .= "<h2>Grease Interceptors</h2>";

  $sql = "Select question.questionTitle, question.template, question.pdfOutput, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = $projectID WHERE question.category = 17 ORDER BY question.priority ASC, question.id ASC";

  $result = $database->query($sql);

  $ansArray = array();
  if($result->num_rows >= 1)
  {


      $answers = $result;
      $ii = 0;
      while($question = $answers->fetch_assoc())
      {
        $repArray = array();
        $i = 0;
        $answerArray = explode(";#;#;",$question['answer']);
        $fileArray = explode(";#;#;",$question['file']);

        while ($i < $repTotal)
        {
          $repArray[$i]['pdfOutput'] = $question['pdfOutput'];
          $repArray[$i]['file'] = $fileArray[$i];
          $repArray[$i]['questionTitle'] = $question['questionTitle'];
          $repArray[$i]['template'] = $question['template'];
          $repArray[$i]['answer'] = $answerArray[$i];
          $i++;
        }
        $ansArray[$ii] = $repArray;
        $ii++;
      }

    $tankNumber = 1;
    $repCount = 0;
    while($repCount < $repTotal)
    {
      $html .= "<h3>Grease Interceptor #".$tankNumber++."</h3>";
      foreach($ansArray as $ans)
      {
        $answer = array();
        $answer['questionTitle'] = $ans[$repCount]['questionTitle'];
        $answer['pdfOutput'] = $ans[$repCount]['pdfOutput'];
        $answer['answer'] = $ans[$repCount]['answer'];
        $answer['file'] = $ans[$repCount]['file'];
        $answer['template'] = $ans[$repCount]['template'];
    

     
        include(FS_PATH . "php/pdfTemplateOutputer.php");
       
        
      }
      $repCount++;
    }
  }

  $mpdf->WriteHTML($html,2);
  $mpdf->AddPage();
}

$repCount = 0;





$mpdf->Output();

