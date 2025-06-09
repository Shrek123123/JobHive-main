<!-- Các xử lý logic liên quan đến công việc -->


<?php
include_once(__DIR__ . '/../models/Job.php');
include_once __DIR__ . '/../../config.php';

class JobController {
    // Xử lý tìm kiếm và hiển thị kết quả (đã thêm phân trang)
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

    // Nhận các tham số để thực hiện quá trình phân trang
    // page là trang hiện tại; perPage là số bản ghi max mỗi trang; offset vị trí hiện tại hay vị trí bắt đầu lấy dữ liệu
    $page     = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
            ? (int)$_GET['page']
            : 1;                    // nếu không có hoặc không hợp lệ → trang 1
    $perPage  = 3;                           // muốn hiển thị 10 job/trang
    $offset   = ($page - 1) * $perPage;       // bỏ qua (page-1)*perPage bản ghi

    // Đếm tổng số kết quả để tính tổng trang cần chia
    $totalItems = Job::countJobs(
            $keyword, $job_id, $location, $company_name,
            $minSalary, $maxSalary, $sort_by, $category,
            $experience, $job_type, $remote, $industry
        );
    $totalPages = (int) ceil($totalItems / $perPage); // ép kiểu int

    // Gọi model lấy đúng các bản dữ liệu thỏa mãn cho trang hiện tại 
    // truyền thêm limit, offset để thuận tiện gọi trong SQL
    $jobs = Job::searchJobs(
            $keyword, $job_id, $location, $company_name,
            $minSalary, $maxSalary, $sort_by, $category,
            $experience, $job_type, $remote, $industry,
            $perPage, $offset       // chỉ lấy $perPage bản ghi, bỏ qua $offset
        );
    // Đẩy các dữ liệu và biến phân trang xuống view 
    // View sẽ dùng $jobs, $page, $totalPages để vẽ widget phân trang
    include __DIR__ . '/../views/job/search_result.php';
    }
    // Hiển thị Quick Search form 
    public function quickSearch() {
        include __DIR__ . '/../views/job/quick_search.php';
    }

    // Xử lý Quick Search với phân trang tương tự searchResults
    public function quickResults() {
        // 1. Lấy filter chính từ URL để tiện phân trang
        $keyword  = $_GET['keyword']  ?? '';
        $location = $_GET['location'] ?? '';
        $category = $_GET['category'] ?? '';
        $job_type = $_GET['job_type'] ?? '';

        // 2. Nhận tham số phân trang
        $page     = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
                    ? (int)$_GET['page']
                    : 1;
        $perPage  = 3;
        $offset   = ($page - 1) * $perPage;

        // 3. Đếm tổng để chia trang
        $totalItems = Job::countJobs(
            '', '', $location, '', '', '', '', $category,
            '', $job_type, '', ''
        );
        $totalPages = (int) ceil($totalItems / $perPage);

        // 4. Lấy dữ liệu có phân trang
        $jobs = Job::searchJobs(
            '', '', $location, '', '', '', '', $category,
            '', $job_type, '', '',
            $perPage, $offset
        );

        // 5. Gọi view với biến phân trang
        include __DIR__ . '/../views/job/search_result.php';
    }


    // thêm method tìm kiếm nâng cao
    public function advancedSearch() {
    include __DIR__ . '/../views/job/advanced_search.php';
    exit;
    }
}
?>
