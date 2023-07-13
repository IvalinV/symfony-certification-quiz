<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Factory\CategoryFactory;
use App\Factory\QuestionFactory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Yaml\Yaml;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /**
         * Create questions for each category.
         */
        $categories = $this->getCategories();
        
        foreach ($categories as $category) {
            CategoryFactory::createOne($category, $manager);
            $this->seedQuestions($category, $manager);
        }
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function seedQuestions($category, $manager)
    {
        $slug = $category['slug'];
        $data = Yaml::parse(file_get_contents("src/storage/{$slug}.yml"));

        foreach ($data['questions'] as $question) {
            $record = new Question();
            $category = $manager->getRepository(Category::class)->findOneBy(['slug' => $slug]);

            $record->setCategory($category);
            
            $record->setDescription($question['question']);
            $record->setHelp($question['help'] ?? '');
            $record->setHasMultipleCorrect(false);
            $record->setAnswered(false);
            $record->setCreatedAt(new DateTimeImmutable());
            
            $manager->persist($record);
            $manager->flush();
            
            $this->seedAnswers($record, $question, $manager);
        }
    }


        /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function seedAnswers($question_record, $question, $manager)
    {
        foreach ($question['answers'] as $answer) {
            $record = new Answer();

            $record->setQuestion($question_record);
            
            $record->setCorrect($answer['correct']);
            $record->setValue($answer['value']);
            $record->setMarked(false);
            $record->setCreatedAt(new DateTimeImmutable());

            $manager->persist($record);
            $manager->flush();
        }
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function getCategories()
    {
        $slugger = new AsciiSlugger();

        return [
            ['name' => 'Architecture', 'slug' => $slugger->slug('Architecture') ->lower(), 'createdAt' => new DateTimeImmutable()],
            ['name' => 'Automated Tests', 'slug' => $slugger->slug('Automated Tests') ->lower(),  'createdAt' => new DateTimeImmutable()],
            ['name' => 'Command Line', 'slug' => $slugger->slug('Command Line') ->lower(), 'createdAt' => new DateTimeImmutable()],
            ['name' => 'Config', 'slug' => $slugger->slug('Config') ->lower(), 'createdAt' => new DateTimeImmutable()],
            ['name' => 'Controllers', 'slug' => $slugger->slug('Controllers') ->lower(), 'createdAt' => new DateTimeImmutable()],
            ['name' => 'Dependacy Injection', 'slug' => $slugger->slug('Dependancy Injection') ->lower(),  'createdAt' => new DateTimeImmutable()],
            ['name' => 'Http Cache', 'slug' => $slugger->slug('Http Cache') ->lower(),  'createdAt' => new DateTimeImmutable()],
            ['name' => 'Forms', 'slug' => $slugger->slug('Forms') ->lower(),  'createdAt' => new DateTimeImmutable()],
            ['name' => 'Http', 'slug' => $slugger->slug('Http') ->lower(),  'createdAt' => new DateTimeImmutable()],
            ['name' => 'Misc', 'slug' => $slugger->slug('Misc') ->lower(),  'createdAt' => new DateTimeImmutable()],
            ['name' => 'PHP', 'slug' => $slugger->slug('PHP') ->lower(), 'createdAt' => new DateTimeImmutable()],
            ['name' => 'Process', 'slug' => $slugger->slug('Process') ->lower(),  'createdAt' => new DateTimeImmutable()],
            ['name' => 'PSR', 'slug' => $slugger->slug('PSR') ->lower(), 'createdAt' => new DateTimeImmutable()],
            ['name' => 'Routing', 'slug' => $slugger->slug('Routing') ->lower(), 'createdAt' => new DateTimeImmutable()],
            ['name' => 'Security', 'slug' => $slugger->slug('Security') ->lower(),  'createdAt' => new DateTimeImmutable()],
            ['name' => 'Standartization', 'slug' => $slugger->slug('Standartization') ->lower(), 'createdAt' => new DateTimeImmutable()],
            ['name' => 'Validation', 'slug' => $slugger->slug('Validation') ->lower(),  'createdAt' => new DateTimeImmutable()],
            ['name' => 'Yaml', 'slug' => $slugger->slug('Yaml') ->lower(),  'createdAt' => new DateTimeImmutable()]
        ];
    }
}
