# BML OCR:camera: (Experimental)

BML Transaction Receipt OCR based on Tesseract OCR. 
At the moment this uses string replacement but ideally, the regex will work better in this case so we will be switching on the next version.

Would not recommend to use in production.

## Installation

```
composer require baraveli/bml-ocr
```

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
