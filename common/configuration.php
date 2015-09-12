<?php

error_reporting(E_ALL);

/* Base Settings */
define("BASEURL","http://wadmin.florianalexandermoser.ch/");

define("DEFAULTDESCRIPTION","WAdmin, das vielfältige Verwaltungstool für KMU's und Vereine");
define("DEFAULTTITLE","WAdmin");
define("APPLICATION_TITLE","Personenverzeichnis");
define("AFTER_LOGIN_PAGE","persons");


/* Database */
define("DATABASE_HOST","floria74.mysql.db.internal");
define("DATABASE_NAME","floria74_usmg");
define("DATABASE_USER","floria74_usmg");
define("DATABASE_USER_PASSWORD","4YQflB1s");


/* Emails */
define("SERVER_EMAIL", "server@florianalexandermoser.ch");
define("SERVER_EMAIL_PASSWORD", "IJYKC7XO");

define("SERVER_EMAIL_RESPOND_EMAIL", "webmaster@knabenkantorei.ch");
define("SERVER_EMAIL_RESPOND_NAME", "Knabenkantorei Basel");

define("EMAIL_HOST", "asmtp.mail.hostpoint.ch");
define("EMAIL_SECURE", "tls");
define("EMAIL_PORT", 587);


/* Locale */
setlocale(LC_TIME, "de_CH.utf8");
define("LOCALE_DAYS_SER", serialize(array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag")));
define("LOCALE_DAYS_SHORT_SER", serialize(array("So", "Mo", "Di", "Mi", "Do", "Fr", "Sa")));
define("LOCALE_MONTHS_SER", serialize(array(1 => "Januar", 2 => "Februar", 3 => "März", 4 => "April", 5 => "Mai", 6 => "Juni", 7 => "Juli", 8 => "August", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Dezember")));


define("LOG_LEVEL_INFO", 1);
define("LOG_LEVEL_USER_ERROR", 2);
define("LOG_LEVEL_SYSTEM_ERROR", 3);


define("DATETIME_FORMAT_DATABASE", "Y-m-d H:i:s");
define("DATETIME_FORMAT_INPUT", "d.m.Y H:i");
define("DATETIME_FORMAT_DISPLAY", "d.m.Y H:i");

define("DATE_FORMAT_DATABASE", "Y-m-d");
define("DATE_FORMAT_INPUT", "Y-m-d");
define("DATE_FORMAT_DISPLAY", "d.m.Y");

define("TIME_FORMAT_DATABASE", "H:i:s");
define("TIME_FORMAT_INPUT", "H:i");
define("TIME_FORMAT_DISPLAY", "H:i");
