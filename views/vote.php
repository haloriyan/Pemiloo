<!DOCTYPE html>
<html lang="en">
<head>
    <?= insert('./partials/Head', ['title' => "Give your Vote"]); ?>
    <style>
        .container {
            position: absolute;
            top: 50px;left: 30%;right: 30%;
        }
        .cover {height: 250px; }
        .photo { height: 220px; }
        .detail {
            position: relative;
            filter: blur(0px);
            height: 250px;
            background-color: #00000040;
            color: #fff;
            margin-top: -250px;
            box-sizing: border-box;
        }
        .detail h1 { margin: 0; }
        .detail .content {
            position: absolute;
            bottom: 30px;left: 5%;right: 5%;
        }
        .candidates.selected {
            border: 4px solid #2ecc71;
        }
        @media (max-width: 480px) {
            .container {
                top: 0px;left: 0px;right: 0px;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    
<div class="container bayangan-5 corner-top-left corner-top-right">
    <div class="cover corner-top-left corner-top-right" bg-image="<?= base_url().'storage/cover/'.$polling->cover ?>"></div>
    <div class="detail corner-top-left corner-top-right">
        <div class="content">
            <h1><?= $polling->title ?></h1>
            <p><?= $polling->description ?></p>
        </div>
    </div>
    <div class="wrap">
        <?php foreach ($candidates as $candidate) : ?>
            <div class="bagi bagi-2 pointer">
                <div class="wrap">
                    <div class="bayangan-5 rounded candidates" onclick="choose(this)" candidate-id="<?= $candidate->id ?>">
                        <div class="photo corner-top-left corner-top-right" bg-image="<?= base_url().'storage/photo/'.$candidate->photo ?>"></div>
                        <div class="smallPadding">
                            <div class="wrap">
                                <h3><?= $candidate->name ?></h3>
                                <p><?= $candidate->bio ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <div class="bg-merah-transparan p-2 rounded mt-2 d-none" id="notif">
            <div class="d-inline-block" id="message"></div>
            <div class="ke-kanan" onclick="closeNotif()"><i class="fas fa-times"></i></div>
        </div>

        <input type="hidden" id="polling_id" value="<?= $polling->id ?>">
        <input type="hidden" id="voter_id" value="<?= $myData['id'] ?>">
        <?php if ($hasVote == 0) : ?>
            <button onclick="vote(this)" class="hijau lebar-100 mt-3 rounded-circle">VOTE</button>
        <?php else : ?>
            <p class="rata-tengah mt-3">
                You have already voted to this poll. <a href="<?= route('result') ?>">See result</a>
            </p>
        <?php endif ?>
    </div>
</div>

<script src="<?= base_url().'js/base.js' ?>"></script>
<script>
    let selectedCandidateId = 0
    const notif = msg => {
        select("#notif").classList.remove('d-none')
        select("#notif #message").innerHTML = msg
    }
    const closeNotif = () => {
        select("#notif").classList.add('d-none')
    }
    const choose = that => {
        selectAll(".candidates").forEach(candidate => {
            candidate.classList.remove('selected')
        })
        that.classList.remove('bagi-4')
        that.classList.add('selected', 'lebar-100')
        selectedCandidateId = that.getAttribute('candidate-id')
    }
    const vote = btn => {
        let voter_id = select("#voter_id").value
        let polling_id = select("#polling_id").value

        let formData = new FormData()
        formData.append('candidate_id', selectedCandidateId)
        formData.append('voter_id', voter_id)
        formData.append('polling_id', polling_id)

        if (selectedCandidateId == 0) {
            notif("You have not selected anyone yet")
            return false
        }
        btn.innerHTML = "<i class='fas fa-spinner'></i> &nbsp; loading..."
        let req = fetch('<?= route("doVote") ?>', {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(res => {
            btn.innerHTML = "<i class='fas fa-check'></i> &nbsp; Sucess! redirecting..."
            window.location = "<?= route('result') ?>"
        })
    }
</script>

</body>
</html>