<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
            margin: auto;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: white;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Your Image</h1>
        <form id="uploadForm" action="http://localhost/cdn/" method="post" enctype="multipart/form-data">
            <label for="file">Select Image:</label>
            <input type="file" id="file" name="file" accept="image/*">
            <button type="submit">Upload</button>
        </form>
        <div id="status"></div>
        <h1>Upload Your Video</h1>
        <form id="uploadForm" action="http://localhost/cdn/" method="post" enctype="multipart/form-data">
            <label for="file">Select Image:</label>
            <input type="file" id="file" name="file" accept="video/mp4,video/x-m4v,video/*">
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>