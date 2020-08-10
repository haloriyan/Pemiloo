<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../../partials/Head', ['title' => "Create Polling"]); ?>
</head>
<body>
    
<?= insert('../../partials/Header', ['title' => "Create Polling"]); ?>

<?= insert('../../partials/LeftMenu'); ?>

<div class="container">
    <form action="<?= route('admin/polling/store') ?>" method="POST" enctype="multipart/form-data">
        <div>Polling name :</div>
        <input type="text" class="box" name="title" required />
        <div class="mt-2">Cover image :</div>
        <input type="file" name="cover" class="box" required />
        <div class="mt-2">Describe about this polling :</div>
        <textarea name="description" required class="box"></textarea>
        <div class="mt-2">End date :</div>
        <input type="date" name="end_date" class="box" required />

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