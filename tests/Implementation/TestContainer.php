<?php
/**
 * Created by PhpStorm.
 * User: glenneggleton
 * Date: 2017-01-25
 * Time: 3:30 PM
 */

namespace Tests\Infra\Implementation;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Interop\Container\Exception\NotFoundException;
use Slim\Exception\ContainerValueNotFoundException;

class TestContainer implements ContainerInterface
{
    protected $objects;

    public function __construct()
    {
        $this->objects = [];
    }

    public function add($id, $object) {
        $this->objects[$id] = $object;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if ($this->has($id))
            return $this->objects[$id];
        else
            throw new ContainerValueNotFoundException();
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has($id)
    {
        return isset($this->objects[$id]);
    }
}