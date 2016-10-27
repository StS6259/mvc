<?php use core\auth\Auth;

require __DIR__.'/../blocks/header.php'?>
<div class="container">
    <h1>
        POSTS
        <?php if (Auth::check()) :?>
            <a class="btn btn-default pull-right" href="<?php echo route('post/create')?>">Create</a>
        <?php endif?>
    </h1>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Content</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($posts as $post) :?>
            <tr>
                <td><?php echo $post->result['title']?></td>
                <td><?php echo $post->result['content']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__.'/../blocks/footer.php'?>