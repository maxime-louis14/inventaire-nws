<?php

namespace Test\Controller;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ReservationRepository $repository;
    private string $path = '/reservation/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Reservation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }
    
    //  je test si il y a une reponse 200 sur ma page index de reservation et si il y a bien ércit Reservation index.
    public function testIndex(): void
    {
    $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        
    }

    //  Ici c'est le test pour la création d'une nouvelle anonnce. qui return rien
    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);
        
        $this->client->submitForm('Save', [
            'reservation[name]' => 'Testing',
            'reservation[email]' => 'Testing',
            'reservation[rendered]' => 'Testing',
            'reservation[loandate]' => 'Testing',
            'reservation[isrenderd]' => '',
            'reservation[product]' => 'true false',
        ]);

        self::assertResponseRedirects('/reservation/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    // public function testShow(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Reservation();
    //     $fixture->setName('My Title');
    //     $fixture->setEmail('My Title');
    //     // $fixture->setRendered('My Title');
    //     // $fixture->setLoandate('My Title');
    //     $fixture->setIsrenderd('My Title');
    //     // $fixture->setProduct('My Title');

    //     $this->repository->add($fixture, true);

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Reservation');

    //     // Use assertions to check that the properties are properly displayed.
    // }

    // public function testEdit(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Reservation();
    //     $fixture->setName('My Title');
    //     $fixture->setEmail('My Title');
    //     // $fixture->setRendered('My Title');
    //     // $fixture->setLoandate('My Title');
    //     $fixture->setIsrenderd('My Title');
    //     // $fixture->setProduct('Oui Non');

    //     $this->repository->add($fixture, true);

    //     $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

    //     $this->client->submitForm('Update', [
    //         'reservation[name]' => 'Something New',
    //         'reservation[email]' => 'Something New',
    //         'reservation[rendered]' => 'Something New',
    //         'reservation[loandate]' => 'Something New',
    //         'reservation[isrenderd]' => 'Something New',
    //         'reservation[product]' => 'Something New',
    //     ]);

    //     self::assertResponseRedirects('/reservation/');

    //     $fixture = $this->repository->findAll();

    //     self::assertSame('Something New', $fixture[0]->getName());
    //     self::assertSame('Something New', $fixture[0]->getEmail());
    //     self::assertSame('Something New', $fixture[0]->getRendered());
    //     self::assertSame('Something New', $fixture[0]->getLoandate());
    //     // self::assertSame('Something New', $fixture[0]->getIsrenderd());
    //     self::assertSame('Something New', $fixture[0]->getProduct());
    // }

    // public function testRemove(): void
    // {
    //     $this->markTestIncomplete();

    //     $originalNumObjectsInRepository = count($this->repository->findAll());

    //     $fixture = new Reservation();
    //     $fixture->setName('My Title');
    //     $fixture->setEmail('My Title');
    //     // $fixture->setRendered('My Title');
    //     // $fixture->setLoandate('My Title');
    //     $fixture->setIsrenderd('My Title');
    //     // $fixture->setProduct('My Title');

    //     $this->repository->add($fixture, true);

    //     self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
    //     $this->client->submitForm('Delete');

    //     self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
    //     self::assertResponseRedirects('/reservation/');
    // }
}
