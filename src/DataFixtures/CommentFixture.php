<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


//class CommentFixture extends BaseFixture
class CommentFixture extends Base_2Fixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
       $this->createMany(100, 'main_comments', function ($i) use ($manager) {

           $comment = new Comment();

            $comment->setContent(
                $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
            )
                ->setAuthorName($this->faker->name)
                ->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'))
                ->setIsDeleted($this->faker->boolean(20))
                ->setArticle($this->getRandomReference('main_articles'))
            ;
            return $comment;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [ArticleFixture::class];
    }

}
