<script>
    $(function() {
        $( "#helpAccordion" ).accordion({
            collapsible: true,
            active: false,
            heightStyle: "content"
        });
    });
</script>

<div id='helpAccordion'>
    <?php  
    $helpCopyConnection = new HelpCopy($db);
    $entries = $helpCopyConnection->listAll();

    foreach ($entries as $entry)
    {
        $body = str_replace("%SELF_URL%", "http://".$_SERVER['HTTP_HOST'], $entry['body']);
        
        echo "<h2 class='accordionHeader'>{$entry['title']}</h2>";
        echo "
            <div>
                $body 
            </div>
            ";
        echo "<br /><br />";
    }
    
    ?>
</div>
