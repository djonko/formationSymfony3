<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 1/7/2017
 * Time: 11:14 PM
 */

namespace OC\PlateformBundle\Controller;



use Lib\Test\TestLib;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdvertController extends Controller
{

    public function indexAction($page)
    {
        // On ne sait pas combien de pages il y a
        // Mais on sait qu'une page doit être supérieure ou égale à 1
        if ($page < 1) {
            // On déclenche une exception NotFoundHttpException, cela va afficher
            // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }
        $test = TestLib::getName();
        // Ici, on récupérera la liste des annonces, puis on la passera au template
        // les anonces
        // Notre liste d'annonce en dur
        $listAdverts = array(
            array(
                'title'   => 'Recherche développpeur Symfony',
                'id'      => 1,
                'author'  => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date'    => new \Datetime()),
            array(
                'title'   => 'Mission de webmaster',
                'id'      => 2,
                'author'  => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date'    => new \Datetime()),
            array(
                'title'   => 'Offre de stage webdesigner',
                'id'      => 3,
                'author'  => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date'    => new \Datetime())
        );
        // Mais pour l'instant, on ne fait qu'appeler le template
        $content = $this
            ->get('templating')
            ->render('OCPlateformBundle:Advert:index.html.twig', array( 'listAdverts' => $listAdverts));
        return new Response($content);
    }


    public function viewAction($id, Request $request)
    {
        $advert = array(
            'title'   => 'Recherche développpeur Symfony2',
            'id'      => $id,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
            'date'    => new \Datetime()
        );
        // $id vaut 5 si l'on a appelé l'URL /platform/advert/5

        // Ici, on récupèrera depuis la base de données
        // l'annonce correspondant à l'id $id.
        // Puis on passera l'annonce à la vue pour
        // qu'elle puisse l'afficher
        $url = $this
            ->get('router')
            ->generate('oc_platform_view',array('id'=>5), UrlGeneratorInterface::ABSOLUTE_URL);

        // Méthode courte
        //$url = $this->generateUrl('oc_platform_home');
        $tag = $request->query->get('tag');
        //return new Response("L'url de l'annonce d'id 5 est : ".$url);
        return $this->render('OCPlateformBundle:Advert:view.html.twig',array(
            'advert'=>$advert
        ));
        // la redirection (methode 1)
        //$url = $this->get('router')->generate("oc_platform_home");
        //return new RedirectResponse($url);
    }

    public function addAction(Request $request)
    {
        // recuperation de la session
     //   $session = $request->getSession();

        //$session->getFlashBag()->add()
     //   $this->addFlash('info', 'Annonce bien enregistrée');
        // equivalence
        //$session->getFlashBag()->add('info', 'Oui oui, elle est bien enregistrée !');

     //  return $this->render('OCPlateformBundle:Advert:add.html.twig');

        // On récupère le service
        $antispam = $this->container->get('oc_plateform.antispam');

        // Je pars du principe que $text contient le texte d'un message quelconque
        $text = '...';
        if ($antispam->isSpam($text)) {
            throw new \Exception('Votre message a été détecté comme spam !');
        }

        // Ici le message n'est pas un spam

    }

    public function editAction($id)
    {
        $advert = array(
            'title'   => 'Recherche développpeur Symfony',
            'id'      => $id,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
            'date'    => new \Datetime()
        );

        return $this->render('OCPlateformBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));
    }

    public function deleteAction(Request $request)
    {

        // Ici, on récupérera l'annonce correspondant à $id

        // Ici, on gérera la suppression de l'annonce en question

        return $this->render('OCPlateformBundle:Advert:delete.html.twig');
    }

    // l'ordre des arguments n'est pas important
    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$_format."."
        );
    }

    public function menuAction($limit){
        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !
        $listAdverts = array(
            array('id' => 2, 'title' => 'Recherche développeur Symfony'),
            array('id' => 5, 'title' => 'Mission de webmaster'),
            array('id' => 9, 'title' => 'Offre de stage webdesigner')
        );

        return $this->render('OCPlateformBundle:Advert:menu.html.twig', array(
            // Tout l'intérêt est ici : le contrôleur passe
            // les variables nécessaires au template !
            'listAdverts' => $listAdverts
        ));
    }

}