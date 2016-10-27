<?php require __DIR__.'/../blocks/header.php'?>

<div class="container">
    <form action="<?php echo route('register/register')?>" method="post">
        <div class="form-group">
            <label for="nickname">Nickname</label>
            <input name="nickname" type="text" class="form-control" id="nickname" placeholder="nick">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input name="email" type="email" class="form-control" id="email" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="repeat_password">Repeat password</label>
            <input name="repeat_password" type="password" class="form-control" id="repeat_password" placeholder="Repeat password">
        </div>
        <button type="submit" class="btn btn-default">Register</button>
    </form>
</div>
<?php require __DIR__.'/../blocks/footer.php'?>
