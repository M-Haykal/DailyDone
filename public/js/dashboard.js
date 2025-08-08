document
    .getElementById("projectSearch")
    .addEventListener("input", function (e) {
        const search = e.target.value.toLowerCase();
        document.querySelectorAll(".table tbody tr").forEach((row) => {
            const projectName = row
                .querySelector("td:first-child h6")
                .textContent.toLowerCase();
            row.style.display = projectName.includes(search) ? "" : "none";
        });
    });
