<?php

Croogo::hookAdminRowAction('Users/admin_index', 'Logged As', array(
	'admin:true/plugin:chameleon/controller:chameleon/action:login_as/:id' => array(
		'title' => false,
		'options' => array(
			'icon' => 'user-md',
			'tooltip' => array(
				'data-title' => __d('croogo', 'Login As'),
			),
		),
	),
));
?>
