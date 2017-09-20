<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers auditHandover
 */
final class auditHandoverTest extends TestCase
{

    public function testCreateAudit_ServiceInstance(): void
    {
        $auditHandover = new auditHandover();
        $this->assertInstanceOf(auditHandover::class, $auditHandover);
    }
}
