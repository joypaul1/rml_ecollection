
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
 <style>
.thumbnail {
  padding: 50px;
  transition: transform .2s;
  width: 200px;
  height: 200px;
  margin: 0 auto;
}

.thumbnail:hover {
  -ms-transform: scale(1.5); /* IE 9 */
  -webkit-transform: scale(1.5); /* Safari 3-8 */
  transform: scale(1.5); 
}
}
</style>
</head>
<body>




<div class="container">
  <h2>Image Gallery</h2>
  <p>The .thumbnail class can be used to display an image gallery.</p>
  <p>The .caption class adds proper padding and a dark grey color to text inside thumbnails.</p>
  <p>Click on the images to enlarge them.</p>
  <div class="row">
    <div class="col-md-3">
      <div class="thumbnail">
        <a href="http://202.40.181.98:9090/rangs_collection_rml/apps_api/version%201.0.1/Collection/uploads/MB2753_1.jpg" target="_blank">
          <img src="http://202.40.181.98:9090/rangs_collection_rml/apps_api/version%201.0.1/Collection/uploads/MB2753_1.jpg" alt="Lights" style="width:100%">
          <div class="caption">
            <p>Lorem ipsum donec id elit non mi porta gravida at eget metus.</p>
          </div>
        </a>
      </div>
    </div>

    
  </div>
</div>

</body>
</html>

