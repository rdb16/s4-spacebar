<?php
/**
 * Created by PhpStorm.
 * User: rdb
 * Date: 2019-02-15
 * Time: 18:14
 */

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        for($i=0; $i < 10; $i++){
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setEmail(sprintf('spacebar%d@example.com', $i + 1));
            $manager->persist($user);
        }
        $manager->flush();
    }

}
