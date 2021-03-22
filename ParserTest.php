<?php 
require 'Parser.php';
use PHPUnit\Framework\TestCase;
class ParserTest extends TestCase
{
	private $parser;
 
    protected function setUp(): void
    {
        $this->parser = new Parser();
    }
 
    protected function tearDown(): void
    {
        $this->parser = NULL;
    }
 
    public function testHeading1(): void
    {
		$result = $this->parser->render("#header");
        $this->assertEquals("<h1>header</h1>", $result);
    }

    public function testHeading2(): void
    {
		$result = $this->parser->addHeading("##header");
        $this->assertEquals("<h2>header</h2>", $result);
    }
    public function testHeading(): void
    {
		$result = $this->parser->addHeading("#######header");
        $this->assertEquals("", $result);
		$result = $this->parser->render("#######header");
        $this->assertEquals("<p>#######header</p>", $result);

    }		
	public function testBlank(): void
    {
		$result = $this->parser->render("");
        $this->assertEquals("", $result);
    }

	public function testLink(): void
    {
		
		$result = $this->parser->addLink("[Mailchimp](https://www.mailchimp.com)");
        $this->assertEquals('<a href="https://www.mailchimp.com">Mailchimp</a>', $result);
		$result = $this->parser->render("[Mailchimp](https://www.mailchimp.com)");
        $this->assertEquals('<p><a href="https://www.mailchimp.com">Mailchimp</a></p>', $result);
    }	
	
	public function testHeaderLink(): void
    {
		$result = $this->parser->render("This is sample markdown for the [Mailchimp](https://www.mailchimp.com) homework assignment.");
        $this->assertEquals('<p>This is sample markdown for the <a href="https://www.mailchimp.com">Mailchimp</a> homework assignment.</p>', $result);
    }	

}