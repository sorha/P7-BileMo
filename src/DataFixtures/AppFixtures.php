<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

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

        // === Clients ===
        $client = new Client();
        $client->setName('Orange');
        $this->addReference('Orange', $client);
        $manager->persist($client);

        $client = new Client();
        $client->setName('SFR');
        $this->addReference('SFR', $client);
        $manager->persist($client);

        // === Users ===
        // 10 users from Orange
        for($i=1; $i<=10; $i++)
        {
            $user = new User();
            $client = $this->getReference('Orange');
            $user->setUsername('user'.$i.$client->getName())
                ->setEmail('user'.$i.$client->getName().'@test.com')
                ->setPassword($this->passwordEncoder->encodePassword($user, 'test'))
                ->setClient($client)
            ;
            $manager->persist($user);
        }
        
        // 10 users from SFR
        for($i=1; $i<=10; $i++)
        {
            $user = new User();
            $client = $this->getReference('SFR');
            $user->setUsername('user'.$i.$client->getName())
                ->setEmail('user'.$i.$client->getName().'@test.com')
                ->setPassword($this->passwordEncoder->encodePassword($user, 'test'))
                ->setClient($client)
            ;
            $manager->persist($user);
        }

        // === Admin Users===
        $user = new User();
        $client = $this->getReference('Orange');
        $user->setUsername('admin'.$client->getName())
            ->setEmail('admin'.$client->getName().'@test.com')
            ->setPassword($this->passwordEncoder->encodePassword($user, 'test'))
            ->setClient($client)
            ->setRoles([User::ROLE_ADMIN])
        ;
        $manager->persist($user);

        $user = new User();
        $client = $this->getReference('SFR');
        $user->setUsername('admin'.$client->getName())
            ->setEmail('admin'.$client->getName().'@test.com')
            ->setPassword($this->passwordEncoder->encodePassword($user, 'test'))
            ->setClient($client)
            ->setRoles([User::ROLE_ADMIN])
        ;
        $manager->persist($user);

        $manager->flush();
    }
}
