<?php

use Baraveli\BmlOcr\BmlOcr;
use Baraveli\BmlOcr\BmlOcrManager;
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
        $bmlocr = BmlOcr::make(__DIR__ . '/test.png', __DIR__);
        $filename = $bmlocr->GetHashedImage();
        $this->assertEquals(true, file_exists(__DIR__ . DIRECTORY_SEPARATOR . $filename));
        unlink(__DIR__ . DIRECTORY_SEPARATOR . $filename);
    }

    /** @test */
    public function when_its_detected_it_returns_an_array()
    {
        $result = BmlOcr::make(__DIR__ . '/test.png', __DIR__)
            ->detect();
        $this->assertIsArray($result);
    }

    /** @test */
    public function it_returns_a_valid_detected_text_in_invoice()
    {
        $result = BmlOcr::make(__DIR__ . '/test.png', __DIR__)
            ->detect();

        $this->assertEquals("Transaction Receipt", $result[0]);
        $this->assertEquals("Status SUCCESS", $result[1]);
        $this->assertEquals("Message Transfer transaction is successful.", $result[2]);
        $this->assertEquals("Ref # BLAZ418696504822", $result[3]);
        $this->assertEquals("Date 30/07/2020 21:46", $result[4]);
        $this->assertEquals("From SHIHAM A.RAHMAN", $result[5]);
        $this->assertEquals("To Mohamed Jinas", $result[6]);
        $this->assertEquals("7730000151614", $result[7]);
        $this->assertEquals("Amount MVR 750", $result[8]);
    }
}
