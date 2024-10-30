<?php
/**
 * This file is part of miniOrange Login with Office 365 plugin.
 *
 * miniOrange Login with Office 365 plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * miniOrange Login with Office 365 plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with miniOrange Login with Office 365 plugin.  If not, see <http://www.gnu.org/licenses/>.
 */

include_once 'xmlseclibs.php';
use \RobRichards\XMLSecLibs\XMLSecurityKey;
use \RobRichards\XMLSecLibs\XMLSecurityDSig;
use \RobRichards\XMLSecLibs\XMLSecEnc;

class Mo_o365_Utilities {

    public static function generateID() {
        return '_' . self::stringToHex(self::generateRandomBytes(21));
    }

    public static function stringToHex($bytes) {
        $ret = '';
        for($i = 0; $i < strlen($bytes); $i++) {
            $ret .= sprintf('%02x', ord($bytes[$i]));
        }
        return $ret;
    }

    public static function generateRandomBytes($length, $fallback = TRUE) {

        return openssl_random_pseudo_bytes($length);
    }

    public static function createAuthnRequest($acsUrl, $issuer, $force_authn = 'false') {
        $requestXmlStr = '<?xml version="1.0" encoding="UTF-8"?>' .
                        '<samlp:AuthnRequest xmlns:samlp="urn:oasis:names:tc:SAML:2.0:protocol" ID="' . self::generateID() .
                        '" Version="2.0" IssueInstant="' . self::generateTimestamp() . '"';
        if( $force_authn == 'true') {
            $requestXmlStr .= ' ForceAuthn="true"';
        }
        $requestXmlStr .= ' ProtocolBinding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST" AssertionConsumerServiceURL="' . $acsUrl .
                        '" ><saml:Issuer xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion">' . $issuer . '</saml:Issuer></samlp:AuthnRequest>';
        $deflatedStr = gzdeflate($requestXmlStr);
        $base64EncodedStr = base64_encode($deflatedStr);
        $urlEncoded = urlencode($base64EncodedStr);
        update_option('MO_SAML_REQUEST',$base64EncodedStr);

        return $urlEncoded;
    }

	public static function createSAMLRequest($acsUrl, $issuer, $destination, $force_authn = 'false') {

		$requestXmlStr = '<?xml version="1.0" encoding="UTF-8"?>' .
		                 '<samlp:AuthnRequest xmlns:samlp="urn:oasis:names:tc:SAML:2.0:protocol" xmlns="urn:oasis:names:tc:SAML:2.0:assertion" ID="' . self::generateID() .
		                 '" Version="2.0" IssueInstant="' . self::generateTimestamp() . '"';
		if( $force_authn == 'true') {
			$requestXmlStr .= ' ForceAuthn="true"';
		}
		$requestXmlStr .= ' ProtocolBinding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST" AssertionConsumerServiceURL="' . $acsUrl .
		                  '" Destination="' . htmlspecialchars($destination) . '"><saml:Issuer xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion">' . $issuer . '</saml:Issuer><samlp:NameIDPolicy AllowCreate="true" Format="urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified"
                        /></samlp:AuthnRequest>';
        $samlRequest  = base64_encode($requestXmlStr);
        update_option('MO_SAML_REQUEST',$samlRequest);
        return $requestXmlStr;
	}

    public static function generateTimestamp($instant = NULL) {
        if($instant === NULL) {
            $instant = time();
        }
        return gmdate('Y-m-d\TH:i:s\Z', $instant);
    }

    public static function xpQuery(DOMNode $node, $query)
    {

        static $xpCache = NULL;

        if ($node instanceof DOMDocument) {
            $doc = $node;
        } else {
            $doc = $node->ownerDocument;
        }

        if ($xpCache === NULL || !$xpCache->document->isSameNode($doc)) {
            $xpCache = new DOMXPath($doc);
            $xpCache->registerNamespace('soap-env', 'http://schemas.xmlsoap.org/soap/envelope/');
            $xpCache->registerNamespace('saml_protocol', 'urn:oasis:names:tc:SAML:2.0:protocol');
            $xpCache->registerNamespace('saml_assertion', 'urn:oasis:names:tc:SAML:2.0:assertion');
            $xpCache->registerNamespace('saml_metadata', 'urn:oasis:names:tc:SAML:2.0:metadata');
            $xpCache->registerNamespace('ds', 'http://www.w3.org/2000/09/xmldsig#');
            $xpCache->registerNamespace('xenc', 'http://www.w3.org/2001/04/xmlenc#');
        }

        $results = $xpCache->query($query, $node);
        $ret = array();
        for ($i = 0; $i < $results->length; $i++) {
            $ret[$i] = $results->item($i);
        }

        return $ret;
    }

    public static function parseNameId(DOMElement $xml)
    {
        $ret = array('Value' => trim($xml->textContent));

        foreach (array('NameQualifier', 'SPNameQualifier', 'Format') as $attr) {
            if ($xml->hasAttribute($attr)) {
                $ret[$attr] = $xml->getAttribute($attr);
            }
        }

        return $ret;
    }

    public static function xsDateTimeToTimestamp($time)
    {
        $matches = array();

        
        $regex = '/^(\\d\\d\\d\\d)-(\\d\\d)-(\\d\\d)T(\\d\\d):(\\d\\d):(\\d\\d)(?:\\.\\d+)?Z$/D';
        if (preg_match($regex, $time, $matches) == 0) {
            echo sprintf("nvalid SAML2 timestamp passed to xsDateTimeToTimestamp: ".$time);
            exit;
        }

        
        $year   = intval($matches[1]);
        $month  = intval($matches[2]);
        $day    = intval($matches[3]);
        $hour   = intval($matches[4]);
        $minute = intval($matches[5]);
        $second = intval($matches[6]);

        
        $ts = gmmktime($hour, $minute, $second, $month, $day, $year);

        return $ts;
    }

    public static function extractStrings(DOMElement $parent, $namespaceURI, $localName)
    {
        $ret = array();
        for ($node = $parent->firstChild; $node !== NULL; $node = $node->nextSibling) {
            if ($node->namespaceURI !== $namespaceURI || $node->localName !== $localName) {
                continue;
            }
            $ret[] = trim($node->textContent);
        }

        return $ret;
    }

    public static function validateElement(DOMElement $root)
    {
        $objXMLSecDSig = new XMLSecurityDSig();
        $objXMLSecDSig->idKeys[] = 'ID';
        $signatureElement = self::xpQuery($root, './ds:Signature');

        if (count($signatureElement) === 0) {
            
            return FALSE;
        } elseif (count($signatureElement) > 1) {
            echo sprintf("XMLSec: more than one signature element in root.");
            exit;
        }

        $signatureElement = $signatureElement[0];
        $objXMLSecDSig->sigNode = $signatureElement;

        
        $objXMLSecDSig->canonicalizeSignedInfo();

       
        if (!$objXMLSecDSig->validateReference()) {
            echo sprintf("XMLsec: digest validation failed");
            exit;
        }

        
        $rootSigned = FALSE;
        
        foreach ($objXMLSecDSig->getValidatedNodes() as $signedNode) {
            if ($signedNode->isSameNode($root)) {
                $rootSigned = TRUE;
                break;
            } elseif ($root->parentNode instanceof DOMDocument && $signedNode->isSameNode($root->ownerDocument)) {
                
                $rootSigned = TRUE;
                break;
            }
        }

        if (!$rootSigned) {
            echo sprintf("XMLSec: The root element is not signed.");
            exit;
        }

        
        $certificates = array();
        foreach (self::xpQuery($signatureElement, './ds:KeyInfo/ds:X509Data/ds:X509Certificate') as $certNode) {
            $certData = trim($certNode->textContent);
            $certData = str_replace(array("\r", "\n", "\t", ' '), '', $certData);
            $certificates[] = $certData;
            
        }

        $ret = array(
            'Signature' => $objXMLSecDSig,
            'Certificates' => $certificates,
            );

        


        return $ret;
    }

    public static function validateSignature(array $info, XMLSecurityKey $key)
    {
        $objXMLSecDSig = $info['Signature'];

        $sigMethod = self::xpQuery($objXMLSecDSig->sigNode, './ds:SignedInfo/ds:SignatureMethod');
        if (empty($sigMethod)) {
            echo sprintf('Missing SignatureMethod element');
            exit();
        }
        $sigMethod = $sigMethod[0];
        if (!$sigMethod->hasAttribute('Algorithm')) {
            echo sprintf('Missing Algorithm-attribute on SignatureMethod element.');
            exit;
        }
        $algo = $sigMethod->getAttribute('Algorithm');

        if ($key->type === XMLSecurityKey::RSA_SHA1 && $algo !== $key->type) {
            $key = self::castKey($key, $algo);
        }

        
        if (! $objXMLSecDSig->verify($key)) {
            echo sprintf('Unable to validate Sgnature');
            exit;
        }
    }

    public static function castKey(XMLSecurityKey $key, $algorithm, $type = 'public')
    {
        if ($key->type === $algorithm) {
            return $key;
        }

        $keyInfo = openssl_pkey_get_details($key->key);
        if ($keyInfo === FALSE) {
            echo sprintf('Unable to get key details from XMLSecurityKey.');
            exit;
        }
        if (!isset($keyInfo['key'])) {
            echo sprintf('Missing key in public key details.');
            exit;
        }

        $newKey = new XMLSecurityKey($algorithm, array('type'=>$type));
        $newKey->loadKey($keyInfo['key']);

        return $newKey;
    }

    public static function processResponse($currentURL, $certFingerprint, $signatureData,
        Mo_o365_SAML2_Response $response, $certNumber,$relayState) {

        $assertion = current($response->getAssertions());

        $notBefore = $assertion->getNotBefore();
        if ($notBefore !== NULL && $notBefore > time() + 60) {
            wp_die('Received an assertion that is valid in the future. Check clock synchronization on IdP and SP.');
        }

        $notOnOrAfter = $assertion->getNotOnOrAfter();
        if ($notOnOrAfter !== NULL && $notOnOrAfter <= time() - 60) {
            wp_die('Received an assertion that has expired. Check clock synchronization on IdP and SP.');
        }

        $sessionNotOnOrAfter = $assertion->getSessionNotOnOrAfter();
        if ($sessionNotOnOrAfter !== NULL && $sessionNotOnOrAfter <= time() - 60) {
            wp_die('Received an assertion with a session that has expired. Check clock synchronization on IdP and SP.');
        }

        
        $msgDestination = $response->getDestination();
        if(substr($msgDestination, -1) == '/') {
            $msgDestination = substr($msgDestination, 0, -1);
        }
        if(substr($currentURL, -1) == '/') {
            $currentURL = substr($currentURL, 0, -1);
        }

        if ($msgDestination !== NULL && $msgDestination !== $currentURL) {
            echo sprintf('Destination in response doesn\'t match the current URL. Destination is "' .
                $msgDestination . '", current URL is "' . $currentURL . '".');
            exit;
        }

        $responseSigned = self::checkSign($certFingerprint, $signatureData, $certNumber,$relayState);

       
        return $responseSigned;
    }

    public static function checkSign($certFingerprint, $signatureData, $certNumber, $relayState) {
        $certificates = $signatureData['Certificates'];

        if (count($certificates) === 0) {
            $storedCerts = maybe_unserialize(get_option('saml_x509_certificate'));
            $pemCert = $storedCerts[$certNumber];
        }else{
            $fpArray = array();
            $fpArray[] = $certFingerprint;
            $pemCert = self::findCertificate($fpArray, $certificates, $relayState);
            if($pemCert==false)
                return false;
        }

        $lastException = NULL;

        $key = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type'=>'public'));
        $key->loadKey($pemCert);

        try {
            
            self::validateSignature($signatureData, $key);
            return TRUE;
        } catch (Exception $e) {
            $lastException = $e;
        }


        
        if ($lastException !== NULL) {
            throw $lastException;
        } else {
            return FALSE;
        }

    }

    public static function validateIssuerAndAudience($samlResponse, $spEntityId, $issuerToValidateAgainst, $relayState) {
        $issuer = current($samlResponse->getAssertions())->getIssuer();
        $assertion = current($samlResponse->getAssertions());
        $audiences = $assertion->getValidAudiences();
        if(strcmp($issuerToValidateAgainst, $issuer) === 0) {
            if(!empty($audiences)) {
                if(in_array($spEntityId, $audiences, TRUE)) {
                    return TRUE;
                } else {
                    if($relayState=='testValidate'){
                    
					$Error_message=Mo_o365_options_error_constants::Error_invalid_audience;
					$Cause_message = Mo_o365_options_error_constants::Cause_invalid_audience;
                    echo '<div style="font-family:Calibri;padding:0 3%;">';
                    echo '<div style="color: #a94442;background-color: #f2dede;padding: 15px;margin-bottom: 20px;text-align:center;border:1px solid #E6B3B2;font-size:18pt;"> ERROR</div>
                    <div style="color: #a94442;font-size:14pt; margin-bottom:20px;"><p><strong>Error: </strong>'.$Error_message.'</p>
                    
                    <p><strong>Possible Cause: </strong>'.$Cause_message.'</p>
                    <p>Expected one of the Audiences to be: '.$spEntityId.'<p>
                    </div>';
                    mo_o365_saml_download_logs($Error_message,$Cause_message);
                    exit;
                }
                else
                {
                    wp_die("We could not sign you in. Please contact your administrator","Error: Invalid Audience URI");
                }
                }
            }
        } else {
            if($relayState=='testValidate'){

	            $Error_message=Mo_o365_options_error_constants::Error_issuer_not_verfied;
	            $Cause_message = Mo_o365_options_error_constants::Cause_issuer_not_verfied;
                echo '<div style="font-family:Calibri;padding:0 3%;">';
                echo '<div style="color: #a94442;background-color: #f2dede;padding: 15px;margin-bottom: 20px;text-align:center;border:1px solid #E6B3B2;font-size:18pt;"> ERROR</div>
                <div style="color: #a94442;font-size:14pt; margin-bottom:20px;text-align: justify"><p><strong>Error:'.$Error_message.' </strong></p>
                
                <p><strong>Possible Cause:'.$Cause_message.' </strong></p>
                <p><strong>Entity ID in SAML Response: </strong>'.$issuer.'<p>
                <p><strong>Entity ID Configured in the plugin: </strong>'.$issuerToValidateAgainst.'</p>
                </div>
                </div>';

	            mo_o365_saml_download_logs($Error_message,$Cause_message);
                 exit;
        }
         else
                {
                    wp_die("We could not sign you in. Please contact your administrator","Error: Issuer cannot be verified");
                }
    }
}

    private static function findCertificate(array $certFingerprints, array $certificates, $relayState) {

        $candidates = array();

        
            $fp = strtolower(sha1(base64_decode($certificates[0])));
            if (!in_array($fp, $certFingerprints, TRUE)) {
                $candidates[] = $fp;
                return false;
                
            }

            
            $pem = "-----BEGIN CERTIFICATE-----\n" .
                chunk_split($certificates[0], 64) .
                "-----END CERTIFICATE-----\n";

            return $pem;
      
    }

    /**
     * Decrypt an encrypted element.
     *
     * This is an internal helper function.
     *
     * @param  DOMElement     $encryptedData The encrypted data.
     * @param  XMLSecurityKey $inputKey      The decryption key.
     * @param  array          &$blacklist    Blacklisted decryption algorithms.
     * @return DOMElement     The decrypted element.
     * @throws Exception
     */
    private static function doDecryptElement(DOMElement $encryptedData, XMLSecurityKey $inputKey, array &$blacklist)
    {
        $enc = new XMLSecEnc();
        $enc->setNode($encryptedData);

        $enc->type = $encryptedData->getAttribute("Type");
        $symmetricKey = $enc->locateKey($encryptedData);
        if (!$symmetricKey) {
            echo sprintf('Could not locate key algorithm in encrypted data.');
            exit;
        }

        $symmetricKeyInfo = $enc->locateKeyInfo($symmetricKey);
        if (!$symmetricKeyInfo) {
            echo sprintf('Could not locate <dsig:KeyInfo> for the encrypted key.');
            exit;
        }
        $inputKeyAlgo = $inputKey->getAlgorith();
        if ($symmetricKeyInfo->isEncrypted) {
            $symKeyInfoAlgo = $symmetricKeyInfo->getAlgorith();
            if (in_array($symKeyInfoAlgo, $blacklist, TRUE)) {
                echo sprintf('Algorithm disabled: ' . var_export($symKeyInfoAlgo, TRUE));
                exit;
            }
            if ($symKeyInfoAlgo === XMLSecurityKey::RSA_OAEP_MGF1P && $inputKeyAlgo === XMLSecurityKey::RSA_1_5) {
                
                $inputKeyAlgo = XMLSecurityKey::RSA_OAEP_MGF1P;
            }
            
            if ($inputKeyAlgo !== $symKeyInfoAlgo) {
                echo sprintf( 'Algorithm mismatch between input key and key used to encrypt ' .
                    ' the symmetric key for the message. Key was: ' .
                    var_export($inputKeyAlgo, TRUE) . '; message was: ' .
                    var_export($symKeyInfoAlgo, TRUE));
                exit;
            }
            
            $encKey = $symmetricKeyInfo->encryptedCtx;
            $symmetricKeyInfo->key = $inputKey->key;
            $keySize = $symmetricKey->getSymmetricKeySize();
            if ($keySize === NULL) {
                
                echo sprintf('Unknown key size for encryption algorithm: ' . var_export($symmetricKey->type, TRUE));
                exit;
            }
            try {
                $key = $encKey->decryptKey($symmetricKeyInfo);
                if (strlen($key) != $keySize) {
                    echo sprintf('Unexpected key size (' . strlen($key) * 8 . 'bits) for encryption algorithm: ' .
                        var_export($symmetricKey->type, TRUE));
                    exit;
                }
            } catch (Exception $e) {
                
                $encryptedKey = $encKey->getCipherValue();
                $pkey = openssl_pkey_get_details($symmetricKeyInfo->key);
                $pkey = sha1(serialize($pkey), TRUE);
                $key = sha1($encryptedKey . $pkey, TRUE);
                
                if (strlen($key) > $keySize) {
                    $key = substr($key, 0, $keySize);
                } elseif (strlen($key) < $keySize) {
                    $key = str_pad($key, $keySize);
                }
            }
            $symmetricKey->loadkey($key);
        } else {
            $symKeyAlgo = $symmetricKey->getAlgorith();
            
            if ($inputKeyAlgo !== $symKeyAlgo) {
                echo sprintf( 'Algorithm mismatch between input key and key in message. ' .
                    'Key was: ' . var_export($inputKeyAlgo, TRUE) . '; message was: ' .
                    var_export($symKeyAlgo, TRUE));
                exit;
            }
            $symmetricKey = $inputKey;
        }
        $algorithm = $symmetricKey->getAlgorith();
        if (in_array($algorithm, $blacklist, TRUE)) {
            echo sprintf('Algorithm disabled: ' . var_export($algorithm, TRUE));
            exit;
        }
        
        $decrypted = $enc->decryptNode($symmetricKey, FALSE);
        
        $xml = '<root xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion" '.
                     'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">' .
            $decrypted .
            '</root>';
        $newDoc = new DOMDocument();
        if (!@$newDoc->loadXML($xml)) {
            echo sprintf('Failed to parse decrypted XML. Maybe the wrong sharedkey was used?');
            throw new Exception('Failed to parse decrypted XML. Maybe the wrong sharedkey was used?');
        }
        $decryptedElement = $newDoc->firstChild->firstChild;
        if ($decryptedElement === NULL) {
            echo sprintf('Missing encrypted element.');
            throw new Exception('Missing encrypted element.');
        }

        if (!($decryptedElement instanceof DOMElement)) {
            echo sprintf('Decrypted element was not actually a DOMElement.');
        }

        return $decryptedElement;
    }

    /**
     * Decrypt an encrypted element.
     *
     * @param  DOMElement     $encryptedData The encrypted data.
     * @param  XMLSecurityKey $inputKey      The decryption key.
     * @param  array          $blacklist     Blacklisted decryption algorithms.
     * @return DOMElement     The decrypted element.
     * @throws Exception
     */
    public static function decryptElement(DOMElement $encryptedData, XMLSecurityKey $inputKey, array $blacklist = array(), XMLSecurityKey $alternateKey = NULL)
    {
        try {
            return self::doDecryptElement($encryptedData, $inputKey, $blacklist);
        } catch (Exception $e) {
            
            try {
                return self::doDecryptElement($encryptedData, $alternateKey, $blacklist);
            } catch(Exception $t) {

            }
            
            echo sprintf('Failed to decrypt XML element.');
            exit;
        }
    }

     /**
     * Generates the metadata of the SP based on the settings
     *
     * @param string    $sp            The SP data
     * @param string    $authnsign     authnRequestsSigned attribute
     * @param string    $wsign         wantAssertionsSigned attribute
     * @param DateTime  $validUntil    Metadata's valid time
     * @param Timestamp $cacheDuration Duration of the cache in seconds
     * @param array     $contacts      Contacts info
     * @param array     $organization  Organization ingo
     *
     * @return string SAML Metadata XML
     */
    public static function metadata_builder($siteUrl)
    {
        $xml = new DOMDocument();
        $url = plugins_url().'/miniorange-office-365-single-sign-on/sp-metadata.xml';

        $xml->load($url);

        $xpath = new DOMXPath($xml);
        $elements = $xpath->query('//md:EntityDescriptor[@entityID="http://{path-to-your-site}/wp-content/plugins/miniorange-saml-20-single-sign-on/"]');

         if ($elements->length >= 1) {
            $element = $elements->item(0);
            $element->setAttribute('entityID', $siteUrl.'/wp-content/plugins/miniorange-saml-20-single-sign-on/');
        }

        $elements = $xpath->query('//md:AssertionConsumerService[@Location="http://{path-to-your-site}"]');
        if ($elements->length >= 1) {
            $element = $elements->item(0);
            $element->setAttribute('Location', $siteUrl.'/');
        }

        
        $xml->save(plugins_url()."/miniorange-office-365-single-sign-on/sp-metadata.xml");
    }

    public static function get_mapped_groups($saml_params, $saml_groups)
    {
            $groups = array();

        if (!empty($saml_groups)) {
            $saml_mapped_groups = array();
            $i=1;
            while ($i < 10) {
                $saml_mapped_groups_value = $saml_params->get('group'.$i.'_map');

                $saml_mapped_groups[$i] = explode(';', $saml_mapped_groups_value);
                $i++;
            }
        }

        foreach ($saml_groups as $saml_group) {
            if (!empty($saml_group)) {
                $i = 0;
                $found = false;

                while ($i < 9 && !$found) {
                    if (!empty($saml_mapped_groups[$i]) && in_array($saml_group, $saml_mapped_groups[$i], TRUE)) {
                        $groups[] = $saml_params->get('group'.$i);
                        $found = true;
                    }
                    $i++;
                }
            }
        }

        return array_unique($groups);
    }

    public static function getEncryptionAlgorithm($method){
        switch($method){
            case 'http://www.w3.org/2001/04/xmlenc#tripledes-cbc':
                return XMLSecurityKey::TRIPLEDES_CBC;
                break;

            case 'http://www.w3.org/2001/04/xmlenc#aes128-cbc':
                return XMLSecurityKey::AES128_CBC;

            case 'http://www.w3.org/2001/04/xmlenc#aes192-cbc':
                return XMLSecurityKey::AES192_CBC;
                break;

            case 'http://www.w3.org/2001/04/xmlenc#aes256-cbc':
                return XMLSecurityKey::AES256_CBC;
                break;

            case 'http://www.w3.org/2001/04/xmlenc#rsa-1_5':
                return XMLSecurityKey::RSA_1_5;
                break;

            case 'http://www.w3.org/2001/04/xmlenc#rsa-oaep-mgf1p':
                return XMLSecurityKey::RSA_OAEP_MGF1P;
                break;

            case 'http://www.w3.org/2000/09/xmldsig#dsa-sha1':
                return XMLSecurityKey::DSA_SHA1;
                break;

            case 'http://www.w3.org/2000/09/xmldsig#rsa-sha1':
                return XMLSecurityKey::RSA_SHA1;
                break;

            case 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256':
                return XMLSecurityKey::RSA_SHA256;
                break;

            case 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha384':
                return XMLSecurityKey::RSA_SHA384;
                break;

            case 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha512':
                return XMLSecurityKey::RSA_SHA512;
                break;

            default:
                echo sprintf('Invalid Encryption Method: '.$method);
                exit;
                break;
        }
    }

    public static function sanitize_certificate( $certificate ) {
        $certificate = preg_replace("/[\r\n]+/", "", $certificate);
        $certificate = str_replace( "-", "", $certificate );
        $certificate = str_replace( "BEGIN CERTIFICATE", "", $certificate );
        $certificate = str_replace( "END CERTIFICATE", "", $certificate );
        $certificate = str_replace( " ", "", $certificate );
        $certificate = chunk_split($certificate, 64, "\r\n");
        $certificate = "-----BEGIN CERTIFICATE-----\r\n" . $certificate . "-----END CERTIFICATE-----";
        return $certificate;
    }

    public static function desanitize_certificate( $certificate ) {
        $certificate = preg_replace("/[\r\n]+/", "", $certificate);
        
        $certificate = str_replace( "-----BEGIN CERTIFICATE-----", "", $certificate );
        $certificate = str_replace( "-----END CERTIFICATE-----", "", $certificate );
        $certificate = str_replace( " ", "", $certificate );
        
        return $certificate;
    }

    public static function mo_o365_saml_wp_remote_post($url, $args = array()){
        $response = wp_remote_post($url, $args);
        if(!is_wp_error($response)){			
			return $response;
		} else {
            $show_message = new Mo_o365_mo_login();
            update_option('mo_saml_message', 'Unable to connect to the Internet. Please try again.');
            $show_message->mo_o365_saml_show_error_message();
        }
    }
    
    public static function mo_o365_saml_wp_remote_get($url, $args = array()){
		$response = wp_remote_get($url, $args);
		if(!is_wp_error($response)){			
			return $response;
		} else {
            $show_message = new Mo_o365_mo_login();
            update_option('mo_saml_message', 'Unable to connect to the Internet. Please try again.');
            $show_message->mo_o365_saml_show_error_message();
        }
    }
    
}
?>