<?php
return array(
	'URL_ROUTE_RULES'=>array( 
		'/^product(\d+)\/detail(\d+)/'    	   => 'Show/product?cid=:1&id=:2',
		'/^product(\d+)/'    					=> 'List/product?cid=:1',
		'/^productt(\d+)/'    					=> 'List/productt?cid=:1',
		'/^article(\d+)\/detail(\d+)/'   		=> 'Show/article?cid=:1&id=:2',
		'/^article(\d+)/'       				=> 'List/article?cid=:1',
		'/^picture(\d+)\/detail(\d+)/'   		=> 'Show/picture?cid=:1&id=:2',
		'/^picture(\d+)/'       				=> 'List/picture?cid=:1',
		'/^picturee(\d+)/'       				=> 'List/picturee?cid=:1',
		'/^index/'       						=> 'Index/index',
		'/^about(\d+)/'       					=> 'Show/about?cid=:1',
		'/^aboutt(\d+)/'       					=> 'Show/aboutt?cid=:1',
		'/^abouttt(\d+)/'       					=> 'Show/abouttt?cid=:1',

		'/^contact(\d+)/'       				=> 'Show/contact?cid=:1',
		'/^feedback(\d+)/'       		     	=> 'Show/feedback?cid=:1',
		'/^join(\d+)/'       					=> 'Show/join?cid=:1',
		'/^jobs(\d+)/'       					=> 'Show/jobs?cid=:1',
		'/^services(\d+)/'       				=> 'Show/services?cid=:1',		
	),
);