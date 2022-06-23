let remove_copy = document.getElementsByClassName("remove1");
let add_copy = document.getElementsByClassName("add1");
for (let j = 0; j < remove_copy.length; j++) {
    remove_copy[j].addEventListener("click", function(event) {
        if (copies_change_list[j] != 0) {
            copies_change_list[j] = parseInt(copies_change_list[j]) - 1;
            let dif = copies_change_list[j] - copies_list[j];
            dif = (dif > 0) ? (" (+"+dif) : (dif != 0) ? (" ("+dif) : "";
            let changes = (dif != "") ? (dif + ")") : "";
            if (anyChanges())
                document.getElementById("confirm_remove_book_wrapper").style.display = "flex";
            else
                document.getElementById("confirm_remove_book_wrapper").style.display = "none";
            document.getElementsByClassName("book_copies")[j].innerText = copies_change_list[j] + changes;
        }
    });
    add_copy[j].addEventListener("click", function(event) {
        copies_change_list[j] = parseInt(copies_change_list[j]) + 1;
        let dif = copies_change_list[j] - copies_list[j];
        dif = (dif > 0) ? (" (+"+dif) : (dif != 0) ? (" ("+dif) : "";
        let changes = (dif != "") ? (dif + ")") : "";
        if (anyChanges())
                document.getElementById("confirm_remove_book_wrapper").style.display = "flex";
            else
                document.getElementById("confirm_remove_book_wrapper").style.display = "none";
        document.getElementsByClassName("book_copies")[j].innerText = copies_change_list[j] + changes;
    });
}

function anyChanges() {
    for (let j = 0; j < copies_change_list.length; j++) {
        if (copies_list[j] != copies_change_list[j])
            return true;
    }
    return false;
}

document.getElementById("confirm_remove_book_button").addEventListener("click", function(event) {
    let temp_copies_list = [].concat(copies_change_list);
    for (let j = 0; j < copies_change_list.length; j++) {
        if (copies_change_list[j] == copies_list[j])
            temp_copies_list[j] = 9999;
        else
            temp_copies_list[j] = temp_copies_list[j] - copies_list[j];
    }
    document.cookie = "isbnRemoveList="+isbn_list+"; max-age=7200; path=/";
    document.cookie = "copiesRemoveList="+temp_copies_list+"; max-age=7200; path=/";
});

if (window.history.replaceState ) {
    window.history.replaceState(null, null, window.location.href );
}