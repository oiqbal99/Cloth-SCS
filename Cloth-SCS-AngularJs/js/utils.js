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

async function signOut() {
    await HTTPRequest.post("./api/auth.php", {
        function: "sign_out",
        callback: function () {
            location.reload();
        }
    });
}

function attemptEnableInvoiceProceed() {
    const val_ccnumber = $('#ccnumber').prop("value") ?? "";
    const val_cvvcvccode = $('#cvvcvccode').prop("value") ?? "";
    const val_cardholder = $('#cardholder').prop("value") ?? "";
    const val_instituteno =$('#instituteno').prop("value") ?? "";
    const can_proceed =
        val_ccnumber.length === 19 &&
        val_cvvcvccode.length === 3 &&
        val_cardholder.length > 0 &&
        val_instituteno.length === 3;
    $('#proceed-bttn').prop("disabled", !can_proceed);
}

function obfuscate_card_no(card_no_strg) {
    return `XXXX-XXXX-XXXX-${card_no_strg.substring(card_no_strg.length - 4)}`;
}