<?php declare(strict_types=1);

namespace Checkers;

use JsonSerializable;

/**
 * This DTO contains the properties describing a move.
 */
final class Move implements JsonSerializable
{
    public static function fromInput(array $input) : self
    {
        return new self(
            Square::fromArray($input['start']),
            Square::fromArray($input['target']),
        );
    }

    public function __construct(public Square $start, public Square $target, public ?Square $capture = null)
    {}

    public function equals(self $other) : bool
    {
        return $this->jsonSerialize() === $other->jsonSerialize();
    }

    public function jsonSerialize()
    {
        return [
            'start' => $this->start->jsonSerialize(),
            'target' => $this->target->jsonSerialize(),
        ];
    }
}
