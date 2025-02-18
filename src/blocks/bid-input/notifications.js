export function showNotification(message, type = "success", duration = 5000) {
    const notification = document.getElementById("notification");
    if (!notification) return;
    
    notification.textContent = message;
    notification.classList.remove("success", "error");
    notification.classList.add(type);
    notification.style.visibility = "visible";

    // ✅ Jei jau veikia kitas `setTimeout()`, jį sustabdome
    if (window.notificationTimeout) {
        clearTimeout(window.notificationTimeout);
    }

    // ✅ Nustatome naują `setTimeout()` ir išsaugome jo ID
    window.notificationTimeout = setTimeout(() => {
        notification.style.visibility = "hidden";
        window.notificationTimeout = null; // Išvalome ID
    }, duration);
}
