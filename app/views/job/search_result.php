<?php
// Nhận các biến từ controller:
// $jobs (mảng job trang hiện tại),
// $totalItems (tổng số job),
// $page (trang hiện tại),
// $totalPages (tổng số trang),
// $keyword, $location, $category, $job_type (filter)
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả tìm kiếm việc làm</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .job { border: 1px solid #ccc; padding: 10px; margin-bottom: 15px; border-radius: 6px; }
        .job h3 { margin-top: 0; }
        .pagination { list-style: none; padding: 0; display: flex; gap: 5px; }
        .pagination li { display: inline; }
        .pagination a, .pagination span { padding: 5px 10px; text-decoration: none; border: 1px solid #ccc; border-radius: 4px; }
        .pagination .active span { background-color: #007bff; color: #fff; border-color: #007bff; }
        .pagination .disabled span { color: #999; border-color: #ddd; }
        .job-tabs { margin-bottom: 20px; display: flex; gap: 10px; }
        .job-tabs a { padding: 8px 12px; text-decoration: none; border-radius: 4px; border: 1px solid #ccc; }
        .job-tabs a.active { background-color: #007bff; color: #fff; border-color: #007bff; }
    </style>
</head>
<body>
    <h1>Kết quả tìm kiếm</h1>

    <!-- Tạo UI tabs để chọn category tại thanh nav bar-->
    <?php
    $tabs = [
        'Tất cả'                    => '',
        'IT & Software'             => 'IT & Software',
        'Marketing'                 => 'Marketing',
        'Finance'                   => 'Finance',
        'Healthcare'                => 'Healthcare',
        'Government & Public Sector'=> 'Government & Public Sector'
    ];
    $currentCat = $_GET['category'] ?? '';

    // Mảng chung các filter để build URL phân trang
    $baseParams = [
        'action'   => $_GET['action']   ?? 'searchResults',
        'keyword'  => $_GET['keyword']  ?? '',
        'location' => $_GET['location'] ?? '',
        'category' => $currentCat,
        'job_type' => $_GET['job_type'] ?? ''
    ];
    function buildUrl(array $params): string {
        return '?' . http_build_query($params);
    }
    ?>
    <nav class="job-tabs">
        <?php foreach($tabs as $label => $val):
            // Clone và gán page=1 khi đổi tab
            $params = $baseParams;
            $params['category'] = $val;
            $params['page'] = 1;
            $url = buildUrl($params);
            $active = ($val === $currentCat) ? 'active' : '';
        ?>
            <a href="<?= $url ?>" class="<?= $active ?>"><?= $label ?></a>
        <?php endforeach; ?>
    </nav>

    <?php if (!empty($jobs)): ?>
        <p>Đã tìm thấy <strong><?= $totalItems ?></strong> công việc phù hợp:</p>
        <?php foreach ($jobs as $job): ?>
            <div class="job">
                <h3><?= htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p><strong>Công ty:</strong> <?= htmlspecialchars($job['company_name'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Lương:</strong> <?= htmlspecialchars($job['salary'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Vị trí:</strong> <?= htmlspecialchars($job['location'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Loại hình:</strong> <?= htmlspecialchars($job['job_type'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Kinh nghiệm:</strong> <?= htmlspecialchars($job['experience_level'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Ngành nghề:</strong> <?= htmlspecialchars($job['industry'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        <?php endforeach; ?>

        <!-- Pagination giữ nguyên category -->
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Trang">
                <ul class="pagination">
                    <!-- Prev -->
                    <?php if ($page > 1):
                        $prev = $baseParams;
                        $prev['page'] = $page - 1;
                    ?>
                        <li><a href="<?= buildUrl($prev) ?>">&lsaquo; Prev</a></li>
                    <?php else: ?>
                        <li class="disabled"><span>&lsaquo; Prev</span></li>
                    <?php endif; ?>

                    <!-- Pages -->
                    <?php
                    $start = max(1, $page - 2);
                    $end   = min($totalPages, $page + 2);
                    for ($i = $start; $i <= $end; $i++):
                        if ($i === $page):
                    ?>
                            <li class="active"><span><?= $i ?></span></li>
                        <?php else:
                            $p = $baseParams;
                            $p['page'] = $i;
                        ?>
                            <li><a href="<?= buildUrl($p) ?>"><?= $i ?></a></li>
                        <?php endif;
                    endfor;
                    ?>

                    <!-- Next -->
                    <?php if ($page < $totalPages):
                        $next = $baseParams;
                        $next['page'] = $page + 1;
                    ?>
                        <li><a href="<?= buildUrl($next) ?>">Next &rsaquo;</a></li>
                    <?php else: ?>
                        <li class="disabled"><span>Next &rsaquo;</span></li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>

    <?php else: ?>
        <p>Không tìm thấy công việc nào phù hợp với tiêu chí bạn đã nhập.</p>
    <?php endif; ?>

    <p><a href="index.php?action=home">← Quay lại</a></p>
</body>
</html>
