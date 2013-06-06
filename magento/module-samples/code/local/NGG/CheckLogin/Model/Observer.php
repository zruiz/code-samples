<?php

/**
 * Magento Enterprise
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * package    NGG_CheckLogin
 * copyright  Copyright (c) 2013 Zaria Ruiz
 * license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/**
     * Fired on controller_action_predispatch event
     * Redirects every request but create account, forgot pass and reset pass to login page if customer session is not actived
     *
     * @param Varien_Event_Observer $observer
     */
	 
class NGG_CheckLogin_Model_Observer extends Varien_Object
{
    public function checkForLogin(Varien_Event_Observer $observer){
	  if (Mage::app()->getStore()->getId() == 2 ) {
        if(!Mage::getSingleton('customer/session')->isLoggedIn() && $observer->getControllerAction()->getFullActionName() != 'customer_account_login' && $observer->getControllerAction()->getFullActionName() != 'customer_account_create' && $observer->getControllerAction()->getFullActionName() != 'customer_account_forgotpassword' && $observer->getControllerAction()->getFullActionName() != 'customer_account_resetpassword') {
            Mage::app()->getResponse()->setRedirect(Mage::getUrl('customer/account/login'))->sendResponse();
        }
	  }
    }
}