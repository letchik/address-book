<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends AbstractController
{
    /**
     * @Route("/contacts", name="contacts.list")
     */
    public function index()
    {
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        return $this->render('contacts/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/contacts/edit/{id}", name="contacts.edit", requirements={"id"="\d+"})
     * @Route("/contacts/edit", name="contacts.add")
     * @param Contact $contact
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editContact(Contact $contact = null)
    {
        if (!$contact) {
            $contact = new Contact;
        }
        $form = $this->createForm(\App\Form\Contact::class, $contact);
        $form->handleRequest($this->get('request_stack')->getMasterRequest());
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
                return $this->redirectToRoute('contacts.list');
            } else {
                if ($file = $form->get('avatar')->getData() ) {
                    unlink($file->getPath() . '/' . $file->getFileName());
                }
            }
        }
        return $this->render('contacts/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/contacts/delete/{id}", name="contacts.delete")
     * @param Contact $contact
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteContact(Contact $contact)
    {
        $this->getDoctrine()->getManager()->remove($contact);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('contacts.list');
    }
}
