<?php error_reporting(E_ALL ^E_NOTICE); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link href="css/custum.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>   



      <script>  
  	  $(document).ready(function(){  
      $('#submit_form').on('submit', function(e){  
           e.preventDefault();  
           $.ajax({  
                url:"upload.php",  
                method:"POST",  
                data:new FormData(this),  
                contentType:false,  
                //cache:false,  
                processData:false,  
                success:function(data)  
                {  
					$('#image_preview').load("upload.php", {loaddata:'loaddata'});
          //$('#successmsg').load("upload.php", {loaddata:'loaddata',succmsg:'succmsg'});
					$('#image_file').val('');
                }  
           })  
      });
         
      }); 
      </script>
      <script type="text/javascript">  
      $(document).ready(function(){  
        function fetch_data()  
        {  
            $.ajax({  
                 url:"select.php",  
                  method:"POST",  
                  success:function(data){  
                       $('#image_preview').html(data);  
                 }  
            });  
        }  
       
      $(document).on('click', '.btn_delete', function(){  
           var id=$(this).data("id3");  
             if(confirm("Are you sure you want to delete this?"))  
             {  
                  $.ajax({  
                      url:"delete.php",  
                      method:"POST",  
                      data:{id:id},  
                      dataType:"text",  
                      success:function(data){  
                           $('#image_preview').html(data); 
                           fetch_data();    
                      }  
                  });  
              }  
          });  
      });  
      </script>
      <script type="text/javascript">
      $(document).ready(function(){  
      load_data();  
      function load_data(page)  
      {  
           $.ajax({  
                url:"select.php",  
                method:"POST",  
                data:{page:page},  
                success:function(data){  
                     $('#image_preview').html(data);  
                }  
           })  
      }  
      $(document).on('click', '.pagination_link', function(){  
           var page = $(this).attr("id");  
           load_data(page);  
      });  
 });  
 </script>
</head>

<body>
    <div class="container">
      <hr>
			<div class="row">  
            <form id="submit_form" enctype="multipart/form-data">  
                <div class="form-group">  
                    <label>Select Image</label>  
                    <input type="file" name="image" id="image_file" />  
                    <span class="help-block">Allowed File Type - jpg, jpeg, png, gif</span>  
                </div>  
                    <input type="submit" name="upload_button" class="btn btn-primary" value="Upload" />  
            </form>  
      </div>
			<div class="row">
				 <div id="image_preview"></div>
    	</div>
    </div>
    <hr>
</body>
</html>







