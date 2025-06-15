// Sử dụng jQuery nếu bạn đang dùng jQuery ở các modal khác, nếu không thì dùng fetch API.
    // Tôi sẽ dùng jQuery cho đồng bộ với các ví dụ trước, nhưng fetch API cũng rất tốt.
    // Đảm bảo jQuery đã được tải trước script này.
    
    $(document).ready(function() {
        // Sử dụng event delegation vì các nút này được tải động qua Ajax
        $(document).on('click', '.remove-btn', function(event) {
            event.stopPropagation(); // Ngăn chặn sự kiện click nổi bọt lên phần tử cha (ví dụ: thẻ <a>)
            event.preventDefault(); // Ngăn chặn hành vi mặc định của nút

            const jobId = $(this).data('jobid');
            const jobseekerId = $(this).data('jobseekerid'); // Lấy jobseekerId từ nút

            if (confirm('Are you sure you want to remove this job from your saved list?')) {
                $.ajax({
                    url: 'jobseekerprofile/removesavedjobs.php', // Đường dẫn đến file xử lý xóa
                    method: 'POST',
                    data: {
                        job_id: jobId,
                        jobseeker_id: jobseekerId
                    },
                    dataType: 'json', // Mong đợi phản hồi JSON
                    success: function(response) {
                        if (response.success) {
                            alert('Job removed successfully!');
                            // Xóa phần tử job khỏi DOM
                            $('#saved-job-' + jobId).remove();
                            // Nếu không còn job nào, hiển thị thông báo
                            if ($('.saved-job-item').length === 0) {
                                $('.saved-jobs-container').html('<div style="color: #888;">No saved jobs found.</div>'); // Thay thế container bằng thông báo
                            }
                        } else {
                            alert('Error removing job: ' + response.message);
                            console.error('Remove saved job error:', response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Ajax error removing saved job:', error);
                        console.error('Full AJAX Error Response:', xhr.responseText);
                        alert('An error occurred while trying to remove the job.');
                    }
                });
            }
        });
    });