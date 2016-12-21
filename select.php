<?php  
 $connect = mysqli_connect("localhost", "root", "root", "crud_tutorial");  
 $record_per_page = 5;  
 $page = '';  
 $output = '';  
 if(isset($_POST["page"]))  
 {  
      $page = $_POST["page"];  
 }  
 else  
 {  
      $page = 1;  
 }  
 $start_from = ($page - 1)*$record_per_page;  
 $query = "SELECT * FROM customers ORDER BY id DESC LIMIT $start_from, $record_per_page";  
 $result = mysqli_query($connect, $query);  
 $output .= "  
      <table class='table table-bordered'>
                <thead>
                   <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Size</th>
                        <th>Action</th>
                   </tr>
                </thead> 
 ";  
 while($row = mysqli_fetch_array($result))  
 {  
      $output .= '<tbody> 
           <tr>  
                <td>'.$row["id"].'</td>  
                <td contenteditable="true" id="data_'.$row['id'].'" onblur="savedata('.$row['id'].')">' .$row['name']. '</td> 
                <td><img src="'.  $row['image'] . '" hight="100" width="50"></td>;
                <td>'. $row['Size'] . '</td>;
                <td><button type="button" name="delete_btn" data-id3="'.$row["id"].'" class="btn btn-danger btn_delete">delete</button></td>;
              
           </tr> </tbody> 
      ';  
 }  
 $output .= '</table><br/><div align="center">';  
 $page_query = "SELECT * FROM customers ORDER BY id DESC";  
 $page_result = mysqli_query($connect, $page_query);  
 $total_records = mysqli_num_rows($page_result);  
 $total_pages = ceil($total_records/$record_per_page);  
 for($i=1; $i<=$total_pages; $i++)  
 {  
      $output .= "<span class='pagination_link' style='cursor:pointer;margin:4px;color:grey; padding:8px; border:1px solid #ccc;' id='".$i."'>".$i."</span>";  
 } 
 
 $output .= '</div>';  
 echo $output;  
 ?>
 <script type="text/javascript">
function savedata(id)
{
  var data = $('#data_'+id).text()
  var id= id
    $.ajax({  
            
            url:"update.php",  
            method:"POST",  
            data:{id:id,data:data},  
            dataType:"text",  
            success:function(data){  
                console.log(data);
                alert('successfully updated');
            }  
    })
}
</script>


















<?php
    include('database.php');
    session_start();
   
      $name = $_SESSION['name'];
    $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT username FROM `user` WHERE username='$name'";
        $q = $pdo->prepare($sql);
        $q->execute(); 
        $number_of_rows = $q->fetchColumn();

  if(!isset($_SESSION['name'])){
      header("location:crud.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/custum.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

  <script>
    function deleletconfig(){
      var del=confirm("Are you sure you want to delete this record?");
        
      if (del==true){
        alert ("record deleted successfully");
      }
      return del;
    }
  </script>
  <script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable( {
        "processing": false,
        "serverSide": false,
        "lengthMenu": [5,10,15,20],
    } );
  } );
  </script>
</head>

<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
      <div class="navbar-header">
          <a class="navbar-brand" href="#"><b>CRUD</b></a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <b><?php echo "hi.." . $name . "";?></b> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href='logout.php' class="btn">Logout</a> </li>
                </ul>
            </li>
          </ul>
      </div>
    </div>
</nav>
<div class="container">
<p><a href="create.php"><span class="glyphicon glyphicon-plus-sign"></span></a></p>
  <table class="table table-striped table-bordered" id="example">
  <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $pdo = Database::connect();
    $sql = 'SELECT * FROM customers ORDER BY id DESC';
    
    foreach ($pdo->query($sql) as $row) {
      echo '<tr>';
      echo '<td>'. $row['name'] . '</td>';
      echo '<td>'. $row['email'] . '</td>';
      echo '<td>'. $row['mobile'] . '</td>';
      echo '<td width=160>';
      echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
      echo '&nbsp;';
      echo '<a href="delete.php?id='.$row['id'].'" class="btn btn-danger" onclick="return deleletconfig()">delete</a>';
      echo '</td>';
      echo '</tr>';
    }
    Database::disconnect();
  ?>
  </tbody>
   </table>
</div>
</body>
</html>