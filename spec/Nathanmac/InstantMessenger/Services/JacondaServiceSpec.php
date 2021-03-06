<?php

namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Nathanmac\InstantMessenger\Services\JacondaService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;

class JacondaServiceSpec extends ObjectBehavior
{
    function let(GuzzleHttp\Client $client)
    {
        $this->beAnInstanceOf('spec\Nathanmac\InstantMessenger\Services\JacondaServiceStub');
        $this->beConstructedWith('subdomain', 'token', 'room');

        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {

        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\JacondaService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_sends_a_messages($client)
    {
        // Create a new message.
        $message = new Message();
        $message->from('API');
        $message->body("Simple notification message.");

        $client->post("https://subdomain.jaconda.im/api/v2/rooms/room/notify.xml",
            array(
                "auth" => array("token", "X"),
                "json" => array("message" => array("sender_name" => "API", "text" => "Simple notification message."))
            )
        )->shouldBeCalled();

        $this->send($message);
    }

    function it_gets_and_sets_the_sub_domain()
    {
        // Get the current key
        $this->getSubDomain()->shouldReturn('subdomain');

        // Set the api key
        $this->setSubDomain('newsubdomain');

        // Get the current key
        $this->getSubDomain()->shouldReturn('newsubdomain');
    }

    function it_gets_and_sets_the_token()
    {
        // Get the current key
        $this->getToken()->shouldReturn('token');

        // Set the api key
        $this->setToken('newtoken');

        // Get the current key
        $this->getToken()->shouldReturn('newtoken');
    }

    function it_gets_and_sets_the_room()
    {
        // Get the current key
        $this->getRoom()->shouldReturn('room');

        // Set the api key
        $this->setRoom('newroom');

        // Get the current key
        $this->getRoom()->shouldReturn('newroom');
    }
}

class JacondaServiceStub extends JacondaService {

    public $client;

    public function setHttpClient($client)
    {
        $this->client = $client;
    }

    public function getHttpClient()
    {
        return $this->client;
    }
}
