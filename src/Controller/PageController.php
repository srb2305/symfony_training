<?php

namespace App\Controller;
use App\Entity\Contact; 

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\FileType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


/**
 * @Route("/page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/contact", name="page_contact", methods={"GET","POST"})
     */
    public function contact(Request $request)
    {
    	$contact = new Contact(); 
      	$form = $this->createFormBuilder($contact) 
	         ->add('name', TextType::class) 
	         ->add('contact', TextType::class) 
	         ->add('image', FileType::class, array('label' => 'Photo (png, jpeg)')) 
	         ->add('save', SubmitType::class, array('label' => 'Submit')) 
	         ->getForm(); 
         
	      $form->handleRequest($request); 
	      if ($form->isSubmitted()) { 
	      	// ----- image upload code -------------
	         $file = $contact->getImage();
	         $fileName = md5(uniqid()).'.'.$file->guessExtension(); 
	         $file->move($this->getParameter('photos_directory'), $fileName); 
	         $contact->setImage($fileName);
	         // ------------
	           //$contact->setContact('1');
	           //$contact->setName('RAM');
	         // ---------save data on database -----------
	        $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            // ------------------------------------------

	         return new Response("User photo is successfully uploaded."); 
	      } else { 
	         return $this->render('pages/contact.html.twig', array( 
	            'form' => $form->createView(), 
	         )); 
	      } 

    }

    /**
     * @Route("/about", name="page_about", methods={"GET"})
     */
    public function about()
    {
        return $this->render('pages/about.html.twig');
    }
 }   
?>