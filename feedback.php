<?php
include 'config.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
    $note = isset($_POST['note']) ? trim($_POST['note']) : '';

    if ($rating >= 1 && $rating <= 5) {
        $stmt = $pdo->prepare("INSERT INTO feedback (rating, note) VALUES (?, ?)");
        $stmt->execute([$rating, $note]);
        $message = "Cảm ơn bạn đã gửi phản hồi!";
    } else {
        $message = "Vui lòng chọn mức đánh giá từ 1 đến 5.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<title>Gửi Feedback với 5 ngôi sao</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f6f8;
    padding: 20px;
  }
  form {
    background: #fff;
    max-width: 450px;
    margin: 0 auto;
    padding: 25px 30px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
  }
  label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
    color: #333;
  }
  .stars {
  display: flex;
  flex-direction: row-reverse;
  justify-content: center;  /* canh giữa */
  margin-bottom: 20px;
}
  .stars input {
    display: none;
  }
  .stars label {
    cursor: pointer;
    font-size: 2rem;
    color: #ccc;
    transition: color 0.2s;
    padding: 0 5px;
  }
  .stars input:checked ~ label,
  .stars label:hover,
  .stars label:hover ~ label {
    color: #ffca08;
  }
  textarea {
    width: 100%;
    padding: 8px 10px;
    margin-bottom: 20px;
    border: 1.5px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
    resize: vertical;
    box-sizing: border-box;
    transition: border-color 0.3s;
  }
  textarea:focus {
    border-color: #007bff;
    outline: none;
  }
  button {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
    border: none;
    padding: 12px 25px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
  }
  button:hover {
    background-color: #0056b3;
  }
  p.message {
    max-width: 450px;
    margin: 0 auto 20px;
    padding: 12px 15px;
    border-radius: 5px;
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    font-weight: 600;
    text-align: center;
  }
  h1 {
            background-color: #e74c3c;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
</style>
<head>
</head>
<body>
    <?php
    include 'homepage/header.php';
    
    ?>
    <h1>Feedback</h1>
<?php if (!empty($message)): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="post" action="">
  <label>Đánh giá (1-5 sao):</label>
  <div class="stars">
    <input type="radio" id="star5" name="rating" value="5" />
    <label for="star5" title="5 sao">&#9733;</label>
    <input type="radio" id="star4" name="rating" value="4" />
    <label for="star4" title="4 sao">&#9733;</label>
    <input type="radio" id="star3" name="rating" value="3" />
    <label for="star3" title="3 sao">&#9733;</label>
    <input type="radio" id="star2" name="rating" value="2" />
    <label for="star2" title="2 sao">&#9733;</label>
    <input type="radio" id="star1" name="rating" value="1" />
    <label for="star1" title="1 sao">&#9733;</label>
  </div>

  <label>Ghi chú (tuỳ chọn):</label>
  <textarea name="note" rows="4" placeholder="Nhập góp ý của bạn..."></textarea>

  <button type="submit">Gửi Feedback</button>
</form>

</body>
</html>

</body>
<?php
    include 'homepage/footer.php';
    
    ?>
</html>
