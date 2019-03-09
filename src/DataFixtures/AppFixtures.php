<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // === Products ===
        $product = new Product();
        $product->setName('Galaxy Note 9')
                ->setBrand('Samsung')
                ->setPrice(599.99)
                ->setDescription('Le Samsung Galaxy Note 9 est le dernier-né de la gamme Note du géant coréen. C’est, aujourd’hui, l’une des solutions les plus complètes et les plus abouties sous Android.')
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setName('Pixel 3')
                ->setBrand('Google ')
                ->setPrice(699.99)
                ->setDescription('Vous ne jurez que par Android Stock ? Ne cherchez pas plus loin, c’est le Google Pixel 3 qu’il vous faut. Ce smartphone associe à la perfection la partie matérielle avec la partie logicielle. Premièrement, il possède un design assez unique avec un dos en verre dépoli garantissant une meilleure tenue du smartphone. C’est sobre et ça fonctionne très bien. Il n’est pas très grand avec son écran OLED de 5,5 pouces et ravira les personnes à la recherche d’un appareil un peu passe-partout.')
        ;
        $manager->persist($product);

        $product = new Product();
        $product->setName('P20 Pro')
                ->setBrand('Huawei')
                ->setPrice(449.99)
                ->setDescription('Le Huawei P20 Pro est un très beau smartphone. Lorsqu’on le retourne, on découvre un dos en verre du plus bel effet pouvant servir occasionnellement de miroir au besoin (oui, oui). L’écran OLED de 6,1 pouces est très équilibré et possède une grande luminosité ainsi que des noirs très profonds. Un vrai plaisir à regarder au quotidien.')
        ;
        $manager->persist($product);

        // === Users ===
        $user = new User();
        $user->setEmail('user1@test.com')
             ->setPassword('$2y$10$uh1FaHYFGL8v00o7JMNrr.jH9XbnIyqM3E2gqIRjqWyXaE7o7l8vS') // 'test' via bcrypt
        ;
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user2@test.com')
             ->setPassword('$2y$10$uh1FaHYFGL8v00o7JMNrr.jH9XbnIyqM3E2gqIRjqWyXaE7o7l8vS') // 'test' via bcrypt
        ;
        $manager->persist($user);

        $manager->flush();
    }
}
