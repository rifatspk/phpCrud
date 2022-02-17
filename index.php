<?php
require_once('./database.php');
$statement = $pdo->prepare("SELECT*FROM posts ORDER BY created_at DESC");
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
include_once('./header.php');
?>
<a href="create.php" class="btn btn-primary my-3">Create New Post</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Post Image</th>
            <th>Title</th>
            <th>Description</th>
            <th>Created Time</th>
            <th>Updated Time</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $key => $post) : ?>
            <tr>
                <th><?php echo $key + 1; ?></th>
                <th> <img src="<?php echo $post['image'] ?>" alt="<?php echo $post['title']; ?>" style="max-width: 100px;"> </th>
                <td><?php echo $post['title']; ?></td>
                <td><?php echo $post['description']; ?></td>
                <td><?php echo $post['created_at']; ?></td>
                <td><?php echo $post['updated_at']; ?></td>
                <td>
                    <a href="update.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-secondary">Edit</a>
                    <form action="delete.php" method="post" style="display: inline-block;">
                        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include_once('./footer.php'); ?>