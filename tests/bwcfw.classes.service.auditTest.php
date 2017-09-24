<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers AuditService
 */
final class AuditServiceTest extends TestCase
{

    public function testCreateAudit_ServiceInstance(): void
    {
        $AuditService = new AuditService();
        $this->assertInstanceOf(AuditService::class, $AuditService);
    }
}
