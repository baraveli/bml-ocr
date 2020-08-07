<?php

use Baraveli\BmlOcr\BmlOcr;
use Baraveli\BmlOcr\BmlOcrManager;
use Baraveli\BmlOcr\Receipt;
use PHPUnit\Framework\TestCase;

class BmlOcrTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_bmlocrmanager()
    {
        $this->assertInstanceOf(BmlOcrManager::class, BmlOcr::getManager());
    }

    /** @test */
    public function it_creates_a_temporary_sharpen_image()
    {
        $bmlocr = BmlOcr::make(__DIR__ . '/test.jpg', __DIR__);
        $filename = $bmlocr->GetHashedImage();
        $this->assertEquals(true, file_exists(__DIR__ . DIRECTORY_SEPARATOR . $filename));
        unlink(__DIR__ . DIRECTORY_SEPARATOR . $filename);
    }

    /** @test */
    public function when_its_detected_it_returns_an_receipt_object()
    {
        $result = BmlOcr::make(__DIR__ . '/test.jpg', __DIR__)
            ->detect();
        $this->assertInstanceOf(Receipt::class, $result);
    }

    /** @test */
    public function it_returns_a_valid_detected_text_in_invoice()
    {
        $result = BmlOcr::make(__DIR__ . '/test.jpg', __DIR__)
            ->detect();

        $this->assertEquals('SUCCESS', $result->status);
        $this->assertEquals('20/07/2020 13:50', $result->date);
        $this->assertEquals('AISH.SIYAMA', $result->from);
        $this->assertEquals('Ali najeeb', $result->to);
        $this->assertEquals("154", $result->amount);
    }
}
