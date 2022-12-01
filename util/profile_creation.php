<?php 

date_default_timezone_set("America/New_York");

function getInputLine($type, $name, $placeholder, $value, $isRequired=FALSE) {
    $line = '<label for="' . $name . '">' . $placeholder . ":&emsp;</label>";
    $line = $line . '<input type="' . $type . '" name="' . $name .
     '" placeholder="' . $placeholder . '" value="' . $value .
      '" ' . ($isRequired ? "required" : "") . "/>";
    if ($isRequired) {
        $line = "<strong>" . $line . "</strong>";
    }
    return $line;
}

function adminProfileCreationHTML(User $user=null){
    return profileCreationHTML($user, TRUE);
}

function selfProfileCreationHTML(User $user=null){
    return profileCreationHTML($user, FALSE);
}
function profileCreationHTML(User $user=null, $adminAdds) {

    if ($user instanceof UserStudent or $adminAdds) {
        $display = $user->getDisplay();
        $dflt = !($adminAdds or $display == null);
        $html = '<center><form class="form" action="" method ="post" > <h1>Student Profile Creation</h1>';       
        $html = $html . getInputLine("text", "first_name", "First Name", $dflt ? $display->getFirstName() : "", TRUE) .
                getInputLine("text", "last_name", "Last Name", $dflt ? $display->getLastName() : "", TRUE) .
                getInputLine("text", "preferred_name", "Preferred Name", $dflt ? $display->getPreferredName() : "") .
                "<br>" .
                getInputLine("text", "university", "University", $dflt ? $display->getUniversity() : "") .
                getInputLine("text", "primary_major", "Major", $dflt ? $display->getPrimMajor() : "", TRUE) .
                getInputLine("text", "secondary_major", "Secondary Major", $dflt ? $display->getSecMajor() : "") .
                "<br>" .
                getInputLine("text", "primary_minor", "Minor", $dflt ? $display->getPrimMinor() : "") .
                getInputLine("text", "secondary_minor", "Secondary Minor", $dflt ? $display->getSecMinor() : "") .
                "<br>" .
                getInputLine("text", "skills", "List Your Skills", $dflt ? $display->getSkills() : "", TRUE) .
                getInputLine('month" min="' . date("Y-m") . '" value="' . date("Y-m"),
                    "graduation_date", "Graduation Month", $dflt ? $display->getGraduationMonthYearStr() : "", TRUE) .
                "<br>" .
                getInputLine("text", "link_extension", "Link Extension", $dflt ? $display->getLink() : "", TRUE) .
                getInputLine("text", "status", "Status", $dflt ? $display->getStatus() : "") .
                "<br>";
        $html = $html . ($dflt ? '<input type="submit" name="submit" value="Update Profile">' :
                        '<input type="submit" name="submit" value="Create Profile">');
        $html = $html . '</form>';
        echo $html;
    } else {
        echo "";
    }

}