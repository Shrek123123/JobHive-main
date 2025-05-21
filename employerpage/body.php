
<?php
require_once 'config.php';
if (!isset($_SESSION['usernameemployer'])) {
  echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
      var openBtn = document.getElementById('openModalBtn');
      if (openBtn) {
        openBtn.onclick = function() {
          window.location.href = 'employerlogin.php';
        }
      }
    });
  </script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $companyName = $_POST['companyName'];
    $jobTitle = $_POST['jobTitle'];
    $jobDescription = $_POST['jobDescription'];
    $jobLocation = $_POST['jobLocation'];
    $salary = $_POST['salary'];
    $contactEmail = $_POST['contactEmail'];
    $contactPhone = $_POST['contactPhone'];
    $jobType = $_POST['jobType'];
    $jobCategory = $_POST['jobCategory'];
    $requiredcertification = $_POST['requiredcertification'];
    $jobExperience = $_POST['jobExperience'];
    if (!isset($_SESSION['employerid'])) {
        echo "<script>alert('You must be logged in as an employer to post a job.');</script>";
        exit;
    }
    $employerid = $_SESSION['employerid'];

    // Handle file upload
    if (isset($_FILES['companylogo']) && $_FILES['companylogo']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["companylogo"]["name"]);
        move_uploaded_file($_FILES["companylogo"]["tmp_name"], $targetFile);
    }

    // Database connection and insertion logic here
    $stmt = $conn->prepare("INSERT INTO job (posted_by_employer_id, company_name, job_title, job_description, job_location, salary, contact_email, contact_phone, job_type, job_category, required_certification, job_experience, company_logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssssssss", $employerid, $companyName, $jobTitle, $jobDescription, $jobLocation, $salary, $contactEmail, $contactPhone, $jobType, $jobCategory, $requiredcertification, $jobExperience, $targetFile);
    if ($stmt->execute()) {
        echo "<script>alert('Job posted successfully!');</script>";
    } else {
        echo "<script>alert(`Error posting job: {$stmt->error}`);</script>";
    }
}
?>
<style>
     .hero {
      position: relative;
      color: white;
      background: url('https://via.placeholder.com/1500x700') no-repeat center center/cover;
      height: 90vh;
      display: flex;
      align-items: center;
      padding: 40px;
    }

    .hero-overlay {
      background: rgba(0, 0, 0, 0.5);
      padding: 40px;
      max-width: 700px;
      border-radius: 12px;
    }

    .hero h1 {
      font-size: 48px;
      color: #ff0000;
      margin-bottom: 20px;
    }

    .hero ul {
      list-style: disc;
      padding-left: 20px;
      color: white;
      font-size: 18px;
      margin-bottom: 30px;
    }

    .hero-buttons {
      display: flex;
      gap: 20px;
    }

    .hero-buttons button {
      padding: 12px 20px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }

    .consult-btn {
      background: white;
      color: #d40000;
      border: 2px solid #d40000;
    }

    .post-now-btn {
      background: #d40000;
      color: white;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      overflow-y: auto;
    }

    .modal-content {
      background-color: #fff;
      margin: 40px auto 40px auto; /* Cách đều trên/dưới */
      padding: 20px;
      border-radius: 8px;
      width: 90%;
      max-width: 500px;
      text-align: center;
      position: relative;
      top: 0;
    }

    .closeBtn {
      float: right;
      font-size: 24px;
      cursor: pointer;
    }


</style>
<section class="hero">
    <div class="hero-overlay">
      <h1>Post Jobs & Find Candidates Effectively</h1>
      <ul>
        <li>Post jobs for free, easily and quickly</li>
        <li>Huge candidate pool from various industries and fields</li>
        <li>Toppy AI recommends potential candidates, filters top profiles, and ranks them by relevance</li>
      </ul>
      <div class="hero-buttons">
        <button class="consult-btn">Recruitment Consulting</button>

        <button class="post-now-btn" id="openModalBtn">Post a Job Now →</button>
      </div>
    </div>
  </section>


<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="closeBtn">&times;</span>
    <h2>Post job form</h2>
    <form accept="multipart/form-data" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
      <table class="form-table">
        <tr>
          <td><label for="companyName">Company Name:</label></td>
          <td><input type="text" id="companyName" name="companyName" placeholder="Company Name" required></td>
        </tr>
        <tr>
          <td><label for="jobTitle">Job Title:</label></td>
          <td><input type="text" id="jobTitle" name="jobTitle" placeholder="Job Title" required></td>
        </tr>
        <tr>
          <td><label for="jobDescription">Job Description:</label></td>
          <td><textarea id="jobDescription" name="jobDescription" placeholder="Job Description" required></textarea></td>
        </tr>
        <tr>
          <td><label for="jobLocation">Job Location:</label></td>
          <td><input type="text" id="jobLocation" name="jobLocation" placeholder="Job Location" required></td>
        </tr>
        <tr>
          <td><label for="salary">Salary:</label></td>
          <td><input type="text" id="salary" name="salary" placeholder="Eg: 1000 USD, 20 million VND, negotiable..." required></td>
        </tr>
        <tr>
          <td><label for="contactEmail">Contact Email:</label></td>
          <td><input type="email" id="contactEmail" name="contactEmail" placeholder="Contact Email" required></td>
        </tr>
        <tr>
          <td><label for="contactPhone">Contact Phone:</label></td>
          <td><input type="text" id="contactPhone" name="contactPhone" placeholder="Contact Phone" required></td>
        </tr>
        <tr>
          <td><label for="jobType">Job Type:</label></td>
          <td>
            <select id="jobType" name="jobType" required>
              <option value="full-time">Full-time</option>
              <option value="part-time">Part-time</option>
              <option value="internship">Internship</option>
              <option value="freelance">Freelance</option>
              <option value="contract">Contract</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><label for="jobCategory">Job Category:</label></td>
          <td>
            <select id="jobCategory" name="jobCategory" required>
              <option value="IT & Software">IT & Software</option>
              <option value="Marketing">Marketing</option>
              <option value="Finance">Finance</option>
              <option value="Healthcare">Healthcare</option>
              <option value="Government & Public Sector">Government & Public Sector</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><label for="requiredcertification">Require certification:</label></td>
          <td><input type="text" id="requiredcertification" name="requiredcertification" placeholder="Eg: Bachelor of finance, none..." required></td>
        </tr>
        <tr>
          <td><label for="jobExperience">Job experience required</label></td>
          <td><input type="text" id="jobExperience" name="jobExperience" placeholder="Eg: 1 year, 6 months, none..." required></td>
        </tr>
        <tr>
          <td><label for="companylogo">Company Logo:</label></td>
          <td><input type="file" id="companylogo" name="companylogo" accept="image/*" required></td>
        </tr>
        <tr>
          <td colspan="2" style="text-align:center;">
            <button type="submit">Submit</button>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<style>
  .form-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
  }
  .form-table td {
    padding: 6px 8px;
    vertical-align: middle;
  }
  .form-table label {
    font-weight: 500;
    white-space: nowrap;
  }
  .form-table input[type="text"],
  .form-table input[type="email"],
  .form-table input[type="number"],
  .form-table input[type="file"],
  .form-table textarea,
  .form-table select {
    width: 100%;
    padding: 7px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 15px;
    box-sizing: border-box;
  }
  .form-table textarea {
    resize: vertical;
    min-height: 60px;
  }
  .form-table button[type="submit"] {
    padding: 10px 30px;
    background: #d40000;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
  }
</style>


<script>
  const modal = document.getElementById("myModal");
const openBtn = document.getElementById("openModalBtn");
const closeBtn = document.querySelector(".closeBtn");

openBtn.onclick = () => {
  modal.style.display = "block";
}

closeBtn.onclick = () => {
  modal.style.display = "none";
}

window.onclick = (event) => {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>


