<?php

// Check if a file was uploaded
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Specify the upload directory
    $uploadDirectory = 'uploads/';

    // Generate a unique filename to avoid overwriting existing files
    $uniqueFilename = uniqid() . '_' . $_FILES['file']['name'];

    // Move the uploaded file to the destination directory
    $destinationPath = $uploadDirectory . $uniqueFilename;
    move_uploaded_file($_FILES['file']['tmp_name'], $destinationPath);

    // Send a success response
    echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully.', 'filename' => $uniqueFilename]);
} else {
    // Send an error response
    echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
}
