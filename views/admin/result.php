<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $title = @$_GET['poll_id'] != "" ? "Result for ".$pollings[0]->title : "Polling Results";
    ?>
    <?= insert('../partials/Head', ['title' => $title]); ?>
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
    
<?= insert('../partials/Header', ['title' => $title]) ?>

<?= insert('../partials/LeftMenu'); ?>

<div class="container">
    
    <?php if (@$message != "") : ?>
        <div class="bg-hijau-transparan rounded p-2 mb-3">
            <?= $message ?>
        </div>
    <?php endif ?>
    <select onchange="choosePoll(this.value)" class="box lebar-100 mb-3">
        <option value="">Select poll..</option>
        <?php foreach ($pollings as $poll) : ?>
            <?php $selected = @$poll_id == $poll->id ? "selected='selected'" : "" ?>
            <option <?= $selected ?> value="<?= $poll->id ?>"><?= $poll->title ?></option>
        <?php endforeach ?>
    </select>
    <?php if (@$poll_id == "") : ?>
        <h3>Select poll first</h3>
    <?php else : ?>
        <div class="mb-3">
            <div class="bagi bagi-2">
                <div class="wrap">
                    <div class="bayangan-5 rounded smallPadding">
                        <div class="wrap">
                            <h2>Votes Collected</h2>
                            <canvas id="dataCollectedCanvas" class="lebar-100 mb-3"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bagi bagi-2">
                <div class="wrap">
                    <div class="bayangan-5 rounded smallPadding">
                        <div class="wrap">
                            <h2>Votes Summary</h2>
                            <canvas id="resultVote" class="lebar-100 mb-3"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <input type="hidden" id="totalData" value="<?= $votes['totalData'] ?>" />
            <input type="hidden" id="notVotedYet" value="<?= $notVotedYet ?>" />
            <?php foreach ($candidates as $candidate) : ?>
                <div class="bagi bagi-3 candidates">
                    <div class="wrap">
                        <div class="bayangan-5 rounded smallPadding">
                            <div class="photo corner-top-left corner-top-right" bg-image="<?= base_url() ?>storage/photo/<?= $candidate->photo ?>"></div>
                            <div class="wrap">
                                <h3><?= $candidate->name ?></h3>
                                <li>Total Votes : <?= $votes[$candidate->id]['count'] ?> <b>(<?= $votes[$candidate->id]['percentage'] ?>%)</b></li>
                                <a href="<?= route('admin/result/'.$candidate->id) ?>">
                                    <button class="hijau lebar-100 p-0 tinggi-40 mt-2">See who vote this</button>
                                </a>
                                <input type="hidden" class="percentage" label-color="<?= $candidate->label_color ?>" candidate-name="<?= $candidate->name ?>" value="<?= $votes[$candidate->id]['percentage'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <input type="hidden" class="box" id="currentUrl" value="<?= route('admin/result') ?>">
</div>

<script src="<?= base_url(); ?>js/Chart.js/dist/Chart.min.js"></script>
<script src="<?= base_url(); ?>js/base.js"></script>
<script src="<?= base_url(); ?>js/dashboard.js"></script>
<script>
    let data = {
        candidateNames: [],
        percentageData: [],
        colors: []
    }
    selectAll(".percentage").forEach(percent => {
        let candidateName = percent.getAttribute('candidate-name')
        let labelColor = percent.getAttribute('label-color')
        data['candidateNames'].push(candidateName)
        data['percentageData'].push(percent.value)
        data['colors'].push(labelColor)
    })
    let ctx = select("#resultVote")
    let dataCollectedCanvas = select("#dataCollectedCanvas")
    if (ctx !== null) {
        let chart = new Chart(ctx.getContext('2d'), {
            type: 'pie',
            data: {
                datasets: [{
                    data: data.percentageData,
                    backgroundColor: data.colors
                }],
                labels: data.candidateNames
            }
        })
    }
    if (dataCollectedCanvas !== null) {
        let totalData = select("#totalData").value
        let notVotedYet = select("#notVotedYet").value
        let collectedData = new Chart(dataCollectedCanvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [totalData, notVotedYet],
                    backgroundColor: ['#2980b9', '#3498db']
                }],
                labels: ['Voted', 'Have not voted yet']
            }
        })
    }
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