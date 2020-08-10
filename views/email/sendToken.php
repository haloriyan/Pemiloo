<div style="font-family: sans-serif;background-color: #ecf0f1;padding: 30px;">
    <div style="width: 60%;margin-left: 20%;">
        <h1>Your Token is Here</h1>
        <div style="padding: 20px 25px;border-radius: 6px;background-color: #fff;border: 1px solid #ddd;">
            <p>Hello <?= $name ?>,</p>
            <p>
                <?= $appName ?>'s team was added you to be a voter in their poll <b><?= $polling->title ?></b>. To vote your candidate's choice, click on this button to open our website and input your token : <b><?= $token ?></b>.
                <br /><br />
                <a href=\'<?= base_url() ?>\'>
                    <button
                        style="width: 100%;background: #3498db;text-align: center;line-height: 60px;border-radius: 8px;color: #fff;border: none;font-size: 18px;"
                    >VOTE</button>
                </a>
                <br />
            </p>
            <p>
                Regards,<br />
                <?= $appName ?>'s team
            </p>
        </div>
    </div>
</div>