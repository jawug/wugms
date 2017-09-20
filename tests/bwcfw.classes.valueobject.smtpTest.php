<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers voSMTP
 */
final class voSMTPTest extends TestCase
{

    public function testCreatevoSMTPInstance(): void
    {
        $voSMTP = new voSMTP();
        $this->assertInstanceOf(voSMTP::class, $voSMTP);
    }
}
