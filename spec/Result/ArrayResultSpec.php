<?php

namespace spec\eLife\ApiSdk\Result;

use ArrayAccess;
use ArrayIterator;
use BadMethodCallException;
use Countable;
use eLife\ApiSdk\MediaType;
use IteratorAggregate;
use PhpSpec\ObjectBehavior;

final class ArrayResultSpec extends ObjectBehavior
{
    private $mediaType;
    private $data;

    public function let()
    {
        $this->mediaType = MediaType::fromString('application/vnd.elife.labs-experiment+json; version=1');
        $this->data = ['foo' => ['bar', 'baz']];

        $this->beConstructedWith($this->mediaType, $this->data);
    }

    public function it_has_a_media_type()
    {
        $this->getMediaType()->shouldBeLike($this->mediaType);
    }

    public function it_casts_to_any_array()
    {
        $this->toArray()->shouldBeLike($this->data);
    }

    public function it_can_be_searched()
    {
        $this->search('foo[1]')->shouldBeLike(array_pop($this->data['foo']));
    }

    public function it_can_be_counted()
    {
        $this->shouldHaveType(Countable::class);
        $this->count()->shouldBe(count($this->data));
    }

    public function it_can_be_iterated()
    {
        $this->shouldHaveType(IteratorAggregate::class);
        $this->getIterator()->shouldBeLike(new ArrayIterator($this->data));
    }

    public function it_can_be_accessed_like_an_array()
    {
        $this->shouldHaveType(ArrayAccess::class);
        $this->offsetExists('foo')->shouldBe(true);
        $this->offsetGet('foo')->shouldBeLike($this->data['foo']);
    }

    public function it_is_immutable()
    {
        $this->shouldThrow(BadMethodCallException::class)->duringOffsetSet('foo', 'bar');
        $this->shouldThrow(BadMethodCallException::class)->duringOffsetUnset('foo');
    }
}
