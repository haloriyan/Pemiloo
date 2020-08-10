<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('../partials/Head', ['title' => "People who vote for ".$candidate->name]); ?>
    <style>
        .photo {
            height: 200px;
        }
        .candidates li {
            line-height: 30px;
            list-style: none;
        }
        .candidates li b { font-family: ProBold; }
    </style>
</head>
<body>
    
<?= insert('../partials/Header', ['title' => "People who vote for ".$candidate->name]) ?>

<?= insert('../partials/LeftMenu'); ?>

<div class="container">
    
    <?php if (@$message != "") : ?>
        <div class="bg-hijau-transparan rounded p-2 mb-3">
            <?= $message ?>
        </div>
    <?php endif ?>

    <?php if (count($votes) == 0) : ?>
        <h3>No data found</h3>
    <?php else : ?>
        <table>
            <thead>
                <tr>
                    <th class="lebar-5 rata-tengah">No</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($votes as $vote) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $vote->voter->name ?></td>
                        <td><?= $vote->voter->email ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
    
    <input type="hidden" class="box" id="currentUrl" value="<?= route('admin/result') ?>">
</div>

<script src="<?= base_url(); ?>js/Chart.js/dist/Chart.min.js"></script>
<script src="<?= base_url(); ?>js/base.js"></script>
<script src="<?= base_url(); ?>js/dashboard.js"></script>
<script>
    const containParams = url => {
        let u = url.split("&")
        return u[1] != "" ? true : false
    }
    const choosePoll = id => {
        let currentUrl = select("#currentUrl").value
        if (containParams) {
            window.location = currentUrl + "&poll_id=" + btoa(id)
        }
    }
</script>

</body>
</html>