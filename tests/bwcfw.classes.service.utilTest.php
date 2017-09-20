<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers bwcfw_util
 */
final class bwcfw_utilTest extends TestCase
{

    public function testCreatebwcfw_utilInstance(): void
    {
        $bwcfw_util = new bwcfw_util();
        $this->assertInstanceOf(bwcfw_util::class, $bwcfw_util);
    }
}
