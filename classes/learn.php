<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if there is a flash message in session
if (isset($_SESSION['flash_message'])):
    $type = $_SESSION['flash_type'] ?? 'info'; // success, danger, warning, info
    $message = $_SESSION['flash_message'];

    // Remove from session after showing once
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
?>
<div id="flashMessage" class="alert alert-<?= $type ?> position-fixed top-0 start-50 translate-middle-x mt-3 shadow" style="z-index: 1050; display: none;">
    <?= htmlspecialchars($message) ?>
</div>

<script>
    // Show flash message
    const flash = document.getElementById('flashMessage');
    flash.style.display = 'block';

    // Auto-hide after 3 seconds
    setTimeout(() => {
        flash.style.transition = 'opacity 0.5s';
        flash.style.opacity = '0';
        setTimeout(() => flash.remove(), 500); // remove from DOM
    }, 3000);
</script>
<?php endif; ?>
