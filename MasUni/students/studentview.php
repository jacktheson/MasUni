<?php
include 'info.php';
$query = "SELECT first_name, last_name, university, graduation, primary_major   FROM USER_DATA";
$result = queryDatabase($query); 
if($result -> num_rows > 0)
{
    while ($row = $result -> fetch_assoc())
    {
        echo "First Name: ". $row["first_name"]. "Last Name; ". $row["last_name"]. "University; ". $row["univesrity"]. "Graduation Year: ". $row["graduation_year"]. "Major". $row["[primary_major"];
    }
}
echo "0 results found";

?>  