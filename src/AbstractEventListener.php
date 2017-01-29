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

    /**
     * @param AbstractEvent $event
     * @return void
     */
    abstract public function receiveEvent(AbstractEvent $event);
}