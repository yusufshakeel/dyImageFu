<?php
/**
 * File: Validator.php
 * Author: Yusuf Shakeel
 * github: https://github.com/yusufshakeel/dyimagefu
 * Date: 12-Feb-2014 Wed
 * Description: This file contains the Validator class.
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

namespace DYImageFu\Utilities;

class Validator
{
    /**
     * This method will return the quality value.
     *
     * @param $quality
     * @return array
     * @throws \Exception
     */
    public static function validateImageQuality($quality)
    {
        // check data type of the $quality
        if (!in_array(gettype($quality), array("integer", "double"))) {
            throw new \Exception('Quality must be a number.');
        }

        // check quality range
        if ($quality > 100 || $quality <= 0) {
            throw new \Exception('Quality must be greater than 0 and less than or equal to 100.');
        }

        return array(
            "type" => gettype($quality),
            "value" => $quality
        );
    }
}