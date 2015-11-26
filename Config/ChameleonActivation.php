<?php

class ChameleonActivation {

	public function beforeActivation(&$controller) {
		return true;
	}

	public function onActivation(&$controller) {
		$Setting = ClassRegistry::init('Settings.Setting');
		$Setting->write('Chameleon.installed', true);

	}

	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
		$Setting = ClassRegistry::init('Settings.Setting');
		$Setting->deleteKey('Chameleon.installed');
	}
}
