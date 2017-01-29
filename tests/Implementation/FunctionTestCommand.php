<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-29
 * Time: 12:29 AM
 */

namespace Tests\Infra\Implementation;


use Infra\AbstractCommand;

class FunctionTestCommand extends AbstractCommand
{
    public function getName()
    {
        return self::class;
    }
}