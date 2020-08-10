<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../../partials/Head', ['title' => "Edit Polling"]); ?>
</head>
<body>
    
<?= insert('../../partials/Header', ['title' => "Edit Polling"]); ?>

<?= insert('../../partials/LeftMenu'); ?>

<div class="container">
    <form action="<?= route('admin/polling/'.$poll->id.'/update') ?>" method="POST" enctype="multipart/form-data">
        <div>Polling name :</div>
        <input type="text" class="box" name="title" value="<?= $poll->title ?>" required />
        <div class="mt-2">Cover image :</div>
        <input type="file" name="cover" class="box" />
        <div class="mt-1 teks-transparan">(let it empty if you don't want to change cover)</div>
        <div class="mt-2">Describe about this polling :</div>
        <textarea name="description" class="box"><?= $poll->description ?></textarea>
        <div class="mt-2">End date :</div>
        <input type="date" name="end_date" class="box" value="<?= $poll->end_date ?>" required />

        <div class="bagi bagi-2">
            <div class="wrap">
                <button class="lebar-100 mt-2">batal</button>
            </div>
        </div>
        <div class="bagi bagi-2">
            <div class="wrap">
                <button class="hijau lebar-100 mt-2">Ubah</button>
            </div>
        </div>
    </form>
</div>

<script src="<?= base_url(); ?>/js/base.js"></script>
<script src="<?= base_url(); ?>/js/dashboard.js"></script>

</body>
</html>