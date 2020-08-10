<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../partials/Head', ['title' => "Voters"]); ?>
</head>
<body>
    
<?= insert('../partials/Header', ['title' => "Voters"]) ?>

<?= insert('../partials/LeftMenu', ['title' => "Voters"]); ?>

<div class="container">
    <?php if (@$message != "") : ?>
        <div class="bg-hijau-transparan rounded p-2 mb-3">
            <?= $message ?>
        </div>
    <?php endif ?>
    <select onchange="choosePoll(this.value)" class="box lebar-100 mb-3">
        <option value="">Select poll..</option>
        <?php foreach ($pollings as $poll) : ?>
            <?php $selected = @$poll_id == $poll->id ? "selected='selected'" : "" ?>
            <option <?= $selected ?> value="<?= $poll->id ?>"><?= $poll->title ?></option>
        <?php endforeach ?>
    </select>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th style="width: 20%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($voters as $voter) : ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $voter->name ?></td>
                    <td><?= $voter->email ?></td>
                    <td>
                        <a href="<?= route('admin/voter/'.$voter->id.'/edit') ?>">
                            <span class="bg-hijau p-1 pl-2 pr-2 rounded"><i class="fas fa-edit"></i></span>
                        </a>
                        <a href="#">
                            <span class="bg-merah p-1 pl-2 pr-2 rounded"><i class="fas fa-trash"></i></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <input type="hidden" class="box" id="currentUrl" value="<?= route('admin/voter') ?>">
</div>

<?php if (@$poll_id != "") : ?>
    <a href="<?= route('admin/voter/'.@$poll_id.'/create') ?>">
        <div class="createBtn"><i class="fas fa-plus"></i></div>
    </a>
<?php endif ?>

<script src="<?= base_url(); ?>/js/base.js"></script>
<script src="<?= base_url(); ?>/js/dashboard.js"></script>
<script>
    const containParams = url => {
        let u = url.split("&")
        return u[1] != "" ? true : false
    }
    const choosePoll = id => {
        let currentUrl = select("#currentUrl").value
        if (containParams) {
            window.location = currentUrl + "&poll_id=" + btoa(id)
        }
    }
</script>

</body>
</html>