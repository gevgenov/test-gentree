<?php declare (strict_types=1);

namespace Io\Objects;

class Paths {
    public function __construct(
        public string $input, 
        public string $output,
    ) {}
}
