<!-- Xử lý tương tác với cơ sở dữ liệu -->

<?php
class Job
{
    /**
     * Tìm kiếm công việc với filter và phân trang
     *
     * @param string $keyword       Từ khóa tìm kiếm (job_title hoặc description)
     * @param int    $job_id        ID công việc
     * @param string $job_location      Địa điểm
     * @param string $company_name  Tên công ty
     * @param float  $minSalary     Mức lương tối thiểu
     * @param float  $maxSalary     Mức lương tối đa
     * @param string $sort_by       Sắp xếp (date|salary)
     * @param string $job_category      Chuyên mục
     * @param string $experience    Kinh nghiệm
     * @param string $job_type      Loại công việc
     * @param string $remote        Remote hay không
     * @param string $industry      Ngành nghề
     * @param int    $limit         Giới hạn lấy số bản ghi lấy ra (phân trang)
     * @param int    $offset        Bỏ qua bao nhiêu bản ghi (phân trang), hay có thể gọi là trang hiện tại
     * @return array                Mảng kết quả công việc
     */

    // dưới đây tạo 1 method tĩnh cho hàm searchJobs, không cần dùng hướng đối tượng, thì sẽ tiện hơn trong quá trình gọi
    public static function searchJobs(
        $keyword,
        $job_id,
        $job_location,
        $company_name,
        $minSalary,
        $maxSalary,
        $sort_by,
        $job_category,
        $experience,
        $job_type,
        $remote,
        $industry,
        $limit = null,
        $offset = null
    ) {
        global $conn;
        // 1) Xây dựng query đảm nhiệm tìm kiếm
        $sql = "SELECT * FROM job WHERE 1";
        if ($keyword)        $sql .= " AND (job_title LIKE '%$keyword%' OR description LIKE '%$keyword%')";
        if ($job_id)         $sql .= " AND id = " . intval($job_id);
        if ($job_location)       $sql .= " AND job_location LIKE '%$job_location%'";
        if ($company_name)   $sql .= " AND company_name LIKE '%$company_name%'";
        if ($minSalary)      $sql .= " AND salary >= " . floatval($minSalary);
        if ($maxSalary)      $sql .= " AND salary <= " . floatval($maxSalary);
        if ($job_category)       $sql .= " AND job_category = '$job_category'";
        if ($experience)     $sql .= " AND experience_level = '$experience'";
        if ($job_type)       $sql .= " AND job_type = '$job_type'";
        if ($remote)         $sql .= " AND remote = '$remote'";
        if ($industry)       $sql .= " AND industry LIKE '%$industry%'";

        // 2) Thêm ORDER BY để làm logic phân trang
        if ($sort_by === 'date') {
            $sql .= " ORDER BY created_at DESC";
        } elseif ($sort_by === 'salary') {
            $sql .= " ORDER BY salary DESC";
        }

        // 3) PHÂN TRANG: chỉ thêm LIMIT/OFFSET khi controller truyền vào
        if ($limit !== null && $offset !== null) {
            // ép kiểu đúng để tránh injection 
            $l = intval($limit);
            $o = intval($offset);
            $sql .= " LIMIT $l OFFSET $o";
        }

        // 4) Chạy và trả về kết quả
        $result = $conn->query($sql)
            or die("<pre>MySQL Error: " . $conn->error . "</pre>");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Đếm tổng số job thỏa mãn filter (để tính tổng trang)
     *
     * @param string $keyword
     * @param int    $job_id
     * @param string $job_location
     * @param string $company_name
     * @param float  $minSalary
     * @param float  $maxSalary
     * @param string $sort_by    (không dùng trong COUNT)
     * @param string $job_category
     * @param string $experience
     * @param string $job_type
     * @param string $remote
     * @param string $industry
     * @return int               Tổng số bản ghi
     */
    public static function countJobs(
        $keyword,
        $job_id,
        $job_location,
        $company_name,
        $minSalary,
        $maxSalary,
        $sort_by,
        $job_category,
        $experience,
        $job_type,
        $remote,
        $industry
    ) {
        global $conn;
        // 1) Câu COUNT(*) giống y phần WHERE ở trên
        $sql = "SELECT COUNT(*) AS total FROM job WHERE 1";
        if ($keyword)        $sql .= " AND (job_title LIKE '%$keyword%' OR description LIKE '%$keyword%')";
        if ($job_id)         $sql .= " AND id = " . intval($job_id);
        if ($job_location)       $sql .= " AND job_location LIKE '%$job_location%'";
        if ($company_name)   $sql .= " AND company_name LIKE '%$company_name%'";
        if ($minSalary)      $sql .= " AND salary >= " . floatval($minSalary);
        if ($maxSalary)      $sql .= " AND salary <= " . floatval($maxSalary);
        if ($job_category)       $sql .= " AND job_category = '$job_category'";
        if ($experience)     $sql .= " AND experience_level = '$experience'";
        if ($job_type)       $sql .= " AND job_type = '$job_type'";
        if ($remote)         $sql .= " AND remote = '$remote'";
        if ($industry)       $sql .= " AND industry LIKE '%$industry%'";

        // 2) Chạy query và lấy tổng
        $res = $conn->query($sql)
            or die("<pre>MySQL Error: " . $conn->error . "</pre>");
        $row = $res->fetch_assoc();
        return (int)$row['total'];
    }

    public static function findById($id, $conn)
    {
        $stmt = $conn->prepare("SELECT * FROM job WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 2. Lấy skills của job
    public static function getSkills($id, $conn)
    {
        $stmt = $conn->prepare("
          SELECT s.name
          FROM skill s
          JOIN job_skill js ON s.id = js.skill_id
          WHERE js.job_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $out = [];
        while ($r = $res->fetch_assoc()) {
            $out[] = $r['name'];
        }
        return $out;
    }
}
?>