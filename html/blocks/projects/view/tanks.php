<h2>Tanks</h2>


<?php
if(isset($_POST) && $_POST['submitted'] == 1)
{
//	print_r($_POST);
	if(isset($_POST['holding-check']) && $_POST['holding-check'] == "on")
	{

		$holdingNumber = $_POST['holding-number'];
		$holdingAlarm = $_POST['alarm'];
		$holdingLocation = $_POST['location'];
    $holdingMaterial = $_POST['holding-material'];
    $holdingCapacity = $_POST['holding-capacity'];
    if(isset($_POST['holding-alarm-visual']))
    {
      $holdingAlarmVisual = 1;
    } else
    {
      $holdingAlarmVisual = 0;
    }
    if(isset($_POST['holding-alarm-remote']))
    {
      $holdingAlarmRemote = 1;
    } else
    {
      $holdingAlarmRemote = 0;
    }
    if(isset($_POST['holding-alarm-audible']))
    {
      $holdingAlarmAudible = 1;
    } else
    {
      $holdingAlarmAudible = 0;
    }
		if(isset($_POST['answersId']) && $_POST['answersId'] != 0)
		{
			$projectid = $_POST['answersId'];
			$sql = "UPDATE answers_tanks SET holding='1', holding_number='$holdingNumber', holding_alarm='$holdingAlarm', holding_location_property='$holdingLocation', holding_material='$holdingMaterial', holding_capacity='$holdingCapacity', holding_alarm_visual=$holdingAlarmVisual, holding_alarm_remote=$holdingAlarmRemote, holding_alarm_audible=$holdingAlarmAudible WHERE projects_id='$projectID'";
//			echo $sql;
			$database->query($sql);
		} else 
		{
			echo "INSERT";
		}
	} else if(isset($_POST['answersId']) && $_POST['answersId'] != 0)
	{
		$projectid = $_POST['answersId'];
		$sql = "UPDATE answers_tanks SET holding='0' WHERE projects_id='$projectID'";
		$database->query($sql);
	}

}

$sql = "SELECT * FROM answers_tanks WHERE projects_id = $projectID";
$DBresult = $database->query($sql);

if($DBresult->num_rows >= 1)
{
	$answerData = $DBresult->fetch_assoc();
//	print_r($answerData);
	$holdingChecked = $answerData['holding'];
	$holdingNumber = $answerData['holding_number'];
	$holdingLocation = $answerData['holding_location'];
  $holdingMaterial = $answerData['holding_material'];
  $holdingCapacity = $answerData['holding_capacity'];
	$holdingAlarm = $answerData['holding_alarm'];
  $holdingAlarmVisual = $answerData['holding_alarm_visual'];
	$holdingLocationProperty = $answerData['holding_location_property'];
	$answersId = $answerData['id'];
}
?>
<form method="post" action="<?php echo WS_URL; ?>projects/view/<?php echo $projectID; ?>/tanks/" name="form">
<input type="checkbox" id="holding" <?php if($holdingChecked == 1) { echo "checked"; } ?> name="holding-check" /><label>Holding</label><br />
<div id="subquestion-holding" class="subquestion" <?php if($holdingChecked != 1) { echo 'style="display:none;"'; } ?>>
<label>Number</label><input type="text" name="holding-number" value="<?php echo $holdingNumber; ?>" /><br /><br />
<!--<label>Location</label><input type="file" name="holding-location-file" /><br />-->
<label for="location-on">On Property</label><input id="location-on" type="radio" name="location" <?php if($holdingLocationProperty == "On Property") { echo "checked"; } ?> value="On Property"><label for="location-off">Off Property</label><input id="location-off" type="radio" name="location" <?php if($holdingLocationProperty == "Off Property") { echo "checked"; } ?> value="Off Property"><label for="location-on-off">On & Off Property</label><input id="location-on-off" type="radio" name="location" <?php if($holdingLocationProperty == "On & Off Property") { echo "checked"; } ?> value="On & Off Property"><br /><br />

<label>Material</label><input type="text" name="holding-material" value="<?php echo $holdingMaterial; ?>" /><br />
<label>Capacity</label><input type="text" name="holding-capacity" value="<?php echo $holdingCapacity; ?>" /><br /><br />

<br /><br />Alarm<br />
<label for="alarm-no">No</label><input id="alarm-no" type="radio" name="alarm" value="No" <?php if($holdingAlarm == "No") { echo "checked"; } ?>><label for="alarm-yes">Yes</label><input id="alarm-yes" type="radio" name="alarm" value="Yes" <?php if($holdingAlarm == "Yes") { echo "checked"; } ?>><br />
<div id="alarm_more" <?php if($holdingAlarm != "Yes") { echo 'style="display:none;"'; }?>>
<label for="holding-alarm-remote">Remote</label><input type="checkbox" name="holding-alarm-remote" id="holding-alarm-remote" <?php if($holdingAlarmRemote) { echo "checked"; } ?>><label for="holding-alarm-audible">Audible</label><input type="checkbox" name="holding-alarm-audible" id="holding-alarm-audible" <?php if($holdingAlarmAudible) { echo "checked"; } ?>><label for="holding-alarm-visual">Visual</label><input type="checkbox" name="holding-alarm-visual" id="holding-alarm-visual" <?php if($holdingAlarmVisual) { echo "checked"; } ?>>

</div>
</div>
<input type="hidden" name="submitted" value="1">
<input type="hidden" name="answersId" value="<?php echo $answersId; ?>">
<input type="submit">
</form>

<!--
<h3>General</h3>
<label>Location</label><input type="text" /><br />
<label>On Property</label><input type="radio"><label>Off Property</label><input type="radio"><label>Combination</label><input type="radio"><br />
<label>Material</label><input type="text" /><br />
<label>Capacity</label><input type="text" /><br />
<h3>Alarm</h3>
<label>Yes</label><input type="radio"><label>No</label><input type="radio"><br />
<label>Location</label><input type="text" /><br />
<input type="checkbox" /><label>Remote</label><input type="checkbox" /><label>Audible</label><input type="checkbox" /><label>Visual</label><br />
<h3>Access</h3>
<input type="checkbox" /><label>Septic</label><br />
<input type="checkbox" /><label>Siphon</label><br />
<input type="checkbox" /><label>Pump</label><br />
<input type="checkbox" /><label>Trash trap</label><br />
<input type="checkbox" /><label>Flow equalization tank</label><br />
<input type="checkbox" /><label>Recirculation</label><br />
<input type="checkbox" /><label>Processing</label><br />
<input type="checkbox" /><label>Stilling / settling tank</label><br />
<input type="checkbox" /><label>Other</label><br />-->
