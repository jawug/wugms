<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers voDAO
 */
final class voDAOTest extends TestCase
{

    public function testCreatevoDAOInstance(): void
    {
        $voDAO = new voDAO();
        $this->assertInstanceOf(voDAO::class, $voDAO);
    }
}
