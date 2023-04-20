<?php declare (strict_types=1);

namespace Trees\Factories;

use Trees\Tree;
use Ds\Map;

class TreeFactory
{
    public function createFromNodes(iterable $nodes): Tree
    {
        $nodeMap = new Map();
        foreach ($nodes as $node) {
            $nodeMap->put($node->getItemName(), $node);
        }
        $tree = new Tree(); 
        foreach ($nodeMap as $node) {
            $tree->setParent($node, $nodeMap->get($node->getParent(), null));
        }
        return $tree;
    }
}
