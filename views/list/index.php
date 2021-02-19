
<h1 class="text-center">TODO LIST</h1>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 m-3">
        <a class="btn btn-success m-1 btn-sm" href="/list/create">CREATE TODO LIST</a>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="w-75">TODO LIST</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $index = 1;
                    foreach ($lists as $list) {
                ?>
                <tr>
                    <th scope="row"><?= $index++?></th>
                    <td>
                        <a href="/task/index?list_id=<?=$list->id?>">
                        <?=$list->name?>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger m-1 btn-sm" href="/list/delete?id=<?=$list->id?>">DELETE</a>
                        <a class="btn btn-primary m-1 btn-sm" href="/list/edit?id=<?=$list->id?>">EDIT</a>
                    </td>
                </tr>
                <?php
                    }
                ?>
                
            </tbody>
        </table>
    </div>
</div>