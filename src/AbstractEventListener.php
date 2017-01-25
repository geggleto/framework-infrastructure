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
        return $this->events;
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
        return $this->commands;
    }

    /**
     * @param AbstractCommand $commands
     */
    public function setCommands(AbstractCommand $commands)
    {
        $this->commands[] = $commands;
    }

    /**
     * @param AbstractEvent $event
     * @return void
     */
    abstract public function receiveEvent(AbstractEvent $event);
}