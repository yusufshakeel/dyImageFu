<?php
/**
 * File: Helper.php
 * Author: Yusuf Shakeel
 * github: https://github.com/yusufshakeel/dyimagefu
 * Date: 12-Feb-2014 Wed
 * Description: This file contains the Helper class.
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

class Helper
{
    /**
     * Constants
     */
    const IMAGE_MODE_LANDSCAPE = 'landscape_image';
    const IMAGE_MODE_PORTRAIT = 'portrait_image';

    const IMAGE_MIME_JPG = 'image/jpg';
    const IMAGE_MIME_JPEG = 'image/jpeg';
    const IMAGE_MIME_PNG = 'image/png';
    const IMAGE_MIME_GIF = 'image/gif';

    /**
     * This function will return the proportional height based on the required width and
     * dimensions of the source image.
     *
     * (Aspect ratio of the image is maintained)
     *
     * Example: If $originalWidth = 500 and $originalHeight = 200
     * and $requiredWidth = 300
     * then $requiredHeight = 120
     *
     * @param integer $originalWidth
     * @param integer $originalHeight
     * @param integer $requiredWidth
     * @return integer
     */
    public static function getProportionalHeight($originalWidth, $originalHeight, $requiredWidth)
    {
        return intval(($originalHeight / $originalWidth) * $requiredWidth);
    }

    /**
     * This function will return the proportional width based on required height and
     * dimensions of the source image.
     *
     * (Aspect ratio of the image is maintained)
     *
     * Example: If $originalWidth = 500 and $originalHeight = 200
     * and $requiredHeight = 120
     * then $requiredWidth = 300
     *
     * @param integer $originalWidth
     * @param integer $originalHeight
     * @param integer $requiredHeight
     * @return integer
     */
    public static function getProportionalWidth($originalWidth, $originalHeight, $requiredHeight)
    {
        return intval(($originalWidth / $originalHeight) * $requiredHeight);
    }

    /**
     * This function will return percent of x.
     *
     * @param integer $x This is the value. Example: 100
     * @param string $percent This is the percentage we want from the value. Example 80 for 80%.
     * @return integer
     */
    public static function getPercentageValue($x, $percent)
    {
        return intval($x * ($percent / 100));
    }

    /**
     * This will return the image detail.
     *
     * @param string $image This is the image file path. Example: /var/www/html/image/sample.png
     * @return array
     */
    public static function getImageDetail($image)
    {
        $detail = getimagesize($image);

        $pathinfo = pathinfo($image);
        $filename = $pathinfo['filename'];
        $dirname = $pathinfo['dirname'];
        $extension = $pathinfo['extension'];

        // mode: landscape/portrait image
        $imgMode = ($detail[0] >= $detail[1]) ? self::IMAGE_MODE_LANDSCAPE : self::IMAGE_MODE_PORTRAIT;

        // aspect ratio
        $aspectRatio = $detail[0] / $detail[1];

        $imgDetail = [
            'filename' => $filename,
            'extension' => $extension,
            'dirname' => $dirname,
            'width' => $detail[0],
            'height' => $detail[1],
            'mime' => $detail['mime'],
            'size' => filesize($image),
            'imageMode' => $imgMode,
            'aspectRatio' => $aspectRatio
        ];

        return $imgDetail;
    }

}