# BML OCR:camera: (Experimental)

[![StyleCI](https://github.styleci.io/repos/285442080/shield?branch=master)](https://github.styleci.io/repos/285442080?branch=master)
[![Build Status](https://travis-ci.org/baraveli/bml-ocr.svg?branch=master)](https://travis-ci.org/baraveli/bml-ocr)

BML Transaction Receipt OCR based on Tesseract OCR.
At the moment this returns the result as an array. We will be switching to an Receipt object with regex matching for a later release.

Would not recommend to use in production.

## Installation

Via [Composer][]:

```
composer require baraveli/bml-ocr
```

:bangbang: **This library depends on [Tesseract OCR][], version _3.02_ or later.**

<br/>

### Note for Linux users

It is pretty simple to install tesseract, run the following commands:

```
sudo apt install tesseract-ocr
```

If the default installation doesn't include english language pack. You have to pull that one seperately, run the following command:

```
sudo apt-get install tesseract-ocr-eng
```

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

When you call the detect method it will return the result as an array.

```php

$receipt = BmlOcr::make("/home/image/imagename.jpg", __DIR__)
        ->detect();

var_dump($receipt);
```

Result:

```
array:9 [
  0 => "Transaction Receipt"
  1 => "Status SUCCESS"
  2 => "Message Transfer transaction is successful."
  3 => "Ref # BLAZ418696504822"
  4 => "Date 30/07/2020 21:46"
  5 => "From SHIHAM A.RAHMAN"
  6 => "To Mohamed Jinas"
  7 => "7730000151614"
  8 => "Amount MVR 750"
]
```

[tesseract ocr]: https://github.com/tesseract-ocr/tesseract
[composer]: http://getcomposer.org/
[windows_icon]: https://thiagoalessio.github.io/tesseract-ocr-for-php/images/windows-18.svg
[macos_icon]: https://thiagoalessio.github.io/tesseract-ocr-for-php/images/apple-18.svg
[tesseract_installation_on_windows]: https://github.com/tesseract-ocr/tesseract/wiki#windows
[capture2text]: https://chocolatey.org/packages/capture2text
[chocolatey]: https://chocolatey.org
[macports]: https://www.macports.org
[homebrew]: https://brew.sh
