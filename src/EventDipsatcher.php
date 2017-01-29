<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 2:25 PM
 */

namespace Infra;


use Interop\Container\ContainerInterface;

class EventDipsatcher implements EventDipsatcherInterface
{
    /** @var array  */
    protected $listeners;

    /** @var ContainerInterface  */
    protected $container;

    /**
     * EventDipsatcher constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->listeners = [];
        $this->container = $container;
    }

    /**
     * @param $eventName
     * @param $listenerClass
     */
    public function addListener($eventName, $listenerClass) {
        if (!isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = [];
        }

        $this->listeners[$eventName][] = $listenerClass;
    }

    /**
     * @param AbstractEvent $event
     */
    public function raise(AbstractEvent $event) {
        if (isset($this->listeners[$event->getName()])) {
            foreach ($this->listeners[$event->getName()] as $listener) {
                $base = $this->container->get($listener[0]);

                /** @var $listener callable */
                call_user_func([$base, $listener[1]], $event);
            }
        }
    }
}