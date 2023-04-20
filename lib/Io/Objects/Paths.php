<?php declare (strict_types=1);

namespace Io\Objects;

class Paths {
    public function __construct(readonly public string $input, readonly public string $output) {}
}
