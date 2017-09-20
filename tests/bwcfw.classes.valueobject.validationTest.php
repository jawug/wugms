<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers voValidation
 */
final class voValidationTest extends TestCase
{

    public function testCreatevoValidationInstance(): void
    {
        $voValidation = new voValidation();
        $this->assertInstanceOf(voValidation::class, $voValidation);
    }
}
