<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Pemiloo</title>
    <link rel="stylesheet" href="<?= base_url(); ?>css/style.css">
    <link rel="stylesheet" href="<?= base_url(); ?>fa/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/auth.css">
</head>
<body>
    
<div class="container bg-putih bayangan-5 smallPadding">
    <div class="wrap">
        <div class="rata-tengah">
            <div class="icon d-none">
                <i class="fas fa-lock"></i>
            </div>
            <? if (@$message != "") : ?>
                <div class="bg-merah-transparan rounded p-2 mb-3">
                    <?= $message; ?>
                </div>
            <? endif; ?>
            <h2>Login Admin</h2>
            <form action="<?= route('admin/loginAction') ?>" class="rata-kiri mt-5" method="POST">
                <div>Email :</div>
                <input type="email" required class="box" name="email" />
                <div class="mt-2">Password :</div>
                <input type="password" class="box" required name="password" />

                <button class="hijau lebar-100 mt-3">Login</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>