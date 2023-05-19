

<?php


?>


<!DOCTYPE html>
<html>
<head>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}


.column {
  float: left;
  width: 25%;
  padding: 0 10px;
}


.row {margin: 0 -5px;}


.row:after {
  content: "";
  display: table;
  clear: both;
}

@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}


.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
}



html {
height:100%;
}
body {
margin:0;
}

.bg {
animation:slide 3s ease-in-out infinite alternate;
background-image: linear-gradient(-60deg, #6c3 50%, #09f 50%);
bottom:0;
left:-50%;
opacity:.5;
position:fixed;
right:-50%;
top:0;
z-index:-1;
}
.bg2 {
animation-direction:alternate-reverse;
animation-duration:4s;
}
.bg3 {
animation-duration:5s;
}

.content {
background-color:rgba(255,255,255,.8);
border-radius:.25em;
box-shadow:0 0 .25em rgba(0,0,0,.25);
box-sizing:border-box;
left:50%;
padding:10vmin;
position:fixed;
text-align:center;
top:50%;
transform:translate(-50%, -50%);
}
h1 {
font-family:monospace;
}

@keyframes slide {
0% {
transform:translateX(-25%);
}

100% {
transform:translateX(25%);
}
}


</style>
</head>
<body>



<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>
<div class="content">

<h2>REALITY CHECK</h2>

<div class="row"  type="hidden">
  <div class="column">
    <div class="card">
    <button style='font-size:90px'><i class='far fa-id-badge'></i></button>
   
    </div>
  </div>

  <div class="column">
    <div class="card">
      <h3>USER</h3>
      <p>this section will </p>
      <p>help to post the issue</p>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
    <button style='font-size:90px'><i class='far fa-id-card'></i></button>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
      <h3>Politican</h3>
      <p>this section will </p>
      <p>manage the issue</p>
    </div>
  </div>
</div>
</div>

</body>
</html>