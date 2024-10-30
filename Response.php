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

include 'Assertion.php';


class Mo_o365_SAML2_Response {
    
    private $assertions;
	private $destination;
	private $certificates;
	private $signatureData;

    /**
     * Constructor for Login with Office 365 response messages.
     *
     * @param DOMElement|NULL $xml The input message.
     */
    public function __construct(DOMElement $xml = NULL) {

        $this->assertions = array();
		$this->certificates = array();

        if ($xml === NULL) {
            return;
        }
		
		$sig = Mo_o365_Utilities::validateElement($xml);
		if ($sig !== FALSE) {
			$this->certificates = $sig['Certificates'];
			$this->signatureData = $sig;
		}
		
		
		if ($xml->hasAttribute('Destination')) {
            $this->destination = $xml->getAttribute('Destination');
        }
		
		for ($node = $xml->firstChild; $node !== NULL; $node = $node->nextSibling) {
			if ($node->namespaceURI !== 'urn:oasis:names:tc:SAML:2.0:assertion') {
				continue;
			}
			
			if ($node->localName === 'Assertion' || $node->localName === 'EncryptedAssertion') {
				$this->assertions[] = new Mo_o365_Assertion($node);
			}
			
		}
    }

    /**
     * Retrieve the assertions in this response.
     *
     * @return Mo_o365_Assertion[]|SAML2_EncryptedAssertion[]
     */
    public function getAssertions()
    {	
        return $this->assertions;
    }

    /**
     * Set the assertions that should be included in this response.
     *
     * @param Mo_o365_Assertion[]|SAML2_EncryptedAssertion[] The assertions.
     */
    public function setAssertions(array $assertions)
    {
        $this->assertions = $assertions;
    }
	
	public function getDestination()
    {
        return $this->destination;
    }

	public function getCertificates()
	{
		return $this->certificates;
	}

	public function getSignatureData()
	{
		return $this->signatureData;
	}
}