<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 3:01 PM
 */
namespace Infra;

interface EventListenerInterface
{
    /**
     * @param AbstractEvent $event
     * @return void
     */
    public function receiveEvent(AbstractEvent $event);
}