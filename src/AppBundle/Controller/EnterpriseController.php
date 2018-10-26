<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Enterprise;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class EnterpriseController extends Controller
{
    /**
     * Formulaire de création d'une entreprise
     *
     * @Route("/createenterprise")
     * @param $request Request
     * @return Response
     */
    public function createAction(Request $request)
    {

        $enterprise = new Enterprise();

        $form = $this->createFormBuilder($enterprise)
            ->add('denomination', TextType::class)
            ->add('siret', TextType::class)
            ->add('juridicForm', EntityType::class,
                array(
                    'class' => 'AppBundle\Entity\JuridicForm',
                    'choice_label' => 'name'
                ) )
            ->add('save',      SubmitType::class)
            ->getForm()
            ;

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                //Persist de l'objet dans la base

                return $this->redirectToRoute('', array('id' => $enterprise->getId()));
            }
        }

       return $this->render('AppBundle:Enterprise:create.html.twig', array(
        'form' => $form->createView(),
        ));
    }

}
