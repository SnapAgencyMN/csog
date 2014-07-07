<?php
    $title = "";
    $body = "";
    $order = "";
    
    if ($copyID > 0)
    {
        $info = $helpCopyConnection->getDetails($copyID);
        
        $title = $info['title'];
        $body = $info['body'];
        $order = $info['order'];
        
    }

    echo "
        <h3> Entry details: </h3>
        <form action = '/help/edit' method='POST'>
            <table id='questionTable'>
                <thead>
                    <tr>
                        <th scope='col'>Title</th>
                        <th scope='col'>Body</th>
                        <th scope='col'>Order</th>
                    </tr>
                </thead>
        ";
    
        echo "
            <tbody>
                <tr>
                    <td><input type='text' id='title' name='title' value='$title' /></td>
                    <td>
                        <textarea name='body' cols='100' rows='30'>$body</textarea>
                    </td>
                    <td><input class='order' type='text' name='order' onclick='this.select();' value='$order' /></td>
                </tr>
            </tbody>
        ";

        echo "
                </table>
                <input style = 'margin-top: 10px;' type='submit' value='Submit' />
                <input type='hidden' name='action' value='save-copy' />
                <input type='hidden' name='copyID' value='$copyID' />
        ";
        
?>