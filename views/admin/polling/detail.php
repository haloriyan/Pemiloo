<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../../partials/Head', ['title' => $poll->title]); ?>
</head>
<body>
    
<?= insert('../../partials/Header', ['title' => $poll->title]); ?>

<?= insert('../../partials/LeftMenu'); ?>

<div class="container">
    <div class="rounded bayangan-5">
        <div class="bagi lebar-30">
            hshs
        </div>
        <div class="bagi lebar-70 smallPadding">
            <div class="wrap">
                <h3><?= $poll->title ?></h3>
                <p><?= $poll->description ?></p>
                <!-- <button class="hijau">Edit</button> -->
                <div class="mt-3">
                    <span class="p-1 pl-2 pr-2 rounded pointer bg-hijau">Edit</span>
                    <span class="p-1 pl-2 pr-2 rounded pointer bg-merah">Delete</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>/js/base.js"></script>
<script src="<?= base_url(); ?>/js/dashboard.js"></script>

</body>
</html>