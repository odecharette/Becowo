<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

class BlogController extends Controller
{
  public function viewLastArticleAction($nbArticles)
  {
    $urlBlogRSS = $this->container->getParameter('blogRSS');

    $articles = array();
    try {
      $content = file_get_contents($urlBlogRSS);
      $node = new \SimpleXmlElement($content);
       

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
    } catch (\Exception $e) {
      $articles[0]['titre'] = "";
      $articles[0]['url'] = "";
      $articles[0]['description'] = "Le contenu du blog est momentanément indisponible. <br> Veuillez recharger la page";
    }
    

  return $this->render('Home/blog.html.twig', array('articles' => $articles));

  }

}
