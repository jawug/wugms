<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers voStatus
 */
final class voStatusTest extends TestCase
{

    public function testCreatevoStatusInstance(): void
    {
        $voStatus = new voStatus();
        $this->assertInstanceOf(voStatus::class, $voStatus);
    }
}
