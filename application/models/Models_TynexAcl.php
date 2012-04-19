<?php 

class Models_TynexAcl extends Zend_Acl
{
	public function __construct()
	{
		$this->add(new Zend_Acl_Resource('project'));
		$this->add(new Zend_Acl_Resource('edit'), 'project');
		$this->add(new Zend_Acl_Resource('add'), 'project');
		
		$this->add(new Zend_Acl_Resource('projects'));
		$this->add(new Zend_Acl_Resource('list'), 'projects');
		
		$this->addRole(new Zend_Acl_Role('niveau3'));
		$this->addRole(new Zend_Acl_Role('niveau2'),'niveau3');
		$this->addRole(new Zend_Acl_Role('niveau1'),'niveau2');
		
		
		$this->allow('niveau3', 'project', 'list');
		$this->allow('niveau1', 'project', 'edit');
		$this->allow('niveau1', 'project', 'add');
		
		
	}	
}