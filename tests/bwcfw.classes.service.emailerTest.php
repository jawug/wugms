<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers serviceEmailer
 */
final class serviceEmailerTest extends TestCase
{

    public function testCreateserviceEmailerInstance(): void
    {
        $serviceEmailer = new serviceEmailer();
        $this->assertInstanceOf(serviceEmailer::class, $serviceEmailer);
    }
}
