<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../../partials/Head', ['title' => "Editing ".$candidate->name]); ?>
</head>
<body>
    
<?= insert('../../partials/Header', ['title' => "Editing ".$candidate->name]); ?>

<?= insert('../../partials/LeftMenu'); ?>

<div class="container">
    <form action="<?= route('admin/candidate/'.$candidate->id.'/update') ?>" method="POST" enctype="multipart/form-data">
        <div>Candidate name :</div>
        <input type="text" class="box" name="name" required value="<?= $candidate->name ?>" />
        <div class="mt-2">Photo :</div>
        <input type="file" class="box" name="photo" />
        (leave it blank if you don't want to change photo)

        <div class="mt-2">Short bio :</div>
        <textarea name="bio" class="box" required><?= $candidate->bio ?></textarea>

        <div class="mt-2">Label Color :</div>
        <input type="color" class="box lebar-20" name="label_color" value="<?= $candidate->label_color ?>" />
        <br />
        
        <div class="bagi bagi-2">
            <div class="wrap">
                <button type="button" class="lebar-100 mt-2" onclick="window.history.back(-1)">batal</button>
            </div>
        </div>
        <div class="bagi bagi-2">
            <div class="wrap">
                <button class="hijau lebar-100 mt-2">Update</button>
            </div>
        </div>
    </form>
</div>

<script src="<?= base_url(); ?>js/base.js"></script>
<script src="<?= base_url(); ?>js/dashboard.js"></script>

</body>
</html>