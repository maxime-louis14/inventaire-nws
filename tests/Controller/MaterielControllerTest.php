<?php

namespace   Test\Controller;

use App\Entity\Materiel;
use App\Repository\MaterielRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MaterielControllerTest extends WebTestCase
{

    /**
     * bin/console make:test
     * TestCase > tests unitaires (tests PHPUnit)
     * KernelTestCase > tests d'intégration
     * WebTestCase > tests fonctionnels ou d'application
     * PantherTestCase > tests de bout en bout
     * ApiTestCase > scénarios orientés API
     */

    private KernelBrowser $client;
    private MaterielRepository $repository;
    private string $path = '/materiel/';

    protected function setUp(): void
    {
        // 
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Materiel::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);
        self::assertResponseStatusCodeSame(200);
        
        // Utilisez le $crawler pour effectuer des assertions supplémentaires, par e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());
        $this->client->request('GET', sprintf('%snew', $this->path));
        self::assertResponseStatusCodeSame(200);
        $this->client->submitForm('Save', [
            'materiel[name]' => 'Testing',
            'materiel[quantity]' => '10',
        ]);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

        public function testShow(): void
        {
            
            $fixture = new Materiel();
            $fixture->setName('MyTitle');
            $fixture->setQuantity('20');
            $this->repository->add($fixture, true);
            $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
            self::assertResponseStatusCodeSame(200);
            self::assertPageTitleContains('Materiel');

            // Use assertions to check that the properties are properly displayed.
        }

    public function testEdit(): void
    {
        $fixture = new Materiel();
        $fixture->setName('titre');
        $fixture->setQuantity('200');
        $this->repository->add($fixture, true);
        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));
        $this->client->submitForm('Update', [
            'materiel[name]' => 'titreTest',
            'materiel[quantity]' => '300',
        ]);
        // self::assertResponseRedirects('/materiel/');
        $fixture = $this->repository->findAll();
        self::assertSame('titreTest', $fixture[0]->getName());
        self::assertSame(300, $fixture[0]->getQuantity());
    }

    public function testRemove(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());
        $fixture = new Materiel();
        $fixture->setName('MyTitle');
        $fixture->setQuantity('30');
        $this->repository->add($fixture, true);
        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');
        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
    }
}
