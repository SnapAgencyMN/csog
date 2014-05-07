<?php
$sectionsClass = new Sections($db);

$sectionID = getParameterNumber("sectionID");
$categoryID = getParameterNumber("categoryID");

require_once ("singleCategory.php");


