<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Manager\Admin\AnnoncementManager;
use App\Manager\Admin\LangageManager;
use App\Manager\Admin\UserManager;
use App\Manager\Admin\StatistiqueManager;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends EasyAdminController
{
    /**
     * @Route(path = "/admin_74ze5f/user/notifier/picture", name = "notifier_profil")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @param UserManager $userManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function notifierProfil(Request $request, UserManager $userManager)
    {
        $id = $request->query->get('id');

        $userManager->mailerNotifierProfilUser($id);

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $request->query->get('entity'),
        ));
    }

    /**
     * @Route(path = "/admin_74ze5f/view/dashboard", name = "easyadmin_dashboard")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @param UserManager $userManager
     * @param LangageManager $langageManager
     * @param AnnoncementManager $annoncementManager
     * @param StatistiqueManager $statistiqueManager
     * @return Response
     */
    public function easyadminDashboard(
        UserManager $userManager,
        LangageManager $langageManager,
        AnnoncementManager $annoncementManager,
        StatistiqueManager $statistiqueManager
    ) {
        dd();
        return $this->render('admin/dashboard.html.twig', [
            'user' => $this->getUser(),
            'userData' => $userManager,
            'langageData' => $langageManager,
            'annoncementData' => $annoncementManager,
            'statistiqueData' => $statistiqueManager
        ]);
    }

    /**
     * @Route(path = "/admin_74ze5f/view/statistic/teacher", name = "statistic_teacher")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @param Request $request
     * @param StatistiqueManager $statistiqueManager
     * @param UserRepository $userRepository
     * @return Response
     * @throws \Exception
     */
    public function viewStatisticTeacher(
        Request $request,
        StatistiqueManager $statistiqueManager,
        UserRepository $userRepository
    ) {
        $id = $request->query->get('id');
        $user = $userRepository->find($id);

        $stats = $statistiqueManager->statisticByUser($user);

        return $this->render('admin/statistics_teacher.html.twig', [
            'user' => $user,
            'statistiques' => $stats,
        ]);
    }
}