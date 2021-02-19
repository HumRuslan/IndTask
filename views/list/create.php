<div class="m-5 w-50 mx-auto">
    <h3 class="text-center">ADD TODO LIST</h3>

    <form method="POST">

    <div class="form-group">
        <label for="name">TODO LIST NAME</label>
        <input type="text" class="form-control" id="name" placeholder="TODO LIST NAME" name="name" value="<?=$model->name?>">
    </div>

    <button type="submit" class="btn w-100 btn-secondary">SAVE</button>
    </form>
</div>
