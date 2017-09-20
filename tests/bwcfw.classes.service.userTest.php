<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers serviceUser
 */
final class serviceUserTest extends TestCase
{

    public function testCreateserviceUserInstance(): void
    {
        $serviceUser = new serviceUser();
        $this->assertInstanceOf(serviceUser::class, $serviceUser);
    }
}
