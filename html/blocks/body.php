<?php
include(FS_PATH . "php/page.php");
?>
<div id="body_wrapper">
    <div id="nav_wrapper">
        <?php
        if ($path[1] != "" && $path[1] != "logout") {
            if (@$_SESSION['USER']['LoggedIn'] == true) {
                echo "</ul>";
                if ($path[1] == "projects" && @$path[2] == "view") {
                    require_once ("sectionsList.php");
                } else if ($_SESSION['USER']['Admin']) {
                    echo "<a href='/admin/sections/edit'>Manage project's sections</a>";
                }
            }
        }
        ?>
    </div>

    <div id="content_wrapper">
        <?php
        include($page);
        if ($pageTwo != "") {
            $sectionTitle = $sectionTitleTwo;
            $catsIds = $catsIdsTwo;
            $catsTitles = $catsTitlesTwo;
            $page = $pageTwo;
            $nextPage = $nextPageTwo;
            include($page);
        }
        ?>
        <img id="droplet" src="/media/site-images/droplet.png" />
    </div>
</div>
</div>
