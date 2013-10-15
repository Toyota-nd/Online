<?php
Zend_Session::start();
//C:\AppServ\www\cca\application\Bootstrap.php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{ 

	protected function _initDoctype() {
	// application.iniresources.view[] =
	define("RO_GUEST", "Guest");
		$this->bootstrap('view');
		$this->view = $this->getResource('view');
	    $this->view->doctype('XHTML1_STRICT');
		$this->view->setEncoding('UTF-8');

	    ini_set("date.timezone", 'Asia/Shanghai');
		//$view= new Zend_View();
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$this->view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		$viewRenderer->setView($this->view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		//$view = new Zend_View();
		/*
		$view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		*/
	   //$campaign = new Zend_
	   //$num = $campaign.getEnrollment();
		$options = $this->getOptions();
		$this->view->mydebug = $options['mydebug']['open'];
		$this->view->logfile = $options['mydebug']['logfile'];
	   $num = 1;
	   $str =  sprintf("%04s", $num);
	   for($i=0;$i<strlen($str);$i++)
	   {
	   $enrollment[$i] = $str{$i};
	   }
	   $view->counts = $enrollment;
	   // Global themes style
	   $this->view->themes = array('black-tie','blitzer','cupertino','dark-hive',
		'dot-luv','eggplant','excite-bike','flick','hot-sneaks',
		'humanity','le-frog','mint-choc','overcast','pepper-grinder',
		'redmond','smoothness','south-street','start','sunny',
		'swanky-purse','trontastic','ui-darkness','ui-lightness','vader');

		$rand_array=range(0,count($this->view->themes)-1);
		shuffle($rand_array);//調用現成的數組隨機排列函數
		$rand = array_slice($rand_array,0,1);
		$this->view->theme = $this->view->themes[$rand[0]];//$this->view->themes[$rand[0]];
		$this->view->theme = 'humanity';//暫時固定
	}
	protected function _initPlugins() {
		# Instantiate the database adapter and setup the plugin.
		# Alternatively just add the plugin like above and rely on the autodiscovery feature.
		$fid = fopen('debug.php','a');fwrite($fid, "Bootstrap\n");fclose($fid);

		if ($this->hasPluginResource('db')) {
			$this->bootstrap('db');
			//$db = $this->getPluginResource('db')->getDbAdapter();
			//$options['plugins']['Database']['adapter'] = $db;
		}
		# Setup the cache plugin
		if ($this->hasPluginResource('cache')) {
			$this->bootstrap('cache');
			$cache = $this-getPluginResource('cache')->getDbAdapter();
			$options['plugins']['Cache']['backend'] = $cache->getBackend();
		}
		$options = $this->getOptions();
		if ($options['acl']['open']) {
			$autoloader = Zend_Loader_Autoloader::getInstance();
			$autoloader->registerNamespace('My_');
			$objFront = Zend_Controller_Front::getInstance();
			$objFront->registerPlugin(new My_Controller_Plugin_ACL(), 1);
			return $objFront;
		}
	}
	protected function _initZFDebug(){ 

		$options = $this->getOptions();
		if ($options['zfdebug']['open'])
		{
			$autoloader = Zend_Loader_Autoloader::getInstance();
			$autoloader->registerNamespace('ZFDebug');
			$options = array(
				'plugins' => array(
					'Variables',
					'File' => array('base_path' => realpath(APPLICATION_PATH . '/../')),
					'Memory',
					'Time',
					'Registry',
					'Exception',
					'Html'
			));
			$debug = new ZFDebug_Controller_Plugin_Debug($options);
			$this->bootstrap('frontController');
			$frontController = $this->getResource('frontController');
			$frontController->registerPlugin($debug);
		}
	}
}
