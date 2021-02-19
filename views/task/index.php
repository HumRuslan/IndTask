<h1 class="text-center"><?=$list->name?></h1>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 m-3">
        <a class="btn btn-success m-1 btn-sm" href="/task/create?list_id=<?=$list->id?>">CREATE TASK</a>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="">TASK</th>
                    <th scope="col" class="">POSITION</th>
                    <th scope="col" class="">DATE STARTED</th>
                    <th scope="col" class="">COMPLETED</th>
                    <th scope="col" class="">DATE COMPLETED</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                <?php
                    $index = 1;
                    foreach ($tasks as $task) {
                ?>
                <tr>
                    <th scope="row"><?= $index++?></th>
                    <td>
                        <?=$task->name?>
                    </td>
                    <td class="text-center">
                        <?=$task->position?>
                    </td>
                    <td>
                        <?=$task->created_at?>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" <?= ($task->completed) ? 'checked' : ''?> id="completed<?=$task->id?>" value=<?=$task->id?> class="completed">
                    </td>
                    <td id="completed_at<?=$task->id?>">
                        <?= ($task->completed) ? $task->completed_at : ''?>
                    </td>
                    <td>
                        <a class="btn btn-danger m-1 btn-sm" href="/task/delete?id=<?=$task->id?>">DELETE</a>
                        <a class="btn btn-primary m-1 btn-sm" href="/task/edit?id=<?=$task->id?>">EDIT</a>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(".completed").change(function() {
        var completed;
        var attr = $(this).attr('checked');
        if (typeof attr !== typeof undefined && attr !== false) {
            $(this).removeAttr('checked');
            completed = false;
        } else {
            $(this).attr('checked', 'checked');
            completed = true;
        }
        $.post('/task/completed', {
            id: $(this).val(),
            completed: completed
        },
        function(data) {
            response = JSON.parse(data);
            if (response.status == "success") {
                $(`#completed_at${response.data.id}`).html(response.data.completed_at);
            } else {
                attr = $(this).attr('checked');
                if (typeof attr !== typeof undefined && attr !== false) {
                    $(this).removeAttr('checked');
                    completed = false;
                } else {
                    $(this).attr('checked', 'checked');
                    completed = true;
                }
            }
        })
    })
</script>
