<?php

define("HTML_BLOCKS_DIR", "html/blocks/");

$page = "";
$pageTwo = "";
if ($_SESSION['USER']['LoggedIn'] == true) {
    switch ($path[1]) {
        case "test":
            $page = FS_PATH . HTML_BLOCKS_DIR . "projects/print/o&m/finalTreatment.php";

            break;
        case "about":
            $page = FS_PATH . HTML_BLOCKS_DIR . "about.php";
            break;
        case "account":
            $page = FS_PATH . HTML_BLOCKS_DIR . "about.php";
            switch ($path[2]) {
                case "edit":
                    $page = FS_PATH . HTML_BLOCKS_DIR . "account/modify.php";
                    break;
                default:
                    $page = FS_PATH . HTML_BLOCKS_DIR . "projects.php";
            }
            break;
        case "login":
            if ($_SESSION['USER']['LoggedIn'] == true) {
                $page = FS_PATH . HTML_BLOCKS_DIR . "home.php";
                break;
            }
            $page = FS_PATH . HTML_BLOCKS_DIR . "login.php";
            break;
        case "register":
            $page = FS_PATH . HTML_BLOCKS_DIR . "register.php";
            break;
        case "projects":
            switch ($path[2]) {
                case "new":
                    $page = FS_PATH . HTML_BLOCKS_DIR . "projects/edit.php";
                    break;
                case "delete":
                    $projectID = $path[3];
                    $page = FS_PATH . HTML_BLOCKS_DIR . "projects/delete.php";
                    break;
                case "edit":
                    $projectID = $path[3];
                    $page = FS_PATH . HTML_BLOCKS_DIR . "projects/edit.php";
                    break;
                case "clone":
                    $projectID = $path[3];
                    include( FS_PATH . "php/clone.php");
                    $page = FS_PATH . HTML_BLOCKS_DIR . "projects.php";
                    break;
                case "view":
                    $projectID = $path[3];
                    if(isset($path[4]))
                    {
                        if (strstr($path[4], "?"))
                            $sectionID = substr($path[4], 0, strpos($path[4], "?"));
                        else
                            $sectionID = $path[4];
                    }
                    else
                        $sectionID = 1;
                    
                    $page = FS_PATH . HTML_BLOCKS_DIR . "projects/view/sectionView.php";

                    break;
                default:
                    $page = FS_PATH . HTML_BLOCKS_DIR . "projects.php";
                    break;
            }
            break;
        case "admin":
            if ($_SESSION['USER']['Admin']) {
                switch ($path[2]) {
                    case "categories":
                            default:
                                $page = FS_PATH . HTML_BLOCKS_DIR . $_SERVER['REQUEST_URI'] . ".php";
                                
                                if (strstr($path[3], "edit?"))
                                    $page = FS_PATH . HTML_BLOCKS_DIR . "admin/categories/edit.php";
                                
                                if (strstr($path[3], "add?"))
                                    $page = FS_PATH . HTML_BLOCKS_DIR . "admin/categories/add.php";
                                
                                break;
                    case "sections":
                            default:
                                $page = FS_PATH . HTML_BLOCKS_DIR . $_SERVER['REQUEST_URI'] . ".php";
                                
                                if (strstr($path[3], "edit?"))
                                    $page = FS_PATH . HTML_BLOCKS_DIR . "admin/sections/edit.php";
                                
                                break;
                    case "questions":
                            default:
                                $page = FS_PATH . HTML_BLOCKS_DIR . $_SERVER['REQUEST_URI'] . ".php";
                                
                                if (strstr($path[3], "edit?"))
                                    $page = FS_PATH . HTML_BLOCKS_DIR . "admin/questions/edit.php";
                                
                                if (strstr($path[3], "add?"))
                                    $page = FS_PATH . HTML_BLOCKS_DIR . "admin/questions/add.php";
                                
                                break;
                    case "answers":
                            default:
                                $page = FS_PATH . HTML_BLOCKS_DIR . $_SERVER['REQUEST_URI'] . ".php";
                                
                                if (strstr($path[3], "edit?"))
                                    $page = FS_PATH . HTML_BLOCKS_DIR . "admin/answers/edit.php";
                                
                                if (strstr($path[3], "add?"))
                                    $page = FS_PATH . HTML_BLOCKS_DIR . "admin/answers/add.php";
                                
                                break;
                    default:
                        $page = FS_PATH . HTML_BLOCKS_DIR . ltrim($_SERVER['REQUEST_URI'], "/") . ".php";
                        break;
                }
            } else {
                $page = FS_PATH . HTML_BLOCKS_DIR . "home.php";
            }
            break;
        case "disclaimer":
            $page = FS_PATH . HTML_BLOCKS_DIR . "disclaimer.php";
            break;
        default:
            $page = FS_PATH . HTML_BLOCKS_DIR . "home.php";
            break;
    }
} else {
    switch ($path[1]) {
        case "logout":
            $page = FS_PATH . HTML_BLOCKS_DIR . "home.php";
            break;
        case "about":
            $page = FS_PATH . HTML_BLOCKS_DIR . "about.php";
            break;
        case "login":
            if ($_SESSION['USER']['LoggedIn'] == true) {
                $page = FS_PATH . HTML_BLOCKS_DIR . "home.php";
                break;
            }
            $page = FS_PATH . HTML_BLOCKS_DIR . "login.php";
            break;
        case "disclaimer":
            $page = FS_PATH . HTML_BLOCKS_DIR . "disclaimer.php";
            break;
        case "register":
            $page = FS_PATH . HTML_BLOCKS_DIR . "register.php";
            break;
        case "account":
            switch ($path[2]) {
                case "verify":
                    $verifyCode = $path[3];
                    $page = FS_PATH . HTML_BLOCKS_DIR . "account/verify.php";
                    break;
                case "reset":
                    $verifyCode = $path[3];
                    $page = FS_PATH . HTML_BLOCKS_DIR . "account/reset.php";
                    break;
                default:
                    $page = FS_PATH . HTML_BLOCKS_DIR . "login.php";
                    break;
            }
            break;
        default:
            $page = FS_PATH . HTML_BLOCKS_DIR . "home.php";
            break;
    }
}
