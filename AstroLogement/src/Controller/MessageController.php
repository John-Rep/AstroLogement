<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/message')]
class MessageController extends AbstractController
{

#[Route('/', name: 'app_message_home')]
public function index(UserRepository $userRepository)
{
    $currentUser = $this->getUser();
    $users = $userRepository->getUserMessages($currentUser);

    return $this->render('message/index.html.twig', [
        'users' => $users,
    ]);
}

    #[Route('/{id}', name: 'app_messages')]
    public function messages(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        MessageRepository $messageRepository
    ) {
        $receiver = $em->getRepository(User::class)->find($id);
        $sender = $this->getUser();

        if (!$receiver || $receiver === $sender) {
            throw $this->createAccessDeniedException("Action non autorisée.");
        }

        $messages = $messageRepository->findConversation($sender, $receiver);

        $message = new Message();
        $message->setUserOrig($sender);
        $message->setUserDest($receiver);
        $message->setDate(new \DateTimeImmutable());

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('app_messages', ['id' => $receiver->getId()]);
        }

        return $this->render('message/conversation.html.twig', [
            'messages' => $messages,
            'form' => $form->createView(),
            'receiver' => $receiver,
        ]);
    }
    #[Route('/refresh/{id}', name: 'app_messages_refresh')]
    public function refreshMessages(
        int $id,
        EntityManagerInterface $em,
        MessageRepository $messageRepository
    ) {
        $receiver = $em->getRepository(User::class)->find($id);
        $sender = $this->getUser();

        if (!$receiver || $receiver === $sender) {
            throw $this->createAccessDeniedException("Non autorisé");
        }

        $messages = $messageRepository->findConversation($sender, $receiver);

        return $this->render('message/_messages.html.twig', [
            'messages' => $messages,
        ]);
    }

}
