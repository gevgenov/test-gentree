<?php declare (strict_types=1);

namespace Trees;

use IteratorAggregate;
use LimitIterator;
use Generator;
use League\Csv\Reader;

class CsvRecordReader implements IteratorAggregate
{
    private Reader $csv;
    private bool $hasHeader;

    public function __construct(
        string $inputPath, 
        string $delimiter = ';',
        bool $hasHeader = true
    ) {
        $this->csv = Reader::createFromPath($inputPath, 'r');
        $this->csv->setDelimiter($delimiter);
        $this->hasHeader = $hasHeader;
    }

    public function getIterator(): Generator
    {
        foreach ($this->getRecordIterator() as $record) {
            yield $this->normalizeRecord($record);
        }
    }

    private function getRecordIterator(): LimitIterator
    {
        return new LimitIterator($this->csv->getRecords(), (int)$this->hasHeader);
    }

    private function normalizeRecord(array $record): array
    {
        return array_map(fn($value) => strlen($value) > 0 ? $value : null, $record);
    }
}
