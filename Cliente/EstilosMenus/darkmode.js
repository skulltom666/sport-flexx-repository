<<<<<<< HEAD
//Código para activar modo oscuro, cambiar iconos y guardar la preferencia para mejorar la experiencia del usuario.
=======
>>>>>>> 32e3d80d3556459344c244bf111247af7d11e2bb
document.getElementById("darkModeToggle").addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");
    const icon = document.getElementById("darkModeIcon");
    if (document.body.classList.contains("dark-mode")) {
        icon.classList.remove("fa-moon");
        icon.classList.add("fa-sun");
        localStorage.setItem('theme', 'dark'); 
    } else {
        icon.classList.remove("fa-sun");
        icon.classList.add("fa-moon");
        localStorage.setItem('theme', 'light');
    }
});

window.onload = function () {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        document.body.classList.add('dark-mode');
        document.getElementById("darkModeIcon").classList.remove("fa-moon");
        document.getElementById("darkModeIcon").classList.add("fa-sun");
    }
};
