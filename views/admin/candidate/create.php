<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../../partials/Head', ['title' => "Add Candidate to ".$polling->title]); ?>
</head>
<body>
    
<?= insert('../../partials/Header', ['title' => "Add Candidate to ".$polling->title]); ?>

<?= insert('../../partials/LeftMenu'); ?>

<div class="container">
    <form action="<?= route('admin/candidate/store') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="polling_id" value="<?= $polling->id ?>">
        <div>Candidate name :</div>
        <input type="text" class="box" name="name" required />
        <div class="mt-2">Photo :</div>
        <input type="file" class="box" name="photo" required />
        <div class="mt-2">Short bio :</div>
        <textarea name="bio" class="box" required></textarea>
        
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