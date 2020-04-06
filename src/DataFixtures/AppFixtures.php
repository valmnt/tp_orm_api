<?php

namespace App\DataFixtures;

use App\Article\Status;
use App\Entity\Article;
use App\Entity\Category;
use App\Status\Status as StatusStatus;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\VarDumper\Cloner\Data;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i <= 30; $i++) {

            $category = new Category();
            $category->setName($faker->word())
                ->setCreated(new DateTime());

            $manager->persist($category);

            $article = new Article();
            $article->setTitle($faker->word())
                ->setContent($faker->text())
                ->setTrending($faker->boolean())
                ->setPublished(new DateTime())
                ->setCreated(new DateTime())
                ->setStatus($faker->numberBetween(Status::notPublished, Status::published))
                ->setCategory($category);

            $manager->persist($article);
        }
        $manager->flush();
    }
}
