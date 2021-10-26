<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage blog contents in the public part of the site.
 *
 * @Route("/api")
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request, PostRepository $posts, TagRepository $tags): Response
    {
        $tag = null;
        if ($request->query->has('tag')) {
            $tag = $tags->findOneBy(['name' => $request->query->get('tag')]);
        }
        $latestPosts = $posts->findLatest(1, $tag);

        return new JsonResponse(iterator_to_array($latestPosts->getResults()));
    }

    /**
     * @Route("/posts/{id}", methods="GET")
     */
    public function postShow(Post $post): Response
    {
        return new JsonResponse($post);
    }

    /**
     * @Route("/posts/{id}/warning", methods="GET")
     */
    public function postWarning(Post $post): Response
    {
        $a = [];
        $a[1];

        return new JsonResponse($post);
    }

    /**
     * @Route("/posts/{id}/error", methods="GET")
     */
    public function postError(Post $post): Response
    {
        trigger_error('My error');

        return new JsonResponse($post);
    }
}
