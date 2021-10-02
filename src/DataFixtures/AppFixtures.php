<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Category;
use App\Entity\Publication;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encodePassword;
    
    public function __construct(UserPasswordHasherInterface $encodePassword)
    {
        $this->encodePassword = $encodePassword;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $categoryNames = ['Berline','Coupé sport', 'Monospace','Break', '4x4'];
        $brandNames = ['BMW','MERCEDES', 'AUDI','LAMBORGHINI', 'JEEP', 'PORSHE', 'FERRARI'];


        $categories = [];
        $brands = [];
        $cars = [];
        $users = [];





        //TODO Fausses Categories
        for ($i=0; $i < 5; $i++) {
            $category = new Category();
            $category
                    ->setName($categoryNames[$i]);
            $categories[] = $category;
            $manager->persist($category);
        }

    

        //TODO Fausses Marques
        for ($i=0; $i < 5; $i++) {
            $brand = new Brand();
            $brand
                    ->setName($brandNames[$i])
                    ->setNationality($faker->country());
            $brands[] = $brand;
            $manager->persist($brand);
        }


        //TODO Fausses Voitures
        for ($i=0; $i < 10; $i++) {
            $car = new Car();
            $car
                    ->setModel($faker->word())
                    ->setBrand($faker->randomElement($brands))
                    ->setCategory($faker->randomElement($categories))
                    ->setReleasedAt(mt_rand(1999, 2021))
                    ->setFuel(mt_rand(0,2));
            $cars[] = $car;
            $manager->persist($car);
        }


        //TODO Fausses Users
        for ($i=0; $i < 5; $i++) {
            $user = new User();
            $user
                    ->setEmail($faker->email())
                    ->setPassword($this->encodePassword->hashPassword($user, 'demo'));
            $users[] = $user;
            $manager->persist($user);
        }


        //TODO Fausses Publications
        for ($i=0; $i < 10; $i++) {
            $publication = new Publication();
            $publication
                    ->setTitle($faker->words(5,true))
                    ->setUser($faker->randomElement($users))
                    ->setCar($faker->randomElement($cars))
                    ->setPrice(mt_rand(4000, 1000000))
                    ->setDescription($faker->paragraphs(2,true))
                    ->setIsSold($faker->randomElement([true,false]));

            $manager->persist($publication);
        }
            $manager->flush();
    }
}