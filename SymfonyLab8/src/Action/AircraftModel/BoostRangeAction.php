<?php

namespace App\Action\AircraftModel;

use App\Entity\AircraftModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class BoostRangeAction extends AbstractController
{
    public function __invoke(AircraftModel $data): Response
    {
        if ($data->getMaxRangeKm()) {
            $data->setMaxRangeKm($data->getMaxRangeKm() + 500);
        }

        return $this->json($data, Response::HTTP_OK, [], ['groups' => ['model:read']]);
    }
}