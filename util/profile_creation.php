<?php 

function getInputLine($type, $name, $placeholder, $value, $isRequired=FALSE) {
    $line = '<input type="' . $type . '" name="' . $name .
     '" placeholder="' . $placeholder . '" value="' . $value .
      '" ' . ($isRequired ? "required" : "") . "/>";
    if ($isRequired) {
        $line = "<strong>" . $line . "</strong>";
    }
    return $line;
}

function opt($optional){
    return $optional !== null ? $optional : "";
}

function profileCreationHTML(Display $display=null, $adminAdds=FALSE) {

    if ($display instanceof DisplayStudent or $adminAdds) {

        if ($adminAdds or $display === null) {
            $dflt = FALSE;
        } else {
            $dflt = TRUE;
        }
        $html = '<form class="form" action="" method ="post" >
        <h1>Student Profile Creation</h1>' .
        getInputLine("text", "first_name", "First Name", $dflt ? $display->getFirstName() : "", TRUE) .
        getInputLine("text", "last_name", "Last Name", $dflt ? $display->getLastName() : "", TRUE) .
        getInputLine("text", "preferred_name", "Preferred Name", $dflt ? $display->getPreferredName() : "") .
        getInputLine("text", "university", "University", $dflt ? $display->getUniversity() : "") .
        getInputLine("text", "primary_major", "Major", $dflt ? $display->getPrimMajor() : "", TRUE) .
        getInputLine("text", "secondary_major", "Secondary Major", $dflt ? $display->getSecMajor() : "") .
        getInputLine("text", "primary_minor", "Minor", $dflt ? $display->getPrimMinor() : "") .
        getInputLine("text", "secondary_minor", "Secondary Minor", $dflt ? $display->getSecMinor() : "") .
        getInputLine("text", "skills", "List Your Skills", $dflt ? $display->getSkills() : "", TRUE) .
        getInputLine('month" min="' . date("Y-m") . '" value="' . date("Y-m"),
            "graduation_date", "Graduation Month", $dflt ? $display->getGraduationMonthYearStr() : "", TRUE) .
        getInputLine("text", "link_extension", "Link Extension", $dflt ? $display->getLink() : "", TRUE) .
        '<input list="status" name="status" placeholder="Status" value="' . $dflt ? $display->getStatus() : "" 
            .'>' .
        $dflt ? '<input type="submit" name="submit" value="Create Profile">' :
                '<input type="submit" name="submit" value="Update Profile">';
        $html = $html . '</form>';
        return $html;
    } else {
        return "";
    }

}