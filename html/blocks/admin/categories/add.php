<?php

$categoriesTable = new DbObject($db, "question_categories", false);
$sectionsTable = new DbObject($db, "sections", false);


@$sectionID = (int) $_GET['sectionID'] > 0 ? (int) $_GET['sectionID'] : (int) $_POST['sectionID'];
@$categoryID = (int) $_GET['categoryID'] > 0 ? (int) $_GET['categoryID'] : (int) $_POST['categoryID'];

require_once ("singleCategory.php");


