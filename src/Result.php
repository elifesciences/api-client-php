<?php

namespace eLife\ApiSdk;

use Countable;
use Traversable;

interface Result extends CastsToArray, Countable, Traversable
{
    public function getMediaType() : MediaType;

    public function search(string $expression);
}
