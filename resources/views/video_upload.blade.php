<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Preview</title>
    <style>
        .preview {
            display: flex;
            flex-wrap: wrap;
        }

        .preview img {
            max-width: 150px;
            margin: 10px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            cursor: pointer;
        }

        .preview-container {
            position: relative;
            display: inline-block;
        }
    </style>
</head>

<body>
    <form onsubmit="" action="{{ url('video-upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" id="file-input" name="file[]" multiple>
        <input type="submit" value="Upload">
    </form>
    <div class="preview" id="preview"></div>

    <script>
        let selectedFiles = [];
        document.getElementById('file-input').addEventListener('change', handleFileSelect);

        function handleFileSelect(event) {
            const files = Array.from(event.target.files);
            selectedFiles = selectedFiles.concat(files);
            console.log(selectedFiles);
            updatePreview();
        }

        function updatePreview() {
            const previewContainer = document.getElementById('preview');
            previewContainer.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                // if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.classList.add('preview-container');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.title = file.name;

                    const button = document.createElement('button');
                    button.classList.add('close-btn');
                    button.innerHTML = 'X';
                    button.onclick = function() {
                        removeFile(index);
                    };

                    div.appendChild(img);
                    div.appendChild(button);
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            console.log(selectedFiles);
            updateInputFiles();
            updatePreview();
        }

        function updateInputFiles() {
            const dataTransfer = new DataTransfer();
            console.log(dataTransfer);
            document.getElementById('file-input').files = dataTransfer.files;
        }
    </script>
</body>

</html>
