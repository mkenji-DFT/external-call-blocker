<?php


class RequestTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $_SERVER["HTTP_REFERER"] = null;
    }
    public function testIsAllowedShouldReturnTrueWhenExternalCallFromAllowedDomain()
    {
        $domains = [".dafiti.com.br"];
        $_SERVER["HTTP_REFERER"] = "www.dafiti.com.br/calcados";
        $blocker = new \Dafiti\Blocker\Request($domains);

        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        $result = $blocker->isAllowed($request);

        $this->assertTrue($result);
    }

    public function testIsAllowedShouldReturnFalseWhenExternalCallFromNotAllowedDomains()
    {
        $domains = [".dafiti.com.br"];
        $_SERVER["HTTP_REFERER"] = "www.net.com.br/calcados";
        $blocker = new \Dafiti\Blocker\Request($domains);

        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        $result = $blocker->isAllowed($request);

        $this->assertFalse($result);
    }

    public function testIsAllowedShouldReturnTrueWhenExternalCallFromAllowedDomains()
    {
        $domains = [".dafiti.com.br", ".dafitisports.com.br", ".grendene.com.br"];
        $_SERVER["HTTP_REFERER"] = "http://www.dafitisports.com.br/calcados";
        $blocker = new \Dafiti\Blocker\Request($domains);

        $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        $result = $blocker->isAllowed($request);

        $this->assertTrue($result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateInstanceShouldBeThrowInvalidArgumentExceptionWhenInvalidDomains()
    {
        $domains = [8];
        new \Dafiti\Blocker\Request($domains);
    }

    public function testSendBlockedResponseShouldReturnResponseWith412StatusCode()
    {
        $domains = [".dafiti.com.br", ".dafitisports.com.br", ".grendene.com.br"];
        $blocker = new \Dafiti\Blocker\Request($domains);
        $result = $blocker->sendBlockedResponse();
        $expected = \Symfony\Component\HttpFoundation\Response::HTTP_PRECONDITION_FAILED;
        $this->assertEquals($expected, $result->getStatusCode());
    }

}