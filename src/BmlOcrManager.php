<?php

namespace Baraveli\BmlOcr;

use Intervention\Image\ImageManagerStatic as Image;
use thiagoalessio\TesseractOCR\TesseractOCR;

class BmlOcrManager
{
    protected $hashedImage;
    protected $temporaryDirectory;

    public function make(string $imagepath)
    {
        $this->hashedImage = md5($imagepath).'.jpg';
        $this->sharpenImage($imagepath);

        return $this;
    }

    public function setTempDirectory(string $path)
    {
        $this->temporaryDirectory = $path;

        return $this;
    }

    public function detect(): Invoice
    {
        $text = (new TesseractOCR($this->hashedImage))->run();
        //Remove the temporary image
        //unlink($this->hashedImage);
        return $this->filter($text);
    }

    protected function sharpenImage(string $imagepath): void
    {
        Image::make($imagepath)
            ->sharpen(25)
            ->save($this->temporaryDirectory ? $this->temporaryDirectory.DIRECTORY_SEPARATOR.$this->hashedImage : $this->hashedImage);
    }

    protected function filter(string $text): Invoice
    {
        $result = array_values(array_filter(explode("\n", $text)));

        return new Invoice($result);
    }
}
