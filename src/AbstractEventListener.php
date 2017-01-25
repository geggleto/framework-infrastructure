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
    abstract public function receiveEvent(AbstractEvent $event);
}