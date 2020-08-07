<?php

namespace Baraveli\BmlOcr;

use Stringy\Stringy;

class Receipt
{
    public $status;
    public $message;
    public $reference;
    public $date;
    public $from;
    public $to;
    public $account;
    public $amount;
    public $remarks;

    public function __construct($rawdata)
    {
        $this->sanitize($rawdata);
    }

    protected function sanitize($rawdata): void
    {
        $string = implode("\n", $rawdata);

        $this->status = (string) Stringy::create($string)->between('Status ', "\n");
        $this->reference = (string) Stringy::create($string)->between('Ref # ', "\n");
        $this->date = (string) Stringy::create($string)->between('Date ', "\n");
        $this->from = (string) Stringy::create($string)->between('From ', "\n");
        $this->to = (string) Stringy::create($string)->between('To ', "\n");
        $this->amount = (string) Stringy::create($string)->after('Amount MVR ');
    }
}
