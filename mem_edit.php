<!-- DATABASE CONNECTION -->
<?php 
    session_start();
    require_once "config/content_db.php";

    // กระบวกการ การ Update ไฟล์
    if (isset($_POST['update'])) {
        $idcontent = $_POST['idcontent'];
        $topic = $_POST['topic'];
        $content = $_POST['content'];
        $reviewer = $_POST['reviewer'];
        $img = $_FILES['img'];    
        $img2 = $_POST['img2'];
        $img_db = $_FILES['img']['name'];

        if ($img_db != '') {
            //จำกัดประเภทไฟล์ img ที่อัพโหลดได้ 
            $allow = array('jpg', 'jpeg', 'png');
            //กำหนดชื่อไฟล์ img ใหม่ แบบ randon number
            $extension = explode('.', $img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            //กำหนด Folder จัดเก็บข้อมูล
            $filePath = 'img_db/'.$fileNew;

            if (in_array($fileActExt, $allow)) {
                //กรณีที่ต้องการ Update รูปภาพใหม่
                if ($img['size'] > 0 && $img['error'] == 0) {
                    move_uploaded_file($img['tmp_name'], $filePath);
                }
            }

        } else {
            //กรณีที่ต้องการใช้รูปภาพเดิม
            $fileNew = $img2;
        }    
           

            //update sql ด้วยตัวแปล conn
            $sql = $conn->prepare("UPDATE content SET topic = :topic, content = :content, reviewer = :reviewer, img = :img WHERE idcontent = :idcontent");
            $sql->bindParam(":idcontent", $idcontent);
            $sql->bindParam(":topic", $topic);
            $sql->bindParam(":content", $content);
            $sql->bindParam(":reviewer", $reviewer);
            $sql->bindParam(":img", $fileNew);
            $sql->execute();
        if ($sql) {
            //เก็บ Seesion [บันทึกสำเร็จ] Data has been inserted successfully
            $_SESSION['success'] = "Data has been updated successfully";
            header("location: mem_page.php");
        } else {
            //เก็บ Seesion [บันทึกไม่สำเร็จ] Data has not been updated successfully
            $_SESSION['error'] = "Data has not been updated successfully";
            header("location: mem_page.php");
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
            <!-- กำหนด max size ของ contrainer -->  
            <style>
                .container {
                    max-width: 770px;
                }
            </style>
        </head>
        <!--*********************************************************** -->  
        <body>

 <!-- Display Zone -->
    <!-- Build Container --> 
        <div class="container mt-5">
            <h1>Edit Data</h1>
            <hr>  

            <!-- ส่วนของแบบ Form -->  
            <form action="mem_edit.php" method="post" enctype="multipart/form-data">

                <!-- ตรวจสอบ id ตัวที่จะ edit -->   
                <?php
                    if (isset($_GET['idcontent'])) {
                        $idcontent = $_GET['idcontent'];
                        $stmt = $conn->query("SELECT * FROM content WHERE idcontent = $idcontent");
                        $stmt->execute();
                        $data = $stmt->fetch();
                    }
                ?>

                <!-- เพิ่มข้อมูล Topic (บังคับใส่ข้อมูล required)-->  
                <div class="mb-3">
                    <!-- ระบุ id ข้อมูลที่ต้องการแก้ไข--> 
                    <label for="idcontent" class="col-form-label">Content ID:</label>
                    <input type="text" readonly value="<?php echo $data['idcontent']; ?>" required class="form-control" name="idcontent" >
                    <!-- Topic Edit-->  
                    <label for="topice" class="col-form-label">Topic:</label>
                    <input type="text" value="<?php echo $data['topic']; ?>" required class="form-control" name="topic">
                    <input type="hidden" value="<?php echo $data['img']; ?>" required class="form-control" name="img2" >
                </div>

                <!-- Content (required)--> 
                <div class="mb-3">
                    <label for="content" class="col-form-label">Content:</label>
                    <textarea required class="form-control" name="content" style = "height: 144px;"><?php echo $data['content']; ?></textarea>                    
                </div>
                    
                <!-- Image (required)-->
                <!-- Noted** Set id name for preview Image --> 
                <div class="mb-3">
                    <label for="img" class="col-form-label">Image:</label>
                    <input type="file" class="form-control" idcontent="imgInput" name="img">
                    <img loading="lazy" width="100%" src="img_db/<?php echo $data['img']; ?>" idcontent="previewImg" alt="">
                </div>

                <!-- Reviewer (required)--> 
                <div class="mb-3">
                    <label for="reviewer" class="col-form-label">Reviewer:</label>
                    <input type="text" readonly value="<?php echo $data['reviewer']; ?>" required class="form-control" name="reviewer">
                </div>

                <!-- เพิ่มปุ่ม Update-->
                <hr>
                <div class="modal-footer">
                    <a class="btn btn-secondary" href="mem_page.php">Go Back</a>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </div>
                        
            </form>      

        </div> 


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
