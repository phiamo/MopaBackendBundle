<?php
/**
 * Created by PhpStorm.
 * User: fle
 * Date: 03.11.14
 * Time: 14:10
 */
namespace Mopa\Bundle\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SiteMapController extends Controller
{

    /**
     * @Template()
     */
    public function siteMapAction(Request $request)
    {
        return $this->get('mopa_backend.sitemap')->render();
    }
}