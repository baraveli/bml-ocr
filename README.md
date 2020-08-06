# BML OCR:camera: (Experimental)

[![StyleCI](https://github.styleci.io/repos/285442080/shield?branch=master)](https://github.styleci.io/repos/285442080?branch=master)
[![Build Status](https://travis-ci.org/baraveli/bml-ocr.svg?branch=master)](https://travis-ci.org/baraveli/bml-ocr)

BML Transaction Receipt OCR based on Tesseract OCR.
At the moment this uses string replacement but ideally, the regex will work better in this case so we will be switching on the next version.

Would not recommend to use in production.

## Installation

Via [Composer][]:

```
composer require baraveli/bml-ocr
```

:bangbang: **This library depends on [Tesseract OCR][], version _3.02_ or later.**

<br/>

### ![][windows_icon] Note for Windows users

There are [many ways][tesseract_installation_on_windows] to install
[Tesseract OCR][] on your system, but if you just want something quick to
get up and running, I recommend installing the [Capture2Text][] package with
[Chocolatey][].

    choco install capture2text --version 3.9

:warning: Recent versions of [Capture2Text][] stopped shipping the `tesseract` binary.

<br/>

### ![][macos_icon] Note for macOS users

With [MacPorts][] you can install support for individual languages, like so:

    $ sudo port install tesseract-<langcode>

But that is not possible with [Homebrew][]. It comes only with **English** support
by default, so if you intend to use it for other language, the quickest solution
is to install them all:

    $ brew install tesseract --with-all-languages

<br/>

## Usage

```php
use Baraveli\BmlOcr\BmlOcr;

BmlOcr::make("/home/image/imagename.jpg", __DIR__)
        ->detect();
```

The first argument of the make method is the path to the receipt you want to do OCR on. and the second argument is the temporary directory path. When the image path is first given it creates a temporary image with higher sharpness because the original BML receipt uses grey color for typography. It is really hard to detect by using just the default image. It deletes after finishing the detection.

When you call the detect method it will returns a Receipt Object.

```php

$receipt = BmlOcr::make("/home/image/imagename.jpg", __DIR__)
        ->detect();

   $receipt->status; //Returns the status in receipt.
   $receipt->message; //Returns the message in receipt.
   $receipt->reference; //Returns the reference in receipt.
   $receipt->date; //Returns the date in receipt.
   $receipt->from; //Returns the from in receipt
   $receipt->to; //Returns the to in receipt.
   $receipt->account; //Returns the account number in receipt.
   $receipt->amount; //Returns the amount in receipt.
   $receipt->remarks; //Returns the remarks in receipt.
```

[Tesseract OCR]: https://github.com/tesseract-ocr/tesseract
[Composer]: http://getcomposer.org/
[windows_icon]: https://thiagoalessio.github.io/tesseract-ocr-for-php/images/windows-18.svg
[macos_icon]: https://thiagoalessio.github.io/tesseract-ocr-for-php/images/apple-18.svg
[tesseract_installation_on_windows]: https://github.com/tesseract-ocr/tesseract/wiki#windows
[Capture2Text]: https://chocolatey.org/packages/capture2text
[Chocolatey]: https://chocolatey.org
[MacPorts]: https://www.macports.org
[Homebrew]: https://brew.sh