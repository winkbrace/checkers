<?php declare(strict_types=1);

namespace Checkers;

use JsonSerializable;

/**
 * This DTO contains the state of one square on the board
 */
final class Square implements JsonSerializable
{
    public static function fromArray(array $data) : self
    {
        return new Square($data['row'], $data['col'], $data['player']);
    }

    public function __construct(public int $row, public int $col, public ?string $player)
    {}

    public function isBlack() : bool
    {
        return ($this->row + $this->col) % 2 === 1;
    }

    public function isEmpty() : bool
    {
        return $this->player === null;
    }

    public function equals(Square $other) : bool
    {
        return (string) $this === (string) $other;
    }

    public function __toString() : string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
