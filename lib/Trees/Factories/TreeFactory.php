<?php declare (strict_types=1);

namespace Trees\Factories;

use Trees\Tree;
use Trees\Interfaces\NodeInterface;
use Trees\Iterators\NodeByUidIterator;
use Ds\Map;
use Generator;

class TreeFactory
{
    public function createFromNodeList(iterable $nodeList): Tree
    {
        $nodeMap = new Map(new NodeByUidIterator($nodeList));
        $tree = new Tree(); 
        foreach ($nodeMap as $node) {
            $tree->setParent($node, $nodeMap->get($node->getParent(), null));
        }
        foreach ($nodeMap as $node) {
            if (!$node->hasRelation() || !$nodeMap->hasKey($node->getRelation())) continue;
            $relatedNode = $nodeMap->get($node->getRelation());
            $tree->setLink($node, $relatedNode);
        }
        return $tree;
    }
}
