<?php
/**
 * File: HelperTest.php
 * Author: Yusuf Shakeel
 * github: https://github.com/yusufshakeel/dyimagefu
 * Date: 12-Feb-2014 Wed
 * Description: This file contains test for the Helper class.
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
use DYImageFu\Utilities\Helper;

class HelperTest extends TestCase
{
    public function testGetProportionalHeight()
    {
        $computed = Helper::getProportionalHeight(500, 200, 300);
        $this->assertEquals(120, $computed);
    }

    public function testGetProportionalWidth()
    {
        $computed = Helper::getProportionalWidth(500, 200, 120);
        $this->assertEquals(300, $computed);
    }

    public function testGetPercentageValue()
    {
        $computed = Helper::getPercentageValue(500, 50);
        $this->assertEquals(250, $computed);
    }

    public function testGetImageDetail()
    {
        $image = __DIR__ . '/../../example/image/landscape.jpeg';
        $result = Helper::getImageDetail($image);
        $expected = [
            'filename' => 'landscape',
            'extension' => 'jpeg',
            'dirname' => __DIR__ . '/../../example/image',
            'width' => 1920,
            'height' => 1280,
            'mime' => 'image/jpeg',
            'size' => 356965,
            'imageMode' => 'landscape_image',
            'aspectRatio' => 1.5
        ];
        $this->assertEquals($expected, $result);
    }
}