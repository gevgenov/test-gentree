<?php declare (strict_types=1);

namespace Support\Objects;

class IoPaths {
    public function __construct(readonly public string $input, readonly public string $output) {}
}
