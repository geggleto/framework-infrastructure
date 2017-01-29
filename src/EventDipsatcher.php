<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 2:25 PM
 */

namespace Infra;


class EventDipsatcher implements EventDipsatcherInterface
{
    /** @var array  */
    protected $listeners;

    /** @var CommandBus */
    protected $commandBus;


    /**
     * EventBus constructor.
     *
     * @param array $listeners
     */
    public function __construct(array $listeners = [])
    {
        $this->listeners = $listeners;
        $this->commandBus = null;
    }

    /**
     * @return CommandBus
     */
    public function getCommandBus()
    {
        return $this->commandBus;
    }

    /**
     * @param CommandBus $commandBus
     */
    public function setCommandBus(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param $eventName
     * @param $instance
     */
    public function addListener($eventName, callable $instance) {
        if (!isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = [];
        }

        $this->listeners[$eventName][] = $instance;
    }

    /**
     * @param AbstractEvent $event
     */
    public function raise(AbstractEvent $event) {
        if (isset($this->listeners[$event->getName()])) {
            foreach ($this->listeners[$event->getName()] as $listener) {
                /** @var $listener callable */
                call_user_func($listener, $event);
            }
        }
    }
}