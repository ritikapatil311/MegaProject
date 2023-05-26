<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
    }
    h1 {
      text-align: center;
    }
    .button-container {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    .button-container button {
      padding: 10px 20px;
      margin: 0 10px;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome to the Dashboard</h1>
    <div class="button-container">
      <button onclick="showSubmitConfirmation()">Submit Problem</button>
      <button onclick="showCommentConfirmation()">Comment on Problem</button>
    </div>
  </div>

  <!-- Submit Confirmation Modal -->
  <div id="submitModal" style="display: none;">
    <h2>Submit Confirmation</h2>
    <p>Are you sure you want to submit a problem?</p>
    <button onclick="redirectToPoliticianRequest()">Submit</button>
    <button onclick="closeModal()">Cancel</button>
  </div>

  <!-- Comment Confirmation Modal -->
  <div id="commentModal" style="display: none;">
    <h2>Comment Confirmation</h2>
    <p>Are you sure you want to comment on a problem?</p>
    <button onclick="redirectToPoliticianDisplay()">Comment</button>
    <button onclick="closeModal()">Cancel</button>
  </div>

  <script>
    function showSubmitConfirmation() {
      document.getElementById("submitModal").style.display = "block";
    }

    function showCommentConfirmation() {
      document.getElementById("commentModal").style.display = "block";
    }

    function redirectToPoliticianRequest() {
      window.location.href = "politicianRequest.php";
    }

    function redirectToPoliticianDisplay() {
      window.location.href = "politicianDisplay.php";
    }

    function closeModal() {
      document.getElementById("submitModal").style.display = "none";
      document.getElementById("commentModal").style.display = "none";
    }
  </script>
</body>
</html>
