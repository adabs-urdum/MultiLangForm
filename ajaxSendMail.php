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

		require_once('./MultiLangFormMessages.php');

		$sEmpfaenger = $_POST['mail'];
		$sBcc = $_POST['bcc'];
		$sAbsender = $_POST['absender'];
		$aForm = $_POST['form'];
		$aRequired = $_POST['required'];
		$userLanguage = $_POST['userLanguage'];

		$aReturn['lang'] = $userLanguage;

		foreach ($aForm as $key => $value) {
			if(array_key_exists($value['name'], $aForm)){
				$aForm[$value['name']] .= htmlspecialchars($value['value']);
			}
			else{
				$aForm[$value['name']] = htmlspecialchars($value['value']);
			}
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

				$sBetreff = $message['subject'][$aReturn['lang']];

				if(array_key_exists('emailMessage', $message)){
					$sMail .= nl2br($message['emailMessage'][$aReturn['lang']]);
				}

				$sMail .= '<table>';

				foreach ($aForm as $key => $value) {
					if($key != 'honeypot'){
						$key = str_replace('[]', '', $key);
						$sMail .= '<tr><td>'.ucfirst($key).': '.nl2br(wordwrap(htmlspecialchars($value),60)).'</td></tr>';
					}
				}

				$sMail .= '</table>';

				if(array_key_exists('autoMessage', $message)){
					$sMail .= nl2br($message['autoMessage'][$aReturn['lang']]);
				}

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
