let book_status_button = document.getElementsByClassName("book_status_option_wrapper");
let book_status_changes = [];
for (let j = 0; j < book_status_button.length; j++) {
    book_status_button[j].addEventListener("click", function(event) {
        let current_book_status = document.getElementsByClassName("book_status")[j];
        if (current_book_status.innerHTML == "Not Pickup") {
            current_book_status.innerHTML = "Borrowed";
            book_status_changes[j] = "Borrowed";
        }
        else if (current_book_status.innerHTML == "Borrowed") {
            current_book_status.innerHTML = "Returned";
            book_status_changes[j] = "Ret";
        }
        else {
            current_book_status.innerHTML = "Not Pickup";
            book_status_changes[j] = "Not Pickup";
        }
        if (anyChanges())
            document.getElementById("confirm_remove_book_wrapper").style.visibility = "visible";
        else
            document.getElementById("confirm_remove_book_wrapper").style.visibility = "hidden";
    });
}

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

function anyChanges() {
    for (let j = 0; j < book_status_changes.length; j++)
        if (book_status_list[j] != book_status_changes[j])
            return true;
    for (let j = 0; j < time_due_changes.length; j++)
        if (time_due_changes[j] !== undefined && time_due_changes[j] != "")
            return true;
    return false;
}

document.getElementById("confirm_remove_book_wrapper").addEventListener("click", function(event) {
    document.cookie = "borrowIDList="+borrow_book_id+"; max-age=7200; path=/";
    document.cookie = "bookStatusList="+book_status_changes+"; max-age=7200; path=/";
    document.cookie = "bookDueList="+time_due_changes+"; max-age=7200; path=/";
});


if (window.history.replaceState ) {
    window.history.replaceState(null, null, window.location.href );
}