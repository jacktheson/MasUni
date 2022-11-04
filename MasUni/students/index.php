<?php
include '../../../util/info.php';
$query = "SELECT first_name, last_name, university, graduation_year, primary_major FROM USER_DATA";
$result = queryDatabase($query); 
if($result->num_rows > 0)
{
    while ($row = $result -> fetch_assoc())
    {
        echo $row["first_name"]. " ". $row["last_name"]. "<br>University: ". $row["university"]. 
        "<br>Graduation Year: ". $row["graduation_year"]. "<br>Major: ". $row["primary_major"];
	echo "<br><br>";
    }
}
else { echo "0 results found"; }
?>