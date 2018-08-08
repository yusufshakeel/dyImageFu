<?php
/**
 * File: ValidatorTest.php
 * Author: Yusuf Shakeel
 * github: https://github.com/yusufshakeel/dyimagefu
 * Date: 12-Feb-2014 Wed
 * Description: This file contains test for the Validator class.
 *
 * MIT License
 *
 * Copyright (c) 2018 Yusuf Shakeel
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace DYImageFu\Tests\Utilities;

use PHPUnit\Framework\TestCase;
use DYImageFu\Utilities\Validator;

class ValidatorTest extends TestCase
{
    public function testValidateImageQuality()
    {
        // testing integer value for quality
        $quality = 50;
        $expected = [
            'type' => 'integer',
            'value' => 50
        ];
        $this->assertEquals($expected, Validator::validateImageQuality($quality));

        // testing floating value for quality
        $quality = 80.1;
        $expected = [
            'type' => 'double',
            'value' => 80.1
        ];
        $this->assertEquals($expected, Validator::validateImageQuality($quality));

        // testing value greater than 100
        try {
            $quality = 101;
            Validator::validateImageQuality($quality);
        } catch (\Exception $e) {
            $this->assertEquals('Quality must be greater than 0 and less than or equal to 100.', $e->getMessage());
        }

        // testing value equal to 0
        try {
            $quality = 0;
            Validator::validateImageQuality($quality);
        } catch (\Exception $e) {
            $this->assertEquals('Quality must be greater than 0 and less than or equal to 100.', $e->getMessage());
        }

        // testing value less than 0
        try {
            $quality = -1;
            Validator::validateImageQuality($quality);
        } catch (\Exception $e) {
            $this->assertEquals('Quality must be greater than 0 and less than or equal to 100.', $e->getMessage());
        }

        // testing invalid value
        try {
            $quality = 'invalid';
            Validator::validateImageQuality($quality);
        } catch (\Exception $e) {
            $this->assertEquals('Quality must be a number.', $e->getMessage());
        }
    }
}