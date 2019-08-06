<?php

namespace spec\eLife\ApiClient\Exception;

use Crell\ApiProblem\ApiProblem;
use eLife\ApiClient\Exception\BadResponse;
use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;

final class ApiProblemResponseSpec extends ObjectBehavior
{
    private $apiProblem;
    private $request;
    private $response;

    public function let()
    {
        $this->apiProblem = new ApiProblem();
        $this->request = new Request('GET', '/');
        $this->response = new Response();

        $this->beConstructedWith($this->apiProblem, $this->request, $this->response);
    }

    public function it_has_an_api_problem()
    {
        $this->getApiProblem()->shouldBeLike($this->apiProblem);
    }

    public function it_has_a_request()
    {
        $this->getRequest()->shouldBeLike($this->request);
    }

    public function it_has_a_response()
    {
        $this->getResponse()->shouldBeLike($this->response);
    }

    public function it_can_not_have_a_previous_exception()
    {
        $this->getPrevious()->shouldBe(null);
    }

    public function it_can_have_a_previous_exception(Exception $previous)
    {
        $this->beConstructedWith($this->apiProblem, $this->request, $this->response, $previous);

        $this->getPrevious()->shouldBeLike($previous);
    }

    public function it_is_a_problem_response()
    {
        $this->shouldHaveType(BadResponse::class);
    }
}
