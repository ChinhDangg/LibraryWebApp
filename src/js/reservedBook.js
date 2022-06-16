let currentSelected = -1;
function selectBook(element) {
    let which = document.getElementsByClassName("reserved_book_wrapper");
    for (let j = 0; j < which.length; j++) {
        if (which[j] == element) {
            if (which[j].style.backgroundColor == "") {
                currentSelected = j;
                which[j].style.backgroundColor = "rgb(120,120,120)";
                document.getElementsByClassName("reserved_book_img_wrapper")[j].style.opacity = "0.5";
                document.getElementsByClassName("reserved_book_wrapper")[j].style.color = "white";
            }
            else { //unselected
                currentSelected = -1;
                which[j].style.backgroundColor = "";
                document.getElementsByClassName("reserved_book_img_wrapper")[j].style.opacity = "1.0";
                document.getElementsByClassName("reserved_book_wrapper")[j].style.color = "black";
                break;
            }
        }
        else if (which[j].style.backgroundColor != "") {
            which[j].style.backgroundColor = "";
            document.getElementsByClassName("reserved_book_img_wrapper")[j].style.opacity = "1.0";
            document.getElementsByClassName("reserved_book_wrapper")[j].style.color = "black";
        }
    }
    if (currentSelected != -1) {
        if (availability[currentSelected] == 1) 
            document.getElementById("book_option").value = "Add to Book List";
        else
            document.getElementById("book_option").value = "Remove";
        document.getElementById("book_option").style.display = "block";
    }
    else
        document.getElementById("book_option").style.display = "none";
    document.cookie = "selectedReservedBook="+reservedBookID[currentSelected]+"; max-age=3600; path=/";
}

document.getElementById("view_book_info_icon").addEventListener("click", function(event) {
    let reserved_view_more = document.getElementById("reserved_view_more_style");
    if (reserved_view_more.media == "none")
        reserved_view_more.media = "";
    else
        reserved_view_more.media = "none";
});

document.getElementById("book_option").addEventListener("click", function(event) {
    reservedBookID.splice(currentSelected, 1);
    availability.splice(currentSelected, 1);
    document.getElementsByClassName("reserved_book_wrapper")[currentSelected].remove();
});

if (window.history.replaceState ) {
    window.history.replaceState(null, null, window.location.href );
}