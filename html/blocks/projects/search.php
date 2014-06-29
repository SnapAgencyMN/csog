<?php
    $projects = new Projects($db);
    
    $results = $projects->search($zip, $pname, $parcel);
    
    if (!empty($results))
    {
?>
<h2>Contact:</h2>
<p>The system you searched for has an Owner's Guide.</p>
<p>Contact the person(s) below to confirm it is the septic system you're looking for, and get more information.</p>
<p>If you see more than one professional listed below, it's because more than one project matches your search criteria.</p>
<br /><br />
<?php
        foreach ($results as $project)
        {
            echo "<p>{$project['contact_name']}</p>";
            echo "<p>{$project['contact_email']}</p>";
            echo "<p>{$project['contact_phone']}</p>";
            echo "<br /><br />";
        }
    }
    else
    {
?>
<h3>No matching record was found.</h3>
<p>Please check the accuracy of the information you entered.</p>
<p>If your search does not identify an existing project, then a system guide has not yet been created.</p>
<br />
<?php
    }
?>

<h3>Return to your existing projects.</h3>
<button class='form-button' onclick="javascript:window.location.href='<?php echo WS_URL ?>projects/';">Return</button>