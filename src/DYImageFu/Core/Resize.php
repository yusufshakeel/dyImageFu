<?php
/**
 * File: Resize.php
 * Author: Yusuf Shakeel
 * github: https://github.com/yusufshakeel/dyimagefu
 * Date: 12-Feb-2014 Wed
 * Description: This file contains the Resize class.
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

class Resize
{
    /**
     * This options array for resize operation.
     *
     * @var array
     */
    private $_option = [
        'src' => '',
        'srcDetail' => [],  // this will be computed using 'src'
        'destDir' => '',
        'config' => [
            'resize' => 'width',    // either width or height
            'dimension' => [],
            'dimensionOtherSide' => [], // this will be computed using 'srcDetail', 'resize' and 'dimension'
            'quality' => []
        ]
    ];

    /**
     * Resize constructor.
     *
     * @param array $option
     * @throws \Exception
     */
    public function __construct(array $option)
    {
        $this->_init($option);
    }

    /**
     * This function will set option for resize operation.
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
     * This will initialise the options for resize operation.
     *
     * @param array $option
     * @throws \Exception
     */
    private function _init(array $option)
    {
        // check and set source image file
        if (!isset($option['src'])) {

            throw new \Exception('src is required.');

        } else if (!file_exists($option['src'])) {

            throw new \Exception('src file does not exists.');

        } else {

            $this->_option['src'] = $option['src'];

            // set source image detail
            $this->_option['srcDetail'] = Helper::getImageDetail($this->_option['src']);

        }

        // check and set destination directory
        if (!isset($option['destDir'])) {

            throw new \Exception('destDir is required.');

        } else if (!is_dir($option['destDir'])) {

            throw new \Exception('destDir is not a directory.');

        } else {

            $this->_option['destDir'] = $option['destDir'];

        }

        // check config
        if (!isset($option['config'])) {

            throw new \Exception('config is required.');

        } else {

            $this->_option['config'] = [];

        }

        // check and set resize
        if (!isset($option['config']['resize'])) {

            throw new \Exception('config resize is required.');

        } else if (!in_array($option['config']['resize'], ['width', 'height'])) {

            throw new \Exception('config resize must either be set to "width" or "height".');

        } else {

            $this->_option['config']['resize'] = $option['config']['resize'];

        }

        // check and set dimension
        if (!isset($option['config']['dimension'])) {

            throw new \Exception('config dimension is required.');

        }
        if (in_array(gettype($option['config']['dimension']), ['integer', 'double'])) {

            $this->_option['config']['dimension'] = [$option['config']['dimension']];

        } else if (gettype($option['config']['dimension']) === "array") {

            $this->_option['config']['dimension'] = [];

            foreach ($option['config']['dimension'] as $value) {

                if (in_array(gettype($value), ['integer'])) {

                    array_push($this->_option['config']['dimension'], $value);

                } else {

                    throw new \Exception('One of the value in dimension array is of invalid type. Use integer or decimal value.');

                }

            }

        } else {
            throw new \Exception('config dimension must be an integer or decimal value or an array of integer or decimal values.');
        }
        $this->_computeDimensionOtherSide();

        // check and set quality
        if (!isset($option['config']['quality'])) {

            throw new \Exception('config quality is required.');

        }
        if (in_array(gettype($option['config']['quality']), ['integer', 'double'])) {

            $this->_option['config']['quality'] = [$option['config']['quality']];

        } else if (gettype($option['config']['quality']) === "array") {

            $this->_option['config']['quality'] = [];

            foreach ($option['config']['quality'] as $value) {

                if (in_array(gettype($value), ['integer'])) {

                    array_push($this->_option['config']['quality'], $value);

                } else {

                    throw new \Exception('One of the value in quality array is of invalid type. Use integer or decimal value.');

                }

            }
        } else {
            throw new \Exception('config quality must be an integer or decimal value or an array of integer or decimal values.');
        }
    }

    /**
     * This will compute the other side dimension.
     */
    private function _computeDimensionOtherSide()
    {
        $dimensionOtherSide = [];
        $imgMode = $this->_option['srcDetail']['imageMode'];
        $resize = $this->_option['config']['resize'];
        $dimension = $this->_option['config']['dimension'];
        $aspectRatio = $this->_option['srcDetail']['aspectRatio'];

        switch ($imgMode) {
            case Helper::IMAGE_MODE_LANDSCAPE:
            case Helper::IMAGE_MODE_PORTRAIT:
                if ($resize === 'width') {
                    foreach ($dimension as $width) {
                        $height = round($width / $aspectRatio);
                        array_push($dimensionOtherSide, $height);
                    }
                } else if ($resize === 'height') {
                    foreach ($dimension as $height) {
                        $width = round($height * $aspectRatio);
                        array_push($dimensionOtherSide, $width);
                    }
                }
                break;
        }

        $this->_option['config']['dimensionOtherSide'] = $dimensionOtherSide;
    }
}