<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers PageLoggingService
 */
final class PageLoggingServiceTest extends TestCase
{

    public function testCreatePageLoggingServiceInstance(): void
    {
        $PageLoggingService = new PageLoggingService();
        $this->assertInstanceOf(PageLoggingService::class, $PageLoggingService);
    }
}
