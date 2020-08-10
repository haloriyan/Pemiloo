<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../partials/Head', ['title' => "Candidates"]); ?>
</head>
<body>
    
<?= insert('../partials/Header', ['title' => "Candidates"]) ?>

<?= insert('../partials/LeftMenu'); ?>

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
    <?php if (@$poll_id == "") : ?>
        <h3>Select poll first</h3>
    <?php elseif (count($candidates) == 0) : ?>
        <h3>No data found</h3>
    <?php else : ?>
        <?php foreach ($candidates as $candidate) : ?>
            <div class="bagi bagi-3">
                <div class="wrap">
                    <div class="rounded bayangan-5">
                        <div
                            class="photo tinggi-250 corner-top-left corner-top-right"
                            bg-image="<?= base_url().'storage/photo/'.$candidate->photo; ?> "
                        ></div>
                        <div class="smallPadding">
                            <div class="wrap">
                                <h3><?= $candidate->name ?></h3>
                                <p><?= $candidate->bio ?></p>
                                <div class="bagi bagi-3">
                                    <div class="wrap">
                                        <a href="<?= route('admin/candidate/'.$candidate->id.'/edit') ?>">
                                            <button class="hijau lebar-100 p-0 tinggi-40"><i class="fas fa-edit"></i></button>
                                        </a>
                                    </div>
                                </div>
                                <div class="bagi bagi-3">
                                    <div class="wrap">
                                        <a href="<?= route('admin/candidate/'.$candidate->id.'/delete') ?>">
                                            <button class="merah lebar-100 p-0 tinggi-40"><i class="fas fa-trash"></i></button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
    <input type="hidden" class="box" id="currentUrl" value="<?= route('admin/candidate') ?>">
</div>

<?php if (@$poll_id != "") : ?>
    <a href="<?= route('admin/candidate/'.@$poll_id.'/create') ?>">
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