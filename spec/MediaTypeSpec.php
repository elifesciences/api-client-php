<?php

namespace spec\eLife\ApiClient;

use PhpSpec\ObjectBehavior;

final class MediaTypeSpec extends ObjectBehavior
{
    private $type;
    private $version;
    private $string;

    public function let()
    {
        $this->type = 'application/vnd.elife.labs-post+json';
        $this->version = 1;
        $this->string = sprintf('%s; version=%s', $this->type, $this->version);

        $this->beConstructedWith($this->type, $this->version);
    }

    public function it_has_a_media_type()
    {
        $this->getType()->shouldBe($this->type);
    }

    public function it_has_a_version()
    {
        $this->getVersion()->shouldBe($this->version);
    }

    public function it_can_become_a_string()
    {
        $this->__toString()->shouldBe($this->string);
    }

    public function it_can_be_constructed_from_a_string()
    {
        $this->beConstructedThrough('fromString', [$this->string]);

        $this->getType()->shouldBe($this->type);
        $this->getVersion()->shouldBe($this->version);
    }
}
