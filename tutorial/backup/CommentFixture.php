<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixture extends BaseFixture
{
    public function load(ObjectManager $manager)
    {
       $this->createMany(Comment::class, 100, function (Comment $comment) {
            $comment->setContent(
                $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
            )
                ->setAuthorName($this->faker->name)
                ->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'))
                ->setArticle($this->getReference(Article::class .$this->faker->numberBetween(0,9)));
            ;
        });

        $manager->flush();
    }
}
