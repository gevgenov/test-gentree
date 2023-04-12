<?php declare (strict_types=1);

namespace Trees;

use Ds\Vector;
use Trees\Interfaces\NodeBuilderInterface;

class TreeBuilder
{
    private Vector $nodeList;

    public function __construct(private NodeBuilderInterface $nodeBuilder)
    {
        $this->nodeList = new Vector();
    }

    protected function createTree(): Tree
    {
        return new Tree();
    }

    public function setTree(Tree $itemName): Node
    {
    }

    public function addRecord(array $record): void
    {
        $node = $this->nodeBuilder
             ->create()
            ->setItemName($record[0])
            ->setParent($record[2])
            ->setRelation($record[3])
            ->build();
        $this->nodeList->push($node);
    }

    public function build(): mixed
    {
        return $this->nodeList;
    }

    private function linkParents(): self
    {
        return $this;
    }

    private function linkRelations(): self
    {
        return $this;
    }
}
