<?php declare (strict_types=1);

namespace Trees;

use Generator;
use Trees\Factories\Interfaces\NodeFactoryInterface;
use Trees\Interfaces\NodeInterface;

class NodeService
{
    public function __construct(private NodeFactoryInterface $nodeFactory) {}

    public function createGeneratorFromRecords(iterable $records): Generator
    {
        foreach ($records as $record) {
            yield $this->createFromRecord($record);
        }
    }

    public function createFromRecord(array $record): NodeInterface
    {
        $itemName = $record[0];
        $parent = $record[2];
        $relation = $record[3];
        return $this->nodeFactory->create($itemName, $parent, $relation);
    }
}
