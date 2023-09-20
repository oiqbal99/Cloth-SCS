function toggleMenu() {
    const menuNode = document.getElementById("menu-container");
    menuNode.style.display = menuNode.style.display === "none" ? "block" : "none";
}

function onPassChange() {  
    const password = document.querySelector("input[name=password]");
    const password_conf = document.querySelector("input[name=password_conf]");

    if (password && password_conf) {
        if (password.value === password_conf.value) {
            password_conf.setCustomValidity('');
            return true;
        }
        password_conf.setCustomValidity('Passwords do not match');
        return false;
    }
    return false;
}

function verifyAdminCode() {
    if (prompt("Admin Code:") !== "123chicken123") {
        alert("Incorrect Admin Code");
        return false;
    }
    return true;
}