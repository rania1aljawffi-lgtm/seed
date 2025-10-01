<?php
require 'db.php';
if (!empty($_SESSION['user'])) {
    header('Location: products.php');
    exit;
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'املأ البيانات';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            // تسجيل الدخول
            $_SESSION['user'] = ['id'=>$user['id'], 'fullname'=>$user['fullname'], 'email'=>$user['email']];
            header('Location: products.php');
            exit;
        } else {
            $errors[] = 'خطأ في البريد أو كلمة المرور';
        }
    }
}
include 'header.php';
?>
<h2>تسجيل دخول</h2>
<div class="form-card">
  <?php if($errors): ?><div class="alert"><?php echo implode('<br>', array_map('htmlspecialchars',$errors)); ?></div><?php endif; ?>
  <form method="post" action="login.php">
    <input class="input" type="email" name="email" placeholder="البريد الإلكتروني" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
    <input class="input" type="password" name="password" placeholder="كلمة المرور">
    <button class="btn" type="submit">دخول</button>
  </form>
  <p>ليس لديك حساب؟ <a href="register.php">إنشاء حساب</a></p>
</div>
<?php include 'footer.php'; ?>