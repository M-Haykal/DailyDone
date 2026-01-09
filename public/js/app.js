document.addEventListener("DOMContentLoaded", () => {
    const html = document.documentElement;
    const toggle = document.getElementById("theme-toggle");

    if (!toggle) return;

    // 1. Load theme dari localStorage
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme) {
        html.setAttribute("data-theme", savedTheme);
        toggle.checked = savedTheme === "dark";
    }

    // 2. Simpan theme saat toggle berubah
    toggle.addEventListener("change", (e) => {
        const theme = e.target.checked ? "dark" : "light";
        html.setAttribute("data-theme", theme);
        localStorage.setItem("theme", theme);
    });
});
