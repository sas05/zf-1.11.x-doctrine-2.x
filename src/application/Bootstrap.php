<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public $frontController;

    /**
     * generate registry
     * @return Zend_Registry
     */
    protected function _initRegistry()
    {
        $registry = Zend_Registry::getInstance();
        return $registry;
    }
    
    protected function _initAppAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => 'Application_',
                    'basePath' => dirname(__FILE__),
                ));
        return $autoloader;
    }
    
    /**
     * Initialized View settings
     */
    protected function _initViewSettings()
    {
        $this->bootstrap('view');

        $this->_view = $this->getResource('view');

        // set encoding and doctype
        $this->_view->setEncoding('UTF-8');
        $this->_view->doctype('HTML5');

        // set the content type and language
        $this->_view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'en-US');

        // set css/js links and a special import for the accessibility styles
        $this->_view->headLink()->appendStylesheet('/css/reset.css');
        $this->_view->headLink()->appendStylesheet('/css/style.css');

        /* jQuery AND jQueryUI */
        $this->_view->headScript()->appendFile('/js/');;

        $this->_view->addHelperPath('View/Helper', 'View_Helper');
        // setting the site in the title
        $this->_view->headTitle('Zf-1.11.x-doctrine-2.x');
    }

    /**
     * Initialize Doctrine
     * @return Doctrine_Manager
     */
    public function _initDoctrine()
    {
        $doctrineConfig = $this->getOption('doctrine');
        $connection = $doctrineConfig['connection'];
        $settings = $doctrineConfig['settings'];

        // Setup Autoloading
        $classLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPLICATION_PATH . '/../library');
        $classLoader->register();

        $classLoader = new \Doctrine\Common\ClassLoader('Symfony', APPLICATION_PATH . '/../library');
        $classLoader->register();

        $classLoader = new \Doctrine\Common\ClassLoader('Entity', APPLICATION_PATH . '/models');
        $classLoader->register();

        $classLoader = new \Doctrine\Common\ClassLoader('Repository', APPLICATION_PATH . '/models');
        $classLoader->register();

        $classLoader = new \Doctrine\Common\ClassLoader('Proxy', APPLICATION_PATH . '/cache');
        $classLoader->register();

        // Get ORM config
        $ormConfig = new \Doctrine\ORM\Configuration();

        // Configure Entity Mapping Driver
        $driverImpl = $ormConfig->newDefaultAnnotationDriver(APPLICATION_PATH . '/models/Entity');
        $ormConfig->setMetadataDriverImpl($driverImpl);

        // Configure Proxies
        $ormConfig->setAutoGenerateProxyClasses($settings['autogenerateProxies']);
        $ormConfig->setProxyDir(APPLICATION_PATH . '/cache/Proxy');
        $ormConfig->setProxyNamespace('Proxy');

        // Configure Logging
        //$ormConfig->setSQLLogger(new \Doctrine\DBAL\Logging\FileSQLLogger(APPLICATION_PATH . '/logs');
        $ormConfig->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack());

        // Configure Caching
        if (php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) {
            $settings['cacheType'] = '\Doctrine\Common\Cache\ArrayCache';
        }
        if (is_array($settings['cacheType'])) {
            $ormConfig->setQueryCacheImpl(new $settings['cacheType']['query']);
            $ormConfig->setMetadataCacheImpl(new $settings['cacheType']['metadata']);
        } else {
            $ormConfig->setQueryCacheImpl(new $settings['cacheType']);
            $ormConfig->setMetadataCacheImpl(new $settings['cacheType']);
        }

        // Register Entity Manager
        $entityManager = \Doctrine\ORM\EntityManager::create($connection, $ormConfig);
        \Zend_Registry::set('DoctrineEntityManager', $entityManager);

        return $entityManager;
    }
}
