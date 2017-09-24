<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers ServiceMetrics
 */
final class ServiceMetricsTest extends TestCase
{

    public function testCreateServiceMetricsInstance(): void
    {
        $ServiceMetrics = new ServiceMetrics();
        $this->assertInstanceOf(ServiceMetrics::class, $ServiceMetrics);
    }
}
