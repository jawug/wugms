<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers voFileRecord
 */
final class voFileRecordTest extends TestCase
{

    public function testCreatevoFileRecordInstance(): void
    {
        $voFileRecord = new voFileRecord();
        $this->assertInstanceOf(voFileRecord::class, $voFileRecord);
    }
}
