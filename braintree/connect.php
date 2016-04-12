<?php
set_include_path(
  get_include_path() . PATH_SEPARATOR .
  realpath(dirname(__FILE__)) . '/lib'
);

$error='';

require_once "Braintree.php";

Braintree_Configuration::environment($environment);
Braintree_Configuration::merchantId($braintree_mtid);
Braintree_Configuration::publicKey($braintree_key);
Braintree_Configuration::privateKey($braintree_privatekey);