<?php

namespace App\Controller;

use App\Service\FlightService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlightController extends AbstractController
{
    /**
     * @var FlightService
     */
    private $flightService;

    public function __construct(FlightService $flightService)
    {
        $this->flightService = $flightService;
    }

    /**
     * @Route("api/v1/flight/reserve", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function reserve(Request $request): Response
    {
        $parameters = $request->request;

        $passengerId = $parameters->get('passengerId');
        $flightId = $parameters->get('flightId');
        $seatNumber = $parameters->get('seatNumber');

        $reservedFlightId = $this->flightService->reserve($passengerId, $flightId, $seatNumber);

        return $this->json([
            'flightId' => $reservedFlightId
        ]);
    }

    /**
     * @Route("api/v1/flight/cancel", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function cancel(Request $request): Response
    {
        $parameters = $request->request;

        $passengerId = $parameters->get('passengerId');
        $flightId = $parameters->get('flightId');

        $cancelledFlightId = $this->flightService->cancel($passengerId, $flightId);

        return $this->json([
            'flightId' => $cancelledFlightId
        ]);
    }

    /**
     * @Route("api/v1/flight/buy", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function buy(Request $request): Response
    {
        $parameters = $request->request;

        $passengerId = $parameters->get('passengerId');
        $flightId = $parameters->get('flightId');
        $seatNumber = $parameters->get('seatNumber');

        $ticketId = $this->flightService->buy($passengerId, $flightId, $seatNumber);

        return $this->json([
            'ticketId' => $ticketId
        ]);
    }
}
