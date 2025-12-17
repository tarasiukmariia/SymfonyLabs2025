<?php

namespace App\Action\Aircraft;

use App\Entity\Aircraft;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class CapitalizeRegistrationAction extends AbstractController
{
    public function __invoke(Aircraft $data): Response
    {
        if ($data->getRegistrationNumber()) {
            $data->setRegistrationNumber(strtoupper($data->getRegistrationNumber()));
        }

        return $this->json($data, Response::HTTP_OK, [], ['groups' => ['aircraft:read']]);
    }
}