<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/temperature")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function temperatureAction() {
        $weather = $this->container->get('app.delegating_weather');

        $temperature =$weather->fetch('Aleppo');

        return $this->render('default/weather.html.twig', [
            'temperature' => $temperature,
        ]);
    }

}