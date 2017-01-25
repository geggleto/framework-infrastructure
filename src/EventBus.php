<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 2:25 PM
 */

namespace Infra;


class EventBus
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
     * @param $class
     */
    public function addListener($eventName, $class) {
        if (!is_array($this->listeners[$eventName])) {
            $this->listeners[$eventName] = [];
        }

        $this->listeners[$eventName][] = $class;
    }

    /**
     * @param AbstractEvent $event
     */
    public function raise(AbstractEvent $event) {
        foreach ($this->listeners as $listener) {
            /** @var $listener AbstractEventListener */
            $listener->receiveEvent($event);

            foreach ($listener->getEvents() as $event) {
                $this->raise($event);
            }

            if ($this->commandBus instanceof CommandBus) {
                foreach ($listener->getCommands() as $command) {
                    $this->commandBus->handle($command);
                }
            }
        }
    }
}