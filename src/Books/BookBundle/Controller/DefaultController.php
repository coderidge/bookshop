<?php

namespace Books\BookBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Books\BookBundle\Entity\Books;
use Books\BookBundle\Entity\User;
use Books\BookBundle\Entity\BookSales;

class DefaultController extends Controller
{
    public function indexAction()
    {
  
     // check if session
     $session = $this->container->get('session')->isStarted();
     // check if session
     if($session == true){
     $id = $this->get('session')->get('id');
     }
     else { 
     $id=null;
     }   
        
    $sql="SELECT distinct books.id,books.title,book_sales.user_id from books join book_sales on books.id=book_sales.book_id where book_sales.user_id=?";
    
    $em = $this->getDoctrine()->getManager();
    
    $connection = $em->getConnection();
    
    $statement = $connection->prepare($sql);
    
    $statement->bindValue(1,$id);
    
    $statement->execute();
    
    $books = $statement->fetchAll();
                         
    $session = new Session();

    $new_array = unserialize($session->get('viewed'));
       
    return $this->render('BooksBookBundle:Default:home.html.twig',array('list_books' => $books,'viewed' => $new_array));
        
    }
 
    public function listAction() { 
    
     $session = new Session();

    $new_array = unserialize($session->get('viewed'));    
        
    $em = $this->getDoctrine()->getManager();

    $books = $em->getRepository("BooksBookBundle:Books")->findAll();
                     
    return $this->render('BooksBookBundle:Default:list.html.twig',array('list_books' => $books,'last_viewed' => $new_array));   
    
    
    }
    
    public function detailsAction(Request $request) 
    {
    
     $id = $request->get('bookid');
          
     $em = $this->getDoctrine()->getManager();

     $books = $em->getRepository("BooksBookBundle:Books")->find($id);
                 
     $title = $books->getTitle();
             
     $session = new Session();

      $new_array = unserialize($session->get('viewed'));
               
      $new_array[] = $title;
                            
      $session->set('viewed', serialize($new_array));
         
      return $this->render('BooksBookBundle:Default:detail.html.twig',array('list_details' => $books));   
        
    }      
    
    public function buyAction(Request $request) 
    {
    
     $email = $request->get('email');
     
     $book_id = $request->get('book_id');
             
      $session = $this->container->get('session')->isStarted();

          if($session == true)    {
               $session = new Session();
              // check if session
               $id = $this->get('session')->get('id');
          }  else { 
             $id=null;
          }
   

   
         if($id == null) {
   
          $em = $this->getDoctrine()->getManager();

          $user = $em->getRepository("BooksBookBundle:User")->findOneByEmail($email);
         
                    if($user == null) {
                    // if no user create new user with email   
                    $task = new User();
                    $task->setEmail($email);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($task);
                    $em->flush(); 
                    
                    $user_id=$task->getid();
                    // enter sale with for user 
                    $task2 = new BookSales();
                    $task2->setUserId($user_id);
                    $task2->setBookId($book_id);                 
                    $em2 = $this->getDoctrine()->getManager();
                    $em2->persist($task2);
                    $em2->flush(); 

                    // start new session with id 
                    $session = new Session();
                    $session->set('id',$user_id);
                    
                    }
                    else { 
                     // enter sale with for user registered but not session
                    $task2 = new BookSales();
                    $task2->setUserId($user->getId());
                    $task2->setBookId($book_id);                 
                    $em2 = $this->getDoctrine()->getManager();
                    $em2->persist($task2);
                    $em2->flush(); 
                   
                    // start session with id 

                    $session = new Session();

                    
                    $session->set('id',$user->getId());
                    }
                    
        }  else { 
               
        // enter sale with for user in session
        $task2 = new BookSales();
        $task2->setUserId($id);
        $task2->setBookId($book_id);                 
        $em2 = $this->getDoctrine()->getManager();
        $em2->persist($task2);
        $em2->flush(); 

                    
         }
         
         return $this->redirect("/");
    }
    
}
