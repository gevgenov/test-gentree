<?php declare (strict_types=1);

namespace Trees;

use Trees\Interfaces\NodeInterface;

class Node implements NodeInterface
{
    public function __construct(
        private string $itemName,
        private ?string $parent,
        private ?string $relation,
    ) {
        $this->uid = uniqid();
    }

    public function __clone()
    {
        $this->uid = uniqid();
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function hasParent(): bool
    {
        return !is_null($this->parent);
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function hasRelation(): bool
    {
        return !is_null($this->relation);
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }
}
