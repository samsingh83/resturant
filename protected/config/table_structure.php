<?php
$prefix=$table_prefix;

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."user (
  `user_id` int(14) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 NOT NULL,
  `status` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT 'active',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `lang_id` int(14) NOT NULL,
  `user_type` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT 'admin',
  `user_access` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";


$tbl[]="CREATE TABLE IF NOT EXISTS ".$prefix."category (
  `cat_id` int(14) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `category_description` text CHARACTER SET utf8 NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` varchar(100) CHARACTER SET utf8 NOT NULL,
  `sequence` int(14) NOT NULL,
  `date_created` varchar(50) CHARACTER SET utf8 NOT NULL,
  `date_modified` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$tbl[]="CREATE TABLE IF NOT EXISTS ".$prefix."client (
  `client_id` int(14) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8 NOT NULL,
  `mobile` varchar(20) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `delivery_address` text CHARACTER SET utf8 NOT NULL,
  `delivery_instruction` text CHARACTER SET utf8 NOT NULL,
  `location_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `social_strategy` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT 'active',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  `delivery_date` datetime NOT NULL,
  `delivery_time` varchar(20) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."client_wishlist (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `client_id` int(14) NOT NULL,
  `item_id` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$tbl[]="CREATE TABLE IF NOT EXISTS ".$prefix."cooking_ref (
  `cook_id` int(14) NOT NULL AUTO_INCREMENT,
  `cooking_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sequence` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT 'published',
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`cook_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$tbl[]="CREATE TABLE IF NOT EXISTS ".$prefix."currency (
  `currency_code` varchar(3) CHARACTER SET utf8 NOT NULL,
  `currency_symbol` varchar(20) CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`currency_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."item (
  `item_id` int(14) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `item_description` text CHARACTER SET utf8 NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 NOT NULL,
  `category` text CHARACTER SET utf8 NOT NULL,
  `price` text CHARACTER SET utf8 NOT NULL,
  `subcat_item` text CHARACTER SET utf8 NOT NULL,
  `cooking_ref` text CHARACTER SET utf8 NOT NULL,
  `discount` varchar(14) CHARACTER SET utf8 NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sequence` int(14) NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  `multi_option_title` varchar(255) NOT NULL,
  `multi_option_number` int(14) NOT NULL,
  `multi_id` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."item_option (
  `option_id` int(14) NOT NULL AUTO_INCREMENT,
  `item_id` int(14) NOT NULL,
  `option_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `option_value` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."item_relationship (
  `item_id` int(14) NOT NULL,
  `cat_id` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."option (
  `option_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `option_value` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`option_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."order (
  `order_id` int(14) NOT NULL AUTO_INCREMENT,
  `client_id` int(14) NOT NULL,
  `json_order_details` text NOT NULL,
  `trans_type` varchar(100) NOT NULL DEFAULT 'delivery',
  `payment_type` varchar(100) NOT NULL,
  `total` float(14,2) NOT NULL,
  `tax` float(14,2) NOT NULL,
  `total_w_tax` float(14,2) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `viewed` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `set_tax` float NOT NULL,
  `delivery_charge` float NOT NULL,
  `stats_id` int(14) NOT NULL DEFAULT '4',
  `delivery_date` datetime NOT NULL,
  `delivery_time` varchar(20) NOT NULL,
  `voucher_code` varchar(50) NOT NULL,
  `voucher_amount` varchar(14) NOT NULL,
  `voucher_type` varchar(100) NOT NULL,
  `cc_id` int(14) NOT NULL,
  `pre_approved` int(5) NOT NULL,
  `date_modified` datetime NOT NULL,
  `pre_approved_time` varchar(255) NOT NULL,
  `delivery_asap` int(2) NOT NULL DEFAULT '1',
  `convenience_charge` float(14,5) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."order_details (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `client_id` int(14) NOT NULL,
  `item_id` int(14) NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `item_size` varchar(50) CHARACTER SET utf8 NOT NULL,
  `order_notes` text CHARACTER SET utf8 NOT NULL,
  `item_price` varchar(14) CHARACTER SET utf8 NOT NULL,
  `qty` int(14) NOT NULL,
  `cooking_ref` int(14) NOT NULL,
  `addon` text CHARACTER SET utf8 NOT NULL,
  `multi_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."paypal_checkout (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 NOT NULL,
  `paypal_request` text CHARACTER SET utf8 NOT NULL,
  `paypal_response` text CHARACTER SET utf8 NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'checkout',
  `date_created` datetime NOT NULL,
  `ip_address` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."paypal_payment (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `order_id` int(14) NOT NULL,
  `TOKEN` varchar(255) NOT NULL,
  `TRANSACTIONID` varchar(100) NOT NULL,
  `TRANSACTIONTYPE` varchar(100) NOT NULL,
  `PAYMENTTYPE` varchar(100) NOT NULL,
  `ORDERTIME` varchar(100) NOT NULL,
  `AMT` varchar(14) NOT NULL,
  `FEEAMT` varchar(14) NOT NULL,
  `TAXAMT` varchar(14) NOT NULL,
  `CURRENCYCODE` varchar(3) NOT NULL,
  `PAYMENTSTATUS` varchar(100) NOT NULL,
  `CORRELATIONID` varchar(100) NOT NULL,
  `TIMESTAMP` varchar(100) NOT NULL,
  `json_details` text NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."size (
  `size_id` int(14) NOT NULL AUTO_INCREMENT,
  `size_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sequence` int(14) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT 'published',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."subcategory (
  `subcat_id` int(14) NOT NULL AUTO_INCREMENT,
  `subcategory_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `subcategory_description` text CHARACTER SET utf8 NOT NULL,
  `discount` varchar(20) CHARACTER SET utf8 NOT NULL,
  `sequence` int(14) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`subcat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."subcategory_item (
  `sub_item_id` int(14) NOT NULL AUTO_INCREMENT,
  `sub_item_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `item_description` text CHARACTER SET utf8 NOT NULL,
  `category` varchar(255) CHARACTER SET utf8 NOT NULL,
  `price` varchar(15) CHARACTER SET utf8 NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sequence` int(14) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`sub_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."subcat_relationship (
  `subcat_id` int(14) NOT NULL,
  `sub_item_id` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";


$tbl[]="
CREATE TABLE IF NOT EXISTS `".$prefix."languages` (
  `lang_id` int(14) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(14) CHARACTER SET utf8 NOT NULL,
  `language_code` varchar(10) CHARACTER SET utf8 NOT NULL,
  `source_text` text CHARACTER SET utf8 NOT NULL,
  `is_assign` int(1) NOT NULL DEFAULT '2',
  `date_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

/*VERSION 1.0.3 ADDED TABLE*/
$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."sms_logs (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `provider` varchar(100) CHARACTER SET utf8 NOT NULL,
  `sms_message` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mobile` varchar(20) CHARACTER SET utf8 NOT NULL,
  `response` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."order_status (
  `stats_id` int(14) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`stats_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."events (
  `event_id` int(14) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` varchar(100) CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."pages (
  `page_id` int(14) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `page_icon` varchar(255) CHARACTER SET utf8 NOT NULL,
  `seo_title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `meta_description` varchar(156) CHARACTER SET utf8 NOT NULL,
  `meta_keywords` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `status` varchar(100) CHARACTER SET utf8 NOT NULL,
  `sequence` int(14) NOT NULL,
  `assign_menu` int(14) NOT NULL,
  `friendly_url` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";


/*VERSION 1.0.5 ADDED TABLE*/
$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."voucher (
  `voucher_id` int(14) NOT NULL AUTO_INCREMENT,
  `voucher_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `number_of_voucher` int(14) NOT NULL,
  `amount` float NOT NULL,
  `voucher_type` varchar(100) NOT NULL DEFAULT 'fixed amount',
  `status` varchar(100) CHARACTER SET utf8 NOT NULL,
  `date_created` varchar(50) CHARACTER SET utf8 NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`voucher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."voucher_list (
  `voucher_id` int(14) NOT NULL,
  `voucher_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'unused',
  `client_id` int(14) NOT NULL,
  `date_used` varchar(50) CHARACTER SET utf8 NOT NULL,
  `order_id` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."multi_options (
  `multi_id` int(14) NOT NULL AUTO_INCREMENT,
  `multi_name` varchar(255) NOT NULL,
  `sequence` int(14) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'published',
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  PRIMARY KEY (`multi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."client_cc (
  `cc_id` int(14) NOT NULL AUTO_INCREMENT,
  `client_id` int(14) NOT NULL,
  `card_name` varchar(255) NOT NULL,
  `credit_card_number` varchar(20) CHARACTER SET utf8 NOT NULL,
  `expiration_month` varchar(5) CHARACTER SET utf8 NOT NULL,
  `expiration_yr` varchar(5) CHARACTER SET utf8 NOT NULL,
  `cvv` varchar(20) CHARACTER SET utf8 NOT NULL,
  `billing_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`cc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";

$tbl[]="
CREATE TABLE IF NOT EXISTS ".$prefix."braintree_trans (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `payment_method` varchar(100) NOT NULL DEFAULT 'creditcard',
  `order_id` int(14) NOT NULL,
  `transaction_id` varchar(14) NOT NULL,
  `json_data` text NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

";

/*CURRENCY*/

$curr_data[]=array(
 'currency_code'=>"AUD",
 'currency_symbol'=>"&#36;",
 'date_created'=>date('c'),
 'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$curr_data[]=array(
 'currency_code'=>"CAD",
 'currency_symbol'=>"&#36;",
 'date_created'=>date('c'),
 'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$curr_data[]=array(
 'currency_code'=>"CNY",
 'currency_symbol'=>"&yen;",
 'date_created'=>date('c'),
 'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$curr_data[]=array(
 'currency_code'=>"EUR",
 'currency_symbol'=>"&euro;",
 'date_created'=>date('c'),
 'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$curr_data[]=array(
 'currency_code'=>"HKD",
 'currency_symbol'=>"&#36;",
 'date_created'=>date('c'),
 'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$curr_data[]=array(
 'currency_code'=>"JPY",
 'currency_symbol'=>"&yen;",
 'date_created'=>date('c'),
 'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$curr_data[]=array(
 'currency_code'=>"MXN",
 'currency_symbol'=>"&#36;",
 'date_created'=>date('c'),
 'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$curr_data[]=array(
 'currency_code'=>"MYR",
 'currency_symbol'=>"&#82;&#77;",
 'date_created'=>date('c'),
 'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$curr_data[]=array(
 'currency_code'=>"NZD",
 'currency_symbol'=>"&#36;",
 'date_created'=>date('c'),
 'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$curr_data[]=array(
 'currency_code'=>"USD",
 'currency_symbol'=>"&#36;",
 'date_created'=>date('c'),
 'ip_address'=>$_SERVER['REMOTE_ADDR']
);

/*ORDER STATUS*/
$order_stats[]=array(
  'description'=>"pending",
  //'date_created'=>date('c'),
  //'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$order_stats[]=array(
  'description'=>"cancelled",
  //'date_created'=>date('c'),
  //'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$order_stats[]=array(
  'description'=>"delivered",
  //'date_created'=>date('c'),
  //'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$order_stats[]=array(
  'description'=>"paid",
  /*'date_created'=>date('c'),
  'ip_address'=>$_SERVER['REMOTE_ADDR']*/
);

/*SIZE LIST*/
$size_list[]=array(
  'size_name'=>"Small",
  'date_created'=>date('c'),
  'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$size_list[]=array(
  'size_name'=>"Medium",
  'date_created'=>date('c'),
  'ip_address'=>$_SERVER['REMOTE_ADDR']
);
$size_list[]=array(
  'size_name'=>"Large",
  'date_created'=>date('c'),
  'ip_address'=>$_SERVER['REMOTE_ADDR']
);