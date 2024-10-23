<?php

namespace eLife\ApiClient\Result;

use ArrayIterator;
use BadMethodCallException;
use eLife\ApiClient\MediaType;
use eLife\ApiClient\Result;
use Iterator;
use IteratorAggregate;
use JmesPath\Env;

final class ArrayResult implements IteratorAggregate, Result
{
    private $mediaType;
    private $data;

    public function __construct(MediaType $mediaType, array $data)
    {
        $this->mediaType = $mediaType;
        $this->data = $data;
    }

    public function getMediaType() : MediaType
    {
        return $this->mediaType;
    }

    public function toArray() : array
    {
        return $this->data;
    }

    public function search(string $expression)
    {
        if (false === function_exists('JmesPath\search')) {
            throw new BadMethodCallException('Requires mtdowling/jmespath.php');
        }

        return Env::search($expression, $this->data);
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->data[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if (false === $this->offsetExists($offset)) {
            return null;
        }

        return $this->data[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        throw new BadMethodCallException('Object is immutable');
    }

    public function offsetUnset($offset): void
    {
        throw new BadMethodCallException('Object is immutable');
    }

    public function getIterator() : Iterator
    {
        return new ArrayIterator($this->data);
    }

    public function count() : int
    {
        return count($this->data);
    }
}
