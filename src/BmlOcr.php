<?php

namespace Baraveli\BmlOcr;

class BmlOcr
{
    public static function make(string $imagepath)
    {
        return self::getManager()->make($imagepath);
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
