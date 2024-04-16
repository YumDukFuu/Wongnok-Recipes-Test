<?php
    // Connecting Database . . .
    session_start();
    require_once "config/content_db.php";
    
    // กระบวกการ การ Delete ไฟล์
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deletestmt = $conn->query("DELETE FROM content WHERE idcontent = $delete_id");
        $deletestmt->execute();

        if ($deletestmt) {
            // แจ้งเตือนการ Delete ไฟล์สำเร็จ
            echo "<script>alert('Data has been deleted successfully');</script>";
            $_SESSION['success'] = "Data has been deleted succesfully";
            // Refrash 1 ครั้ง หลังจาก Delete ไฟล์สำเร็จ
            header("refresh:1; url=mem_page.php");
        }
        
    }

?>

<!DOCTYPE html>
    <html lang="en">
        <!--*********************************************************** -->  
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Member Homepage</title>
            <!-- Noted** Get start "css" from Boostrap5 -->  
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        </head>
        <!--*********************************************************** -->  
        <body>

<!-- D A T A _ I N S E R T -->

<!-- ก๊อป modal "Varying modal content" จาก Boostrap5 -->   
    <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- แก้ id ให้ตรงกับ userModal -->   
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Content</h5>
                    <!-- แก้ขื่อ Add User -->   
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- ส่วนของแบบ Form -->   
                <div class="modal-body">
                    <!-- DEST. File:  mem_insert.php -->   
                    <!-- enctype="multipart/form-data" for Insert Image -->  
                    <form action="mem_insert.php" method="post" enctype="multipart/form-data">
                    
                        <!-- Topic (required)-->  
                        <div class="mb-3">
                            <label for="topic" class="col-form-label">Topic:</label>
                            <input type="text" required class="form-control" name="topic">
                        </div>

                        <!-- Content (required)--> 
                        <div class="mb-3">
                            <label for="content" class="col-form-label">Content:</label>
                            <textarea type="text" required class="form-control" name="content" style = "height: 144px;" placeholder="Amazing Recipe . . ."></textarea>
                        </div>
                    
                        <!-- Image (required)-->
                        <!-- Noted** Set id name for preview Image --> 
                        <div class="mb-3">
                            <label for="img" class="col-form-label">Image:</label>
                            <input type="file" required class="form-control" id="imgInput" name="img">
                            <img loading="lazy" width="100%" id="previewImg" alt="">
                        </div>

                        <!-- Reviewer (required)--> 
                        <div class="mb-3">
                            <label for="reviewer" class="col-form-label">Reviewer:</label>
                            <input type="text" required class="form-control" name="reviewer">
                        </div>

                        <!-- Botton Submit-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        </div>
                        
                    </form>
                </div>            
            </div>
        </div>
    </div>

 <!-- Display Zone -->
    <!-- Build Container --> 
        <div class="container mt-5">
            <div class="row">

                <div class="col d-flex justify-content-star">
                    <h1>Content</h1>
                </div>

                <div class="col-md-auto d-flex justify-content-end align-self-center">                    
                    <a class="btn btn-secondary" href="index.php" role="button">Page</a>
                </div>

                <div class="col-md-auto d-flex justify-content-end align-self-center">
                    <!-- Set Modal Pop-up [ data-bs-target=_________ ]--> 
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contentModal" data-bs-whatever="@mdo">New Content</button>
                </div>

                

            </div>                     
                
        </div>

    <!-- แสดง Alarm Session สำหรับ DB กรณี Success -->  
        <hr>           
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']); 
                ?>
            </div>
        <?php } ?>

    <!-- แสดง Alarm Session สำหรับ DB กรณี Error -->  
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']); 
                ?>
            </div>
        <?php } ?>


    <!-- ตารางแสดงผลข้อมูล User--> 
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Topic</th>
                <th scope="col">Content</th>
                <th scope="col">Img</th>
                <th scope="col">Reviewer</th>
                </tr>
            </thead>

            <tbody>
                <!-- query ข้อมูล sql ด้วยตัวแปล conn--> 
                <?php 
                    $stmt = $conn->query("SELECT * FROM content");
                    $stmt->execute();
                    $users = $stmt->fetchAll();

                    if (!$users) {
                        //แสดงข้อความ No data available เมื่อไม่มีข้อมูล
                        echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                    } else {
                    foreach($users as $user)  {  
                ?>


                <tr>
                    <th scope="row"><?php echo $user['idcontent']; ?></th>
                    <td><?php echo $user['topic']; ?></td>                    
                    <td><textarea readonly cols="30" rows="7" ><?php echo $user['content']; ?></textarea></td>                    
                    <td width="250px"><img class="rounded" width="100%" src="img_db/<?php echo $user['img']; ?>" alt=""></td>
                    <td><?php echo $user['reviewer']; ?></td>
                    <td>
                        <!-- สร้างปุ่ม Edit--> 
                        <a href="mem_edit.php?idcontent=<?php echo $user['idcontent']; ?>" class="btn btn-warning">Edit</a>
                        <!-- สร้างปุ่ม Delete--> 
                        <a onclick="return confirm('Are you sure you want to delete?');" href="?delete=<?php echo $user['idcontent']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <!-- query ข้อมูลจาก sql DB มาแสดง--> 
                <?php }  } ?>
            </tbody>
        </table>

    


<!-- S C R I P T _ E L E M E N T -->

<!-- ก๊อป get start "javascript" จาก Boostrap5 -->   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- script สำหรับ preview ภาพก่อน submit -->  
    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file)
            }
        }

    </script>



</body>

<!--*********************************************************** -->  

</html>