<?php declare (strict_types=1);

namespace Trees;

class TreeService
{
    public function __construct(private NodeFactoryInterface $nodeFactory)

    public function createFromRecordIterable(iterable $records)
    {
        return new Tree(); 
    }

    public function toJson(Tree $tree, $flags): string
    {
        return '';
    }
}

