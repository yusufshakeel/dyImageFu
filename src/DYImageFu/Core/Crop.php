<?php
/**
 * File: Crop.php
 * Author: Yusuf Shakeel
 * github: https://github.com/yusufshakeel/dyimagefu
 * Date: 12-Feb-2014 Wed
 * Description: This file contains the Crop class.
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

use DYImageFu\Utilities\Helper;

class Crop
{
    private const CONFIG_TYPE_CROP = 'crop';
    private const CONFIG_TYPE_CENTER_CROP = 'center-crop';

    /**
     * This options array for crop operation.
     *
     * @var array
     */
    private $_option = [
        'src' => '',
        'srcDetail' => [],  // this will be computed using 'src'
        'destDir' => '',
        'config' => [
            /**
             * this is the type of the crop:
             *
             * - crop
             *  requires: x, y, width, height
             *  description: Will crop the image.
             *
             *         Width
             *  +------------------------+
             *  |  (x,y)   width         |
             *  |    *--------------+    |
             *  |    |              |    | Height
             *  |    | height       |    |
             *  |    |              |    |
             *  |    +--------------+    |
             *  +------------------------+
             *
             *
             * - center-crop
             *  requires: width, height
             *  description: Will place the crop-window at the center of the image
             *               and then perform the crop.
             */
            'type' => self::CONFIG_TYPE_CROP,

            /**
             * starting x co-ordinate for the crop operation.
             */
            'x' => 0,

            /**
             * starting y co-ordinate for the crop operation.
             */
            'y' => 0,

            /**
             * final width of the crop image.
             */
            'width' => 0,

            /**
             * final height of the crop image.
             */
            'height' => 0
        ]
    ];

    /**
     * Crop constructor.
     *
     * @param array $option
     * @throws \Exception
     */
    public function __construct(array $option)
    {
        $this->_init($option);
    }

    /**
     * This function will set option for crop operation.
     *
     * @param array $option
     * @throws \Exception
     */
    public function setOption(array $option)
    {
        $this->_init($option);
    }

    /**
     * This will return the option.
     *
     * @return array
     */
    public function getOption()
    {
        return $this->_option;
    }

    /**
     * This will initialise the options for crop operation.
     *
     * @param array $option
     * @throws \Exception
     */
    private function _init(array $option)
    {
        /**
         * check and set source image file
         */
        if (!isset($option['src'])) {

            throw new \Exception('src is required.');

        } else if (!file_exists($option['src'])) {

            throw new \Exception('src file does not exists.');

        } else {

            $this->_option['src'] = $option['src'];

            // set source image detail
            $this->_option['srcDetail'] = Helper::getImageDetail($this->_option['src']);

        }

        /**
         * check and set destination directory
         */
        if (!isset($option['destDir'])) {

            throw new \Exception('destDir is required.');

        } else if (!is_dir($option['destDir'])) {

            throw new \Exception('destDir is not a directory.');

        } else {

            $this->_option['destDir'] = $option['destDir'];

        }

        /**
         * check config
         */
        if (!isset($option['config'])) {

            throw new \Exception('config is required.');

        } else {

            $this->_option['config'] = [];

        }

        /**
         * check and set type
         */
        if (!isset($option['config']['type'])) {

            $this->_option['config']['type'] = self::CONFIG_TYPE_CROP;

        } else if (!in_array($option['config']['type'], [self::CONFIG_TYPE_CROP, self::CONFIG_TYPE_CENTER_CROP])) {

            $errMsg = sprintf("config type must either be set to '%s' or '%s'.", self::CONFIG_TYPE_CROP, self::CONFIG_TYPE_CENTER_CROP);

            throw new \Exception($errMsg);

        } else {

            $this->_option['config']['type'] = $option['config']['type'];

        }

        /**
         * check and set x and y
         */
        if ($this->_option['config']['type'] === self::CONFIG_TYPE_CROP) {

            // set x
            if (!isset($option['config']['x'])) {

                throw new \Exception('config x is required.');

            }

            if (in_array(gettype($option['config']['x']), ['integer', 'double'])) {

                $this->_option['config']['x'] = $option['config']['x'];

            } else {
                throw new \Exception('config x must be an integer or decimal value.');
            }

            // check x
            if ($this->_option['config']['x'] < 0) {
                throw new \Exception('config x must be 0 or a positive number.');
            } else if ($this->_option['config']['x'] > $this->_option['srcDetail']['width']) {
                throw new \Exception("config x can't be greater than source image width.");
            }

            // set y
            if (!isset($option['config']['y'])) {

                throw new \Exception('config y is required.');

            }

            if (in_array(gettype($option['config']['y']), ['integer', 'double'])) {

                $this->_option['config']['y'] = $option['config']['y'];

            } else {
                throw new \Exception('config y must be an integer or decimal value.');
            }

            // check y
            if ($this->_option['config']['y'] < 0) {
                throw new \Exception('config y must be 0 or a positive number.');
            } else if ($this->_option['config']['y'] > $this->_option['srcDetail']['height']) {
                throw new \Exception("config y can't be greater than source image height.");
            }

        } else {
            $this->_option['config']['x'] = 0;
            $this->_option['config']['y'] = 0;
        }

        /**
         * check and set width
         */
        if (!isset($option['config']['width'])) {

            throw new \Exception('config width is required.');

        }
        if (in_array(gettype($option['config']['width']), ['integer', 'double'])) {

            $this->_option['config']['width'] = $option['config']['width'];

        } else {
            throw new \Exception('config width must be an integer or decimal value.');
        }
        // check width
        if ($this->_option['config']['width'] < 0) {
            throw new \Exception('config width must be 0 or a positive number.');
        } else if ($this->_option['config']['width'] > $this->_option['srcDetail']['width']) {
            throw new \Exception("config width can't be greater than source image width.");
        }

        /**
         * check and set height
         */
        if (!isset($option['config']['height'])) {

            throw new \Exception('config height is required.');

        }
        if (in_array(gettype($option['config']['height']), ['integer', 'double'])) {

            $this->_option['config']['height'] = $option['config']['height'];

        } else {
            throw new \Exception('config height must be an integer or decimal value.');
        }
        // check height
        if ($this->_option['config']['height'] < 0) {
            throw new \Exception('config height must be 0 or a positive number.');
        } else if ($this->_option['config']['height'] > $this->_option['srcDetail']['width']) {
            throw new \Exception("config height can't be greater than source image height.");
        }

    }

    /**
     * This will crop the image.
     *
     * @throws \Exception
     */
    public function crop()
    {
        $src = $this->_option['src'];
        $mime = $this->_option['srcDetail']['mime'];
        $srcWidth = $this->_option['srcDetail']['width'];
        $srcHeigth = $this->_option['srcDetail']['height'];
        $srcFilename = $this->_option['srcDetail']['filename'];
        $extension = $this->_option['srcDetail']['extension'];

        $destDir = $this->_option['destDir'];

        $cropType = $this->_option['config']['type'];

        $cropImgWidth = $this->_option['config']['width'];
        $cropImgHeight = $this->_option['config']['height'];

        // compute crop image x,y co-ordinate
        switch ($cropType) {
            case self::CONFIG_TYPE_CROP:
                $cropImgX = $this->_option['config']['x'];
                $cropImgY = $this->_option['config']['y'];
                break;

            case self::CONFIG_TYPE_CENTER_CROP:
                $cropImgX = floatval(($srcWidth - $cropImgWidth) / 2);
                $cropImgY = floatval(($srcHeigth - $cropImgHeight) / 2);
                break;
        }

        switch ($mime) {
            case Helper::IMAGE_MIME_JPG:
            case Helper::IMAGE_MIME_JPEG:
                $srcImgFile = imagecreatefromjpeg($src);
                if ($srcImgFile === false) {
                    throw new \Exception("Unable to create image from $extension file.");
                }

                // for jpg/jpeg image quality must be 0 to 100
                $quality = 100;

                break;

            case Helper::IMAGE_MIME_PNG:
                $srcImgFile = imagecreatefrompng($src);
                if ($srcImgFile === false) {
                    throw new \Exception("Unable to create image from $extension file.");
                }

                // for png images quality must be between 0 to 9
                $quality = 9;

                break;

            default:
                throw new \Exception('Invalid MIME type.');
        }

        // crop
        $croppedImage = imagecrop(
            $srcImgFile,
            [
                'x' => $cropImgX,
                'y' => $cropImgY,
                'width' => $cropImgWidth,
                'height' => $cropImgHeight
            ]
        );

        if ($croppedImage === false) {
            throw new \Exception('Failed to crop image.');
        }

        // create image
        switch ($mime) {
            case Helper::IMAGE_MIME_JPG:
            case Helper::IMAGE_MIME_JPEG:
                $destFile = $destDir . '/' . $srcFilename . '_crop.' . $extension;
                if (imagejpeg($croppedImage, $destFile, $quality) === false) {
                    throw new \Exception('Failed to save image.');
                }
                break;

            case Helper::IMAGE_MIME_PNG:
                $destFile = $destDir . '/' . $srcFilename . '_crop.' . $extension;
                if (imagepng($croppedImage, $destFile, $quality) === FALSE) {
                    throw new \Exception("Failed to save image.");
                }
                break;
        }

        // destroy image
        if (imagedestroy($croppedImage) === false) {
            throw new \Exception("Failed to free memory associated with cropped image.");
        }
        if (imagedestroy($srcImgFile) === false) {
            throw new \Exception("Failed to free memory associated with source image.");
        }
    }
}