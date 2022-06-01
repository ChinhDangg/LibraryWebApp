let input_search = document.getElementById("input_book_search");
input_search.addEventListener('keyup', function(event) {
    if (event.key == "Enter") {
        find_Book();
    }
});

function submit_Book_Search() {
    find_Book();
}

function find_Book() {
    let search_info = input_search.value.toLowerCase();
    console.log(search_info);
}
