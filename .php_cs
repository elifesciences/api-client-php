<?php

$finder = Symfony\CS\Finder\DefaultFinder::create();

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->finder($finder)
;
