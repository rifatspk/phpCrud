<?php
require_once('./database.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $created_at = date('Y-m-d H:i:s');

    if ($_FILES['image']) {
        $image = $_FILES['image'];
        $tmp = explode(".", $image['name']);
        $extension = end($tmp);
        if (!is_dir('images')) {
            mkdir('images');
        }

        function randomString($n)
        {
            $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
            $ctr_lngth = strlen($characters);
            $rndString = '';
            for ($i = 0; $i < $n; $i++) {
                $rndString .= $characters[rand(0, $ctr_lngth - 1)];
            }
            return $rndString;
        }
        $filename = randomString(10) . "." . $extension;
        $imagePath = 'images/' . $filename ?? null;
        move_uploaded_file($image['tmp_name'], $imagePath);
    }


    $statement = $pdo->prepare("INSERT INTO posts (image,title,description, created_at, updated_at) VALUES (:image, :title,:description,:created_at,:updated_at)");
    $statement->bindValue(':image', $imagePath);
    $statement->bindValue(':title',  $title);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':created_at', $created_at);
    $statement->bindValue(':updated_at', $created_at);
    $statement->execute();
    header('Location:/');
}



include_once('./header.php');
?>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Post Image</label>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label>Post Title</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
                <label>Post Description</label>
                <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>


<?php include_once('./footer.php'); ?>