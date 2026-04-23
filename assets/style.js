function validateForm() {
    let name = document.forms["itemForm"]["name"].value;
    if (name.trim() == "") {
        alert("Item name is required");
        return false;
    }
    return true;
}