<?php declare (strict_types=1);

namespace Trees\Interfaces;

use Trees\Node;

interface NodeBuilderInterface
{
    public function create(): self;

    public function setItemName(string $str): self;

    public function setParent(string $str): self;

    public function setRelation(string $str): self;

    public function build(): NodeInterface;
}
