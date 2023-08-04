<!-- Db php -->
<?php 
  $insert = false;
  $update = false;
  $delete = false;
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "notes";
  $conn = mysqli_connect($servername,$username,$password,$database);

  // both the GET and POST methods successfully retrieve the form data as associative arrays (KEY-VALUE pairs), but the POST method is more secure as it does not expose sensitive information in the URL. Always use POST for sensitive data like passwords.
  if(isset($_GET['delete'])){
    // `isset()` is a language construct used to check if a variable or an array element is set and not null.
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `notes` WHERE `sno`='$sno';";
    $result = mysqli_query($conn,$sql);
    if($result){
      $delete = true;
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // `$_SERVER['REQUEST_METHOD']` is a superglobal variable that holds the request method used to access the current script. It provides information about the type of HTTP request made to the server. 
    if(isset($_POST['snoEdit'])){
      $sno = $_POST['snoEdit'];
      $title = $_POST['titleEdit'];
      $description = $_POST['descriptionEdit'];
      $sql = "UPDATE `notes` SET `title` = '$title' , `description`= '$description' WHERE `sno` = '$sno';";
      $result = mysqli_query($conn,$sql);
      if($result){
        $update = true;
      }
    }
    else{
      $title = $_POST['title'];
      $description = $_POST['description'];
      $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description');";
      $result = mysqli_query($conn,$sql);
      if($result){
        $insert = true;
      }
    }
  }
?>
<!-- HTML -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Noted✅</title>
<!-- BootStrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
  </head>
<!--Datatables CSS-->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
  </head>
  <body>
<!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="/CRUD/index.php" method="POST">
            <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit">
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div>
                <button type="submit" class="btn btn-outline-success">Update Note</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Noted  <i class="bi bi-card-checklist"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact Us</a>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div> -->
      </div>
    </nav>
<!-- Alert -->
    <div class="container">
      <?php
      if($insert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="selfDismissingAlert">
                <strong>Note Added!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              ';
      }
      if($update){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="selfDismissingAlert">
                <strong>Note Updated!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              ';
      }
      if($delete){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="selfDismissingAlert">
                <strong>Note Deleted!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              ';
      }
      ?>
    </div>
<!--Form -->
    <div class="container my-4">
      <form action="/CRUD/index.php" method="POST">
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
          <button type="submit" class="btn btn-primary">Add Note <i class="bi bi-plus-square"></i></button>
        </div>
      </form>
    <div class="container">
    <hr></hr>
<!-- Table -->
    <div class="container my-4">
        <table class="table" id="mytable">
          <thead>
            <tr>
              <th scope="col">S.No</th>
              <th scope="col">Title</th>
              <th scope="col">Description</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!--Form php -->
              <?php
                $sql = "SELECT * FROM notes";
                $result = mysqli_query($conn,$sql);
                $sno = 1;
                while($row = mysqli_fetch_assoc($result)){
                  echo '<tr>
                          <th scope="row">'.$sno.'</th>
                          <td>'.$row['title'].'</td>
                          <td>'.$row['description'].'</td>
                          <td><button class="edit btn btn-sm btn-outline-success" id='.$row['sno'].'>
                                <i class="bi-pencil"></i>
                              </button> 
                              <button class="delete btn btn-sm btn-outline-danger" id=d'.$row['sno'].'>
                                <i class="bi-trash"></i>
                              </button></td>
                        </tr>';
                  $sno++;
                }
              ?>
          </tbody>
        </table>
    </div>
    <hr></hr>
    </div>

<!-- BootStrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>


<!-- Scripts -->
<!--Self Dismissing Alert-->
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          const alert = document.getElementById('selfDismissingAlert');
          const duration = 2000;

          // Function to dismiss the alert
          function dismissAlert() {
            alert.classList.add('hide');
            setTimeout(function () {
              alert.remove();
            }, 500);
          }
              setTimeout(dismissAlert, duration);
        });
      </script>

<!-- JQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<!-- Datatables script -->
    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function (){
        $('#mytable').DataTable();
      });
    </script>
<!-- Modal -->
    <script>
      edits = document.getElementsByClassName("edit");
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          tr = e.target.parentNode.parentNode; 
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;

          snoEdit.value = e.target.id;
          console.log(e.target.id);
          titleEdit.value = title;
          descriptionEdit.value = description;
          $('#editModal').modal('toggle');
        })
      })
      deletes = document.getElementsByClassName("delete");
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          sno = e.target.id.substr(1,);
          if(confirm('Do you want to delete ?')){
            console.log("yes");
            window.location = `/CRUD/index.php?delete=${sno}`;
          }
          else{
            console.log("no");
          }
        })
      })
    </script>
  </body>
</html>