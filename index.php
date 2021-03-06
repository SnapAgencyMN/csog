<?php

require_once("config.php");
require_once("libs".DIRECTORY_SEPARATOR."utils.php");
require_once("libs".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."db.php");
require_once("libs".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."dbObj.php");
require_once("libs".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."sections.class.php");
require_once("libs".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."categories.class.php");
require_once("libs".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."questions.class.php");
require_once("libs".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."answers.class.php");
require_once("libs".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."helpCopy.class.php");
require_once("libs".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."projects.class.php");
require_once("libs".DIRECTORY_SEPARATOR."phpmailer".DIRECTORY_SEPARATOR."PHPMailerAutoload.php");
ini_set('max_execution_time', 120);
date_default_timezone_set('America/Chicago');

session_save_path(__DIR__."".DIRECTORY_SEPARATOR."temp");

if (DEBUG) {
    ini_set('display_errors', '1');
    //pr_out($_POST);
    //pr_out($_SERVER);
    //pr_out(get_included_files());
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
/*
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);
if ($database->connect_errno) {
    printf("Connect failed: %s\n", $database->connect_error);
    exit();
}
 */

$connectionInfo = array( "Database"=>DB_BASE, "UID"=>DB_USER, "PWD"=>DB_PASS);
$database = sqlsrv_connect( DB_HOST, $connectionInfo);
if (!$database) {
    die("Database connection failed: " . sqlsrv_errors());
}

$loginError = "";

if (!isset($_SESSION['USER']))
{
    // Instantiating session object so no warning are thrown
    $_SESSION['USER']['LoggedIn'] = "";
    $_SESSION['USER']['Admin'] = "";
    $_SESSION['USER']['Verbose'] = "";
    $_SESSION['USER']['Username'] = "";
    $_SESSION['USER']['ID'] = "";
    $_SESSION['USER']['Name'] = "";
    $_SESSION['USER']['Email'] = "";
    $_SESSION['USER']['CompanyName'] = "";
}

if (isset($_POST['user']) && isset($_POST['pass'])) {
    //$user = addslashes($_POST['user']);
    $user = str_replace("'", "''", $_POST['user']);
    
    //$pass = addslashes(sha1($_POST['pass']));
    $pass = str_replace("'", "''", sha1($_POST['pass']));

    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass' AND level > 0";
    $statement = sqlsrv_query($database, $sql);

    if (sqlsrv_has_rows($statement)) {
        $userData = sqlsrv_fetch_array($statement, SQLSRV_FETCH_ASSOC);

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
        
        header( 'Location: '.WS_URL.'projects' );
    }
    else
    {
        $loginError = "Username or password is incorrect. Please try again.";
    }
}

if (strstr($_SERVER['REQUEST_URI'], "/projects/print/"))
{
    $projectID = $path[3];

    require_once(FS_PATH . "html/blocks/projects/print/index.php");
    exit();
}

if (strstr($_SERVER['SCRIPT_NAME'], "ajaxHandler.php") == false)
{
    include(FS_PATH . "html".DIRECTORY_SEPARATOR."blocks".DIRECTORY_SEPARATOR."header.php");
    include(FS_PATH . "html".DIRECTORY_SEPARATOR."blocks".DIRECTORY_SEPARATOR."body.php");
    include(FS_PATH . "html".DIRECTORY_SEPARATOR."blocks".DIRECTORY_SEPARATOR."footer.php");
}
