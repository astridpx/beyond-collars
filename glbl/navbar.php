
<style>
    /* Your CSS styles here */
    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: Verdana, Tahoma, sans-serif;
      margin: 0;
      background: #3d64f4;
      padding-top: 170px; /* Remove unnecessary padding */
    }

    nav {
      overflow: hidden;
      padding: 20px 200px; /* Add padding for left and right */
      white-space: nowrap;
      position: fixed;
      top: 0;
      width: calc(100% - 400px); /* Adjust width considering left and right padding */
      background-color: #333;
      border-bottom: solid white 2px;
      z-index: 1000;
    }

    nav p {
      float: left; /* Align to the left */
      color: white;
      text-align: center;
      font-size: 1.3em;
      padding-right: 20px; /* Add some spacing between elements */
    }

    nav a {
      float: right; /* Align to the right */
      font-size: 1em;
      color: white;
      text-align: center;
      padding: 20px 24px;
      text-decoration: none;
      transition: transform 0.3s ease;
    }

    nav a:hover {
      color: #3d64f4;
      transform: translateY(-1px);
    }

    .icon-img {
      height: 3.5em;
      padding: 10px;
      vertical-align: middle; /* Align vertically in the middle */
    }

    .event {
      margin-left: 10px;
      background-color: #387ADF;
      border-radius: 40px;
    }
    .event:hover {
      background-color: white;
      color: #333;
    }
</style>

<nav>
  <p id="brandLink"><strong>BEYOND COLLARS</strong></p>
  <img src="/bc/img/main_icon.png" alt="This is Icon" class="icon-img">
  <a class="event" href="/bc/user/event.php">EVENT</a>
  <a class="more" href="/bc/user/more.php">MORE</a>
  <a class="report" href="/bc/user/report.php">REPORT</a>
  <a class="report-stray" href="/bc/user/report_stray.php">REPORT STRAY</a>
  <a class="stray" href="/bc/user/stray.php">STRAY</a>
  <a class="found" href="/bc/user/found.php">FOUND PET</a>
  <a class="lost" href="/bc/user/lost.php">LOST PET</a>
</nav>

<script>
  // JavaScript to handle the click event on the paragraph
  document.getElementById("brandLink").addEventListener("click", function() {
      window.location.href = "/bc/index.php"; // Replace with your brand URL
  });
</script>

