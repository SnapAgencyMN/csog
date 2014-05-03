<?php

$categoriesClass = new Categories($db);
$sectionsClass = new Sections($db);

$sectionID = getParameterNumber("sectionID");
$categoryID = getParameterNumber("categoryID");

require_once ("singleCategory.php");


