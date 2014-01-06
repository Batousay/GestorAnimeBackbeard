<?php


$mail = mail("batousay@backbeard.es", "wahahahahahaahahahahaa","I like spamming your inbox!!!", "From: Backbeard<webmaster@backbeard.es");


if(!$mail){

echo 'mail is not sent!';

} else {

echo 'mail is sent :-)';

}


?>
