<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 1/7/2017
 * Time: 11:14 PM
 */

namespace OC\PlateformBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdvertController extends Controller
{

    public function indexAction()
    {
        $content = $this
            ->get('templating')
            ->render('OCPlateformBundle:Advert:index.html.twig', array('nom'=>'winzou',"advert_id" =>5));
        return new Response($content);
    }


    public function viewAction($id, Request $request)
    {
        // $id vaut 5 si l'on a appelé l'URL /platform/advert/5

        // Ici, on récupèrera depuis la base de données
        // l'annonce correspondant à l'id $id.
        // Puis on passera l'annonce à la vue pour
        // qu'elle puisse l'afficher
        $url = $this
            ->get('router')
            ->generate('oc_plateform_view',array('id'=>5), UrlGeneratorInterface::ABSOLUTE_URL);

        // Méthode courte
        //$url = $this->generateUrl('oc_platform_home');
        $tag = $request->query->get('tag');
        //return new Response("L'url de l'annonce d'id 5 est : ".$url);
        return $this->render('OCPlateformBundle:Advert:view.html.twig',array(
            'id' => $id,
            'tag' => $tag
        ));
        // la redirection (methode 1)
        //$url = $this->get('router')->generate("oc_plateform_home");
        //return new RedirectResponse($url);
    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }

    // l'ordre des arguments n'est pas important
    public function viewSlugAction($slug, $year, $_format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$_format."."
        );
    }
}