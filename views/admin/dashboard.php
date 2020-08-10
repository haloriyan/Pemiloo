<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../partials/Head', ['title' => "Dashboard"]); ?>
    <style>
        .card h2 { font-size: 30px; }
    </style>
</head>
<body>
    
<?= insert('../partials/Header', ['title' => "Dashboard"]); ?>

<?= insert('../partials/LeftMenu'); ?>

<div class="container">
    <div class="bagi bagi-3 card">
        <div class="wrap">
            <a href="<?= route('admin/polling') ?>">
                <div class="rounded bayangan-5 bg-hijau smallPadding">
                    <div class="wrap">
                        <h2><?= count($activePolls) ?></h2>
                        <p>Active pollings</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="bagi bagi-3 card">
        <div class="wrap">
            <a href="<?= route('admin/candidate') ?>">
                <div class="rounded bayangan-5 bg-hijau smallPadding">
                    <div class="wrap">
                        <h2><?= count($candidates) ?></h2>
                        <p>Candidates</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="bagi bagi-3 card">
        <div class="wrap">
            <a href="<?= route('admin/result') ?>">
                <div class="rounded bayangan-5 bg-hijau smallPadding">
                    <div class="wrap">
                        <h2><?= count($votes) ?></h2>
                        <p>Votes collected</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="mt-3"></div>

    <?php foreach ($activePolls as $poll) : ?>
        <div class="rounded bayangan-5 mb-4">
            <div class="bagi lebar-30 smallPadding">
                <div class="corner-top-left corner-bottom-left" style="height: 180px;" bg-image="<?= base_url(); ?>storage/cover/<?= $poll->cover ?>"></div>
            </div>
            <div class="bagi lebar-70 smallPadding">
                <div class="wrap">
                    <h3 class="lebar-100">
                        <?= $poll->title ?>
                        <span class="ke-kanan fontLight teks-transparan"><?= $poll->end_date ?></span>
                    </h3>
                    <p><?= $poll->description ?></p>
                    <div class="mt-3">
                        <a href="<?= route('admin/result&poll_id='.base64_encode($poll->id)) ?>"><span class="p-1 pl-2 pr-2 rounded pointer bg-hijau"><i class="fas fa-chart-line"></i> &nbsp; Result</span></a>
                        &nbsp;
                        <a href="<?= route('admin/candidate&poll_id='.base64_encode($poll->id)) ?>"><span class="p-1 pl-2 pr-2 rounded pointer bg-biru"><i class="fas fa-users"></i> &nbsp; Candidates</span></a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<script src="<?= base_url(); ?>/js/base.js"></script>
<script src="<?= base_url(); ?>/js/dashboard.js"></script>

</body>
</html>