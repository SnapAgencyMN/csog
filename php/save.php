<?php
require_once('../config.php');
function partition( $list, $p ) {
  $listlen = count( $list );
  $partlen = floor( $listlen / $p );
  $partrem = $listlen % $p;
  $partition = array();
  $mark = 0;
  for ($px = 0; $px < $p; $px++) {
    $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
    $partition[$px] = array_slice( $list, $mark, $incr );
    $mark += $incr;
  }
  return $partition;
}


$project_id = $_POST['pID'];
$question_id = $_POST['qID'];
$answer = "";

$repeater = (int) $_POST['repeatCount'];
//$values = implode($_POST['qData'],";&,&;");
//echo $values;
if ($repeater > 0)
{
  $chunkedQDataText = partition($_POST['qDataText'], $repeater);
  $chunkedQDataChecked = partition($_POST['qDataChecked'], $repeater);
  $answerCount = max(count($chunkedQDataText),count($chunkedQDataChecked));
  $compiledData = array();
  $i = 0;
  while($i < $answerCount)
  {
    $chunkedQDataText[$i] = implode($chunkedQDataText[$i],";&,&;");
    $chunkedQDataChecked[$i] = implode($chunkedQDataChecked[$i],";&,&;");
    $compiledData[$i] = $chunkedQDataChecked[$i].";+;+;".$chunkedQDataText[$i];
    $i++;
  }
  $answer = implode($compiledData,";#;#;");
} else
{

  $values[0] = implode($_POST['qDataChecked'],";&,&;");
  $values[1] = implode($_POST['qDataText'],";&,&;");
  $i = 0;
  while ($i < count($values))
  {
    if($values[$i] == "" || $values[$i] == null)
    {
      $values[$i] = "null";
    }
    $i++;
  }
  $answer = implode($values,";+;+;");
}

$sql_value = "";
$database = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_BASE);
$sql = "SELECT * FROM answers WHERE project_id=".$project_id." && questions_id=".$question_id;
$result = $database->query($sql);

if($result->num_rows >= 1)
{
  $sql = "UPDATE answers SET answer='$answer' WHERE questions_id=$question_id && project_id=$project_id";
} else
{
  $sql = "INSERT INTO answers (questions_id,project_id,answer) VALUES ('$question_id','$project_id','$answer');";
}

$database->query($sql);
$sql = "UPDATE projects SET date='". date('Y-m-d') ."' WHERE id=$project_id";
$database->query($sql);
//echo $sql."\n";

//print_r($_POST);
echo "Data!";
echo $sql . "\n\n";
print_r($answer);
print_r($_POST);
