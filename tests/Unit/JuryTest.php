<?php declare(strict_types=1);

namespace Tests\Unit;

use Checkers\Jury;
use PHPUnit\Framework\TestCase;

class JuryTest extends TestCase
{
    private Jury $jury;

    protected function setUp() : void
    {
        parent::setUp();

        $this->jury = new Jury();
    }
}
