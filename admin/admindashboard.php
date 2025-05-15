<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f3f0f2;
    }
    .sidebar {
      width: 200px;
      background-color: #0b1e45;
      color: white;
      height: 100vh;
      position: fixed;
      padding: 20px 10px;
    }
    .sidebar h2 {
      margin-top: 0;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
    }
    .sidebar ul li {
      margin: 20px 0;
      padding: 10px;
      background-color: #15294c;
      border-radius: 5px;
    }
    .sidebar ul li:hover {
      background-color: #1e3a66;
      cursor: pointer;
    }
    .main {
      margin-left: 220px;
      padding: 20px;
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .cards {
      display: flex;
      gap: 15px;
      margin: 20px 0;
    }
    .card {
      flex: 1;
      padding: 15px;
      border-radius: 10px;
      color: white;
      text-align: center;
    }
    .yellow { background-color: #f4b400; }
    .green { background-color: #0f9d58; }
    .blue { background-color: #4285f4; }
    .purple { background-color: #9b59b6; }
    .content-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
    }
    .box {
      background-color: white;
      padding: 15px;
      border-radius: 10px;
    }
    .user-status {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .status-dot {
      height: 10px;
      width: 10px;
      background-color: #4caf50;
      border-radius: 50%;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Admin</h2>
    <div class="user-status">
      <div class="status-dot"></div>
      <span>Online</span>
    </div>
    <ul>
      <li>Dashboard</li>
      <li>Users</li>
      <li>Job Posts</li>
      <li>Service Packages</li>
      <li>Settings</li>
      <li>Feedback</li>
      <li>Reports</li>
      <li>Add Job</li>
    </ul>
  </div>
  <div class="main">
    <div class="top-bar">
      <h1>Dashboard</h1>
      <div>
        <img src="" alt="Profile" style="width: 32px; height: 32px; border-radius: 50%; background: #ccc;">
      </div>
    </div>
    <div class="cards">
      <div class="card yellow">
        <h2>120</h2>
        <p>Total Employer Accounts</p>
      </div>
      <div class="card yellow">
        <h2>120</h2>
        <p>Total Job Seeker Accounts</p>
      </div>
      <div class="card green">
        <h2>17</h2>
        <p>Total Job Posts</p>
      </div>
      <div class="card blue">
        <h2>5</h2>
        <p>Job Post Pendings</p>
      </div>
      <div class="card purple">
        <h2>5</h2>
        <p>User Feedbacks</p>
      </div>
    </div>
    <div class="content-grid">
      <div class="box">
        <img src="https://www.presentationgo.com/wp-content/uploads/2018/12/Free-Growth-Arrow-PowerPoint-Template-Chart.png" width="100%" alt="Graph"/>
      </div>
      <div class="box">
        <h3>Access Activities</h3>
        <ul>
          <li>Post new job</li>
          <li>Recruitment</li>
          <li>Apply</li>
        </ul>
      </div>
    </div>
    <div class="content-grid" style="margin-top: 20px;">
      <div class="box">
        <h3>Notifications</h3>
      </div>
      <div class="box">
        <h3>Page Views</h3>
      </div>
    </div>
  </div>
</body>
</html>
