<?php include_once ("header.php") ?>
<div class="container flex-grow-1">
    <form class="row" method="post" id="ai-form">
        <input type="hidden" name="analyzeMethod" id="analyzeMethod">
        <div class="col-12">
            <h2 class="text-center my-4 font-weight-bold">AI detection</h2>
            <p class="text-center">In-depth analysis of the text to specify the probability of AI tools usage</p>
        </div>
        <div class="col-12 d-flex justify-content-center mb-2">
            <div class="border w-50 border-dashed">
                <div class="row justify-content-center p-4">
                    <div class="d-flex flex-column w-50 align-items-center" id="file-upload-area"> 
                        <img src="./assets/images/upload-ico.svg" alt="">
                        <h4>Choose file</h4>
                        <div class="progress w-100" style="display: none;">
                            <div id="progressBar"
                                class="progress-bar progress-bar-striped progress-bar-animated bg-danger h-100"
                                role="progressbar" style="width: 00%;" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <span class="text-nowrap">to upload the documents for plagiarism check</span>
                        <p id="fileName" class="text-nowrap"></p>
                        <div class="input-group d-flex justify-content-center">
                            <input type="hidden" name="filename" id="filename">
                            <input type="file" id="fileUpload" class="form-control d-none" onchange="uploadFile()">
                            <button type="button" class="btn btn-sm btn-success p-2 text-uppercase rounded-pill text-sm"
                                onclick="document.getElementById('fileUpload').click()"><small>Upload
                                    file</small></button>
                        </div>
                        <hr>
                    </div>
                    <div class="col-12">
                        <textarea name="searchText" rows="5" class="form-control border-top"
                            placeholder="Text for scan (min: 50 words, max: 800 words)" id="contentTextarea"
                            onfocus="hideFileUpload()" minlength="50" maxlength="800"
                            onblur="showFileUpload()"></textarea>
                    </div>
                    <div class="col-12">
                        <i><small class="text-danger text-italicize" id="error-message"></small></i>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <button type="submit"
                            class="btn btn-danger rounded-pill my-2 disabled d-flex justify-content-between align-items-center gap-2"
                            id="submitBtn">
                            <div class="spinner-border spinner-border-sm d-none" id="spinner" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span>Check your text</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

<?php include_once "footer.php"; ?>