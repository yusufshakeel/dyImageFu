<?php
/**
 * File: ResizeTest.php
 * Author: Yusuf Shakeel
 * github: https://github.com/yusufshakeel/dyimagefu
 * Date: 12-Feb-2014 Wed
 * Description: This file contains test for the Resize class.
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

namespace DYImageFu\Tests\Core;

use PHPUnit\Framework\TestCase;
use DYImageFu\Core\Resize;

class ResizeTest extends TestCase
{
    public function testConstructor()
    {
        // src is required
        $option = [];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('src is required.', $e->getMessage());
        }

        // a valid src is required
        $option = [
            'src' => __DIR__ . '/../../example/image/invalid-image.jpg'
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('src file does not exists.', $e->getMessage());
        }

        // destDir is required
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('destDir is required.', $e->getMessage());
        }

        // valid destDir is required
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output/invalid-dir/',
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('destDir is not a directory.', $e->getMessage());
        }

        // config is required
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('config is required.', $e->getMessage());
        }

        // config resize is required
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => []
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('config resize is required.', $e->getMessage());
        }

        // config resize must be either width or height
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'unknown',
                'dimension' => 300,
                'quality' => 100
            ]
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('config resize must either be set to "width" or "height".', $e->getMessage());
        }

        // config dimension is required
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width'
            ]
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('config dimension is required.', $e->getMessage());
        }

        // config dimension must be integer/decimal value or
        // array of integer/decimal values
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => 'unknown'
            ]
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('config dimension must be an integer or decimal value or an array of integer or decimal values.', $e->getMessage());
        }

        // if config dimension is an array
        // then it must have integer/decimal values.
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => [10, 20.5, 'unknown']
            ]
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('One of the value in dimension array is of invalid type. Use integer or decimal value.', $e->getMessage());
        }

        // config quality is required
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => [1200, 920, 720]
            ]
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('config quality is required.', $e->getMessage());
        }

        // if config quality has unknow value
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => [10, 20, 30],
                'quality' => 'unknown'
            ]
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('config quality must be an integer or decimal value or an array of integer or decimal values.', $e->getMessage());
        }

        // config quality must be integer/decimal value or
        // array of integer/decimal values
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => [10, 20, 30],
                'quality' => 'unknown'
            ]
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('config quality must be an integer or decimal value or an array of integer or decimal values.', $e->getMessage());
        }

        // if config quality is an array
        // then it must have integer/decimal values.
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => [10, 20, 30],
                'quality' => [10, 20.5, 'unknown']
            ]
        ];
        try {
            $obj = new Resize($option);
        } catch (\Exception $e) {
            $this->assertEquals('One of the value in quality array is of invalid type. Use integer or decimal value.', $e->getMessage());
        }

    }

    public function testGetOption()
    {
        /* ============ LANDSCAPE IMAGE ============ */

        // check option if resizing width
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => 1200,
                'quality' => 100
            ]
        ];

        $obj = new Resize($option);
        $result = $obj->getOption();

        $expected = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'srcDetail' => [
                'filename' => 'landscape',
                'extension' => 'jpeg',
                'dirname' => __DIR__ . '/../../example/image',
                'width' => 1920,
                'height' => 1280,
                'mime' => 'image/jpeg',
                'size' => 356965,
                'imageMode' => 'landscape_image',
                'aspectRatio' => 1.5
            ],
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => [1200],
                'dimensionOtherSide' => [800],
                'quality' => [100]
            ]
        ];

        $this->assertEquals($expected, $result);


        // check option if resizing height
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'height',
                'dimension' => 1000,
                'quality' => 100
            ]
        ];

        $obj = new Resize($option);
        $result = $obj->getOption();

        $expected = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'srcDetail' => [
                'filename' => 'landscape',
                'extension' => 'jpeg',
                'dirname' => __DIR__ . '/../../example/image',
                'width' => 1920,
                'height' => 1280,
                'mime' => 'image/jpeg',
                'size' => 356965,
                'imageMode' => 'landscape_image',
                'aspectRatio' => 1.5
            ],
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'height',
                'dimension' => [1000],
                'dimensionOtherSide' => [1500],
                'quality' => [100]
            ]
        ];

        $this->assertEquals($expected, $result);


        /* ============ PORTRAIT IMAGE ============ */

        // check option if resizing width
        $option = [
            'src' => __DIR__ . '/../../example/image/portrait.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => 1200,
                'quality' => 100
            ]
        ];

        $obj = new Resize($option);
        $result = $obj->getOption();

        $expected = [
            'src' => __DIR__ . '/../../example/image/portrait.jpeg',
            'srcDetail' => [
                'filename' => 'portrait',
                'extension' => 'jpeg',
                'dirname' => __DIR__ . '/../../example/image',
                'width' => 1280,
                'height' => 1920,
                'mime' => 'image/jpeg',
                'size' => 219381,
                'imageMode' => 'portrait_image',
                'aspectRatio' => 0.6666666666666666
            ],
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => [1200],
                'dimensionOtherSide' => [1800],
                'quality' => [100]
            ]
        ];

        $this->assertEquals($expected, $result);


        // check option if resizing height
        $option = [
            'src' => __DIR__ . '/../../example/image/portrait.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'height',
                'dimension' => 900,
                'quality' => 100
            ]
        ];

        $obj = new Resize($option);
        $result = $obj->getOption();

        $expected = [
            'src' => __DIR__ . '/../../example/image/portrait.jpeg',
            'srcDetail' => [
                'filename' => 'portrait',
                'extension' => 'jpeg',
                'dirname' => __DIR__ . '/../../example/image',
                'width' => 1280,
                'height' => 1920,
                'mime' => 'image/jpeg',
                'size' => 219381,
                'imageMode' => 'portrait_image',
                'aspectRatio' => 0.6666666666666666
            ],
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'height',
                'dimension' => [900],
                'dimensionOtherSide' => [600],
                'quality' => [100]
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testResize()
    {
        /* ========== LANDSCAPE IMAGE ========== */

        // resizing width
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => [1200, 960, 720, 540, 480, 320, 240, 150],
                'quality' => [80, 80, 80, 85, 85, 90, 90, 90]
            ]
        ];
        $obj = new Resize($option);
        $obj->resize();

        // resizing width
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.png',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'width',
                'dimension' => [1200, 960, 720, 540, 480, 320, 240, 150],
                'quality' => [80, 80, 80, 85, 85, 90, 90, 90]
            ]
        ];
        $obj = new Resize($option);
        $obj->resize();


        /* ========== PORTRAIT IMAGE ========== */

        // resizing width
        $option = [
            'src' => __DIR__ . '/../../example/image/portrait.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'height',
                'dimension' => [1200, 960, 720, 540, 480, 320, 240, 150],
                'quality' => [80, 80, 80, 85, 85, 90, 90, 90]
            ]
        ];
        $obj = new Resize($option);
        $obj->resize();

        // resizing height
        $option = [
            'src' => __DIR__ . '/../../example/image/portrait.png',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'resize' => 'height',
                'dimension' => [1200, 960, 720, 540, 480, 320, 240, 150],
                'quality' => [80, 80, 80, 85, 85, 90, 90, 90]
            ]
        ];
        $obj = new Resize($option);
        $obj->resize();

    }
}