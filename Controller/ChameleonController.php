<?php

App::uses('ChameleonAppController', 'Chameleon.Controller');

class ChameleonController extends ChameleonAppController {

	public $_User;

	public function beforeFilter() {
		parent::beforeFilter();
		$this->_User = ClassRegistry::init('Users.User');
	}

	public function admin_logged_as($id = null) {
		$this->autoRender = false;
		$formerId = $this->Session->read('Auth.User.id');
		if (!empty($id)) {
			$user = $this->_User->findById($id);
			if ($this->Auth->login($user['User'])) {
				$this->Session->write('Auth.Admin.id', $formerId);
				$this->Session->setFlash(__d('Chameleon', 'Switched to %s', $user['User']['name']), 'flash', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__d('Chameleon', 'failed to switch User'), 'flash', array('class' => 'error'));
			}
		}
		return $this->redirect('/');
	}

	public function admin_restore_login() {
		$formerId = $this->Session->write('Auth.Admin.id');
		$user = $this->_User->findById($formerId);
		$this->Session->delete('Auth.Admin.id');
		if ($this->Auth->login($user)) {
			return $this->redirect(array(
				'admin' => 'true',
				'plugin' => 'users',
				'controller' => 'users',
				'action' => 'index'
			));
		};
	}
}
