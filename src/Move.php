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

    /**
     * In this equals we only compare the start and target cell. Capture can or cannot be filled yet.
     */
    public function equals(self $other) : bool
    {
        return $this->start->equals($other->start) && $this->target->equals($other->target);
    }

    public function __toString() : string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }

    public function jsonSerialize()
    {
        return [
            'start' => $this->start->jsonSerialize(),
            'target' => $this->target->jsonSerialize(),
            'capture' => $this->capture ? $this->capture->jsonSerialize() : null,
        ];
    }
}
