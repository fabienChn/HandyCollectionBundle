<?php

namespace fabienChn\HandyCollectionBundle\Component;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * Class HandyCollection
 * @package fabienChn\HandyCollectionBundle\Component
 */
class HandyCollection
{
    /**
     * @var array|ArrayCollection|PersistentCollection
     */
    private $data;

    /**
     * HandyCollection constructor.
     * @param $data
     */
    public function __construct($data)
    {
        if (! (
            is_array($data) ||
            $data instanceof PersistentCollection ||
            $data instanceof ArrayCollection
        )) {
            throw new \InvalidArgumentException('Unsupported Type');
        }

        $this->data = $data;
    }

    /**
     * @param $data
     * @return HandyCollection
     */
    public static function collect($data): HandyCollection
    {
        return new self($data);
    }

    /**
     * CAUTION: Unlike other methods, here, the original collection is changed
     *
     * @param callable $function
     * @return self
     */
    public function transform(callable $function): self
    {
        foreach ($this->data as $key => $item) {
            $this->data[$key] = $function($item, $key);
        }

        return $this;
    }

    /**
     * @param callable $function
     * @return HandyCollection
     */
    public function map(callable $function): HandyCollection
    {
        $array = [];

        foreach ($this->data as $key => $item) {
            $value = $function($item, $key);

            $array[$key] = $value;
        }

        return self::collect($array);
    }

    /**
     * The only difference with the map method is that, here,
     * a "return false" in the callable stops the looping
     *
     * @param callable $function
     * @return HandyCollection
     */
    public function each(callable $function): HandyCollection
    {
        $array = [];

        foreach ($this->data as $key => $item) {
            $value = $function($item, $key);

            if ($value == false) {
                return self::collect($array);
            }

            $array[$key] = $value;
        }

        return self::collect($array);
    }

    /**
     * @param callable $function
     * @return HandyCollection
     */
    public function filter(callable $function): HandyCollection
    {
        $array = $this->data;

        foreach ($this->data as $key => $item) {
            $value = $function($item, $key);

            if ($value == false) {
                unset($array[$key]);
            }
        }

        return self::collect($array);
    }

    /**
     * Opposite of filtering
     *
     * @param callable $function
     * @return HandyCollection
     */
    public function reject(callable $function): HandyCollection
    {
        $array = $this->data;

        foreach ($this->data as $key => $item) {
            $value = $function($item, $key);

            if ($value == true) {
                unset($array[$key]);
            }
        }

        return self::collect(array_values($array));
    }

    /**
     * @return HandyCollection
     */
    public function collapse(): HandyCollection
    {
        $array = [];

        foreach ($this->data as $item) {
            $array = array_merge($array, $item);
        }

        return self::collect($array);
    }

    /**
     * Get an array of a single attribute of each item in the collection
     *
     * e.g. collect(['id', 'name'], ['id', 'name'])->pluck('id')->toArray() returns ['id', 'id']
     *
     * @param $itemAttribute
     * @return HandyCollection
     */
    public function pluck($itemAttribute): HandyCollection
    {
        return $this->map(function ($item) use ($itemAttribute) {
            if (is_array($item)) {
                return $item[$itemAttribute];
            }

            $getter = 'get'.ucfirst($itemAttribute);

            return $item->$getter();
        });
    }

    /**
     * @return array|ArrayCollection|PersistentCollection
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * It counts the items of the collection that match the calculations of the function
     *
     * @param callable $function
     * @return int
     */
    public function count(callable $function): int
    {
        $counter = 0;

        foreach ($this->data as $key => $item) {
            if ($function($item, $key) == true) {
                $counter++;
            }
        }

        return $counter;
    }
}
