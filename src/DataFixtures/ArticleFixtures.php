<?php

namespace App\DataFixtures;
use Faker;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;



class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::Create('fr_FR');
        // je veux Créer 3 catégories fakées
        for($i = 1; $i <= 10; $i++){

            $category = new Category(); 
            $category->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph());

            $manager->persist($category);

            //dans chaque catégorie je veux créer quelque articles

            for($k = 1; $k <= mt_rand(4,6); $k++){
                $article = new Article();

                
              
                


                $article->setTitle($faker->sentence())
                ->setContent(($faker->realText(500)))
                ->setImage('https://i.picsum.photos/id/' . rand(0, 1000) . '/1150/368.jpg')
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setCategory($category); //on les articles dans cette category
                //instantiation de la class
                // en symfony dés quon utile une class , il faut utilisé use c'est une sorte de require on_ce
                $manager->persist($article);
                
                    //on donne des commentaires à l'article

                for($k = 1; $k <= mt_rand(0,2); $k++){
                    $comment = new Comment();
                      
                $content =  '<p>' . join($faker->sentence(2,4), '</p><p>').
                '</p>';
                //$personne->setNom($faker->name);

            //    $days = (new \DateTime())->diff($article-getCreatedAt())->days;
            $createdAt = $faker->dateTime();
            $createdAt = $faker->dateTimeBetween($createdAt, 'now');
        
                

                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($createdAt)
                            ->setArticle($article);

                            $manager->persist($comment);



            }

            $manager->flush();
    
        }
    }
    
               

               
    
            }
        }