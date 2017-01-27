<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-27
 * Time: 9:49 AM
 */
namespace Infra;

interface CommandBusInterface
{
    /**
     * @param $command
     * @param $class
     */
    public function addHandler($command, $class);

    /**
     * @return EventDipsatcher
     */
    public function getEventDipsatcher();

    /**
     * @param AbstractCommand $command
     * @return bool
     */
    public function handle(AbstractCommand $command);
}