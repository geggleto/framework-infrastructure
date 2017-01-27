<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-27
 * Time: 9:49 AM
 */
namespace Infra;

interface EventDipsatcherInterface
{
    /**
     * @return CommandBus
     */
    public function getCommandBus();

    /**
     * @param CommandBus $commandBus
     */
    public function setCommandBus(CommandBus $commandBus);

    /**
     * @param $eventName
     * @param $instance
     */
    public function addListener($eventName, EventListenerInterface $instance);

    /**
     * @param AbstractEvent $event
     */
    public function raise(AbstractEvent $event);
}