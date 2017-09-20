<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers LoggingService
 */
final class LoggingServiceTest extends TestCase
{

    public function testCreateLoggingServiceInstance(): void
    {
        $LoggingService = new LoggingService();
        $this->assertInstanceOf(LoggingService::class, $LoggingService);
    }
}
