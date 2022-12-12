<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private SluggerInterface $slugger
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin
            ->setEmail('admin@gmail.com')
            ->setLastname('Gaspard')
            ->setFirstname('maxime')
            ->setAddress('113 rue fontgieve')
            ->setZipcode('63000')
            ->setCity('Clermont-ferrand')
            ->setPassword(
                $this->passwordHasher->hashPassword($admin, 'admin123')
            )
            ->setRoles(['ROLE_ADMIN']);

         $manager->persist($admin);

         // '::' operateur de resolution de portée
         $faker = Faker\Factory::create('fr_FR');

         for($users = 1; $users <= 5; $users++){
             $user = new User();
             $user
                 ->setEmail($faker->email)
                 ->setLastname($faker->lastName)
                 ->setFirstname($faker->firstName)
                 ->setAddress($faker->address)
                 ->setZipcode(str_replace('','', $faker->postcode))
                 ->setCity($faker->city)
                 ->setPassword(
                     $this->passwordHasher->hashPassword($user, 'admin123')
                 );
             dump($user);
             $manager->persist($user);
         }
         $manager->flush();
    }
}
