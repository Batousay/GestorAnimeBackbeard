<?php
/**********************************************************************************
* Settings.php                                                                    *
***********************************************************************************
* SMF: Simple Machines Forum                                                      *
* Open-Source Project Inspired by Zef Hemel (zef@zefhemel.com)                    *
* =============================================================================== *
* Software Version:           SMF 2.0 RC3                                         *
* Software by:                Simple Machines (http://www.simplemachines.org)     *
* Copyright 2006-2010 by:     Simple Machines LLC (http://www.simplemachines.org) *
*           2001-2006 by:     Lewis Media (http://www.lewismedia.com)             *
* Support, News, Updates at:  http://www.simplemachines.org                       *
***********************************************************************************
* This program is free software; you may redistribute it and/or modify it under   *
* the terms of the provided license as published by Simple Machines LLC.          *
*                                                                                 *
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
*                                                                                 *
* See the "license.txt" file for details of the Simple Machines license.          *
* The latest version can always be found at http://www.simplemachines.org.        *
**********************************************************************************/

########## Maintenance ##########
# Note: If $maintenance is set to 2, the forum will be unusable!  Change it to 0 to fix it.
#$mtitle = 'Modo de mantenimiento';		# Title for the Maintenance Mode message.
#$mmessage = 'En unos momentos volvemos, que no cunda el p�nico.';		# Description of why the forum is in maintenance mode.
$mtitle = 'Modo mantenimiento';
$mmessage = 'Dadnos 5 minutejos.';

########## Forum Info ##########
$mbname = 'Backbeard';		# The name of your forum.
$language = 'spanish_es-utf8';		# The default language file set for the forum.
$boardurl = 'CACA';		# URL to your forum's folder. (without the trailing /!)
$webmaster_email = 'CACA';		# Email address to send emails from. (like noreply@yourdomain.com.)
$cookiename = 'CACA';		# Name of the cookie to set for authentication.

########## Database Info ##########
$db_type = 'mysql';
$db_server = 'CACA';
$db_name = 'CACA';
$db_user = 'CACA';
$db_passwd = 'CACA';
$ssi_db_user = '';
$ssi_db_passwd = '';
$db_prefix = 'smf_';
$db_persist = '0';
$db_error_send = 0;

########## Directories/Files ##########
# Note: These directories do not have to be changed unless you move things.
$boarddir = '/home/CACA';		# The absolute path to the forum's folder. (not just '.'!)
$sourcedir = '/home/CACA';		# Path to the Sources directory.
$cachedir = '/home/CACA';		# Path to the cache directory.

########## Error-Catching ##########
# Note: You shouldn't touch these settings.
$db_last_error = 0;

# Make sure the paths are correct... at least try to fix them.
if (!file_exists($boarddir) && file_exists(dirname(__FILE__) . '/agreement.txt'))
	$boarddir = dirname(__FILE__);
if (!file_exists($sourcedir) && file_exists($boarddir . '/Sources'))
	$sourcedir = $boarddir . '/Sources';
if (!file_exists($cachedir) && file_exists($boarddir . '/cache'))
	$cachedir = $boarddir . '/cache';

$db_character_set = 'utf8';
$maintenance = '0';
?>
