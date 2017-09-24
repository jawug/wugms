<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers ServiceDAO
 */
final class ServiceDAOTest extends TestCase
{

    public function testCreateServiceDAOInstance(): void
    {
        $ServiceDAO = new ServiceDAO();
        $this->assertInstanceOf(ServiceDAO::class, $ServiceDAO);
    }
}
