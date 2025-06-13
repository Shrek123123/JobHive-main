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
  $companySize = $_POST['company_size']; // This will be set by the hidden input
  if (isset($_POST['custom_company_size']) && !empty($_POST['custom_company_size'])) {
    $companySize = $_POST['custom_company_size'];
  }
  $jobRequirementText = $_POST['jobRequirementText'];
  $jobBenefit = $_POST['jobBenefit'];
  $jobTitle = $_POST['jobTitle'];
  $jobDescription = $_POST['jobDescription'];
  $jobLocation = $_POST['jobLocation'];
  $salary = $_POST['salary'];
  $post_duration = $_POST['post_duration'];
  $contactEmail = $_POST['contactEmail'];
  $contactPhone = $_POST['contactPhone'];
  $jobType = $_POST['jobType'];
  $jobCategory = $_POST['jobCategory'];
  $requiredcertification = $_POST['requiredcertification'];
  $jobExperience = $_POST['jobExperience'];
  $jobPosition = $_POST['jobPosition'] ?? '';
  $noEmplpoyeeNeeeded = $_POST['noEmplpoyeeNeeded'] ?? 0;

  $jobDetailedLocation = $_POST['jobDetailedLocation'] ?? '';
  $jobLocationDistrict = $_POST['jobLocationDistrict'] ?? '';
  if (!isset($_SESSION['employerid'])) {
    echo "<script>alert('You must be logged in as an employer to post a job.');</script>";
    exit;
  }
  $employerid = $_SESSION['employerid'];

  // Handle file upload
  if (isset($_FILES['companylogo']) && $_FILES['companylogo']['error'] == 0) {
    $targetDir = "uploads/companylogo/";
    if (!is_dir($targetDir)) {
      mkdir($targetDir, 0777, true);
    }
    $fileName = basename($_FILES["companylogo"]["name"]);
    $targetFile = $targetDir . uniqid() . "_" . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check file size (1MB limit)
    if ($_FILES["companylogo"]["size"] > 1000000) {
      echo "<script>alert('Sorry, your file is too large.');</script>";
      exit;
    }

    // Allow certain file formats
    $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
    if (!in_array($fileType, $allowedTypes)) {
      echo "<script>
      alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
      window.history.back();
      </script>";
      exit;
    }

    // Upload file
    if (!move_uploaded_file($_FILES["companylogo"]["tmp_name"], $targetFile)) {
      echo "<script>alert('Sorry, there was an error uploading your file.');
      window.history.back();
      </script>";
      exit;
    }
  } else {
    $targetFile = ""; // No file uploaded
  }
  if (empty($targetFile)) {
    $targetFile = "uploads/default.png"; // Default image if no upload
  }

  // Validate required fields
  // $requiredFields = [
  //   'companyName' => $companyName,
  //   'jobTitle' => $jobTitle,
  //   'jobDescription' => $jobDescription,
  //   'jobLocation' => $jobLocation,
  //   'salary' => $salary,
  //   'contactEmail' => $contactEmail,
  //   'contactPhone' => $contactPhone,
  //   'jobType' => $jobType,
  //   'jobCategory' => $jobCategory,
  //   'requiredcertification' => $requiredcertification,
  //   'jobExperience' => $jobExperience,
  //   'post_duration' => $post_duration,
  //   'jobRequirementText' => $jobRequirementText,
  //   'jobBenefit' => $jobBenefit,
  //   'companySize' => $companySize,
  //   'jobPosition' => $jobPosition,
  //   'noEmplpoyeeNeeded' => $noEmplpoyeeNeeeded,
  //   'jobDetailedLocation' => $jobDetailedLocation,
  //   'jobLocationDistrict' => $jobLocationDistrict
  // ];

  // foreach ($requiredFields as $field => $value) {
  //   if (empty($value)) {
  //     echo "<script>alert('Please fill out all required information.');</script>";
  //   }
  // }

  // Database connection and insertion logic here
  $stmt = $conn->prepare("INSERT INTO job (
    posted_by_employer_id, company_name, job_title, job_description, job_location, salary, post_duration, contact_email, contact_phone, job_type, job_category, required_certification, job_experience, company_logo, job_requirement, job_benefit, company_size, no_employee_needed, job_position, job_detailed_location, job_location_district
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  if (!$stmt) {
    echo "<script>alert('Error preparing statement: {$conn->error}');</script>";
    exit;
  }

  $stmt->bind_param(
    "isssssissssssssssisss",
    $employerid,
    $companyName,
    $jobTitle,
    $jobDescription,
    $jobLocation,
    $salary,
    $post_duration,
    $contactEmail,
    $contactPhone,
    $jobType,
    $jobCategory,
    $requiredcertification,
    $jobExperience,
    $targetFile,
    $jobRequirementText,
    $jobBenefit,
    $companySize,
    $noEmplpoyeeNeeeded,
    $jobPosition,
    $jobDetailedLocation,
    $jobLocationDistrict
  );

  if ($stmt->execute()) {
    echo "<script>alert('Job posted successfully!');</script>";
  } else {
    echo "<script>alert('Error posting job: {$stmt->error}');</script>";
  }
  $stmt->close();
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
    background-color: rgba(0, 0, 0, 0.5);
    overflow-y: auto;
  }

  .modal-content {
    background-color: #fff;
    margin: 40px auto 40px auto;
    /* Cách đều trên/dưới */
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
<section class="hero" style="background: url('image/employerpagebackground.png') no-repeat center center/cover;">
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

<?php
// include modal form for posting job
// This modal will be triggered when the user clicks on the "Post a Job Now" button
?>

<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="closeBtn">&times;</span>
    <h2>Post job form</h2>
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
      <table class="form-table">
        <tr>
          <td><label for="companyName">Company Name:</label></td>
          <td><input type="text" id="companyName" name="companyName" placeholder="Company Name" required></td>
        </tr>
        <tr>
          <td><label for="company_size_select">Company Size:</label></td>
          <td>
            <select id="company_size_select" onchange="toggleCustomInput()" required>
              <option value="">-- Select Company Size --</option>
              <option value="1-10">1–10 employees</option>
              <option value="11-50">11–50 employees</option>
              <option value="51-200">51–200 employees</option>
              <option value="201-500">201–500 employees</option>
              <option value="501-1000">501–1000 employees</option>
              <option value="1001-5000">1001–5000 employees</option>
              <option value="5000+">5000+ employees</option>
              <option value="other">Other</option>
            </select>
            <input type="hidden" name="company_size" id="company_size">
            <div id="custom_input_wrapper" style="display: none; margin-top: 8px;">
              <input type="text" id="custom_company_size" name="custom_company_size" placeholder="e.g. 10-150 or 5000+"
                title="Enter like 10-150 or 5000+">
            </div>
          </td>
        </tr>
        <tr>
          <td><label for="jobTitle">Job Title:</label></td>
          <td><input type="text" id="jobTitle" name="jobTitle" placeholder="Job Title" required></td>
        </tr>
        <tr>
          <td><label for="jobDescription">Job Description:</label></td>
          <td><textarea id="jobDescription" name="jobDescription" placeholder="Job Description" required></textarea>
          </td>
        </tr>
        <tr>
          <td><label for="jobLocation">Job Location:</label></td>
          <td><input type="text" id="jobLocation" name="jobLocation" placeholder="Job Location" required></td>
        </tr>
        <tr>
          <td><label for="salary">Salary:</label></td>
          <td><input type="text" id="salary" name="salary" placeholder="Eg: 1000 USD, 20 million VND, negotiable..."
              required></td>
        </tr>
        <tr>
          <td><label for="post_duration">Duration of the post:</label></td>
          <td><input type="number" id="post_duration" name="post_duration"
              placeholder="Expiry duration (eg: 30 (days))"></td>
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
          <td><label for="noEmplpoyeeNeeded">Number of Employees Needed:</label></td>
          <td>
            <input type="number" id="noEmplpoyeeNeeded" name="noEmplpoyeeNeeded"
              placeholder="Number of Employees Needed (optional)" min="0" oninput="this.value = Math.abs(this.value)">
          </td>
        </tr>
        <tr>
          <td><label for="jobDetailedLocation">Job Detailed Location:</label></td>
          <td><input type="text" id="jobDetailedLocation" name="jobDetailedLocation"
              placeholder="Eg: 123 Main St, City, Country"></td>
        </tr>
        <tr>
          <td><label for="jobLocationDistrict">District:</label></td>
          <td><input type="text" id="jobLocationDistrict" name="jobLocationDistrict" placeholder="Eg: District 1"></td>
        </tr>
        <tr>
          <td><label for="jobPosition">Job Position:</label></td>
          <td><input type="text" id="jobPosition" name="jobPosition"
              placeholder="Eg: Software Engineer, Marketing Manager..."></td>
        </tr>
        <tr>
          <td><label for="jobType">Job Type:</label></td>
          <td>
            <select id="jobType" name="jobType" required>
              <option value="full-time">Full-time</option>
              <option value="part-time">Part-time</option>
              <option value="internship">Internship</option>
              <option value="freelance">Freelance</option>
              <option value="remote">Remote</option>
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
          <td><input type="text" id="requiredcertification" name="requiredcertification"
              placeholder="Eg: Bachelor of finance, none..." required></td>
        </tr>
        <tr>
          <td><label for="jobExperience">Job experience required:</label></td>
          <td><input type="text" id="jobExperience" name="jobExperience" placeholder="Eg: 1 year, 6 months, none..."
              required></td>
        </tr>
        <tr>
          <td><label for="jobRequirementText">Job Requirement:</label></td>
          <td>
            <textarea id="jobRequirementText" name="jobRequirementText" placeholder="Describe the job requirement"
              required></textarea>
          </td>
        </tr>
        <tr>
          <td><label for="jobBenefit">Job Benefit:</label></td>
          <td>
            <textarea id="jobBenefit" name="jobBenefit" placeholder="Describe the job benefit (optional)"></textarea>
          </td>
        </tr>
        <tr>
          <td><label for="companylogo">Company Logo:</label></td>
          <td><input type="file" id="companylogo" name="companylogo" accept="image/*"></td>
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

<script>
  function toggleCustomInput() {
    const select = document.getElementById('company_size_select');
    const customWrapper = document.getElementById('custom_input_wrapper');
    const hiddenInput = document.getElementById('company_size');

    if (select.value === 'other') {
      customWrapper.style.display = 'block';
      hiddenInput.value = ''; // chờ người dùng gõ
    } else {
      customWrapper.style.display = 'none';
      hiddenInput.value = select.value;
    }
  }

  function updateHiddenInput() {
    const customInput = document.getElementById('custom_company_size');
    const hiddenInput = document.getElementById('company_size');
    hiddenInput.value = customInput.value;
  }
</script>