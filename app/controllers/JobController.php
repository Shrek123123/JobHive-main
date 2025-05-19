<!-- Các xử lý logic liên quan đến công việc -->
<!-- /app/controllers/JobController.php -->
<?php
include_once(__DIR__ . '/../models/Job.php');
include_once __DIR__ . '/../../config.php';

class JobController {

    // Xử lý tìm kiếm và hiển thị kết quả
    public function searchResults() {
    $keyword = $_GET['keyword'] ?? '';
    $job_id = $_GET['job_id'] ?? '';
    $location = $_GET['location'] ?? '';
    $company_name = $_GET['company_name'] ?? '';
    $minSalary = $_GET['minSalary'] ?? '';
    $maxSalary = $_GET['maxSalary'] ?? '';

    $sort_by = $_GET['sort_by'] ?? '';
    $category = $_GET['category'] ?? '';
    $experience = $_GET['experience'] ?? '';
    $job_type = $_GET['job_type'] ?? '';
    $remote = $_GET['remote'] ?? '';
    $industry = $_GET['industry'] ?? '';

    // Gọi model để lấy kết quả tìm kiếm
    $jobs = Job::searchJobs($keyword, $job_id, $location, $company_name, $minSalary, $maxSalary, $sort_by, $category, $experience, $job_type, $remote, $industry);

    include __DIR__ . '/../views/job/search_result.php';
    }
    // Hiển thị Quick Search form
    public function quickSearch() {
        include __DIR__ . '/../views/job/quick_search.php';
    }

    // Xử lý Quick Search và show chung search_result.php
    public function quickResults() {
        // Lấy 3 param từ GET
        $location = $_GET['location']       ?? '';
        $category = $_GET['category']       ?? '';
        $job_type = $_GET['job_type']       ?? '';

        // Gọi model với chỉ 3 filter, các param khác để trống
        $jobs = Job::searchJobs(
            /*keyword*/   '',
            /*job_id*/    '',
            /*location*/  $location,
            /*company*/   '',
            /*minSalary*/ '',
            /*maxSalary*/ '',
            /*sort_by*/   '',
            /*category*/  $category,
            /*experience*/'',
            /*job_type*/  $job_type,
            /*remote*/    '',
            /*industry*/  ''
        );

        include __DIR__ . '/../views/job/search_result.php';
    }

    // thêm method tìm kiếm nâng cao
    public function advancedSearch() {
    include __DIR__ . '/../views/job/advanced_search.php';
    exit;
}


}
?>
