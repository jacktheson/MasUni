<?php

include '../../../util/info.php';
$query = "SELECT * FROM USER_DATA";
$result = queryDatabase($query); 
if($result->num_rows > 0)
{
    while ($row = $result -> fetch_assoc())
    {
        $studentDisplay = new DisplayStudent($row);
        $studentDisplay->toHTMLPreview();
    }
}
else { echo "0 results found"; }
