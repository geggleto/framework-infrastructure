<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 3:27 PM
 */

namespace Tests\Infra\Functional;


use Infra\CommandBus;
use Infra\EventDipsatcher;
use PHPUnit\Framework\TestCase;
use Tests\Infra\Implementation\FunctionalTestCommandHandler;
use Tests\Infra\Implementation\FunctionalTestEventListener;
use Tests\Infra\Implementation\FunctionTestCommand;
use Tests\Infra\Implementation\TestCommand;
use Tests\Infra\Implementation\TestCommandHandler;

use Tests\Infra\Implementation\TestContainer;
use Tests\Infra\Implementation\TestEvent;
use Tests\Infra\Implementation\TestEventHandler;


/**
 * Class FunctionalTest
 * @package Tests\Infra\Functional
 *
 * The goal of this test is to make sure that we can complete a complicated execution Pattern
 * A command is fired, to create an event, which creates a command
 */
class FunctionalTest extends TestCase
{
    /** @var CommandBus */
    protected $commandBus;

    protected $eventDispatcher;

    protected $container;

    /** @var FunctionalTestCommandHandler */
    protected $handler;

    /** @var  FunctionalTestEventListener */
    protected $listener;

    public function setUp()
    {
        $this->container = new TestContainer();
        $this->commandBus = new CommandBus($this->container);


        $this->eventDispatcher = new EventDipsatcher($this->container);

        $this->handler = new FunctionalTestCommandHandler($this->eventDispatcher);

        $this->listener = new FunctionalTestEventListener($this->commandBus);

        $this->container->add(FunctionalTestCommandHandler::class, $this->handler);
        $this->container->add(FunctionalTestEventListener::class, $this->listener);


        $this->commandBus->addHandler(FunctionTestCommand::class, FunctionalTestCommandHandler::class);
        $this->eventDispatcher->addListener(TestEvent::class, [FunctionalTestEventListener::class, 'receiveEvent']);

        //We will Fire TestCommand to emit TestEvent which will be handled and sent back to TestCommand
    }

    public function testScenario() {
        $this->commandBus->handle(new FunctionTestCommand());
        $this->assertEquals($this->listener->getCount(), 1);
        $this->assertEquals($this->handler->getCount(), 2);
    }
}