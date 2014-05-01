<?php

require_once('./templates.php');
require_once('../config.php');

$database = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_BASE);

$sql = "Select question.hint, question.questionTitle, question.template, question.question, question.id, answer.answer, answer.file from answers AS answer RIGHT OUTER JOIN questions AS question ON question.id = answer.questions_id && answer.project_id = {$_GET['pID']} WHERE question.id = {$_GET['qID']} ORDER BY question.priority ASC, question.id ASC";
    $result = $database->query($sql);
    if($result->num_rows >= 1)
    {
      while($question = $result->fetch_assoc())
      {
        
        switch ($question['template'])
        {
          case "OperationsTable":
            OperationsTableQTemplate($question['hint'],$question['questionTitle'],$question['question'],$question['id'],$question['answer'],$database);
            break;
        }
        
      }
    }


