<?php

require_once("config.php");
require_once("libs/utils.php");
require_once("libs/classes/db.php");
require_once("libs/classes/dbObj.php");
require_once("libs/classes/sections.class.php");
require_once("libs/classes/categories.class.php");
require_once("libs/classes/questions.class.php");
require_once("libs/classes/answers.class.php");

if (DEBUG) {
    ini_set('display_errors', '1');
    //pr_out($_POST);
}

@session_start();

$path = explode("/", $_SERVER['REQUEST_URI']);

if (isset($path[4])) {
    if ($path[4] == "print") {
        $projectID = $path[3];
        include(FS_PATH . "html/blocks/projects/view/print.php");
    }
}
if ($path[1] == "logout") {
    $_SESSION = array();
}

$dbInfo = array(
        "user" => DB_USER,
        "pass" => DB_PASS,
        "host" => DB_HOST,
        "name" => DB_BASE,
        "site" => "localhost"
    );
 
$db = new Db($dbInfo);
//$session = new Session();
$action = getParameterString("action");

$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);
if ($database->connect_errno) {
    printf("Connect failed: %s\n", $database->connect_error);
    exit();
}

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $user = $database->real_escape_string($_POST['user']);
    $pass = $database->real_escape_string(sha1($_POST['pass']));

    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass' AND level > 0";
    $DBresult = $database->query($sql);

    if ($DBresult->num_rows == 1) {
        $userData = $DBresult->fetch_assoc();

        if ($userData['level'] == 2) {
            $_SESSION['USER']['Admin'] = true;
        } else {
            $_SESSION['USER']['Admin'] = false;
        }

        if ($userData['verbose'] == "false") {
            $_SESSION['USER']['Verbose'] = false;
        } else {
            $_SESSION['USER']['Verbose'] = true;
        }

        $_SESSION['USER']['LoggedIn'] = true;

        $_SESSION['USER']['Username'] = $user;
        $_SESSION['USER']['ID'] = $userData['id'];
        $_SESSION['USER']['Name'] = $userData['name'];
        $_SESSION['USER']['Email'] = $userData['email'];
        $_SESSION['USER']['CompanyName'] = $userData['company_name'];
    }
}

if (strstr($_SERVER['REQUEST_URI'], "/projects/print/"))
{
    $projectID = $path[3];

    require_once(FS_PATH . "html/blocks/projects/print/index.php");
    exit();
}

if ($_SERVER['SCRIPT_NAME'] != "/ajaxHandler.php")
{
    include(FS_PATH . "html/blocks/header.php");
    include(FS_PATH . "html/blocks/body.php");
    include(FS_PATH . "html/blocks/footer.php");
}