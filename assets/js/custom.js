function displayFileName() {
  const fileInput = document.getElementById('fileUpload')
  const fileNameDisplay = document.getElementById('fileName')

  if (fileInput.files.length > 0) {
    const fileName = fileInput.files[0].name
    fileNameDisplay.innerHTML = `<div class="row mt-2">
        <div class="col-2"><img src="./assets/images/file.svg" width="24" height="24" alt="file icon" /></div>
        <div class="col-10"><span>${fileName}</span></div>
    </div>`
  } else {
    fileNameDisplay.textContent = ''
  }
}

function uploadFile() {
  const fileInput = document.getElementById('fileUpload')
  const progressBar = document.getElementById('progressBar')
  const progressContainer = document.querySelector('.progress')
  const submitBtn = document.getElementById('submitBtn')
  const contentTextarea = document.getElementById('contentTextarea')
  const form = document.getElementById('plagiarism-form')
  const filename = document.getElementById('filename')

  const file = fileInput.files[0]

  if (file) {
    const allowedTypes = [
      'application/pdf',
      'text/plain',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ]
    if (!allowedTypes.includes(file.type)) {
      alert(
        'Unsupported file type. Please upload a PDF, plain text, or DOCX file.'
      )
      // Optionally, you can clear the file input
      fileInput.value = ''
      return
    }
    displayFileName()
    const xhr = new XMLHttpRequest()
    xhr.responseType = 'json'
    const formData = new FormData()

    formData.append('file', file)

    xhr.open('POST', '../../upload.php', true)

    xhr.upload.onprogress = function (e) {
      if (e.lengthComputable) {
        const percent = (e.loaded / e.total) * 100
        progressBar.style.width = percent + '%'
      }
    }

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Upload complete, hide progress bar
        progressContainer.style.display = 'none'

        //enable submit button
        submitBtn.classList.remove('disabled')
        //hide the text content
        contentTextarea.classList.add('d-none')

        //update the form action
        setAnalyzeMethod('fileSearch')

        //update file name input
        filename.value = xhr.response['filename']
      }
    }

    // Display progress bar and initiate file upload
    progressContainer.style.display = 'block'
    xhr.send(formData)
  }
}

function hideFileUpload() {
  const fileArea = document.querySelector('#file-upload-area')
  fileArea.classList.add('d-none')
}
function showFileUpload() {
  const fileArea = document.querySelector('#file-upload-area')
  const contentTextarea = document.getElementById('contentTextarea')
  const error = document.getElementById('error-message')
  const submitBtn = document.getElementById('submitBtn')
  const form = document.getElementById('plagiarism-form')

  const content = contentTextarea.value.split('')
  if (content.length === 0) {
    error.textContent = null
    fileArea.classList.remove('d-none')
    form.setAttribute('action', null)
  } else if (content.length < 50) {
    //enable submit button
    submitBtn.classList.add('disabled')
    form.setAttribute('action', null)
    error.textContent =
      'You have entered ' +
      content.length +
      ' words out of 50. Please add more words so the check would be completed.'
  } else {
    //enable submit button
    submitBtn.classList.remove('disabled')
    setAnalyzeMethod('textSearch')
    error.textContent = null
    return
  }
}

function copyToClipboard(text) {
  // Create a temporary hidden input element
  const input = document.createElement('input')
  input.value = text

  // Append the textarea to the document
  document.body.appendChild(input)

  // Select and copy the text
  input.select()
  document.execCommand('copy')

  // Remove the temporary textarea
  document.body.removeChild(input)
  alert('Link copied to clipboard!')
}

function setAnalyzeMethod(method) {
  const element = document.getElementById('analyzeMethod')

  if (element) {
    element.value = method
  }
}

function secondsToHumanDate(seconds) {
  const milliseconds = seconds * 1000
  const date = new Date(milliseconds)

  const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric',
    second: 'numeric',
    // timeZoneName: 'short',
  }

  return date.toLocaleString('en-US', options)
}

function createAccordionItem(
  index,
  { id, plagiarism, text, title, url, matches, rb_id }
) {
  // Create accordion item
  var accordionItem = $('<div class="accordion-item matches"></div>')

  // Create accordion header
  var accordionHeader = $('<h2 class="accordion-header"></h2>')
  var accordionButton = $(
    '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-' +
      index +
      '" aria-expanded="false" aria-controls="flush-collapseOne"></button>'
  )

  var headerContent = $(
    '<div class="w-100">' +
      '<p class="fw-medium m-0 w-100">' +
      title +
      ' <span class="text-danger fw-medium float-end">' +
      plagiarism +
      '%</span></p>' +
      '<a href="' +
      url +
      '" title="' +
      url +
      '" target="_blank" class="d-inline-block fw-medium text-decoration-none w-100 text-truncate">' +
      url +
      '</a>' +
      '</div>'
  )

  accordionButton.append(headerContent)
  accordionHeader.append(accordionButton)

  // Create accordion body
  var accordionBody = $(
    '<div id="flush-' +
      index +
      '" class="accordion-collapse collapse" data-bs-parent="#plagiarismSources">' +
      '<div class="accordion-body p-2 d-flex flex-column">' +
      '<small>' +
      text +
      '</small>' +
      '<a href=' +
      url +
      ' target="_blank" >' +
      url +
      '</a>' +
      '<div class="hstack gap-2">' +
      '<div class="p-2 col">Matched Words: <span class="badge bg-info">' +
      matches +
      '</span></div>' +
      '<div class="vr"></div>' +
      '<div class="p-2 col">Plagiarism: <span class="badge bg-info">' +
      plagiarism +
      '%</span></div>' +
      '</div>' +
      '</div>' +
      '</div>'
  )

  // Append header and body to accordion item
  accordionItem.append(accordionHeader)
  accordionItem.append(accordionBody)

  // Add click event listener to the accordion button
  accordionButton.on('click', function () {
    //remove .selected class from other elements
    $('.selected').each((index, element) => {
      $(element).removeClass('selected')
    })
    // Select an element from the document and give it focus while underlining it
    $(`[data-b-id='${rb_id}']`).addClass('selected')
    $('html, body').animate(
      {
        scrollTop: $(`[data-b-id='${rb_id}']`).offset().top,
      },
      200
    )
  })

  return accordionItem
}

function createCard({id,title,plagiarism,words,originality,created,status_label}) {
  // Create the card container
  var card = $('<div>', {
    class: 'card col-12 shadow-lg p-3',
  })

  // Create the first inner div with class 'hstack'
  var hstackDiv = $('<div>', {
    class: 'hstack gap-3',
  })

  // Append small elements to 'hstackDiv'
  hstackDiv.append(
    $('<small>', {
      class: 'p-2',
      text: 'ID# '+id,
    })
  )
  hstackDiv.append(
    $('<small>', {
      class: 'vr',
    })
  )
  hstackDiv.append(
    $('<small>', {
      class: 'p-2',
      text: secondsToHumanDate(created),
    })
  )

  // Append 'hstackDiv' to the card
  card.append(hstackDiv)

  // Append the second inner div with class 'py-2'
  card.append(
    $('<div>', {
      class: 'py-2',
    }).append(
      $('<a>', {
        href: "./view-report.php?report_id="+id,
        class: 'fs-5 text-decoration-none text-black',
        text: title,
      })
    )
  )

  // Append the third inner div with class 'py-2 d-flex align-items-center gap-2'
  card.append(
    $('<div>', {
      class: 'py-2 d-flex align-items-center gap-2',
    }).append(
      $('<div>', {
        class: 'progress w-25',
        role: 'progressbar',
        'aria-valuenow': plagiarism,
        'aria-valuemin': '0',
        'aria-valuemax': '100',
        style: 'height: 10px;',
      }).append(
        $('<div>', {
          class: 'progress-bar bg-danger',
          style: `width: ${plagiarism}%;`,
        })
      ),
      $('<small>', {
        class: 'text-danger',
        text: `${plagiarism}% Plagiarism`,
      })
    )
  )

  // Append the fourth inner div with class 'd-flex justify-content-between align-items-center'
  card.append(
    $('<div>', {
      class: 'd-flex justify-content-between align-items-center',
    }).append(
      $('<div>', {
        class: 'hstack gap-3',
      }).append(
        $('<small>', {
          class: 'py-2',
          text: 'Words: ',
        }).append(
          $('<b>', {
            text: words,
          })
        ),
        $('<small>', {
          class: 'vr',
        }),
        $('<small>', {
          class: 'py-2 text-primary',
          text: 'Originality: ',
        }).append(
          $('<b>', {
            text: originality+'%',
          })
        )
      ),
      $('<span>', {
        class: `badge bg-success`,
        text: status_label,
      })
    )
  )

  return card
}

document.addEventListener('DOMContentLoaded', () => {
  const plagiarismForm = document.getElementById('plagiarism-form')
  const spinner = document.getElementById('spinner')

  if (plagiarismForm)
    plagiarismForm.onsubmit = (event) => {
      event.preventDefault()
      spinner.classList.remove('d-none')
      const formData = new FormData(event.target)
      const analyzeMethod = formData.get('analyzeMethod')
      const searchText = formData.get('searchText')
      const filename = formData.get('filename')
      //make requests appropriately depending on the analyze method

      if (analyzeMethod == 'textSearch') {
        $.ajax({
          method: 'POST',
          url: './requests/textSearch.php',
          data: { textContent: searchText },
          beforeSend: () => {},
          success: (response) => {
            //create another request to check for the report if its ready
            var reportId = response.reportId
            $.ajax({
              method: 'POST',
              url: './requests/checkReportStatus.php',
              data: { reportId: response.reportId },
              beforeSend: () => {},
              success: (response) => {
                spinner.classList.add('d-none')
                location.assign('view-report.php?report_id=' + reportId)
              },
              error: () => {},
            })
          },
          error: (error) => {
            console.log(error)
            spinner.classList.add('d-none')
          },
        })
      } else if (analyzeMethod == 'fileSearch') {
        $.ajax({
          method: 'POST',
          url: './requests/fileSearch.php',
          data: { filename },
          beforeSend: () => {},
          success: (response) => {
            //create another request to check for the report if its ready
            var reportId = response.reportId
            $.ajax({
              method: 'POST',
              url: './requests/checkReportStatus.php',
              data: { reportId: response.reportId },
              beforeSend: () => {},
              success: (response) => {
                spinner.classList.add('d-none')
                location.assign('view-report.php?report_id=' + reportId)
              },
              error: () => {},
            })
          },
          error: (error) => {
            console.log(error)
            spinner.classList.add('d-none')
          },
        })
      }
    }
})
