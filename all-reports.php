<?php
require_once "header.php";
?>
<div class="container">
    <div class="row mt-2 gap-2">
        <div class="col-12">
            <h2>Reports</h2>
            <p>Found <span id="totalReports">0</span> results</p>
        </div>
        <div class="col-12 row gap-2" id="placeholders">
            <div class="placeholder-glow preloaders col-12" id="content">
                <div class="col-12 placeholder bg-success shadow-lg" style="height:120px;"></div>
            </div>
            <div class="placeholder-glow preloaders col-12" id="content">
                <div class="col-12 placeholder bg-success shadow-lg" style="height:120px;"></div>
            </div>
            <div class="placeholder-glow preloaders col-12" id="content">
                <div class="col-12 placeholder bg-success shadow-lg" style="height:120px;"></div>
            </div>
            <div class="placeholder-glow preloaders col-12" id="content">
                <div class="col-12 placeholder bg-success shadow-lg" style="height:120px;"></div>
            </div>
        </div>
        <div class="col-12 row gap-4" id="reports">
             
        </div>

    </div>
</div>
<?php require_once "footer.php" ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        $.ajax({
            method: 'POST',
            url: './requests/getUserReports.php',
            beforeSend: () => { },
            success: (response) => {
                const { data } = response
                //hide preloaders
                $("#placeholders").hide(200)
                $("#totalReports").html(data.length)
                data.forEach((dataItem, index) => { 
                    $("#reports").append(createCard(dataItem))
                })
            },
            error: () => { },
        })



    })
</script>