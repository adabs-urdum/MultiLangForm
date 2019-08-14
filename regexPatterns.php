<?php

//Buchstaben (gross- und klein-) sowie - und _ sind erlaubt. Minimum zwei Zeichen.
$regex['name']		= '^[a-zA-Z\säüöÄÜÖ\-èéàÉÈÀÎîôÔ_]{2,40}$';

//Buchstaben (gross- und klein-) sowie - und _ sind erlaubt. Minimum zwei Zeichen.
$regex['vorname']	= '^[a-zA-Z\säüöÄÜÖ\-èéàÉÈÀÎîôÔ_]{2,40}$';
$regex['forename']	= $regex['vorname'];
$regex['firstname']	= $regex['vorname'];

//Buchstaben (gross- und klein-) sowie - und _ sind erlaubt. Minimum zwei Zeichen.
$regex['nachname']	= '^[a-zA-Z\säüöÄÜÖ\-èéàÉÈÀÎîôÔ_]{2,40}$';
$regex['surname']	= $regex['nachname'];

//Buchstaben ab einem Zeichen, gefolgt von einem @. Dann wieder Buchstaben, im Minimum 2 Zeichen. Dann folgt ein "." und zum Schluss wieder Buchstaben ab zwei Zeichen.
$regex['mail']		= '^[\.A-Za-zäüöÄÜÖ\-èéàÉÈÀÎîôÔ0-9_]{1,100}@[A-Za-zäüöÄÜÖ\-èéàÉÈÀÎîôÔ0-9_]{2,100}\.[a-zA-Z]{2,6}$';
$regex['Mail']		= $regex['mail'];
$regex['email']		= $regex['mail'];
$regex['Email']		= $regex['mail'];
$regex['e-mail']	= $regex['mail'];
$regex['E-Mail']	= $regex['mail'];

//Zahlen und Leerschläge ab fünf Zeichen.
$regex['tel']		= '^\+?[0-9-\s]{5,17}$';
$regex['phone']		= $regex['tel'];
$regex['mobile']	= $regex['tel'];
$regex['fax']		= $regex['tel'];
$regex['cell']		= $regex['tel'];

//Buchstaben, Zahlen, Leerschläge und Bindestriche sind erlaubt ab einem Zeichen.
$regex['str']		= '^[\.A-Za-z\s\-0-9öäüÖÄÜ0]{1,140}$';
$regex['strasse']	= $regex['str'];
$regex['street']	= $regex['str'];
$regex['ortplz']	= $regex['str'];

//Zahlen ab einer Stelle.
$regex['plz']		= '^[0-9]{1,}$';
$regex['PLZ']		= $regex['plz'];
$regex['ZIP']		= $regex['plz'];
$regex['zip']		= $regex['plz'];

//Buchstaben, Leerschläge, ab zwei Zeichen.
$regex['ort']		= '^[A-Za-z-öäüÖÄÜèéàÉÈÀÎîôÔ0\s]{2,50}$';

//Zahlen getrennt durch Bindestriche
$regex['datum']		= '^[0-3]{1}[0-9]{1}-[0-1]{1}[0-9]{1}-[0-9]{4}$';
$regex['date']		= $regex['datum'];

?>