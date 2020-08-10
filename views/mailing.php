<style>
    .container {
        background: red;
        color: #fff;
        border-radius: 8px;
    }
</style>
    
<div class="container bg-putih bayangan-5 rounded" style="background: green;color: #fff;">
    <div class="wrap">
        <form>
            CSS : <?= env('BASE_URL') ?>css/style.css<br />
            <div>Please insert your token to vote, <?= $name ?> :</div>
            <button class="hijau mt-2 lebar-100">Submit</button>
        </form>
    </div>
</div>
