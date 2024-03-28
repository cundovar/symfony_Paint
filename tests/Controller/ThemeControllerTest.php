<?php

namespace App\Test\Controller;

use App\Entity\Theme;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ThemeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ThemeRepository $repository;
    private string $path = '/theme/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Theme::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Theme index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'theme[urbain]' => 'Testing',
            'theme[portrait]' => 'Testing',
            'theme[oeuvre]' => 'Testing',
        ]);

        self::assertResponseRedirects('/theme/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Theme();
        $fixture->setUrbain('My Title');
        $fixture->setPortrait('My Title');
        $fixture->setOeuvre('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Theme');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Theme();
        $fixture->setUrbain('My Title');
        $fixture->setPortrait('My Title');
        $fixture->setOeuvre('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'theme[urbain]' => 'Something New',
            'theme[portrait]' => 'Something New',
            'theme[oeuvre]' => 'Something New',
        ]);

        self::assertResponseRedirects('/theme/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getUrbain());
        self::assertSame('Something New', $fixture[0]->getPortrait());
        self::assertSame('Something New', $fixture[0]->getOeuvre());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Theme();
        $fixture->setUrbain('My Title');
        $fixture->setPortrait('My Title');
        $fixture->setOeuvre('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/theme/');
    }
}
