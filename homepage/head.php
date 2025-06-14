<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<style>
  body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    color: #000;
  }

  .section-1 {
    background: linear-gradient(to right, #c31432, #240b36);
  }

  .container {
    max-width: 1100px;
    margin: auto;
    padding: 40px 20px;
  }

  .title {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
  }

  .subtitle {
    text-align: center;
    margin-top: 5px;
    font-size: 14px;
    color: #ddd;
  }

  .search-box {
    margin-top: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;

  }

  .search-box input,
  .search-box select {
    padding: 10px;
    border-radius: 8px;
    border: none;
    min-width: 220px;
  }

  .search-box button {
    background-color: #c4002f;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
  }

  .main-content {
    display: flex;
    margin-top: 30px;
    gap: 20px;
    flex-wrap: wrap;
  }

  .left-menu {
    flex: 1;
    min-width: 200px;
    background: white;
    color: black;
    border-radius: 10px;
    padding: 20px;
  }

  .left-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .left-menu li {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
    cursor: pointer;
  }

  .right-banner {
    flex: 3;
    min-width: 300px;
  }

  .right-banner img {
    width: 100%;
    border-radius: 10px;
  }

  .job-section {
    background-color: #f9f5f5;
    padding: 40px 20px;
    border-radius: 10px;
    background-color: #eee;
    margin: 10px;
  }

  .job-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #660000;
  }

  .job-filters {
    margin: 20px 0;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }

  .job-filters button {
    padding: 8px 15px;
    border: none;
    border-radius: 20px;
    background-color: #eee;
    color: #333;
    cursor: pointer;
  }

  .job-filters button.active {
    background-color: #d70018;
    color: white;
    font-weight: bold;
  }

  .sort-dropdown button {
    background-color: #e0e0e0;
    border: none;
    border-radius: 8px;
    padding: 8px 12px;
    cursor: pointer;
  }

  .job-listings {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
  }

  .job-card {
    background-color: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    color: #333;
  }

  .job-card .job-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .circle-logo {
    background-color: #888;
    color: white;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    text-align: center;
    line-height: 32px;
    font-weight: bold;
  }

  .job-card p {
    margin: 4px 0;
    font-size: 14px;
  }

  .pagination {
    margin-top: 30px;
    text-align: center;
  }

  .pagination .dot {
    height: 10px;
    width: 10px;
    margin: 0 4px;
    background-color: #ccc;
    border-radius: 50%;
    display: inline-block;
  }

  .pagination .dot.active {
    background-color: #d70018;
  }

  .section-3 {
    background-color: #f9f5f5;
    padding: 40px 20px;
    border-radius: 10px;
    background-color: #eee;
    margin: 10px;
  }

  .section-3 .container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
  }

  .section-3 .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .section-3 h2 {
    font-size: 24px;
    font-weight: bold;
    color: #000;
  }

  .section-3 .view-all {
    color: #c00;
    text-decoration: none;
    font-weight: bold;
  }

  .logos {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 20px 0;
    gap: 20px;
  }

  .logos img {
    max-height: 60px;
    object-fit: contain;
  }

  .section-4 {
    background-color: #f9f5f5;

  } */

  .info {
    background-color: #f9f5f5;
    
  }
  
  .section-4 h3 {
    font-size: 20px;
    font-weight: bold;
    margin-top: 30px;
  }

  .section-4 ul {
    list-style: disc;
    margin-left: 20px;
  }

  .hotline {
    background-color: #f8f8f8;
    padding: 30px 0;
    border-top: 1px solid #ccc;
    margin-top: 40px;
  }

  .hotline .container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 30px;
  }

  .hotline-box {
    flex: 1;
    min-width: 300px;
  }

  .hotline-box h4 {
    color: #c00;
    font-size: 18px;
    margin-bottom: 10px;
  }

  .hotline-detail p {
    margin: 10px 0;
  }

  .hotline-detail button {
    background-color: #e00;
    color: white;
    border: none;
    padding: 10px 16px;
    margin-top: 10px;
    border-radius: 5px;
    cursor: pointer;
  }

  .hotline-detail .btn-recruiter {
    background-color: #900;
  }
</style>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const form = document.querySelector('form.search-box');
  if (!form) return;

  form.addEventListener('submit', function(e){
    e.preventDefault();  // Ngăn trình duyệt submit mặc định
    // Lấy tất cả field của form
    const params = new URLSearchParams(new FormData(form)).toString();
    // Chuyển hướng thủ công
    window.location.href = `/JobHive-main/index.php?action=quickResults&${params}`;
  });
});
</script>


