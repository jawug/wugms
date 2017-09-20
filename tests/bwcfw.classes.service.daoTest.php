<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers serviceDAO
 */
final class serviceDAOTest extends TestCase
{

    public function testCreateserviceDAOInstance(): void
    {
        $serviceDAO = new serviceDAO();
        $this->assertInstanceOf(serviceDAO::class, $serviceDAO);
    }
}
