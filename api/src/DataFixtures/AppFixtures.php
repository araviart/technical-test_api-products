<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des catégories
        $categoryClothing = new Category();
        $categoryClothing->setName('Vêtements');
        $manager->persist($categoryClothing);

        $categoryShoes = new Category();
        $categoryShoes->setName('Chaussures');
        $manager->persist($categoryShoes);

        // Création des produits
        $product1 = new Product();
        $product1->setName('T-Shirt')
            ->setDescription('T-Shirt de qualité en coton bio.')
            ->setPrice(19.99)
            ->setImage('https://www.pull-in.com/media/catalog/product/t/s/tsh-relaxwht-1.jpg')
            ->addCategory($categoryClothing);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Jean Slim')
            ->setDescription('Jean slim pour hommes.')
            ->setPrice(49.99)
            ->setImage('https://www.jules.com/dw/image/v2/AAHK_PRD/on/demandware.static/-/Sites-core-master-catalog/default/dw8e03a7db/images/1004760_9980_V1.jpg?sw=1562&sh=1800&sm=fit')
            ->addCategory($categoryClothing);
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setName('Sneakers')
            ->setDescription('Sneakers confortables et stylées.')
            ->setPrice(89.99)
            ->setImage('https://www.okumak.fr/wp-content/uploads/2022/05/le-site-de-la-sneakers-616qwg-1.jpg')
            ->addCategory($categoryShoes);
        $manager->persist($product3);

        // Exécution des changements
        $manager->flush();
    }
}
