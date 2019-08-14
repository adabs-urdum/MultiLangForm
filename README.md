# ProcessWire MultiLangFrom
### Ein ProcessWire Modul, um mehrsprachige Formulare zu erzeugen.

## Dateien in diesem zip Ordner:
- _MultiLangFormExamples.txt - *Beispiele für das MultiLangFormBuilder Feld sowie auch das MultiLangFormLanguages Feld.*
- ajaxSendMail.php – ***Nicht verändern.*** *(In dieser Datei wird der Versand sowie das Regex ausgeführt.)*
- contact.template – ***Veränderbar.*** *Ein Beispiel für ein Kontakt-Template mit MultiLangForm Aufruf.*
- hourglass.svg – ***Nicht löschen.*** *Dies ist die Default Animation, wenn ein Formular verarbeitet wird.*
– MultiLangForm.module – ***Nicht verändern.*** *Das ist das Modul an sich. (Where the magic happens.)*
- MultiLangForm.template – ***Nicht verändern.*** *Beim installieren des Moduls wird ein Template aus dieser Datei erstellt.*
- MultiLangFormMessages.php – ***Veränderbar.*** *In dieser Datei werden die Rückmeldungen (Sendeerfolg, Sendefehler und Fehleingabe) in allen erforderlichen Sprachen erfasst.*
– regexPatterns.php –  ***Veränderbar.*** *Hier werden die Regex Zeilen erfasst. Die Bezeichnung der Sprache ['de']/['en'] bezieht sich im Backend auf den Name der Sprache, nicht auf Title!*

## Anleitung

- 0.1 Language Support Modul installieren

- 0.2 Language Support - Fields Modul installieren

- 0.3 Languages Support - Page Names Modul installieren

- 0.4 Erforderliche Sprachen hinzufügen. (Language-Title sowie Language-Name sollten gleich heissen und aus zwei Buchstaben bestehen. z.B. de, en, fr, it. Default ist unveränderbar.)

- 0.5 Im Backend die HOME/oberste Seite aufrufen.

- 0.6 Unter Settings die Namen der Sprachen für die url ersetzen. z.B. de, fr, it, fi, en.

- 1. MultiLangForm Modul installieren

- 1.1 Mit dem Installieren dieses Moduls werden automatisch zwei neue Felder (MultiLangFormBuilder und MultiLangFormLanguages), eine Seite (ajaxSendMail) und ein Template(MultiLangForm.php) installiert. Nichts davon löschen!

- 2. Die Felder MultiLangFormBuilder und MultiLangFormLanguages dem Template in dem das Formular angezeigt werden soll, zuweisen. (z.B. contact.template aus dem Modules/MultiLangForm kopieren und .template durch .php ersetzen und im Backend einfügen.)

- 3. Das Template einer Seite zuweisen / Seite erstellen mit entsprechendem Template.

- 4. Diese Seite im Backend öffnen.

- 5. MultiLangFormBuilder ist die Struktur des Formulars. In diesem Feld NUR DIE DEFAULT SPRACHE(erster Tab) AUSFÜLLEN!
	Beispiele für den Builder:
	```
	type=textarea, name=simpleTextarea, id=simpleTextarea, class=formInput, cols=20, rows=20;
	type=radio, name=simpleSex, id=GenderRadio, class=formInput;
	type=checkbox, name=simpleGender, id=GenderCheckbox, class=formInput;
	type=select, name=selectGender, id=GenderSelect, class=formInput;
	type=text, name=simpleText, id=simpleText, class=formInput, required=true;
	type=email, name=simpleEmail, id=simpleEmail, class=formInput;
	type=password, name=simplePass, id=simplePass, class=formInput, required=true;
	type=number, name=simpleNumber, id=simpleNumber, class=formInput, value=5;
	type=date, name=simpleDate, id=simpleDate, class=formInput, placeholder=05-12-1990;
	type=color, name=simpleColor, id=simpleColor, class=formInput;
	type=range, name=simpleRange, id=simpleRange, class=formInput, from=1, to=10;
	type=datetime, name=simpleDateTime, id=simpleDateTime, class=formInput;
	type=url, name=simpleUrl, id=simpleUrl, class=formInput, placeholder=www.example.com;
	type=button, name=simpleButton, id=simpleButton, class=formInput;
	type=submit, name=submit, id=submit, class=formInput;
	```

- 5.1 Alle Felder werden per regex geprüft! Für Felder die ein Requiredzeichen(*) brauchen, gibt man required=true im Builder ein.

- 6. MultiLangFormLanguages sind die zu übersetzenden Felder. z.B: label, value und values bei radio und checkbox
	Beispiele dafür:
	```
	id=simpleTextarea, label=Textfeld, value=Dies ist ein deutscher Text.;
	id=GenderRadio, label=Geschlecht Radio, values=m:w(checked):u;
	id=GenderCheckbox, label=Geschlecht Checkbox, values=m:w:u(checked);
	id=GenderSelect, label=Geschlecht Select, values=männlich:weiblich:unbestimmt;
	id=simpleText, label=Textfeld, placeholder=Dies ist ein Platzhalter;
	id=simpleEmail, label=Deine Mail, placeholder=my@mail.ch;
	id=simplePass, label=Passwort, value=meinPass;
	id=simpleNumber, label=Nummer;
	id=simpleDate, label=Datum;
	id=simpleColor, label=Farbe;
	id=simpleRange, label=Bereich;
	id=simpleDateTime, label=Datum Uhrzeit;
	id=simpleUrl, label=Webseite, placeholder=www.beispiel.ch;
	id=simpleButton, value=Knopf;
	id=submit, value=Senden;
	```

- 7. Template auf dem Server öffnen. (Falls die contact.template Kopie verwendet wurde, sind die Schritte bis und mit 12 bereits ausgeführt.)

- 8. `$MultiLangForm = new MultiLangForm();` einfügen um ein neues Formular zu erzeugen.

- 9. Oder mit individuellen Daten userInit setzen.
	 ```
	 $MultiLangForm->userInit = array(
		 'structure' 	  => $page->MultiLangFormBuilder,	//Hier kommt das Feld MultiLangFormBuilder hinein
		 'translation' 	  => $page->MultiLangFormLanguages,	//Hier kommt das Feld MultiLangFormLanguages hinein
		 'formId'		  => 'MultiLangForm',				//ID des <form> Tags für CSS
		 'breakLabel' 	  => false,							//setzt einen <br> nach jedem <label>
		 'honeyPot'		  => true,							//hängt ein Feld an das Formular mit der CSS Klasse hidden. Wenn ausgefüllt, wird das Formular nicht versendet
		 'wrap'			  => 'section',						//umrahmt <label> und <input> mit <section
		 'loader'		  => 'http://adabs.ch/site/assets/files/1284/thumbnail_img_0325_small.jpg',		//Pfad zum loader bild. Default ist die Sanduhr
		 'mail'			  => '',							//Mail Empfänger
		 'bcc'			  => '',							//Blind Copy Empfänger
		 'betreff'		  => 'your website has called',		//Mail Betreff
		 'absender'		  => '',							//Mail Absender
		 'defaultLanguage' => 'de',							//Default Language vom BackEnd
		 'requiredZeichen' => '*'							//Wird an das Label angefügt bei den required=true Feldern
	 );
	 ```

- 10. Formular ausgeben über $MultiLangForm->render();

- 11. Formular geniessen.
