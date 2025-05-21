<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết tuyển dụng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .job-title {
            font-size: 24px;
            font-weight: bold;
        }

        .tag {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            margin-right: 10px;
        }

        .skill-tag {
            display: inline-block;
            background: #e0f3ff;
            color: #007bff;
            padding: 4px 8px;
            margin: 2px;
            border-radius: 4px;
            font-size: 13px;
        }

        .sidebar-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX load applyform.php -->
    <script>
        $(document).ready(function() {
            $('.apply-btn').on('click', function() {
                $('#applyModal').modal('show');
                $('#applyFormContent').load('applyform.php');
            });
        });
    </script>
</head>

<body>

    <header class="bg-danger text-white py-3">
        <div class="container">
            <?php require_once 'homepage/header.php' ?>
        </div>
    </header>
    <div>

    </div>
    <div class="container my-5">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8 mb-4">
                <div class="bg-white p-4 shadow rounded">
                    <div class="bg-white p-3 mb-4 shadow rounded ">
                        <h5 class="fw-bold">Senior Frontend Engineer (React/NextJS), StoreFront ECommerce Platform</h5>
                        <small class="text-muted">(Total Annual Compensation $55,000)</small>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4 d-flex align-items-center">
                                <i class="bi bi-currency-dollar me-2"></i> <strong>Mức lương</strong>
                            </div>
                            <div class="col-md-8 text-danger fw-bold">18 - 20 triệu</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 d-flex align-items-center">
                                <i class="bi bi-geo-alt me-2"></i> <strong>Địa điểm</strong>
                            </div>
                            <div class="col-md-8">65 Ngô Thì Nhậm, Hai Bà Trưng, Hà Nội</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 d-flex align-items-center">
                                <i class="bi bi-person-workspace me-2"></i> <strong>Kinh nghiệm</strong>
                            </div>
                            <div class="col-md-8">3 năm kinh nghiệm trở lên</div>
                        </div>
                        <div class="text-muted mb-3">
                            <i class="bi bi-calendar-event me-2"></i> Hạn nộp hồ sơ: 04/06/2025
                        </div>
                        <div class="d-flex gap-3">
                            <button class="btn btn-danger apply-btn">Apply Now</button>
                            <a href="#" id="save-job-btn" class="btn btn-secondary">
                            <span id="save-job-icon">&#9734;</span> Lưu tin</a>
                        </div>

                    </div>

                    <h2 class="text-danger mt-4">Chi tiết tuyển dụng</h2>
                    <p><strong>Chuyên môn:</strong> Fullstack Developer</p>
                    <p><strong>Ngành:</strong> IT - Phần mềm</p>
                    <p><strong>Lịch làm việc:</strong> Nghỉ thứ 7</p>

                    <h2 class="text-danger mt-4">Mô tả công việc</h2>
                    <p><strong>About the role:</strong></p>
                    <p>Join our Technology Innovations Center of Excellence (CoE) at Crossian...</p>

                    <ul>
                        <li>Design and develop scalable user interfaces using ReactJS and NextJS.</li>
                        <li>Optimize web performance and ensure cross-browser compatibility.</li>
                        <li>Implement SSR and CSR for seamless user experience.</li>
                    </ul>

                    <h2 class="text-danger mt-4">Yêu cầu ứng viên</h2>
                    <ul>
                        <li>Bachelor’s degree in IT, Computer Science or related fields</li>
                        <li>5+ years of experience in ReactJS, NextJS</li>
                        <li>Experience with Git, Agile, modern frontend tools</li>
                        <li>Understanding of accessibility, security, cross-browser compatibility</li>
                    </ul>

                    <h2 class="text-danger mt-4">Quyền lợi</h2>
                    <ul>
                        <li>Competitive salary: $55,000/year</li>
                        <li>13th month salary + performance-based bonus</li>
                        <li>Global health insurance, team building, flexible working time</li>
                    </ul>

                    <p><strong>Thời gian làm việc:</strong> Thứ 2 – Thứ 6 từ 08:30 đến 17:00</p>
                    <p><strong>Cách thức ứng tuyển:</strong> Ứng tuyển ngay hoặc lưu tin</p>

                    <div class="mt-3">
                        <button class="btn btn-danger apply-btn">Apply Now</button>
                        <a href="#" class="btn btn-secondary">Lưu tin</a>
                    </div>
                    <!-- Modal xử lý nút Apply-->
                    <div class="modal fade " id="applyModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" id="applyFormContent">
                                <!-- Nội dung form sẽ được load ở đây -->
                                <div class="modal-body text-center p-10">
                                    <div class="spinner-border" role="status"></div>
                                    <p>Đang tải form...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Việc làm liên quan -->
                <div class="bg-white p-4 shadow rounded mt-5">
                    <h4 class="text-danger">Việc làm liên quan</h4>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">Kỹ sư phát triển phần mềm - 800 - 3,500 USD</a>
                        <a href="#" class="list-group-item list-group-item-action">Lập trình viên Fullstack - 10 - 15 Triệu</a>
                        <a href="#" class="list-group-item list-group-item-action">FullStack Engineer Mid Level - 18 - 21 Triệu</a>
                        <a href="#" class="list-group-item list-group-item-action">Lập trình PHP - 10 - 15 Triệu</a>
                    </div>
                </div>
            </div>


            <!-- Right Column -->
            <div class="col-lg-4">
                <div class="bg-white p-3 mb-4 shadow rounded">
                    <div class="d-flex align-items-center mb-3">
                        <img src="image/logo1.png" alt="Logo công ty" class="me-3 rounded" style="width: 80px; height: 80px;">
                        <div class="sidebar-title mb-0">
                            <h4>Crossian</h4>
                            <p><strong>Quy mô:</strong> 100–499 nhân viên</p>
                            <p><strong>Lĩnh vực:</strong> Thương mại điện tử</p>
                            <p><strong>Địa chỉ:</strong> Tầng 1 Pax Sky, 63-65 Ngô Thì Nhậm, Hà Nội</p>

                        </div>
                    </div>

                </div>

                <div class="bg-white p-3 mb-4 shadow rounded">
                    <div class="sidebar-title">Thông tin chung</div>
                    <p><strong>Cấp bậc:</strong> Nhân viên</p>
                    <p><strong>Học vấn:</strong> Đại học trở lên</p>
                    <p><strong>Số lượng:</strong> 1 người</p>
                    <p><strong>Hình thức:</strong> Toàn thời gian</p>
                </div>

                <div class="bg-white p-3 mb-4 shadow rounded">
                    <div class="sidebar-title">Kỹ năng cần có</div>
                    <span class="skill-tag">HTML5</span>
                    <span class="skill-tag">CSS3</span>
                    <span class="skill-tag">React</span>
                    <span class="skill-tag">Next.js</span>
                    <span class="skill-tag">Javascript (es6+)</span>
                </div>

                <div class="bg-white p-3 shadow rounded">
                    <div class="sidebar-title">Địa điểm</div>
                    <span class="skill-tag">Hà Nội</span>
                    <span class="skill-tag">Hai Bà Trưng</span>
                </div>
            </div>
        </div>
    </div>
<script>
    // Giả sử mỗi job có một ID duy nhất, ở đây ví dụ là "job-123"
    const jobId = "job-123"; // Bạn nên lấy ID thực tế từ database hoặc URL

    // Kiểm tra trạng thái đã lưu khi load trang
    document.addEventListener('DOMContentLoaded', function () {
        const savedJobs = JSON.parse(localStorage.getItem('savedJobs') || '[]');
        if (savedJobs.includes(jobId)) {
            document.getElementById('save-job-icon').innerHTML = '★';
            document.getElementById('save-job-btn').classList.add('btn-danger');
            document.getElementById('save-job-btn').classList.remove('btn-secondary');
        }
    });

    // Xử lý khi click nút lưu
    document.getElementById('save-job-btn').addEventListener('click', function (e) {
        e.preventDefault();
        let savedJobs = JSON.parse(localStorage.getItem('savedJobs') || '[]');
        const icon = document.getElementById('save-job-icon');
        if (savedJobs.includes(jobId)) {
            // Bỏ lưu
            savedJobs = savedJobs.filter(id => id !== jobId);
            icon.innerHTML = '☆';
            this.classList.remove('btn-danger');
            this.classList.add('btn-secondary');
        } else {
            // Lưu tin
            savedJobs.push(jobId);
            icon.innerHTML = '★';
            this.classList.add('btn-danger');
            this.classList.remove('btn-secondary');
        }
        localStorage.setItem('savedJobs', JSON.stringify(savedJobs));
    });
</script>
</body>
<footer>
    <?php require_once 'homepage/footer.php' ?>
</footer>

</html>