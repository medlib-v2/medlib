<?php

namespace Medlib\Services;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProcessImage {

	/**
	 * Save Image to the public folder
	 *
	 * @param $file, $path, $width, $height
	 * @return $filePath
	 */
	public function execute($file, $path, $width, $height) {

	    $filename = $this->rename($file);
        $full_path = public_path($path);

		Image::make($file)->resize($width, $height)->save($full_path.$filename);
		//return asset($path.$filename);
        return $path.$filename;
	}

	/**
	 * Rename a image
	 *
	 * @param $file
	 *
	 * @return $filename
	 */
	public function rename($file) {

		$faker = Faker::create();
		switch(exif_imagetype($file)) {
			
			 case IMAGETYPE_GIF : return $faker->sha1.'.gif';
				 break;
			 case IMAGETYPE_JPEG : return $faker->sha1.'.jpg';
				 break;
			 case IMAGETYPE_PNG : return $faker->sha1.'.png';
				 break;
			 case IMAGETYPE_BMP : return $faker->sha1.'.bmp';
		 }
	
	}

	/**
	 * Resize an image
	 *
	 * @param  string  $url
	 * @param  integer $width
	 * @param  integer $height
	 * @param  boolean $crop
	 * @param  int $quality
	 * @return string
	 */
	public function resize($url, $width = 100, $height = null, $crop = false, $quality = 90) {

		if ($url) {
			// URL info
			$info = pathinfo($url);

			// The size
			if (!$height) $height = $width;

			// Quality
			$quality = Config::get('image.quality', $quality);

			// Directories and file names
			$fileName       = $info['basename'];
			$sourceDirPath  = public_path() . '/' . $info['dirname'];
			$sourceFilePath = $sourceDirPath . '/' . $fileName;
			$targetDirName  = $width . 'x' . $height . ($crop ? '_crop' : '');
			$targetDirPath  = $sourceDirPath . '/' . $targetDirName . '/';
			$targetFilePath = $targetDirPath . $fileName;
			$targetUrl      = asset($info['dirname'] . '/' . $targetDirName . '/' . $fileName);


			/**
			// Create directory if missing
			try
			{
				// Create dir if missing
				if ( ! File::isDirectory($targetDirPath) and $targetDirPath) @File::makeDirectory($targetDirPath);

				// Set the size
				$size = Image::make($sourceFilePath) ;new \Imagine\Image\Box($width, $height);

				// Now the mode
				$mode = $crop ? \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND : \Imagine\Image\ImageInterface::THUMBNAIL_INSET;

				if ( ! File::exists($targetFilePath) or (File::lastModified($targetFilePath) < File::lastModified($sourceFilePath)))
				{
					Image::make($sourceFilePath)->resize($size, $mode)->save($targetFilePath, array('quality' => $quality));

				}
			}
			catch (\Exception $e)
			{
				Log::error('[IMAGE SERVICE] Failed to resize image "' . $url . '" [' . $e->getMessage() . ']');
			}

			return $targetUrl;

			*/
		}
	}

	/**
	 * Helper for creating thumbs
	 *
	 * @param string $url
	 * @param integer $width
	 * @param integer $height
	 * @return string
	 */
	public function thumb($url, $width, $height = null) {

		return $this->resize($url, $width, $height, true);
	}

	/**
	 * Upload an image to the public storage
	 *
	 * @param  UploadedFile $file
	 * @param string $dir
	 * @param boolean $createDimensions
	 * @return string
	 */
	public function upload(UploadedFile $file, $dir = null, $createDimensions = false) {

		if ($file) {

			// Generate random dir
			if (!$dir) $dir = Config::get('image.upload_path').'images/';

			// Get file info and try to move
			$destination = $dir;
			$filename = $this->rename($file);
			$path = $dir . '/' . $filename;
			$uploaded = $file->move($destination, $filename);

			if ($uploaded) {

				if ($createDimensions) $this->createDimensions($path);

				return asset('uploads/images/'.$filename);
			}
		}
	}

	/**
	 * Creates image dimensions based on a configuration
	 * @param  string $url
	 * @param  array  $dimensions
	 * @return void
	 */
	public function createDimensions($url, $dimensions = []) {

		// Get default dimensions
		$defaultDimensions = Config::get('image.dimensions');

		if (is_array($defaultDimensions)) $dimensions = array_merge($defaultDimensions, $dimensions);

		foreach ($dimensions as $dimension)  {

			// Get dimmensions and quality
			$width   = (int) $dimension[0];
			$height  = isset($dimension[1]) ?  (int) $dimension[1] : $width;
			$crop    = isset($dimension[2]) ? (bool) $dimension[2] : false;
			$quality = isset($dimension[3]) ?  (int) $dimension[3] : Config::get('image.quality');

			// Run resizer
			$img = $this->resize($url, $width, $height, $crop, $quality);
		}
	}
}