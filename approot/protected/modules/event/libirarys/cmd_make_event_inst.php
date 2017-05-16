<?php
$arr = array(
'EventTryToFinishTask          ',
'EventFinishTask               ',
'EventPointsChange             ',
'EventLevelUp                  ',
'EventTryToLevelUp             ',
'EventCheckIn                  ',
'EventTryToCheckInNday         ',
'EventCheckInNday              ',
'EventRegister                 ',
'EventRegisterByInvite         ',
'EventTryToFinishInviteFriend  ',
'EventFinishInviteFriend       ',
'EventShare                    ',
'EventShareClicked             ',
'EventFillAvatar               ',
);
    $fileEventTest = 'EventTest.php';
    $fileTplContent = file_get_contents($fileEventTest);
foreach ($arr as $classname) {
    $classname = trim($classname);
    $filename = $classname.'.php';
    echo $filename.":\n";
    if (file_exists($filename)) {
        echo "exist!\n";
    }
    $fileContent = str_replace(array('EventTest'), array($classname), $fileTplContent);
    file_put_contents($filename, $fileContent);
}
