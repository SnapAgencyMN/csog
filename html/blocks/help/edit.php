<?php

$helpCopyConnection = new HelpCopy($db);
$copyID = getParameterNumber("copyID");
$action = getParameterString("action", 'display-all');


if (!empty($action))
{
    if ($action == "save-copy")
    {
        $title = getParameterString("title");
        $body = getParameterString('body');
        $order = getParameterNumber("order");

        $helpCopyConnection->saveCopy($title, $body, $order, $copyID);
        
        $action = "display-all";
    }

    if ($action == "delete-copy")
    {
        $helpCopyConnection->deleteCopy($copyID);
        
        $action = "display-all";
    }
}
$entries = $helpCopyConnection->listAll();

if ($action == "display-all")
{
    echo "
        <div class='submenu'>
            <a href='/help/add'>Add new entry</a>
            <a style='margin-left:20px;' href='/help'>Back to list of entries</a>
        </div>
        <br />
    ";

    echo "
        <table>
            <thead>
                <tr>
                    <th scope='col'>Name</th>
                    <th scope='col'>Order</th>
                    <th scope='col'>Actions</th>
                </tr>
            </thead>
            <tbody>

        ";

    foreach ($entries as $entry)
    {
         echo " <tr>
                    <td>{$entry['title']}</td>
                    <td>{$entry['order']}</td>
                    <td>
                        <a href='/help/edit?copyID={$entry['id']}&amp;action=display-one'>Edit</a>
                        <a href='/help/edit?action=delete-copy&amp;copyID={$entry['id']}'>Delete</a>
                    </td>
                </tr>
            ";
    }

    echo "</tbody></table>";
}
elseif ($action == "display-one")
    require_once("singleCopy.php");