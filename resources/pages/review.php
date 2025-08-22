<?php
    $title = "Book Now";
    include __DIR__ . '/head.php';
    include __DIR__ . '/navbar.php';
?>

<h1>Drop Us Your Review</h1>

<?php
if (session('success')) {
    echo '<p style="color:green;">' . session('success') . '</p>';
}
?>

<form method="POST" action="/review">
    <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
    <p>
        <label>Name:</label><br>
        <input type="text" name="name" required>
    </p>
    <p>
        <label>Email:</label><br>
        <input type="email" name="email" required>
    </p>
    <p>
        <label>Message:</label><br>
        <textarea name="message" required></textarea>
    </p>
    <button type="submit">Submit</button>
</form>

<?php include __DIR__ . '/footer.php'; ?>