<!-- DATABASE CONNECTION -->
<?php 
    session_start();
    require_once "config/content_db.php";

    if (isset($_POST['submit'])) {
        $topic = $_POST['topic'];
        $content = $_POST['content'];
        $reviewer = $_POST['reviewer'];
        $img = $_FILES['img'];

            //จำกัดประเภทไฟล์ img ที่อัพโหลดได้ 
            $allow = array('jpg', 'jpeg', 'png');
            //กำหนดชื่อไฟล์ img ใหม่ แบบ randon number
            $extension = explode('.', $img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            //กำหนด Folder จัดเก็บข้อมูล
            $filePath = 'img_db/'.$fileNew;


            //ตรวจสอบประเภทไฟล์ img ที่อัพโหลดได้            
            if (in_array($fileActExt, $allow)) {
                //ตรวจสอบขนาดไฟล์ img size ไม่ 0 ไม่ error
                if ($img['size'] > 0 && $img['error'] == 0) {
                    //อัพโหลดไฟล์ที่ Submit
                    if (move_uploaded_file($img['tmp_name'], $filePath)) {
                        //insert sql แบบ block injection ด้วยตัวแปล conn
                        $sql = $conn->prepare("INSERT INTO content(topic, content, reviewer, img) VALUES(:topic, :content, :reviewer, :img)");
                        $sql->bindParam(":topic", $topic);
                        $sql->bindParam(":content", $content);
                        $sql->bindParam(":reviewer", $reviewer);
                        $sql->bindParam(":img", $fileNew);
                        $sql->execute();

                        if ($sql) {
                            //เก็บ Seesion [บันทึกสำเร็จ] Data has been inserted successfully
                            $_SESSION['success'] = "Enjoy :) This content has been posted";
                            header("location: mem_page.php");
                        } else {
                            //เก็บ Seesion [บันทึกไม่สำเร็จ] Data has not been updated successfully
                            $_SESSION['error'] = "Sorry :( This content has not been posted";
                            header("location: mem_page.php");
                        }
                    }
                }
            }


    }
?>