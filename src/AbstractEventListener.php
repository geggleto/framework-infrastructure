<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 2:39 PM
 */

namespace Infra;


abstract class AbstractEventListener implements EventListenerInterface
{
    private $events = [];
    private $commands = [];

    protected $bus;
    protected $eventDispatcher;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
        $this->eventDispatcher = $bus->getEventDipsatcher();
    }

    /**
     * @return AbstractEvent[]
     */
    public function getEvents()
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    /**
     * @param AbstractEvent $event
     */
    public function addEvent(AbstractEvent $event)
    {
        $this->events[] = $event;
    }

    /**
     * @return AbstractCommand[]
     */
    public function getCommands()
    {
        $commands = $this->commands;
        $this->commands = [];
        return $commands;
    }

    /**
     * @param AbstractCommand $commands
     */
    public function addCommand(AbstractCommand $commands)
    {
        $this->commands[] = $commands;
    }

    /**
     * @param AbstractEvent $event
     * @return void
     */
    public function receiveEvent(AbstractEvent $event) {
        foreach ($this->getEvents() as $event) {
            $this->eventDispatcher->raise($event);
        }

        foreach ($this->getCommands() as $command) {
            $this->bus->handle($command);
        }
    }
}