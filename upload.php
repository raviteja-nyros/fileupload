<?php 
	error_reporting(E_ALL ^E_NOTICE);
	require 'database.php';

	if ($_FILES['image']['name'] != '') {

			$extension = end(explode(".", $_FILES['image']['name']));  
 			$allowed_type = array("jpg", "jpeg", "png", "gif");  
     		if(in_array($extension, $allowed_type)){  	
				$tmp_name = $_FILES['image']['tmp_name'];
				$name= basename($_FILES['image']['name']);
				$names=explode('.',$name);
				$imgSize=$_FILES["image"]["size"];
				$imageSize = number_format($imgSize / 1024, 2) . ' kB';

				$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
				$upload_dir="images/";
				$imgname= $upload_dir.time().'.'.$ext;
				$imgname= 'images/'.time().'.'.$ext;
    		$dir="images/".time().'.'.$ext;
				$file=move_uploaded_file($tmp_name,$dir);
			
			if($file)
			{
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO customers (name,Size,image) values(?, ?, ?) ";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$imageSize,$imgname));
				Database::disconnect();
				
				echo '<script>alert("image uploaded successfully")</script>';
			}
	
  			}
  			else  
     		{  
                echo '<script>alert("Invalid File Formate")</script>';  
            }  
    }
    else if($_POST['loaddata']=='loaddata'){
	
			if(empty($_POST['succmsg'])){
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
 				$output .= "<table class='table table-bordered'>
             				<thead>
                   				<tr>
                        			<th>ID</th>
                        			<th>Name</th>
                       				<th>Image</th>
                        			<th>Size</th>
                       				<th>Action</th>
                   				</tr>
                			</thead>";  
 				while($row = mysqli_fetch_array($result))  
 				{  
     				 $output .= '<tbody> 
           						 <tr>  
               						 <td>'.$row["id"].'</td>  
                					 <td contenteditable="true" id="data_'.$row['id'].'" onblur="savedata('.$row['id'].')">' .$row['name']. '</td> 
                					 <td><img src="'.  $row['image'] . '" hight="100" width="50"></td>;
                					 <td>'. $row['Size'] . '</td>;
                					 <td><button type="button" name="delete_btn" data-id3="'.$row["id"].'" class="btn btn-danger btn_delete">delete</button></td>;
              
           						 </tr>
           						 </tbody>';  
 				}  
 				$output .= '</table><br/><div align="center">';  
 				$page_query = "SELECT * FROM customers ORDER BY id DESC";  
 				$page_result = mysqli_query($connect, $page_query);  
 				$total_records = mysqli_num_rows($page_result);  
 				$total_pages = ceil($total_records/$record_per_page);  
 				for($i=1; $i<=$total_pages; $i++)  
 				{  
     				 $output .= "<span class='pagination_link' style='cursor:pointer;margin:4px; padding:8px; color:grey; border:1px solid #ccc;' id='".$i."'>".$i."</span>";  
 				}  
 				$output .= '</div>';  
 				echo $output;				
			}
			else{
				echo '<script>alert("successfully uploaded")</script>';
				//echo '<div class="alert alert-success"><strong>Success!</strong>Data has been inserted successfully</div>';
				return false;
			}
	}
    else  
 	{  
      	echo '<script>alert("Please Select File")</script>';  
	}  
	
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



