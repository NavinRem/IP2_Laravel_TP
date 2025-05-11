<html>
  <body>
    <h3>Upload Gallery Image</h3>
    <form action="/upload_gallery" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" required />
        <button type="submit">Upload</button>
    </form>
  </body>
</html>
