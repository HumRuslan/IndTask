<div class="m-5 w-50 mx-auto">
    <h3 class="text-center">EDIT TODO TASK</h3>

    <form method="POST">
        <input type="text" class="form-control" name="list_id" value="<?=$model->list_id?>" hidden>
        <div class="form-group">
            <label for="name">TODO TASK NAME</label>
            <input type="text" class="form-control" placeholder="TODO LIST NAME" name="name" value="<?=$model->name?>">
        </div>
        <div class="form-group">   
            <label for="name">POSITION</label>
            <input type="number" class="form-control" min="1" step="1" name="position" value="<?=$model->position?>">
        </div>
            <?php
                if ($model->created_at) {
            ?>
        <div class="form-check">
            <input type="checkbox" id="completed" val="" class="form-check-input" name="completed" <?=($model->completed) ? 'checked' : ''?>>
            <label class="form-check-label" for="completed" >COMPLETED</label>
        </div>    
            <?php
                }
            ?>
        <button type="submit" class="btn w-100 btn-secondary">SAVE</button>
    </form>
</div>
