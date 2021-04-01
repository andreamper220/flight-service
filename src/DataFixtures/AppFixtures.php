<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Document;
use App\Entity\DocumentType;
use App\Entity\Flight;
use App\Entity\Passenger;
use App\Entity\Place;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $documentType = new DocumentType;
        $documentType->setName('passport');
        $manager->persist($documentType);

        for ($i = 0; $i < 3; $i++) {
            $status = new Status;
            $status->setName('status_' . $i);
            $manager->persist($status);
        }

        for ($i = 0; $i < 10; $i++) {
            $passenger = new Passenger();
            $passenger
                ->setLastName('Volkov_' . $i)
                ->setFirstName('Andrey_' . $i)
                ->setPatronymic('Vladimirovich_' . $i)
                ->setEmail('email_' . $i);
            $manager->persist($passenger);

            $document = new Document();
            $document
                ->setSeries($i)
                ->setNumber($i . '0')
                ->setType($documentType)
                ->setOwner($passenger);
            $manager->persist($document);

            $company = new Company();
            $company->setName('company_' . $i);
            $manager->persist($company);

            $place = new Place();
            $place->setName('Russia_' . $i);
            $manager->persist($place);

            $flight = new Flight();
            $flight
                ->setDeparture($place)
                ->setDestination($place)
                ->setSeatCount(150)
                ->setCompany($company);
            $manager->persist($flight);
        }

        $manager->flush();
    }
}
