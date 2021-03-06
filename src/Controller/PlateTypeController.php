<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use App\Entity\PlateType;
use App\Form\PlateTypeType;
use App\Repository\PlateTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * PlateType controller.
 *
 * @Route("/plate_type")
 */
class PlateTypeController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;

    /**
     * Lists all PlateType entities.
     *
     * @return array
     *
     * @Route("/", name="plate_type_index", methods={"GET"})")
     *
     * @Template
     */
    public function indexAction(Request $request, EntityManagerInterface $em) {
        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(PlateType::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();

        $plateTypes = $this->paginator->paginate($query, $request->query->getint('page', 1), 25);

        return [
            'plateTypes' => $plateTypes,
        ];
    }

    /**
     * Typeahead API endpoint for PlateType entities.
     *
     * @Route("/typeahead", name="plate_type_typeahead", methods={"GET"})")
     *
     * @return JsonResponse
     */
    public function typeahead(Request $request, PlateTypeRepository $repo) {
        $q = $request->query->get('q');
        if ( ! $q) {
            return new JsonResponse([]);
        }

        $data = [];

        foreach ($repo->typeaheadQuery($q) as $result) {
            $data[] = [
                'id' => $result->getId(),
                'text' => (string) $result,
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * Creates a new PlateType entity.
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new", name="plate_type_new", methods={"GET", "POST"})")
     *
     * @Template
     */
    public function newAction(Request $request, EntityManagerInterface $em) {
        $plateType = new PlateType();
        $form = $this->createForm(PlateTypeType::class, $plateType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($plateType);
            $em->flush();

            $this->addFlash('success', 'The new plateType was created.');

            return $this->redirectToRoute('plate_type_show', ['id' => $plateType->getId()]);
        }

        return [
            'plateType' => $plateType,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new PlateType entity in a popup.
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/new_popup", name="plate_type_new_popup", methods={"GET", "POST"})")
     *
     * @Template
     */
    public function newPopupAction(Request $request) {
        return $this->newAction($request);
    }

    /**
     * Finds and displays a PlateType entity.
     *
     * @return array
     *
     * @Route("/{id}", name="plate_type_show", methods={"GET"})")
     *
     * @Template
     */
    public function showAction(PlateType $plateType) {
        return [
            'plateType' => $plateType,
        ];
    }

    /**
     * Displays a form to edit an existing PlateType entity.
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/edit", name="plate_type_edit", methods={"GET", "POST"})")
     *
     * @Template
     */
    public function editAction(Request $request, PlateType $plateType, EntityManagerInterface $em) {
        $editForm = $this->createForm(PlateTypeType::class, $plateType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();
            $this->addFlash('success', 'The plateType has been updated.');

            return $this->redirectToRoute('plate_type_show', ['id' => $plateType->getId()]);
        }

        return [
            'plateType' => $plateType,
            'edit_form' => $editForm->createView(),
        ];
    }

    /**
     * Deletes a PlateType entity.
     *
     * @return array|RedirectResponse
     *
     * @Security("is_granted('ROLE_CONTENT_ADMIN')")
     * @Route("/{id}/delete", name="plate_type_delete", methods={"GET"})")
     */
    public function deleteAction(Request $request, PlateType $plateType, EntityManagerInterface $em) {
        $em->remove($plateType);
        $em->flush();
        $this->addFlash('success', 'The plateType was deleted.');

        return $this->redirectToRoute('plate_type_index');
    }
}
