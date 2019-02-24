<?php
/**
 * File: CropTest.php
 * Author: Yusuf Shakeel
 * github: https://github.com/yusufshakeel/dyimagefu
 * Date: 12-Feb-2014 Wed
 * Description: This file contains test for the Crop class.
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

namespace DYImageFu\Core;

use PHPUnit\Framework\TestCase;
use DYImageFu\Core\Crop;

class CropTest extends TestCase
{

    public function test__construct()
    {
        /**
         * ===================
         * src
         * ===================
         */
        // src is required
        $option = [];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('src is required.', $e->getMessage());
        }

        // a valid src is required
        $option = [
            'src' => __DIR__ . '/../../example/image/invalid-image.jpg'
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('src file does not exists.', $e->getMessage());
        }

        /**
         * ===================
         * destDir
         * ===================
         */
        // destDir is required
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('destDir is required.', $e->getMessage());
        }

        // valid destDir is required
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output/invalid-dir/',
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('destDir is not a directory.', $e->getMessage());
        }

        /**
         * ===================
         * config
         * ===================
         */
        // config is required
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config is required.', $e->getMessage());
        }

        /**
         * ===================
         * config.type
         * ===================
         */
        // config type
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'type' => 'unknown'
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals("config type must either be set to 'crop' or 'center-crop'.", $e->getMessage());
        }

        /**
         * =================
         * config.x
         * =================
         */
        // config x for config.type=CROP
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => []
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config x is required.', $e->getMessage());
        }

        // config x for config.type=CROP
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 'unknown'
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config x must be an integer or decimal value.', $e->getMessage());
        }

        // config x for config.type=CROP
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => -100
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config x must be 0 or a positive number.', $e->getMessage());
        }

        // config x for config.type=CROP
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 2000
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config x can\'t be greater than source image width.', $e->getMessage());
        }

        /**
         * =======================
         * config.y
         * =======================
         */
        // config y for config.type=CROP
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config y is required.', $e->getMessage());
        }

        // config y for config.type=CROP
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => 'unknown'
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config y must be an integer or decimal value.', $e->getMessage());
        }

        // config y for config.type=CROP
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => -100
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config y must be 0 or a positive number.', $e->getMessage());
        }

        // config y for config.type=CROP
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => 2000
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config y can\'t be greater than source image height.', $e->getMessage());
        }

        /**
         * =======================
         * config.width
         * =======================
         */
        // config width
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => 600
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config width is required.', $e->getMessage());
        }

        // config width must be number
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => 600,
                'width' => 'unkown'
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config width must be an integer or decimal value.', $e->getMessage());
        }

        // config width must be 0 or positive number
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => 600,
                'width' => -100
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config width must be 0 or a positive number.', $e->getMessage());
        }

        // config width must be less than or equal to source image width
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => 600,
                'width' => 2000
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config width can\'t be greater than source image width.', $e->getMessage());
        }

        /**
         * =======================
         * config.height
         * =======================
         */
        // config height
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => 600,
                'width' => 100
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config height is required.', $e->getMessage());
        }

        // config height must be number
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => 600,
                'width' => 100,
                'height' => 'unknown'
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config height must be an integer or decimal value.', $e->getMessage());
        }

        // config height must be 0 or positive number
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => 600,
                'width' => 100,
                'height' => -100
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config height must be 0 or a positive number.', $e->getMessage());
        }

        // config height must be less than or equal to source image height
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 1000,
                'y' => 600,
                'width' => 1000,
                'height' => 2000
            ]
        ];
        try {
            $obj = new Crop($option);
        } catch (\Exception $e) {
            $this->assertEquals('config height can\'t be greater than source image height.', $e->getMessage());
        }
    }

    public function testGetOption()
    {
        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 10,
                'y' => 10,
                'width' => 1000,
                'height' => 1000,
            ]
        ];

        $obj = new Crop($option);

        $expected = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'srcDetail' => [
                'filename' => 'landscape',
                'extension' => 'jpeg',
                'dirname' => __DIR__ . '/../../example/image',
                'width' => 1920,
                'height' => 1280,
                'mime' => 'image/jpeg',
                'size' => 356965,
                'imageMode' => 'landscape_image',
                'aspectRatio' => 1.5,
            ],
            'config' => [
                'type' => 'crop',
                'x' => 10,
                'y' => 10,
                'width' => 1000,
                'height' => 1000,
            ]
        ];

        $result = $obj->getOption();

        $this->assertEquals($expected, $result);
    }

    public function testCrop()
    {
        /**
         * ===================
         * jpeg image
         * ===================
         */
        $width = 1800;
        $height = 1200;

        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.jpeg',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 0,
                'y' => 0,
                'width' => $width,
                'height' => $height,
            ]
        ];

        $obj = new Crop($option);
        $opt = $obj->getOption();
        $obj->crop();

        // assert that the resized file exists
        $file = __DIR__ . '/../../example/output/' . $opt['srcDetail']['filename'] . '_crop.' . $opt['srcDetail']['extension'];
        $this->assertEquals(true, file_exists($file));

        // assert that the resized file dimension matches
        $fileinfo = getimagesize($file);
        $this->assertEquals($width, $fileinfo[0]);
        $this->assertEquals($height, $fileinfo[1]);

        /**
         * ===================
         * png image
         * ===================
         */
        $width = 1800;
        $height = 800;

        $option = [
            'src' => __DIR__ . '/../../example/image/landscape.png',
            'destDir' => __DIR__ . '/../../example/output',
            'config' => [
                'x' => 0,
                'y' => 0,
                'width' => $width,
                'height' => $height,
            ]
        ];

        $obj = new Crop($option);
        $opt = $obj->getOption();
        $obj->crop();

        // assert that the resized file exists
        $file = __DIR__ . '/../../example/output/' . $opt['srcDetail']['filename'] . '_crop.' . $opt['srcDetail']['extension'];
        $this->assertEquals(true, file_exists($file));

        // assert that the resized file dimension matches
        $fileinfo = getimagesize($file);
        $this->assertEquals($width, $fileinfo[0]);
        $this->assertEquals($height, $fileinfo[1]);
    }
}
