document.getElementById("login-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    var userType = document.getElementById("user-type").value;

    if (userType === "Designer") {
        window.location.href = "DesignerHomePage.html";
    } else if (userType === "client") {
        window.location.href = "ClientHomePage.html";
    }
});