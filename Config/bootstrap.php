<?php

Croogo::hookAdminRowAction('Users/admin_index', 'Logged As', array(
	'admin:true/plugin:chameleon/controller:chameleon/action:logged_as/:id' => array(
		'title' => false,
		'options' => array(
			'icon' => 'taxi',
			'tooltip' => array(
				'data-title' => __d('croogo', 'Logged As'),
			),
		),
	),
));
?>
