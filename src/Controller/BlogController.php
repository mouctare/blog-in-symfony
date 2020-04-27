<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmiType;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;
use App\Entity\Comment;
use App\Form\CommentType;




class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo) // injection de dépendance
    {
       // $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            // je vais passer à twig les articles
            'articles' =>$articles
        ]);
    }
     /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('blog/home.html.twig');
    }
     /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit" ,name="blog_edit")
     */
    public function form(Article $article = null, Request $request, EntityManagerInterface $manager) { // passe moi la requette http avec les données qu'elle contient
        if(!$article){
            // si je n'ai pas d'articule voila c'est que je veux faire  un nouveau articule
            $article = new Article();


        }

       
      /*   $form = $this->createFormBuilder($article) // le formulaire est lié à l'entité article
        ->add( 'title')
        ->add( 'content' )
        ->add( 'image')
        ->getForm(); */

        $form = $this->createForm(ArticleType::class,$article);

        $form->handleRequest($request); //essaye d'analyser la reque http que je te passe en paramettre

        if($form->isSubmitted() && $form->isValid()) {

            if(!$article->getId()){
                $article->setCreatedAt(new \DateTime);

            }

           

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', [ 'id' => $article->getId()

            ]);
        }



   //dd($request);


    

    return $this->render('blog/create.html.twig',[
        'formArticle' => $form->createView(),
        'editMode' => $article->getId() !== null
    ]);
    
        

}



/**
     
 * @Route("/blog{id<\d+>}/delete", methods={"POST"}, name="delete")
 
     */
    public function delete(Article $article , Request $request, EntityManagerInterface $entityManager)
    {
        //$this->denyAccessUnlessGranted('EDIT', $article);
      //  $em = $this->getDoctrine()->getEntityManager();
      
    $this->em = $entityManager;

        $entityManager->remove($article);

        $entityManager->flush();

        return $this->render('blog/show.html.twig',[
            'article' => $article



            ]);

    

    }

    /**
     * @Route("blog/{id}", name="blog_show")
     */
    public function show(Article $article, Request $request, EntityManagerInterface $manager) {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request); //gère la reque que je te passe si,
        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article);
            // alors je fais appelle à mon manager
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute( 'blog_show', [
                'id' => $article->getId()
            ]);

        }
        //ArticleRepository $repo,$id
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        //$article = $repo->find($id);
        return $this->render('blog/show.html.twig',[
            'article' => $article,
            'commentForm' => $form->createView() // je veux la partie affichable de mon comment.



            ]);

        }

    }


/* if ($request->request->count() > 0) {

    $article = new Article();

    $article->setTitle($request->request->get('title'))
            ->setContent(($request->request->get('content')))
            ->setImage(($request->request->get('image')))
            ->setCreatedAt(new \DateTime());

            $manager->persist($article);
            $manager->flush();
            // ceci une rédirection vers l'article crée!
            return $this->redirectTo('blog_show', [ 'id' => $article->getId()

            ]);
            

}
