<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 2:24 PM
 */

namespace Infra;


use Interop\Container\ContainerInterface;

class CommandBus
{
    /**
     * @var EventBus
     */
    protected $eventBus;

    /**
     * @var array
     */
    protected $handlers;

    /**
     * @var ContainerInterface
     */
    protected $container;


    /**
     * CommandBus constructor.
     * @param ContainerInterface $container
     * @param EventBus $eventBus
     * @param array $handlers
     */
    public function __construct(ContainerInterface $container, EventBus $eventBus, array $handlers = [])
    {
        $eventBus->setCommandBus($this);

        $this->container = $container;
        $this->eventBus = $eventBus;
        $this->handlers = $handlers;
    }

    /**
     * @param $command
     * @param $class
     */
    public function addHandler($command, $class) {
        if (!class_exists($command)) {
            throw new \InvalidArgumentException("Class $command does not exist");
        }

        if (!class_exists($class)) {
            throw new \InvalidArgumentException("Class $class does not exist");
        }

        $this->handlers[$command] = $class;
    }

    /**
     * @return EventBus
     */
    public function getEventBus()
    {
        return $this->eventBus;
    }

    /**
     * @param AbstractCommand $command
     * @return bool
     */
    public function handle(AbstractCommand $command) {
        /** @var $handler string */
        if ($handlerEntry = $this->handlers[get_class($command)]) {
            /** @var $handler AbstractCommandHandler */
            $handler = $this->container->get($handlerEntry);
            $result = $handler->handle($command);

            foreach ($handler->getEvents() as $event) {
                /** @var $event AbstractEvent */
                $this->eventBus->raise($event);
            }

            return $result;
        }
        return false;
    }
}