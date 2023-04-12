<?php declare (strict_types=1);

namespace Trees\Interfaces;

use Trees\Node;

interface NodeInterface
{
    public function getItemName(): string;

    public function hasParent(): bool;

    public function getParent(): ?string;

    public function hasRelation(): bool;

    public function getRelation(): ?string;
}
