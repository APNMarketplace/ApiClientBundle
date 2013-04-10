<?php

use ApnMarketplace\ApiClientBundle\DependencyInjection\ApnMarketplaceApiClientExtension as Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $container;

    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->container->set('doctrine_memcache', $this->getMock('\Doctrine\Common\Cache\Cache'));
    }

    public function testConfigDefaults()
    {
        $extension = new Extension();
        $extension->load(array(), $this->container);

        $this->assertEmpty($this->container->getParameter('apnmarketplace.client_id'));
        $this->assertEmpty($this->container->getParameter('apnmarketplace.client_secret'));
        $this->assertEquals('https://api.apnmarketplace.co.nz', $this->container->getParameter('apnmarketplace.host'));
        $this->assertTrue($this->container->getParameter('apnmarketplace.guzzle_verify_ssl'));
        $listeners = array();
        foreach ($this->container->get('apnmarketplace.guzzle_client')->getEventDispatcher()->getListeners('request.before_send') as $listener) {
            $listeners[] = get_class($listener[0]);
        }
        $this->assertContains('Guzzle\Plugin\Cache\CachePlugin', $listeners);
    }

    public function testConfigOverrideDefaults()
    {
        $extension = new Extension();
        $config = array(
            'id'                => '1',
            'secret'            => 'secret',
            'host'              => 'https://example.com',
            'guzzle_verify_ssl' => false,
            'guzzle_caching'    => false,
        );
        $extension->load(array($config), $this->container);

        $this->assertEquals('1', $this->container->getParameter('apnmarketplace.client_id'));
        $this->assertEquals('secret', $this->container->getParameter('apnmarketplace.client_secret'));
        $this->assertEquals('https://example.com', $this->container->getParameter('apnmarketplace.host'));
        $this->assertFalse($this->container->getParameter('apnmarketplace.guzzle_verify_ssl'));
        $listeners = array();
        foreach ($this->container->get('apnmarketplace.guzzle_client')->getEventDispatcher()->getListeners('request.before_send') as $listener) {
            $listeners[] = get_class($listener[0]);
        }
        $this->assertNotContains('Guzzle\Plugin\Cache\CachePlugin', $listeners);
    }
}
