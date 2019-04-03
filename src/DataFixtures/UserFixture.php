<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Base_2Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany('10', 'main_users', function($i){
            $user = new User();
            $user->setEmail(sprintf('spacebar%d@example.com', $i))
                ->setFirstName($this->faker->firstName)
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    'engage'
                ));

            return $user;
        });

        $this->createMany('3', 'admin_users', function($i){
            $user = new User();
            $user->setEmail(sprintf('admin%d@example.com', $i))
                ->setFirstName($this->faker->firstName)
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    'engage'
                ));
            if ($this->faker->boolean) {
                $user->setTwitterUsername($this->faker->userName);
            }

            return $user;
        });


        $manager->flush();
    }
}



