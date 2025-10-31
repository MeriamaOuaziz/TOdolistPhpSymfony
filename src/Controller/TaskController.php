<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/task')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'app_task_index', methods: ['GET'])]
    public function index(TaskRepository $repo): Response
    {
        $tasks = $repo->findBy([], ['id' => 'DESC']);
        $assignees = $repo->findDistinctPersons(); // Q5 boutons dynamiques

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
            'assignees' => $assignees,
        ]);
    }

    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('app_task_index');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Task $task, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_task_index');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form,
            'task' => $task,
        ]);
    }

    #[Route('/{id}', name: 'app_task_delete', methods: ['POST','DELETE'])]
    public function delete(Task $task, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $em->remove($task);
            $em->flush();
        }
        return $this->redirectToRoute('app_task_index');
    }

    // Q4 : Les tâches de XXX
    #[Route('/person/{person}', name: 'app_task_by_person', methods: ['GET'])]
    public function byPerson(string $person, TaskRepository $repo): Response
    {
        $tasks = $repo->findBy(['assignedTo' => $person], ['id' => 'DESC']);

        return $this->render('task/by_person.html.twig', [
            'person' => $person,
            'tasks' => $tasks,
        ]);
    }
}
