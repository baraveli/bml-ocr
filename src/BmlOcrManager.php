<?php

namespace Baraveli\BmlOcr;

use Illuminate\Support\Str;
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
        $this->hashedImage = md5($imagepath).'.jpg';
        $this->sharpenImage($imagepath);

        return $this;
    }

    /**
     * Detect the receipt.
     *
     * @return Receipt
     */
    public function detect()
    {
        $text = (new TesseractOCR($this->temporaryDirectory.DIRECTORY_SEPARATOR.$this->hashedImage))->run();
        //Remove the temporary image
        unlink($this->temporaryDirectory.DIRECTORY_SEPARATOR.$this->hashedImage);

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
            ->crop(930, 1350, 0, 0)
            ->brightness(-11)
            ->invert()
            ->greyscale()
            ->sharpen(25)
            ->save($this->temporaryDirectory.DIRECTORY_SEPARATOR.$this->hashedImage);
    }

    /**
     * FIlter the texts and remove any empty values.
     *
     * @param mixed $text
     *
     * @return Receipt
     */
    protected function filter(string $text): Receipt
    {
        $result = array_values(array_filter(explode("\n", $text)));

        $trimmedData = collect($result)->filter(function ($item) {
            return Str::contains($item, [
                'Transaction Receipt',
                'Status SUCCESS',
                'Message Transfer transaction is successful',
                'Ref #',
                'Date',
                'From',
                'To',
                'Amount',
                '77',
            ]);
        })->values()->toArray();

        return new Receipt($trimmedData);
    }
}
