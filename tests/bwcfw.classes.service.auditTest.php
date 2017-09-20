<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers auditService
 */
final class auditServiceTest extends TestCase
{

    public function testCreateAudit_ServiceInstance(): void
    {
        $auditService = new auditService();
        $this->assertInstanceOf(auditService::class, $auditService);
    }
}
