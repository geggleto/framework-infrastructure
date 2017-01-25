<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 3:27 PM
 */

namespace Tests\Infra\Functional;


use Infra\CommandBus;
use Infra\EventBus;
use PHPUnit\Framework\TestCase;
use Tests\Infra\Implementation\TestCommand;
use Tests\Infra\Implementation\TestCommandHandler;
use Tests\Infra\Implementation\TestCommandHandlerWithQueuedEvent;
use Tests\Infra\Implementation\TestContainer;
use Tests\Infra\Implementation\TestEvent;
use Tests\Infra\Implementation\TestEventHandler;
use Tests\Infra\Implementation\TestEventHandlerWithQueuedCommand;

class FunctionalTest extends TestCase
{
    public function testCommandBusOnlyDeliversProperly() {
        $handler1 = new TestCommandHandler();
        $handler2 = new TestCommandHandler();

        $container = new TestContainer();
        $container->add(TestCommandHandler::class, $handler1);
        $container->add("2", $handler2);

        $commandBus = new CommandBus($container, new EventBus());
        $commandBus->addHandler(TestCommand::class, TestCommandHandler::class);

        $command = new TestCommand(rand(1, 5));

        $commandBus->handle($command);

        $this->assertEquals(1, $handler1->getCount());
        $this->assertEquals(0, $handler2->getCount());
    }

    public function testEventBusDeliversProperly() {
        $eventHandler = new TestEventHandler();
        $eventBus = new EventBus();
        $eventBus->addListener(TestEvent::class, $eventHandler);
        $event = new TestEvent();

        $eventBus->raise($event);

        $this->assertEquals(1, $eventHandler->getCount());
    }

    public function testCommandBusEventBusWithQueuedCommandFromEventHandler() {
        $handler1 = new TestCommandHandlerWithQueuedEvent();
        $handler2 = new TestCommandHandler();

        $container = new TestContainer();
        $container->add(TestCommandHandlerWithQueuedEvent::class, $handler1);

        $commandBus = new CommandBus($container, new EventBus());
        $commandBus->addHandler(TestCommand::class, TestCommandHandlerWithQueuedEvent::class);

        $command = new TestCommand(rand(1, 5));

        $eventBus = $commandBus->getEventBus();

        $eventHandler = new TestEventHandlerWithQueuedCommand();
        $eventBus->addListener(TestEvent::class, $eventHandler);

        $commandBus->handle($command);

        $this->assertEquals(2, $handler1->getCount());
        $this->assertEquals(0, $handler2->getCount());
    }
}