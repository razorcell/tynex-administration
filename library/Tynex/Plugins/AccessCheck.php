<?php 
class Tynex_Plugins_AccessCheck extends Zend_Controller_Plugin_Abstract
{
	private $_acl = null;
	private $_auth = null;
	public function __construct(Zend_Acl $acl,Zend_Auth $auth)
	{
		$this->_acl = $acl;
		$this->_auth = $auth;
		
	}
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$resource = $request->getControllerName();
		$action = $request->getAction();
		
		$identity = $this->_auth->getStorage()->read();
		$level = $identity->level;
		
		if(!$this->_acl->isAllowed($level, $resource, $action))
		{
			$request->setControllerName('authentication')
							->setActionName('login');
		}
	}
}