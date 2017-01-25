<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 2:25 PM
 */

namespace Infra;


abstract class AbstractCommandHandler
{
    private $events = array();

    /**
     * @param AbstractEvent $abstractEvent
     */
    protected function raise(AbstractEvent $abstractEvent) {
        $this->events[] = $abstractEvent;
    }

    /**
     * @return AbstractEvent[]
     */
    public function getEvents() {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    /**
     * @param AbstractCommand $command
     * @return bool
     */
    abstract public function handle(AbstractCommand $command);
}