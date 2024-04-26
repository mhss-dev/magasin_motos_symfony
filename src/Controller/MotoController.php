<?php

namespace App\Controller;

use App\Entity\Moto;
use App\Form\MotoType;
use App\Repository\MotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MotoController extends AbstractController
{
    #[Route('/', name: 'app_moto_index')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $motos = $em->getRepository(Moto::class)->findAll();

        return $this->render('moto/index.html.twig', [
            'motos' => $motos,
        ]);
    }

    #[Route(path : '/motos/creer', name : 'app_moto_create' )]
    public function create(Request $request, EntityManagerInterface $em) : Response 
    {
    $moto = new Moto;
    $form = $this->createForm(MotoType:: class, $moto);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
    $em->persist($moto);
    $em->flush();
    $this->addFlash('success', 'La moto '. $moto->getNom() .' a bien été ajoutée !');
    return $this->redirectToRoute('app_moto_index');
    }
    return $this->render('moto/create.html.twig',[
        'moto' => $moto,
        'form' => $form
    ]);
}


    #[Route(path: '/moto/{id}/details', name: 'app_moto_show', requirements: ['id' => '\d+'])]
    public function show(Request $request, EntityManagerInterface $em, int $id): Response
    {

        $moto = $em->getRepository(Moto::class)->find($id);


        if ($moto->getID() !== $id) {
            return $this->redirectToRoute("app_moto_show", ['id' => $moto->getID()]);
        }

        return $this->render('moto/show.html.twig', [
            'id' => $id,
            'moto' => $moto,
        ]);
    }


    #[Route(path : '/moto/{id}/editer', name : 'app_moto_edit')]
    public function edit(Moto $moto, Request $request, EntityManagerInterface $em) : Response{
        $form = $this->createForm(motoType::class, $moto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        $this->addFlash("success", "La moto a bien été modifiée");
        return $this->redirectToRoute('app_moto_index');
    }
        return $this->render('moto/edit.html.twig',[
            'moto' => $moto,
            'form' => $form
        ]);
    }

    #[Route(path : '/moto/{id}/supprimer', name : 'app_moto_delete')]
    public function delete(moto $moto, Request $request, EntityManagerInterface $em) : Response {

        $titre = $moto->getNom();
        $em->remove($moto);
        $em->flush();
        $this->addFlash("danger", 'La moto' . $titre . " a bien été supprimée");
        return $this->redirectToRoute('app_moto_index');

    }
}
