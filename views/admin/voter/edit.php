<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../../partials/Head', ['title' => "Edit Voter"]); ?>
</head>
<body>
    
<?= insert('../../partials/Header', ['title' => "Edit Voter"]); ?>

<?= insert('../../partials/LeftMenu'); ?>

<div class="container">
    <form action="<?= route('admin/voter/'.$voter->id.'/update') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="polling_id" value="<?= $voter->polling_id ?>" />
        <div>Name :</div>
        <input type="text" class="box" name="name" required value="<?= $voter->name ?>">
        <div class="mt-2">Email :</div>
        <input type="email" class="box" name="email" required value="<?= $voter->email ?>">

        <div class="bagi bagi-2">
            <div class="wrap">
                <button type="button" class="lebar-100 mt-2" onclick="window.history.back(-1)">batal</button>
            </div>
        </div>
        <div class="bagi bagi-2">
            <div class="wrap">
                <button class="hijau lebar-100 mt-2">Create</button>
            </div>
        </div>
    </form>
</div>

<script src="<?= base_url(); ?>/js/base.js"></script>
<script src="<?= base_url(); ?>/js/dashboard.js"></script>

</body>
</html>