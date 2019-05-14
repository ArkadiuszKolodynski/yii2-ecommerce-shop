<?php

require_once realpath(dirname(__FILE__)) . '/../vendor/openpayu/openpayu/lib/openpayu.php';
//set Sandbox Environment
OpenPayU_Configuration::setEnvironment('sandbox');

//set POS ID and Second MD5 Key (from merchant admin panel)
OpenPayU_Configuration::setMerchantPosId('356910');
OpenPayU_Configuration::setSignatureKey('e20a5d5d09063b5c807f4675165589b4');

//set Oauth Client Id and Oauth Client Secret (from merchant admin panel)
OpenPayU_Configuration::setOauthClientId('356910');
OpenPayU_Configuration::setOauthClientSecret('324ea16355a271a3c1c08f5289eab0ce');
