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
        getInputLine("text", "FirstName", "First Name", $dflt ? $display->getFirstName() : "", TRUE) .
        getInputLine("text", "LastName", "Last Name", $dflt ? $display->getLastName() : "", TRUE) .
        getInputLine("text", "PreferredName", "Preferred Name", $dflt ? $display->getPreferredName() : "") .
        getInputLine("text", "University", "University", $dflt ? $display->getUniversity() : "") .
        getInputLine("text", "Major", "Major", $dflt ? $display->getPrimMajor() : "", TRUE) .
        getInputLine("text", "SecMajor", "Secondary Major", $dflt ? $display->getSecMajor() : "") .
        getInputLine("text", "Minor", "Minor", $dflt ? $display->getPrimMinor() : "") .
        getInputLine("text", "SecMinor", "Secondary Minor", $dflt ? $display->getSecMinor() : "") .
        getInputLine("text", "Skills", "List Your Skills", $dflt ? $display->getSkills() : "", TRUE) .
        getInputLine('month" min="' . date("Y-m") . '" value="' . date("Y-m"),
            "GradMonth", "Graduation Month", $dflt ? $display->getGraduationMonthYearStr() : "", TRUE) .
        getInputLine("text", "LinkExt", "Link Extension", $dflt ? $display->getLinkExtension() : "", TRUE) .
        $dflt ? '<input type="submit" name="submit" value="Profile-Create">' :
                '<input type="sybmit" name="submit" value="Profile-Update">';
        $html = $html . '</form>';
        return $html;
    } else {
        return "";
    }

}