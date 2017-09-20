<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers voUser
 */
final class voUserTest extends TestCase
{

    public function testCreatevoUserInstance(): void
    {
        $voUser = new voUser();
        $this->assertInstanceOf(voUser::class, $voUser);
    }
}
