<?php

namespace Baraveli\BmlOcr;

class BmlOcr
{
    public static function make(string $imagepath, string $temporaryDirectory = __DIR__)
    {
        return self::getManager()->make($imagepath, $temporaryDirectory);
    }

    /**
     * create new BmlOcrManager instance.
     *
     * @return BmlOcrManager
     */
    public static function getManager(): BmlOcrManager
    {
        return new BmlOcrManager();
    }
}
