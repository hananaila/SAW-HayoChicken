document.addEventListener("DOMContentLoaded", function () {
    console.log("Sistem SPK Hayo Chicken Loaded Succesfully!");

    // Contoh script untuk auto-dismiss alert (jika nanti ditambahkan notifikasi sukses)
    const alerts = document.querySelectorAll('.alert-message');
    alerts.forEach(function (alert) {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000);
    });
});