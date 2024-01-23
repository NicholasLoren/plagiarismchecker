<?php
require_once "header.php";
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-lg">
    <div class="container">
        <a class="navbar-brand col" href="./all-reports.php">Reports/<small id="reportTitleSub"></small></a>

        <div class="col-3" id="reportTitle">Report</div>
        <div class="col-4 d-flex flex-column gap-2 justify-content-end">
            <div class="d-flex justify-content-end gap-2">
                <small>Total words: </small>
                <small class="fw-medium" id="totalWords">0</small>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <small>Uploaded On: </small>
                <small class="fw-medium" id="dateCreated">30th Jan 2024</small>
            </div>
        </div>

    </div>
</nav>
<div class="container">
    <div class="row mt-2 gap-2">
        <div class="col card p-5" id="analyzedContent">
            <div class="placeholder-glow preloaders" id="content">
                <div class="col-12 placeholder bg-success"></div>
                <div class="col-12 placeholder bg-success"></div>
                <div class="col-12 placeholder bg-success"></div>
                <div class="col-12 placeholder bg-success"></div>
                <div class="col-12 placeholder bg-success"></div>
                <div class="col-12 placeholder bg-success"></div>
                <div class="col-12 placeholder bg-success"></div>
                <div class="col-12 placeholder bg-success"></div>
                <div class="col-12 placeholder bg-success"></div>
                <div class="col-12 placeholder bg-success"></div>
                <div class="col-6 placeholder bg-success"></div>
            </div>
        </div>
        <div class="col-5 card p-2 align-self-stretch">
            <div id="progressBar" data-value="0" class="mx-auto position-relative">
                <span class="position-absolute top-50 start-50 translate-middle" id="progressBarValue">0%</span>
            </div>
            <div>
                <h6 class="text-center">Plagiarism</h6>
            </div>
            <div class="bg-success">
                <h4 class="text-Left text-white p-2">Sources</h4>
            </div>

            <div class="accordion accordion-flush overflow-y-auto" id="plagiarismSources" style="height: 500px;">
                <div class="placeholder-glow preloaders" id="content">
                    <div class="col-12 placeholder bg-success mb-1" style="height:50px;"></div>
                    <div class="col-12 placeholder bg-success mb-1" style="height:50px;"></div>
                    <div class="col-12 placeholder bg-success mb-1" style="height:50px;"></div>
                    <div class="col-12 placeholder bg-success mb-1" style="height:50px;"></div>
                    <div class="col-12 placeholder bg-success mb-1" style="height:50px;"></div>
                </div>

            </div>


        </div>
    </div>
</div>
<?php require_once "footer.php" ?>
<style>
    .ps-rb-p {
        background-color: lightgreen;
        padding: 2px;
    }

    .ps-rb-i {
        position: absolute;
        right: 5px;
        display: none;
    }

    .h-s,
    .ps-rb-s {
        background: #fff4be;
    }

    .matches b {
        background-color: lightgreen;
    }

    .selected {
        text-decoration-line: underline;
        text-decoration-color: #fffb00;
        text-decoration-thickness: 4px;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", () => {

        if ($('#progressBar').length) {
            $('#progressBar').circleProgress({
                value: 0,
                size: 100,
                fill: {
                    gradient: ['#6fc276', 'teal'],
                },
            })
        }
        const reportId = "<?php print $_GET['report_id'] ?>"
        //Before checking for report details
        //check status
        $.ajax({
            method: 'POST',
            url: './requests/checkReportStatus.php',
            data: { reportId },
            beforeSend: () => { },
            success: (response) => { 
                 getDetails()
            },
            error: () => { },
        })


        const getDetails = () => {
            $.ajax({
                method: 'POST',
                url: './requests/getReportDetails.php',
                data: { reportId: reportId },
                beforeSend: () => { },
                success: (response) => {
                    const { plagiarism, words, paragraphs, title, blocks, sources, created } = response.data
                    //remove all preloaders
                    $(".preloaders").each((index, preloader) => {
                        $(preloader).hide()
                    })
 
                    //find all blocks and add them to the document
                    for (block in blocks) {
                        const { text_format, text } = blocks[block]
                        $("#analyzedContent").append(text_format ?? text)
                    }

                    for (source in sources) {
                        const sourceData = sources[source]
                        const sourceItem = createAccordionItem(source, sourceData)
                        $("#plagiarismSources").append(sourceItem)
                    }



                    //Compute data and format accordingly
                    $("#reportTitleSub").html(title)
                    $("#reportTitle").html("Report " + title)
                    $("#totalWords").html(words)
                    $("#dateCreated").html(secondsToHumanDate(created))
                    $('#progressBar').circleProgress('value', plagiarism / 100);
                    $('#progressBarValue').html(plagiarism + "%");
                },
                error: (error) => {
                    console.log(error)

                },
            })
        }
    })
</script>