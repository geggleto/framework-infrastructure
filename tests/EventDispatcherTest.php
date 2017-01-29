<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-29
 * Time: 12:15 AM
 */

namespace Tests\Infra;


use Infra\EventDipsatcher;
use PHPUnit\Framework\TestCase;
use Tests\Infra\Implementation\TestContainer;
use Tests\Infra\Implementation\TestEvent;
use Tests\Infra\Implementation\TestEventHandler;

class EventDispatcherTest extends TestCase
{
    /** @var  EventDipsatcher */
    protected $dispatcher;

    /** @var  TestEventHandler */
    protected $handler;

    public function setUp()
    {
        $this->handler =  new TestEventHandler();
        $container = new TestContainer();
        $container->add(TestEventHandler::class, $this->handler);

        $this->dispatcher = new EventDipsatcher($container);
        $this->dispatcher->addListener(TestEvent::class, [TestEventHandler::class, 'receiveEvent']);
    }

    public function testEventDispatcherDispatches() {
        $this->dispatcher->raise(new TestEvent());

        $this->assertEquals(1, $this->handler->getCount());
    }
}