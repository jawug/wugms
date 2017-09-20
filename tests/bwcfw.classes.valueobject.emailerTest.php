<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers voEmailer
 */
final class voEmailerTest extends TestCase
{

    public function testCreatevoEmailerInstance(): void
    {
        $voEmailer = new voEmailer();
        $this->assertInstanceOf(voEmailer::class, $voEmailer);
    }
}
