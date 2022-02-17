<?php
require_once('./database.php');

$id = $_GET['id'];

if ($id) {
    $statement = $pdo->prepare("SELECT * FROM posts WHERE id=:id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    $post = $statement->fetch(PDO::FETCH_ASSOC);
    $created_at = $post['created_at'];
    $title = $post['title'];
    $title = $post['description'];
}


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $updated_at = date('Y-m-d H:i:s');
    if ($_FILES['image']) {
        $image = $_FILES['image'];
        $tmp = explode(".", $image['name']);
        $extension = end($tmp);
        if (!is_dir('images')) {
            mkdir('images');
        }

        if ($post['image']) {
            unlink($post['image']);
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
        $imagePath = 'images/' . $filename ?? $post['image'];
        move_uploaded_file($image['tmp_name'], $imagePath);
    }


    $statement = $pdo->prepare("UPDATE posts SET image=:image,title=:title,description=:description,created_at=:created_at,updated_at=:updated_at WHERE id=:id");
    $statement->bindValue(':image', $imagePath);
    $statement->bindValue(':title',  $title);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':created_at', $created_at);
    $statement->bindValue(':updated_at', $updated_at);
    $statement->bindValue(':id', $id);
    $statement->execute();
    header('Location:/');
}



include_once('./header.php');
?>
<div class="row">
    <div class="col-md-3">
        <?php
        if ($post['image']) { ?>
            <img src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>" style="max-width: 100%;">
        <?php }
        ?>
    </div>
    <div class="col-md-6">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Post Image</label>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label>Post Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $post['title']; ?>">
            </div>
            <div class="form-group">
                <label>Post Description</label>
                <textarea name="description" class="form-control" cols="30" rows="10"><?php echo $post['description']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>


<?php include_once('./footer.php'); ?>