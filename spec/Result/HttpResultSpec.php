<?php

namespace spec\eLife\ApiClient\Result;

use ArrayAccess;
use ArrayIterator;
use BadMethodCallException;
use Countable;
use eLife\ApiClient\MediaType;
use GuzzleHttp\Psr7\Response;
use IteratorAggregate;
use PhpSpec\ObjectBehavior;

final class HttpResultSpec extends ObjectBehavior
{
    private $mediaType;
    private $data;
    private $response;

    public function let()
    {
        $this->mediaType = MediaType::fromString('application/vnd.elife.labs-post+json; version=1');
        $this->data = ['one' => ['two', 'three']];
        $this->response = new Response(200, ['Content-Type' => (string) $this->mediaType], json_encode($this->data));

        $this->beConstructedThrough('fromResponse', [$this->response]);
    }

    public function it_has_a_media_type()
    {
        $this->getMediaType()->shouldBeLike($this->mediaType);
    }

    public function it_casts_to_any_array()
    {
        $this->toArray()->shouldBeLike($this->data);
    }

    public function it_has_a_response()
    {
        $this->getResponse()->shouldBeLike($this->response);
    }

    public function it_can_be_searched()
    {
        $this->search('one[1]')->shouldBeLike(array_pop($this->data['one']));
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
        $this->offsetGet('one')->shouldBeLike($this->data['one']);
    }

    public function it_is_immutable()
    {
        $this->shouldThrow(BadMethodCallException::class)->duringOffsetSet('one', 'two');
        $this->shouldThrow(BadMethodCallException::class)->duringOffsetUnset('one');
    }
}
