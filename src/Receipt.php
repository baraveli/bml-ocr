<?php

namespace Baraveli\BmlOcr;

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

    public function __construct(array $rawdata)
    {
        $this->hydrate($rawdata);
    }

    protected function hydrate($rawdata): void
    {
        $this->status = str_replace('Status ', '', $rawdata[2]);
        $this->message = str_replace('Message ', '',$rawdata[3]);
        $this->reference = str_replace('Ref # ', '', $rawdata[4]);
        $this->date = str_replace('Date ', '', $rawdata[5]);
        $this->from = str_replace('From ', '', $rawdata[6]);
        $this->to = str_replace('To ', '', $rawdata[7]);
        $this->account = (int) $rawdata[8];
        $this->amount = (int) str_replace('Amount MVR ', '', $rawdata[9]);
        $this->remarks = str_replace('Remarks ', '', $rawdata[10]);
    }
}
