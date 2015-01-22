<?php
namespace Mopa\Bundle\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SiteMapController
 * @package Mopa\Bundle\BackendBundle\Controller
 */
class SiteMapController extends Controller
{
    /**
     */
    public function siteMapAction(Request $request)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('MopaBackendBundle:SiteMap:siteMap.xml.twig', $this->get('mopa_backend.sitemap')->render(), $response);
    }
}