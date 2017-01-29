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
    /**
     * @param AbstractCommand $command
     * @return bool
     */
    abstract public function handle(AbstractCommand $command);
}