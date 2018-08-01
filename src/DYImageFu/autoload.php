<?php
/**
 * File: autoload.php
 * Author: yusuf shakeel
 * github: https://github.com/yusufshakeel/dyimagefu
 * Date: 12-Feb-2014 Wed
 * Description: This file contains the autoload.
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

if (version_compare(PHP_VERSION, '5.5.0', '<')) {
	throw new Exception('DYImageFu requires PHP version 5.5 or higher.');
}

if (!extension_loaded('gd')) {
	throw new Exception('DYImageFu requires GD extension.');
}

spl_autoload_register(function ($class) {
	
	$namespace = 'DYImageFu\\';
	
	$baseDir = __DIR__;
	
	// if class is not using namespace then return
	$len = strlen($namespace);
	if (strncmp($namespace, $class, $len) !== 0) {
		return;
	}
	
	// get the relative class
	$relativeClass = substr($class, $len);
	
	// find file
	$file = $baseDir . '/' . str_replace('\\', '/', $relativeClass) . '.php';
	
	// require the file if exists
	if (file_exists($file)) {
		require $file;
	}
	
});