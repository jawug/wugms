<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers AuditHandOver
 */
final class AuditHandOverTest extends TestCase
{

    public function testCreateAudit_ServiceInstance(): void
    {
        $AuditHandOver = new AuditHandOver();
        $this->assertInstanceOf(AuditHandOver::class, $AuditHandOver);
    }
}
