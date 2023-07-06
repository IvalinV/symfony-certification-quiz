<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Factory\CategoryFactory;
use App\Factory\QuestionFactory;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $slugger = new AsciiSlugger();

        CategoryFactory::createOne(['name' => 'Architecture', 'slug' => $slugger->slug('Architecture') ->lower(), 'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Automated Tests', 'slug' => $slugger->slug('Automated Tests') ->lower(),  'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Command Line', 'slug' => $slugger->slug('Command Line') ->lower(), 'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Config', 'slug' => $slugger->slug('Config') ->lower(), 'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Controllers', 'slug' => $slugger->slug('Controllers') ->lower(), 'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Dependacy Injection', 'slug' => $slugger->slug('Dependancy Injection') ->lower(),  'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Http Cache', 'slug' => $slugger->slug('Http Cache') ->lower(),  'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Forms', 'slug' => $slugger->slug('Forms') ->lower(),  'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Http', 'slug' => $slugger->slug('Http') ->lower(),  'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Misc', 'slug' => $slugger->slug('Misc') ->lower(),  'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'PHP', 'slug' => $slugger->slug('PHP') ->lower(), 'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Process', 'slug' => $slugger->slug('Process') ->lower(),  'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'PSR', 'slug' => $slugger->slug('PSR') ->lower(), 'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Routing', 'slug' => $slugger->slug('Routing') ->lower(), 'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Security', 'slug' => $slugger->slug('Security') ->lower(),  'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Standartization', 'slug' => $slugger->slug('Standartization') ->lower(), 'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Validation', 'slug' => $slugger->slug('Validation') ->lower(),  'createdAt' => new DateTimeImmutable()]);
        CategoryFactory::createOne(['name' => 'Yaml', 'slug' => $slugger->slug('Yaml') ->lower(),  'createdAt' => new DateTimeImmutable()]);
    }
}
