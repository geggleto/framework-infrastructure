<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-29
 * Time: 12:01 AM
 */

namespace Tests\Infra;


use Infra\CommandBus;
use PHPUnit\Framework\TestCase;
use Tests\Infra\Implementation\TestCommand;
use Tests\Infra\Implementation\TestCommandHandler;
use Tests\Infra\Implementation\TestContainer;

class CommandBusTest extends TestCase
{
    /** @var CommandBus */
    protected $bus;

    /** @var TestCommandHandler */
    protected $handler;

    public function setUp() {
        $container = new TestContainer();
        $this->handler = new TestCommandHandler();
        $container->add(TestCommandHandler::class, $this->handler);
        $this->bus = new CommandBus($container);
    }


    public function testCommandBusHandlesCommand() {
        $this->bus->addHandler(TestCommand::class, TestCommandHandler::class);

        $secret = rand(1,100);

        $this->bus->handle(new TestCommand($secret));

        $this->assertEquals($secret, $this->handler->getCount());
    }
}