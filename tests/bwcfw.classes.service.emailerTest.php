<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers ServiceEmailer
 */
final class ServiceEmailerTest extends TestCase
{

    public function testCreateServiceEmailerInstance(): void
    {
        $ServiceEmailer = new ServiceEmailer();
        $this->assertInstanceOf(ServiceEmailer::class, $ServiceEmailer);
    }
}
