<?php

require(APPPATH.'/libraries/REST_Controller.php');
 
class Api extends REST_Controller{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
    }

    //API - client sends isbn and on valid isbn book information is sent back
    function user_get(){

        $isbn  = $this->get('isbn');
        
        if(!$isbn){

            $this->response("No ISBN specified", 400);

            exit;
        }

        $result = $this->book_model->getbookbyisbn( $isbn );

        if($result){

            $this->response($result, 200); 

            exit;
        } 
        else{

             $this->response("Invalid ISBN", 404);

            exit;
        }
    } 

    //API -  Fetch All books
    function usuario_get(){

        $result = $this->book_model->getallbooks();

        if($result){

            $this->response($result, 200); 

        } 

        else{

            $this->response("No record found", 404);

        }
    }
     
    //API - create a new book item in database.
    function addUser_post(){

         $name      = $this->post('name');

         $password     = $this->post('password');

         
        
         if(!$name || !$password){

                $this->response("Enter complete book information to save", 400);

         }else{

            $result = $this->book_model->add(array("name"=>$name, "price"=>$password, "publish_date"=>$pub_date));

            if($result === 0){

                $this->response("Book information coild not be saved. Try again.", 404);

            }else{

                $this->response("success", 200);  
           
            }

        }

    }

    
    //API - update a book 
    function updateUser_put(){
         
         $name      = $this->put('name');

         $price     = $this->put('password');

         
         if(!$name || !$password){

                $this->response("Enter complete book information to save", 400);

         }else{
            $result = $this->book_model->update($id, array("name"=>$name, "price"=>$password "publish_date"=>$pub_date));

            if($result === 0){

                $this->response("Book information coild not be saved. Try again.", 404);

            }else{

                $this->response("success", 200);  

            }

        }

    }

    //API - delete a book 
    function deleteUser_delete()
    {

        $id  = $this->delete('id');

        if(!$id){

            $this->response("Parameter missing", 404);

        }
         
        if($this->book_model->delete($id))
        {

            $this->response("Success", 200);

        } 
        else
        {

            $this->response("Failed", 400);

        }

    }


}