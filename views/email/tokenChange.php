<div style="font-family: sans-serif;background-color: #ecf0f1;padding: 30px;">
    <div style="width: 60%;margin-left: 20%;">
        <h1>Token Changed</h1>
        <div style="padding: 20px 25px;border-radius: 6px;background-color: #fff;border: 1px solid #ddd;">
            <p>Hello <?= $name ?>,</p>
            <p>
                We want to inform you that your token for voting app has changed due to admin was change your information. And your new token is :
                <br /><br />
                <b><?= $token ?></b>
            </p>
            <p>
                Regards,<br />
                <?= $appName ?>'s team
            </p>
        </div>
    </div>
</div>