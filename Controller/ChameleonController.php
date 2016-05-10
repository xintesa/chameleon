<?php

App::uses('ChameleonAppController', 'Chameleon.Controller');

class ChameleonController extends ChameleonAppController {

	public $_User;

	public $uses = false;

	public function beforeFilter() {
		parent::beforeFilter();
		$this->_User = ClassRegistry::init('Users.User');
		$this->Auth->allow('admin_restore_login');
	}

	public function admin_login_as($id = null) {
		$this->autoRender = false;
		$formerUser = $this->Session->read('Auth.User');
		if (!empty($id)) {
			$user = $this->_User->findById($id);
			if (isset($user['Role']) && isset($user['User'])) {
				$user['User']['Role'] = $user['Role'];
				unset($user['Role']);
			}
			Croogo::dispatchEvent('Controller.Users.beforeAdminLogin', $this);
			if ($this->Auth->login($user['User'])) {
				Croogo::dispatchEvent('Controller.Users.adminLoginSuccessful', $this);
				$this->Session->write('Chameleon.User', $formerUser);
				$this->Session->setFlash(__d('Chameleon', 'Switched to %s', $user['User']['name']), 'flash', array('class' => 'success'));
			} else {
				Croogo::dispatchEvent('Controller.Users.adminLoginFailure', $this);
				$this->Session->setFlash(__d('Chameleon', 'failed to switch User'), 'flash', array('class' => 'error'));
			}
		}
		return $this->redirect('/');
	}

	public function admin_restore_login() {
		$formerUser = $this->Session->read('Chameleon.User');
		if (empty($formerUser)) {
			$this->Session->setFlash('Invalid request', 'flash', array('class' => 'error'));
			return $this->redirect('/');
		}
		if ($this->Session->delete('Chameleon.User')) {
			Croogo::dispatchEvent('Controller.Users.adminLogoutSuccessful', $this);
		}
		Croogo::dispatchEvent('Controller.Chameleon.beforeAdminLogin', $this);
		if ($this->Auth->login($formerUser)) {
			Croogo::dispatchEvent('Controller.Users.adminLoginSuccessful', $this);
			return $this->redirect(Configure::read('Croogo.dashboardUrl'));
		};
	}
}
