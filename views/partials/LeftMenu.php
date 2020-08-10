<div class="LeftMenu">
    <div class="profile rata-tengah">
        <div class="img" bg-image="<?= base_url(); ?>storage/profile_picture/prof.jpg"></div>
        <h3><?= $myData['name'] ?></h3>
        <a href="<?= route('admin/logout') ?>"><i class="fas fa-sign-out-alt"></i></a>
    </div>
    <div class="menus">
        <a href="<?= route('admin/dashboard') ?>"><li><div class="icon"><i class="fas fa-home"></i></div> Dashboard</li></a>
        <a href="<?= route('admin/polling') ?>"><li><div class="icon"><i class="fas fa-poll"></i></div> Polling</li></a>
        <a href="<?= route('admin/candidate') ?>"><li><div class="icon"><i class="fas fa-users"></i></div> Candidates</li></a>
        <a href="<?= route('admin/voter') ?>"><li><div class="icon"><i class="fas fa-users"></i></div> Voters</li></a>
        <a href="<?= route('admin/result') ?>"><li><div class="icon"><i class="fas fa-chart-line"></i></div> Results</li></a>
    </div>
</div>