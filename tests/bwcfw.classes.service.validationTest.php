<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

/**
 * @covers serviceValidation
 */
final class serviceValidationTest extends TestCase
{

    public function testValidateDate(): void
    {
        $this->assertEquals(
            '2017-08-11', (new serviceValidation())->validateDate('2017-08-11')
        );
    }

    public function testInvalidateDate(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->validateDate('aaaaaa');
    }

//validateCheckNumeric

    public function testValidateCheckNumeric(): void
    {
        $this->assertEquals(
            '2017', (new serviceValidation())->validateCheckNumeric('2017')
        );
    }

    public function testInvalidateCheckNumeric(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->validateCheckNumeric('aaaaaa');
    }

//validateStringNotEmpty    

    public function testValidateStringNotEmpty(): void
    {
        $this->assertEquals(
            'String is not empty', (new serviceValidation())->validateStringNotEmpty('String is not empty')
        );
    }

    public function testInvalidateStringNotEmpty(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->validateStringNotEmpty(NULL);
    }

//validateStringLength
    public function testValidateStringLength(): void
    {
        $this->assertEquals(
            'abcd', (new serviceValidation())->validateStringLength('abcd', 4)
        );
    }

    public function testInvalidateStringLength(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->validateStringLength('abcd', 3);
    }

//validateNumberBTV
    public function testValidateNumberBTV(): void
    {
        $this->assertEquals(
            TRUE, (new serviceValidation())->validateNumberBTV(5, 1, 10)
        );
    }

    public function testInvalidateNumberBTV(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->validateNumberBTV(5, 10, 20);
    }

    //StartDateLTTEndDate
    public function testStartDateLTTEndDate(): void
    {
        $this->assertEquals(
            TRUE, (new serviceValidation())->StartDateLTTEndDate('2017-08-20', '2017-08-21')
        );
    }

    public function testInvalidateStartDateLTTEndDate(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->StartDateLTTEndDate('2017-08-21', '2017-08-20');
    }

//    validateStringRegex
    public function testValidateStringRegex(): void
    {
        $this->assertEquals(
            'abcd abcd abcd', (new serviceValidation())->validateStringRegex('abcd abcd abcd', '/^.{10,100}$/i')
        );
    }

    public function testInvalidateStringRegex(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->validateStringRegex('abcd', '/^.{10,100}$/i');
    }

    //    validateStringLengthMinMax
    public function testValidateStringLengthMinMax(): void
    {
        $this->assertEquals(
            'abcdabcd', (new serviceValidation())->validateStringLengthMinMax('abcdabcd', 5, 10)
        );
    }

    public function testInvalidateStringLengthMinMax(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->validateStringLengthMinMax('abcd', 5, 10);
    }

    //    validateStringUnique
    public function testValidateStringUnique(): void
    {
        $this->assertEquals(
            TRUE, (new serviceValidation())->validateStringUnique('abcdabcd', 'abcd')
        );
    }

    public function testInvalidateStringUnique(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->validateStringUnique('abcdabcd', 'abcdabcd');
    }

    //    validateStringSame
    public function testValidateStringSame(): void
    {
        $this->assertEquals(
            'abcdabcd', (new serviceValidation())->validateStringSame('abcdabcd', 'abcdabcd')
        );
    }

    public function testInvalidateStringSame(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->validateStringSame('abc', 'xyz');
    }

    //    validateEmail
    public function testValidateEmail(): void
    {
        $this->assertEquals(
            'address@somewhere.com', (new serviceValidation())->validateEmail('address@somewhere.com')
        );
    }

    public function testInvalidateEmail(): void
    {
        $this->expectException(Exception::class);
        (new serviceValidation())->validateEmail('abcd');
    }
}
