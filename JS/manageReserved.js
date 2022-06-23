let time_input = document.getElementsByClassName("book_due_time");
let time_due_changes = [];
for (let j = 0; j < time_input.length; j++) {
    time_input[j].addEventListener("change", function(event) {
        if (Math.abs(due_time_list[j] - Date.parse(this.value)/1000) > 59)
            time_due_changes[j] = Date.parse(this.value)/1000;
        else
            time_due_changes[j] = "";
        if (anyChanges())
            document.getElementById("confirm_remove_book_wrapper").style.visibility = "visible";
        else
            document.getElementById("confirm_remove_book_wrapper").style.visibility = "hidden";
    });
}

let remove_input = document.getElementsByClassName("remove_reserved_checkbox");
let remove_reserved_changes = [];
for (let j = 0; j < remove_input.length; j++) {
    remove_input[j].addEventListener("change", function(event) {
        if (this.checked == true)
            remove_reserved_changes[j] = "rem";
        else
            remove_reserved_changes[j] = "";
        if (anyChanges())
            document.getElementById("confirm_remove_book_wrapper").style.visibility = "visible";
        else
            document.getElementById("confirm_remove_book_wrapper").style.visibility = "hidden";
    });
}

function anyChanges() {
    for (let j = 0; j < remove_reserved_changes.length; j++)
        if (remove_reserved_changes[j] !== undefined && remove_reserved_changes[j] == "rem")
            return true;
    for (let j = 0; j < time_due_changes.length; j++)
        if (time_due_changes[j] !== undefined && time_due_changes[j] != "")
            return true;
    return false;
}

document.getElementById("confirm_remove_book_wrapper").addEventListener("click", function(event) {
    document.cookie = "reservedIDList="+borrow_book_id+"; max-age=7200; path=/";
    document.cookie = "reservedDueList="+time_due_changes+"; max-age=7200; path=/";
    document.cookie = "reservedRemoveList="+remove_reserved_changes+"; max-age=7200; path=/";
});

if (window.history.replaceState ) {
    window.history.replaceState(null, null, window.location.href );
}