<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 3:55 PM
 */

namespace Tests\Infra\Implementation;


use Infra\AbstractEvent;

class TestEvent extends AbstractEvent
{
    public function getName()
    {
        return self::class;
    }
}