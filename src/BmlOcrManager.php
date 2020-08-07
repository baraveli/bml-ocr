<?php

namespace Baraveli\BmlOcr;

use Intervention\Image\ImageManagerStatic as Image;
use thiagoalessio\TesseractOCR\TesseractOCR;

class BmlOcrManager
{
    protected $hashedImage;
    protected $temporaryDirectory;

    /**
     * make.
     *
     * @param mixed $imagepath
     * @param mixed $temporaryDirectory
     *
     * @return BmlOcrManager
     */
    public function make(string $imagepath, string $temporaryDirectory): BmlOcrManager
    {
        $this->temporaryDirectory = $temporaryDirectory;
        $this->hashedImage = md5($imagepath) . '.jpg';
        $this->sharpenImage($imagepath);

        return $this;
    }

    /**
     * Detect the receipt.
     *
     * @return array
     */
    public function detect(): array
    {
        $text = (new TesseractOCR($this->temporaryDirectory . DIRECTORY_SEPARATOR . $this->hashedImage))
            ->run();
        //Remove the temporary image
        unlink($this->temporaryDirectory . DIRECTORY_SEPARATOR . $this->hashedImage);

        return $this->filter($text);
    }

    /**
     * GetHashedImage.
     *
     * @return string
     */
    public function GetHashedImage(): string
    {
        return $this->hashedImage;
    }

    /**
     * Sharpen the image and store as a temporary file.
     *
     * @param mixed $imagepath
     *
     * @return void
     */
    protected function sharpenImage(string $imagepath): void
    {
        Image::make($imagepath)
            ->crop(930, 1080, 0, 10)
            ->brightness(-9)
            ->sharpen(80)
            ->save($this->temporaryDirectory . DIRECTORY_SEPARATOR . $this->hashedImage);
    }

    /**
     * FIlter the texts and remove any empty values.
     *
     * @param mixed $text
     *
     * @return array
     */
    protected function filter(string $text): array
    {
        return array_values(array_filter(explode("\n", $text)));
    }
}
