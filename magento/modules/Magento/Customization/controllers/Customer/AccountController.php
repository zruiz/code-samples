<?php

// app/code/local/Magento/Customization/controllers/Customer/AccountController.php
 require_once 'Mage'.DS.'Customer'.DS.'controllers'.DS.'AccountController'
 class Magento_Customization_Customer_AccountController extends Mage_Core_Controller_Front_Action
 
 {
    
    public function createPostAction() {
	
	   if ($this->getRequest()->getParam('premium_cigars', false) || $this->getRequest()->getParam('machine_made', false)  || $this->getRequest()->getParam('little_cigars', false)) {
                
	    
        $email = $this->getRequest()->getParam('email', false);
        $fname = $this->getRequest()->getParam('firstname', false);
        $lname = $this->getRequest()->getParam('lastname', false);
        $gender = $this->getRequest()->getParam('gender', false);
        $dob = $this->getRequest()->getParam('dob', false);
        		
        if ($gender == 1) {
         $AttributeValue3 = 'on';
         $AttributeValue4 = 'off';
        }
        else {
          $AttributeValue3 = 'off';
          $AttributeValue4 = 'on';
          }
 
        if ($this->getRequest()->getParam('premium_cigars', false)) 
           $AttributeValue6 = 'on';
        else $AttributeValue6 = 'off';
		
		if ($this->getRequest()->getParam('machine_made', false)) 
           $AttributeValue7 = 'on';
        else $AttributeValue7 = 'off';
		
		if ($this->getRequest()->getParam('little_cigars', false)) 
           $AttributeValue8 = 'on';
        else $AttributeValue8 = 'off';
		
        //Listrak API Call **********************************************
        $WebServiceURL = 'http://webservices.listrak.com/v31/';
        $UserName = 'gothamc';
        $Password = 'lGotham12!';
        $ListID = 252501;
        $EmailAddress = $email;

        $AttributeID1 = 1496118;
        $AttributeValue1 = $fname;

        $AttributeID2 = 1496119;
        $AttributeValue2 = $lname;

        $AttributeID3 = 1496120;
        $AttributeID4 = 1496121;

        $AttributeID5 = 1496122;
        $AttributeValue5 = $dob;

        $AttributeID6 = 1496124;
		$AttributeID7 = 1496125;
        $AttributeID8 = 1496126;
        
		$ExternalEventIDs = '2640';
        $ProfileUpdateType = 'Append'; //See API Enumerations at end of document
        $OverrideUnsubscribe = true; //true/false
        //*********************************************************************************
        //Instantiate SOAP Client, headers, and set values to variables above
        $wsdl = "https://webservices.listrak.com/v31/IntegrationService.asmx?WSDL";
        $soapClient = new SoapClient($wsdl,
        array(
        'soap_version' => SOAP_1_2,
        'trace' => 1
        )
        );
        //Soap Request Header
        $auth = array('UserName'=>$UserName,'Password'=>$Password);
        $header = new SoapHeader('http://webservices.listrak.com/v31/', "WSUser", $auth);
        $soapClient->__setSoapHeaders(array($header));
        $WsContact= new ArrayObject();
        $WsContact->append(new SoapVar($ListID, XSD_INTEGER, null, $WebServiceURL, 'ListID', $WebServiceURL));
        $WsContact->append(new SoapVar($EmailAddress, XSD_STRING, null, $WebServiceURL, 'EmailAddress', $WebServiceURL));
        
		$WsAttribute = new stdClass;
        $WsAttribute->AttributeID = new SoapVar($AttributeID1, XSD_INTEGER, null, $WebServiceURL, 'AttributeID', $WebServiceURL);
        $WsAttribute->Value = new SoapVar($AttributeValue1, XSD_STRING, null, $WebServiceURL, 'Value', $WebServiceURL);
        $WsContactProfileAttribute = new SoapVar($WsAttribute, SOAP_ENC_OBJECT, null, $WebServiceURL, 'ContactProfileAttribute', $WebServiceURL);
        $WsContact->append($WsContactProfileAttribute);
        
		$WsAttribute = new stdClass;
        $WsAttribute->AttributeID = new SoapVar($AttributeID2, XSD_INTEGER, null, $WebServiceURL, 'AttributeID', $WebServiceURL);
        $WsAttribute->Value = new SoapVar($AttributeValue2, XSD_STRING, null, $WebServiceURL, 'Value', $WebServiceURL);
        $WsContactProfileAttribute = new SoapVar($WsAttribute, SOAP_ENC_OBJECT, null, $WebServiceURL, 'ContactProfileAttribute', $WebServiceURL);
        $WsContact->append($WsContactProfileAttribute);
        
		$WsAttribute = new stdClass;
        $WsAttribute->AttributeID = new SoapVar($AttributeID3, XSD_INTEGER, null, $WebServiceURL, 'AttributeID', $WebServiceURL);
        $WsAttribute->Value = new SoapVar($AttributeValue3, XSD_STRING, null, $WebServiceURL, 'Value', $WebServiceURL);
        $WsContactProfileAttribute = new SoapVar($WsAttribute, SOAP_ENC_OBJECT, null, $WebServiceURL, 'ContactProfileAttribute', $WebServiceURL);
        $WsContact->append($WsContactProfileAttribute);
		
		$WsAttribute = new stdClass;
        $WsAttribute->AttributeID = new SoapVar($AttributeID4, XSD_INTEGER, null, $WebServiceURL, 'AttributeID', $WebServiceURL);
        $WsAttribute->Value = new SoapVar($AttributeValue4, XSD_STRING, null, $WebServiceURL, 'Value', $WebServiceURL);
        $WsContactProfileAttribute = new SoapVar($WsAttribute, SOAP_ENC_OBJECT, null, $WebServiceURL, 'ContactProfileAttribute', $WebServiceURL);
        $WsContact->append($WsContactProfileAttribute);
		
		$WsAttribute = new stdClass;
        $WsAttribute->AttributeID = new SoapVar($AttributeID5, XSD_INTEGER, null, $WebServiceURL, 'AttributeID', $WebServiceURL);
        $WsAttribute->Value = new SoapVar($AttributeValue5, XSD_STRING, null, $WebServiceURL, 'Value', $WebServiceURL);
        $WsContactProfileAttribute = new SoapVar($WsAttribute, SOAP_ENC_OBJECT, null, $WebServiceURL, 'ContactProfileAttribute', $WebServiceURL);
        $WsContact->append($WsContactProfileAttribute);
		
		$WsAttribute = new stdClass;
        $WsAttribute->AttributeID = new SoapVar($AttributeID6, XSD_INTEGER, null, $WebServiceURL, 'AttributeID', $WebServiceURL);
        $WsAttribute->Value = new SoapVar($AttributeValue6, XSD_STRING, null, $WebServiceURL, 'Value', $WebServiceURL);
        $WsContactProfileAttribute = new SoapVar($WsAttribute, SOAP_ENC_OBJECT, null, $WebServiceURL, 'ContactProfileAttribute', $WebServiceURL);
        $WsContact->append($WsContactProfileAttribute);
        
		$WsAttribute = new stdClass;
        $WsAttribute->AttributeID = new SoapVar($AttributeID7, XSD_INTEGER, null, $WebServiceURL, 'AttributeID', $WebServiceURL);
        $WsAttribute->Value = new SoapVar($AttributeValue7, XSD_STRING, null, $WebServiceURL, 'Value', $WebServiceURL);
        $WsContactProfileAttribute = new SoapVar($WsAttribute, SOAP_ENC_OBJECT, null, $WebServiceURL, 'ContactProfileAttribute', $WebServiceURL);
        $WsContact->append($WsContactProfileAttribute);
		
		$WsAttribute = new stdClass;
        $WsAttribute->AttributeID = new SoapVar($AttributeID8, XSD_INTEGER, null, $WebServiceURL, 'AttributeID', $WebServiceURL);
        $WsAttribute->Value = new SoapVar($AttributeValue8, XSD_STRING, null, $WebServiceURL, 'Value', $WebServiceURL);
        $WsContactProfileAttribute = new SoapVar($WsAttribute, SOAP_ENC_OBJECT, null, $WebServiceURL, 'ContactProfileAttribute', $WebServiceURL);
        $WsContact->append($WsContactProfileAttribute);
		
		//Bundle the Profile Attribues together
        $WsContactCollection = new SoapVar($WsContact, SOAP_ENC_OBJECT, null, $WebServiceURL, 'WsContact');
        $SoapRequestBody = new stdClass;
        $SoapRequestBody->WSContact = $WsContactCollection;
        $SoapRequestBody->ProfileUpdateType = new SoapVar($ProfileUpdateType, XSD_STRING, null, $WebServiceURL, 'ProfileUpdateType');
        $SoapRequestBody->ExternalEventIDs = new SoapVar($ExternalEventIDs, XSD_STRING, null, $WebServiceURL, 'ExternalEventIDs');
        $SoapRequestBody->OverrideUnsubscribe = new SoapVar($OverrideUnsubscribe, XSD_BOOLEAN, null, $WebServiceURL, 'OverrideUnsubscribe');
        //Call and result
        try
        {
        $result = $soapClient->__soapCall('SetContact', array($SoapRequestBody));
         
        }
        catch (SoapFault $e) {
        
           print($e->getMessage());
          
        }
	}
	
	parent::createPostAction();
	
 }