<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../partials/Head', ['title' => "Polling"]); ?>
    <style>
        .cover {
            border-top-left-radius: 6px;
            border-block-start-width: 6px;
        }
        @media (max-width: 480px) {
            .cover {
                border-radius: 0px;
                border-top-left-radius: 6px;
                border-top-right-radius: 6px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    
<?= insert('../partials/Header', ['title' => "Polling"]) ?>

<?= insert('../partials/LeftMenu'); ?>

<div class="container">
    
    <?php if (@$message != "") : ?>
        <div class="bg-hijau-transparan rounded p-2 mb-3">
            <?= $message ?>
        </div>
    <?php endif ?>
    <?php if (count($pollings) == 0) : ?>
        <h3>No data found</h3>
    <?php else : ?>
        <?php foreach ($pollings as $poll) : ?>
            <div class="rounded bayangan-5 mb-4">
                <div class="bagi lebar-30 smallPadding">
                    <div class="cover" style="height: 180px;" bg-image="<?= base_url(); ?>storage/cover/<?= $poll->cover ?>"></div>
                </div>
                <div class="bagi lebar-70 smallPadding">
                    <div class="wrap">
                        <h3 class="lebar-100">
                            <?= $poll->title ?>
                            <span class="ke-kanan fontLight teks-transparan"><?= $poll->end_date ?></span>
                        </h3>
                        <p><?= $poll->description ?></p>
                        <div class="mt-3">
                            <a href="<?= route('admin/polling/'.$poll->id.'/edit') ?>"><span class="p-1 pl-2 pr-2 rounded pointer bg-hijau">Edit</span></a>
                            &nbsp;
                            <a href="<?= route('admin/result&poll_id='.base64_encode($poll->id)) ?>"><span class="p-1 pl-2 pr-2 rounded pointer bg-biru">Result</span></a>
                            &nbsp;
                            <a href="<?= route('admin/polling/'.$poll->id.'/delete') ?>"><span class="p-1 pl-2 pr-2 rounded pointer bg-merah">Delete</span></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>

<a href="<?= route('admin/polling/create') ?>">
    <div class="createBtn"><i class="fas fa-plus"></i></div>
</a>

<script src="<?= base_url(); ?>/js/base.js"></script>
<script src="<?= base_url(); ?>/js/dashboard.js"></script>

</body>
</html>