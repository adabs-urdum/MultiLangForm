<?php
		$regex = [];
		$aFehler = [];
		$sMail = '';

		if(is_dir('./../modules/MultiLangForm/regexPatterns.php')){
			require_once('./../modules/MultiLangForm/regexPatterns.php');
		}
		else if(is_dir($_SERVER['DOCUMENT_ROOT'].'/site/modules/MultiLangForm/regexPatterns.php')){
			require_once('./../modules/MultiLangForm/regexPatterns.php');
		}

		$sEmpfaenger = $_POST['mail'];
		$sBcc = $_POST['bcc'];
		$sBetreff = $_POST['betreff'];
		$sAbsender = $_POST['absender'];
		$aForm = $_POST['form'];
		$aRequired = $_POST['required'];

		if($user->language->name == 'default'){
			$aReturn['lang'] = $_POST['defLang'];
		}
		else{
			$aReturn['lang'] = $user->language->title;
		}

		foreach ($aForm as $key => $value) {
			$aForm[$value['name']] = htmlspecialchars($value['value']);
			unset($aForm[$key]);
		}

		if( empty($aForm['honeypot']) ){
			unset($aForm['honeypot']);

			foreach ($aForm as $PostKey => $PostValue) {
				foreach ($aRequired as $requiredKey => $requiredValue) {
					if($PostKey == $requiredKey){
						$PostKeyLower = strtolower($PostKey);
						if(array_key_exists($PostKeyLower, $regex)){
							if(!preg_match("/".$regex[$PostKeyLower]."/", $PostValue)||trim($PostValue)==''){
								$aFehler[$PostKey] = $PostKey;
							}
						}
					}
				}
			}

			if(count($aFehler)==0){

				$sBetreff	 = $sBetreff;
				
				$sMail .= '<table>';

				foreach ($aForm as $key => $value) {
					if($key != 'honeypot'){
						$sMail .= '<tr><td>'.ucfirst($key).': '.nl2br(wordwrap(htmlspecialchars($value),60)).'</td></tr>';
					}
				}
				
				$sMail .= '</table>';
			
				$sMail .= '<hr/><p>Das ist ein Automatisch generiertes Mail. Bitte nicht auf dieses Mail antworten!</p>';
				
				// Send
				$sHeader  = 'MIME-Version: 1.0' . "\r\n";
				$sHeader .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$sHeader .= 'From: ' .$sAbsender. "\r\n";
				$sHeader .= 'Bcc: ' . $sBcc . "\r\n";

				if(mail($sEmpfaenger, $sBetreff, $sMail, $sHeader)){
					$aReturn['mail'] = 1;
				}else{
					$aReturn['mail'] = 2;
				}
			}
			else{
				foreach ($aFehler as $key => $value) {
					$aReturn['mail'] = 0;
					// $aReturn['fail'] .= utf8_encode($value.'+');
					$aReturn['fail'] .= $value.'+';
				}	
			}
		}
		else{
			$aReturn['mail']   = 3;
			// $aReturn['fail'] = utf8_encode("TheHoneyPotCaughtYou".'<br>'."YouSneakyLittleBastard");
			$aReturn['fail'] = "TheHoneyPotCaughtYou".'<br>'."YouSneakyLittleBastard";
		}
		
		// $aReturn = array_map(utf8_encode, $aReturn);
		echo json_encode($aReturn);
?>