<?php
session_start();
require_once 'database.php';
class Book
{
    public $id;
    public $title;
    public $description;
    public $book;
    public $cover;
    function __construct(){

    }
    public function view(){
     $conn = new Connection();
     $conn->query = "Select * from books";
     $conn->prepare();
     $books = $conn->selectAll();
     if(!empty($books)){
        foreach($books as $book){
            echo "
            <div class='w-50 bg-light rounded-3'>
               <div class='row'>
                 <div class='col-md-4'>
                   <img src='covers/{$book['cover']}' class='w-75 rounded-3'>
                 </div>
               <div class='col-md-8'>
                 <h1 class='fs-3 text-danger'><span class='badge badge-danger text-primary'>{$book['id']}.</span>{$book['title']}</h1>
                 <p class=''>{$book['description']}</p>
              </div>
            </div>
            <hr>
         </div>
        
            ";
            
        }
     

     }else{
        echo "<p class='text-warning'> There are no books in the database yet </p>";
        
        
     }
    }//end of view method

    public function view_home(){
        $conn = new Connection();
        $conn->query = "Select * from books";
        $conn->prepare();
        $books = $conn->selectAll();
        if(!empty($books)){
           foreach($books as $book){
               echo "
               <div class='w-100 bg-light rounded-3'>
                  <div class='row'>
                    <div class='col-md-4'>
                      <img src='backend/covers/{$book['cover']}' class='w-25 rounded-3'>
                    </div>
                  <div class='col-md-8'>
                    <h1 class='fs-3 text-danger'><span class='badge badge-danger text-primary'>{$book['id']}.</span>{$book['title']}</h1>
                    <p class=''>{$book['description']}</p> 
                    <a href='backend/books/{$book['book']}'downoad
                    class='btn btn-success'>Download</a>
                 </div>
               </div>
               <hr>
            </div>
           
               ";
               
           }
        
   
        }else{
           echo "<p class='text-warning'> There are no books in the database yet </p>";
           
           
        }
       }//end of view method

    public function add($title,$description,$cover,$book){ 
        $this->title  = $title;
        $this->description = $description;
        $this->cover = $cover;
        $this->book = $book;
        //add book and cover to server first
        //if succesfully added then
        //add title description book and cover to database
        //ADD_TO_SERVER
        $bookpathway = '../backend/books/'.$this->book['name'];
        $coverpathway = '../backend/covers/'.$this->cover['name'];
        move_uploaded_file($this->book['tmp_name'],$bookpathway);
        move_uploaded_file($this->cover['tmp_name'],$coverpathway);
        //ADD_TO_DATABASE
     $conn = new Connection();
     $conn->query = "Insert into books(title,description,cover,book)
     VALUES('{$this->title}','{$this->description}','{$this->cover['name']}','{$this->book['name']}')";
     $conn->prepare();
    $success = $conn->insert();
    if($success){
        echo "<p class='text-success lead'> New Book successfully registered</p>";
    }
    else{
        echo "<p class='text-danger'>Check on view if Book was registered</p>";
    }

    }//endof add

    public function update($id,$title,$description){
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        //database
     $conn = new Connection();
     $conn->query = "Update books Set title ='{$this->title}',description='{$this->description}'WHERE id = {$this->id}";
     $conn->prepare();
    $success = $conn->insert();
    if($success){
        echo "<p class='text-success lead'>Book successfully Updated</p>";
    }
    else{
        echo "<p class='text-danger lead'>Check on view if Book was Updated</p>";
    }

    }//endof update


    public function delete($id){
        $this->id = $id;
        //database
     $conn = new Connection();
     $conn->query = "DELETE FROM books WHERE id = $this->id";
     $conn->prepare();
    $success = $conn->insert();
    if($success){
        echo "<p class='text-success'>Student successfully Updated</p>";
    }
    else{
        echo "<p class='text-danger'>Check on view if student was Updated</p>";
    }

    }
} 
//end of class

if(isset($_POST['view'])){
$book = new Book();
$book->view();
}
else if(isset($_POST['view_home'])){
    $book = new Book();
    $book->view_home();
    }
else if(isset($_POST['add'])){
   $book = new Book();
   $book->add($_POST['title'],$_POST['description'],$_FILES['cover'],$_FILES['book']);
}
else if(isset($_POST['update'])){
    $book = new Book();
$book->update($_POST['id'],$_POST['title'],$_POST['description']);
}

else if(isset($_POST['delete'])){
    $book = new Book();
$book->delete($_POST['id']);
}
else{
    echo "no response";
}
?>