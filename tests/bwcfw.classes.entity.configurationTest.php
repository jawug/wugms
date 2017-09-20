<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers entityConfiguration
 */
final class entityConfigurationTest extends TestCase
{

    public function testCreateentityConfigurationInstance(): void
    {
        $entityConfiguration = new entityConfiguration();
        $this->assertInstanceOf(entityConfiguration::class, $entityConfiguration);
    }
}
