<?php
/** Profile Card template

	By Al_eXs

*/
require_once('Load.php');
global $scripturl,$user_profile,$staff,$sourcedir;


    for($lol = 0; $lol <= count($staff)-1; $lol++) {

        $loadedm = loadMemberData($staff[$lol], false, 'profile');

        echo '<div class="staff_card"><img src="' . $scripturl . '/../imgbb/staffback.png" />';
        echo '<a href="' . $scripturl . '?action=profile;u=' . $staff[$lol] . '">';

        if($user_profile[$staff[$lol]]['id_attach'] == 0) {
            echo '<img class="staff_avatar" src="' . $scripturl . '/../imgbb/bb.jpg" /></a>';
        } else {
            echo '<img class="staff_avatar" src="http://pruebasbb.backbeard.es/index.php?action=dlattach;attach=';
            echo $user_profile[$staff[$lol]]['id_attach'] . ';type=avatar" /></a>';
        }

        echo '<span class="staff_nick">' . $user_profile[$staff[$lol]]['member_name'] . '</span>';

//        if($status == "activo") {
            echo '<span class="staff_puesto">Puesto:<pre>' . $user_profile[$staff[$lol]]['options']['cust_puesto'] . '</pre></span></div>';
//        }
//        else {
//            echo '<span style="position:relative;top:-20px;font-size:10pt;margin-left:-105px;display:inline-block;width:110px;">';
//            echo 'Old Staff</span></div>';
//        }

//to see array values
//echo '<pre>';
//print_r($user_profile[$staff[$lol]]);
//echo'</pre>';
    }
?>
