<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
  public function viewLastArticleAction($nbArticles)
  {
    $urlBlogRSS = $this->container->getParameter('blogRSS');

    $content = file_get_contents($urlBlogRSS);
    $node = new \SimpleXmlElement($content);
     
    $articles = array();

    $i = 0;
    foreach($node->channel->item as $entry) {
      $articles[$i]['titre'] = $entry->title;
      $articles[$i]['url'] = $entry->link;
      $articles[$i]['description'] = $entry->description;
      $i ++;
      if($i == $nbArticles){
        break;
      }
    }

  return $this->render('Home/blog.html.twig', array('articles' => $articles));

  }

}
