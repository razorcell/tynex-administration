<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	protected function _initAcl() {
		$fc = Zend_Controller_Front::getInstance ();
		$fc->registerPlugin ( new Tynex_Plugins_AccessCheck () ); // register
		                                                                 // the plugin
	}
}

