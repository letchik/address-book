<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends AbstractController
{
    /**
     * @Route("/contacts", name="contacts")
     */
    public function index()
    {
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        $form = $this->createForm(\App\Form\Contact::class);
        return $this->render('contacts/index.html.twig', [
            'contacts' => $contacts,
            'form' => $form->createView()
        ]);
    }
}
