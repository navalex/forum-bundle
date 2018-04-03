<?php

namespace Navalex\ForumBundle\Controller;

use Navalex\ForumBundle\Entity\Post;
use Navalex\ForumBundle\Entity\Topic;
use Navalex\ForumBundle\Form\PostType;
use Navalex\ForumBundle\Form\TopicType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class ForumController extends Controller
{
	public function homeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$list = $em->getRepository("NavalexForumBundle:Category")->findAll();

        return $this->render('@NavalexForum/Forum/home.html.twig', [
        	'list' => $list
		]);
    }

    public function categoryAction($slug)
    {
		$em = $this->getDoctrine()->getManager();
		$category = $em->getRepository("NavalexForumBundle:Category")->findOneBySlug($slug);

        return $this->render('@NavalexForum/Forum/category.html.twig', [
        	'category' => $category
		]);
    }

    public function forumAction($slug)
    {
		$em = $this->getDoctrine()->getManager();
		$forum = $em->getRepository("NavalexForumBundle:Forum")->findOneBySlug($slug);

		return $this->render('@NavalexForum/Forum/forum.html.twig', [
			'forum' => $forum
		]);
    }

    public function topicAction(Request $request, $slug)
    {
		$em = $this->getDoctrine()->getManager();
		$topic = $em->getRepository("NavalexForumBundle:Topic")->findOneBySlug($slug);
		$post = new Post();
		$post->setTopic($topic);
		$post->setDate(new \DateTime());
		$form = $this->createForm(PostType::class, $post);

		if ($form->handleRequest($request)->isValid() && $this->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
			$post->setAuthor($this->getUser());
			$em->persist($post);
			$em->flush();
			return($this->redirectToRoute('topic', ['slug' => $slug]));
		}

        return $this->render('@NavalexForum/Forum/topic.html.twig', [
        	'topic' => $topic,
			'form' => $form->createView()
		]);
    }

    public function addTopicAction(Request $request, $forum_slug)
	{
		$em = $this->getDoctrine()->getManager();
		$topic = new Topic();
		$topic->setForum($em->getRepository("NavalexForumBundle:Forum")->findOneBySlug($forum_slug));
		$topic->setDate(new \DateTime());
		$form = $this->createForm(TopicType::class, $topic);

		if ($form->handleRequest($request)->isValid() && $this->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
			$topic->setAuthor($this->getUser());
			$em->persist($topic);
			$em->flush();
			return($this->redirectToRoute('forum', ['slug' => $forum_slug]));
		}

		return $this->render('@NavalexForum/Forum/add_topic.html.twig', [
			'form' => $form->createView(),
			'topic' => $topic
		]);
	}

}
