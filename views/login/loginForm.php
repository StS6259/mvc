<?php require __DIR__.'/../blocks/header.php'?>

<div class="container">
    <form action="<?php echo route('login/login')?>" method="post">
        <div class="form-group">
            <label for="nickname">Nickname</label>
            <input name="nickname" type="text" class="form-control" id="nickname" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-default">Login</button>
    </form>
</div>
<?php require __DIR__.'/../blocks/footer.php'?>
