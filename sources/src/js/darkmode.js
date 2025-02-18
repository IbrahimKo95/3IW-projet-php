document.addEventListener("DOMContentLoaded", () => {
    const toggleDarkMode = document.getElementById("toggle-darkmode");
    if (!toggleDarkMode) return;

    const html = document.documentElement;

    if (localStorage.getItem("dark-mode") === "enabled") {
        html.classList.add("dark");
        setIcon();
    }

    toggleDarkMode.addEventListener("click", () => {
        html.classList.toggle("dark");
        setIcon();
        localStorage.setItem("dark-mode", html.classList.contains("dark") ? "enabled" : "disabled");
    });

    function setIcon() {
        if(html.classList.contains("dark")) {
            toggleDarkMode.querySelector("i").classList.add("fa-sun")
            toggleDarkMode.querySelector("i").classList.remove("fa-moon")
        } else {
            toggleDarkMode.querySelector("i").classList.add("fa-moon")
            toggleDarkMode.querySelector("i").classList.remove("fa-sun")
        }
    }
});
