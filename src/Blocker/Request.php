<?php

namespace Dafiti\Blocker;

use Symfony\Component\HttpFoundation;

class Request implements Allower
{
    /**
     * @var array
     */
    private $domains = [];

    public function __construct(array $domains)
    {
        foreach ($domains as $domain) {
            if (!is_string($domain)) {
                throw new \InvalidArgumentException('Domain Must Be a URL in String Format');
            }
        }

        $this->domains = $domains;
    }

    /**
     * @param HttpFoundation\Request $request
     *
     * @return bool
     */
    public function isAllowed(HttpFoundation\Request $request)
    {
        $refer = $request->server->get('HTTP_REFERER', false);
        if (!$refer) {
            return false;
        }

        foreach ($this->domains as $domain) {
            if (is_numeric(strpos($refer, $domain))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return HttpFoundation\Response
     */
    public function sendBlockedResponse()
    {
        $response = new HttpFoundation\Response();
        $response->setStatusCode(HttpFoundation\Response::HTTP_PRECONDITION_FAILED);

        return $response->send();
    }
}
