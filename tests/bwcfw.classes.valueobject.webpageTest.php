<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers voWebPage
 */
final class voWebPageTest extends TestCase
{

    public function testCreatevoWebPageInstance(): void
    {
        $voWebPage = new voWebPage();
        $this->assertInstanceOf(voWebPage::class, $voWebPage);
    }
}
