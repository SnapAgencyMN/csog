<?php 
$id = $_POST['question_delete_id'];
$sql = "DELETE FROM questions WHERE id = $id";
$database->query($sql);
