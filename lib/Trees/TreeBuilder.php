<?php declare (strict_types=1);

namespace Trees;

use Ds\Vector;
use Trees\Interfaces\NodeFactoryInterface;

class TreeBuilder
{
    private Vector $nodeList;
    private NodeFactoryInterface $nodeFactory;

    public function __construct(NodeFactoryInterface $nodeFactory)
    {
        $this->nodeList = new Vector();
        $this->nodeFactory = $nodeFactory;
    }

    public function addRecord(array $record): void
    {
        $node = ($this->nodeFactory)($record);
        $this->nodeList->push($node);
    }

    public function build(): mixed
    {
        return $this->nodeList;
    }
}
