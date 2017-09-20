<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers serviceMetrics
 */
final class serviceMetricsTest extends TestCase
{

    public function testCreateserviceMetricsInstance(): void
    {
        $serviceMetrics = new serviceMetrics();
        $this->assertInstanceOf(serviceMetrics::class, $serviceMetrics);
    }
}
