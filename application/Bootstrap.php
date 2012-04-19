<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAcl()
	{
		//register the ACL plugin
		//$fc = Zend_Controller_Front::getInstance();
		//$fc->registerPlugin(new Tynex_Plugins_AccessCheck());//register the plugin and pass the Model (configurations are defined in it)
	}
}

