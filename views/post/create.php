<?php require __DIR__ . '/../blocks/header.php' ?>
<div class="container">
    <form class="form-horizontal" action="<?php echo route('post/store')?>" method="post">
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label">Title</label>
            <div class="col-sm-10">
                <input name="title" type="text" class="form-control" id="title" placeholder="title">
            </div>
        </div>
        <div class="form-group">
            <label for="content" class="col-sm-2 control-label">Content</label>
            <div class="col-sm-10">
                <textarea name="content" class="form-control" id="content">
                </textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
    </form>
</div>
<?php require __DIR__ . '/../blocks/footer.php' ?>
