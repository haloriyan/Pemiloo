<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('./partials/Head', ['title' => "Polling Application"]); ?>
    <style>
        .container {
            position: absolute;
            top: 210px;left: 25%;right: 25%;
        }
    </style>
</head>
<body>
    
<div class="container bayangan-5 rounded">
    <div class="wrap">
        <?php if (@$message) : ?>
            <div class="bg-merah-transparan rounded p-2 mb-2">
                <?= $message ?>
            </div>
        <?php endif ?>
        <form action="<?= route('login') ?>" method="POST">
            <div>Please insert your token to vote :</div>
            <input type="text" class="box" name="token">
            <button class="hijau mt-2 lebar-100">Submit</button>
        </form>
    </div>
</div>

<script src="<?= base_url() ?>js/base.js"></script>

</body>
</html>