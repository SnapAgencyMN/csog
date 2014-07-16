<?php
include(FS_PATH . "php/page.php");
?>
<div id="body_wrapper">
    <?php if ($path[1] != "admin") {?>
        <div id="nav_wrapper">
            <?php
            if ($path[1] != "" && $path[1] != "logout" && $path[1] != "help") {
                if (@$_SESSION['USER']['LoggedIn'] == true) {
                    echo "</ul>";
                    if ($path[1] == "projects" && @$path[2] == "view") {
                        require_once ("sectionsList.php");
                    } else {
                        $zip = getParameterString("zip");
                        $pname = getParameterString("pname");
                        $parcel = getParameterString('parcel');

                        if ($_SESSION['USER']['Admin']) 
                            echo "<a href='/admin/sections/edit'>Manage project's sections</a><br /> <br />";
    ?>
            <h2>Locate an Existing Project</h2>
            <p>Search here if you think a guide may have been created for this site.</p>

            <p>Search any or all of the following:</p>

            <form id="projectSearch" action="<?php echo WS_URL ?>projects/search/" method='POST'>
                <label for='zip'>Zip code</label>
                <input style='min-width: 200px' type='text' name='zip' value='<?php echo $zip ?>' />

                <label for='pname'>Project name</label>
                <input style='min-width: 200px' type='text' name='pname' value='<?php echo $pname ?>' />

                <label for='parcel'>Parcel ID</label>
                <input style='min-width: 200px' type='text' name='parcel' value='<?php echo $parcel ?>' />

                <br /><br />
                <input style='float:right' class='form-button' type="submit" value="Search" />

            </form>

    <?php
                    }
                }
            }

            if ($path[1] == "help")
            {
                if ($_SESSION["USER"]['Admin'])
                {
                    echo "<a href='".WS_URL."help/edit'>Manage Help Topics</a><br /><br />";
                }

                ?>
                <h2>Contact a Tool Administrator</h2>
                <form id="contact-form-projects" method="post">
                    <div id="contact-form-name-div"><label for="name">Name</label><input type="text" id="contact-form-name" name="name" value="<?php echo $_SESSION['USER']['Name']; ?>"/></div>
                    <div id="contact-form-email-div"><label for="email">Email</label><input type="email" id="contact-form-email" name="email" value="<?php echo $_SESSION['USER']['Email']; ?>" /></div>
                    <div id="contact-form-message-div"><label for="message">Message</label><textarea name="message" id="projects_message"></textarea></div>
                    <input type="submit" value="Send Email" id="projects_submit" class="form-button" />
                </form>
                <?php
            }
            ?>
        </div>
    <?php } ?>
    <div id="content_wrapper" <?php if ($path[1] == "admin" ) echo "style='border-left:0px; margin-left: 250px;'"?> >
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
        <?php if ($path[1] != "admin" ) {?><img id="droplet" src="/media/site-images/droplet.png" /><?php } ?>
    </div>
</div>
</div>
