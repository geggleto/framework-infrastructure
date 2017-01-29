<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-27
 * Time: 9:49 AM
 */
namespace Infra;

interface EventDispatcherInterface
{

    /**
     * @param $eventName
     * @param callable $instance
     */
    public function addListener($eventName, $listenerClass);

    /**
     * @param AbstractEvent $event
     */
    public function raise(AbstractEvent $event);
}