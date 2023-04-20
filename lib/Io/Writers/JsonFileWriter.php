<?php declare (strict_types=1);

namespace Io\Writers;

use RuntimeException;

class JsonFileWriter
{
    public function __construct(
        private int $flags = 0, 
    ) {}

    public function __invoke(mixed $data, string $path): void
    {
        if (file_put_contents($path, json_encode($data, $this->flags)) === false) {
            throw new RuntimeException(sprintf('Failed to write a file: "%s"!', $path));
        }
    }
}
