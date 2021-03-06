<?php

namespace Symfony\Cmf\Bundle\RoutingBundle\Tests\Document;

use Symfony\Cmf\Bundle\RoutingBundle\Tests\BaseTestCase;
use Symfony\Cmf\Bundle\RoutingBundle\Document\RouteProvider;

class RouteProviderTest extends BaseTestCase
{
    public function testGetRouteCollectionForRequest()
    {
        $this->markTestIncomplete();
    }

    public function testGetRouteByName()
    {
        $managerRegistry = $this->getManagerRegistry(
            array(
                'default' => $this->getObjectManager(
                    array('test-route' => $this->getRoute('/cms/routes/test-route'))
                )
            )
        );
        $routeProvider = new RouteProvider($managerRegistry);
        $routeProvider->setManagerName('default');

        $foundRoute = $routeProvider->getRouteByName('test-route');

        $this->assertInstanceOf('Symfony\Component\Routing\Route', $foundRoute);
        $this->assertEquals('/cms/routes/test-route', $foundRoute->getPath());
    }

    public function testGetRoutesByNames()
    {
        $this->markTestIncomplete();
    }

    /**
     * Use getRouteByName() with two different document managers.
     * The two document managers will return different route objects when searching for the same path.
     */
    public function testChangingDocumentManager()
    {
        $managerRegistry = $this->getManagerRegistry(
            array(
                'default' => $this->getObjectManager(
                    array('test-route' => $this->getRoute('/cms/routes/test-route'))
                ),
                'new_manager' => $this->getObjectManager(
                    array('test-route' => $this->getRoute('/cms/routes/new-route'))
                )
            )
        );
        $routeProvider = new RouteProvider($managerRegistry);

        $routeProvider->setManagerName('default');
        $foundRoute = $routeProvider->getRouteByName('test-route');
        $this->assertInstanceOf('Symfony\Component\Routing\Route', $foundRoute);
        $this->assertEquals('/cms/routes/test-route', $foundRoute->getPath());

        $routeProvider->setManagerName('new_manager');
        $newFoundRoute = $routeProvider->getRouteByName('test-route');
        $this->assertInstanceOf('Symfony\Component\Routing\Route', $newFoundRoute);
        $this->assertEquals('/cms/routes/new-route', $newFoundRoute->getPath());
    }

    /**
     * @param string $path
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getRoute($path)
    {
        $route = $this->getMockBuilder('Symfony\Component\Routing\Route')->disableOriginalConstructor()->getMock();
        $route->expects($this->any())->method('getPath')->will($this->returnValue($path));

        return $route;
    }
}
