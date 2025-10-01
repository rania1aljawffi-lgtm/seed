<?php
require 'db.php';
if (!empty($_SESSION['user'])) {
    header('Location: products.php');
    exit;
}

$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $email    = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $phone    = isset($_POST['phone']) ? trim($_POST['phone']) : '';

    if ($fullname === ''   $email === ''  $password === '') {
        $errors[] = 'املأ الحقول المطلوبة';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'البريد الإلكتروني غير صالح';
    } else {
        // تحقق إن لم يكن المستخدم موجودًا
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute(array($email));
        if ($stmt->fetch()) {
            $errors[] = 'الإيميل مسجل مسبقاً';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (fullname, email, password, phone) VALUES (?, ?, ?, ?)');
            $stmt->execute(array($fullname, $email, $hash, $phone));
            $id = $pdo->lastInsertId();
            $_SESSION['user'] = array('id'=>$id, 'fullname'=>$fullname, 'email'=>$email);
            header('Location: products.php');
            exit;
        }
    }
}

include 'header.php';
?>
<h2>إنشاء حساب</h2>
<div class="form-card">
  <?php if(!empty($errors)): ?>
    <div class="alert"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
  <?php endif; ?>
  <form method="post" action="register.php">
    <input class="input" type="text" name="fullname" placeholder="الاسم الكامل" value="<?php echo htmlspecialchars(isset($_POST['fullname'])?$_POST['fullname']:''); ?>">
    <input class="input" type="email" name="email" placeholder="البريد الإلكتروني" value="<?php echo htmlspecialchars(isset($_POST['email'])?$_POST['email']:''); ?>">
    <input class="input" type="password" name="password" placeholder="كلمة المرور">
    <input class="input" type="text" name="phone" placeholder="الهاتف (اختياري)" value="<?php echo htmlspecialchars(isset($_POST['phone'])?$_POST['phone']:''); ?>">
    <button class="btn" type="submit">إنشاء الحساب</button>
  </form>
</div>
<?php include 'footer.php'; ?>