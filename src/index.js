let display_books = document.getElementsByClassName("row1");

for (let j = 0; j < (display_books.length-10)/2; j++) {
    // display_books[j].getElementsByTagName("img")[0].src = "";
    display_books[j].addEventListener('click', function(event) {
        console.log(j);
        //location.href = "";
    });
}

for (let j = (display_books.length-10)/2; j < (display_books.length-10)/2+5; j++) {
    // display_books[j].getElementsByTagName("img")[0].src = "";
    display_books[j].addEventListener('click', function(event) {
        console.log(j);
        //location.href = "";
    });
}

for (let j = (display_books.length-10)/2+5; j < display_books.length-5; j++) {
    // display_books[j].getElementsByTagName("img")[0].src = "";
    display_books[j].addEventListener('click', function(event) {
        console.log(j);
        //location.href = "";
    });
}

for (let j = display_books.length-5; j < display_books.length; j++) {
    // display_books[j].getElementsByTagName("img")[0].src = "";
    display_books[j].addEventListener('click', function(event) {
        console.log(j);
        //location.href = "";
    });
}

let trending = document.getElementsByClassName("trending_books");
for (let j = 0; j < trending.length; j++) {
    // trending[j].getElementsByTagName("img")[0].src = "";
    trending[j].addEventListener('click', function(event) {
        location.href = "";
    });
}

let picks = document.getElementsByClassName("pick_books");
for (let j = 0; j < picks.length; j++) {
    // picks[j].getElementsByTagName("img")[0].src = "";
    picks[j].addEventListener('click', function(event) {
        location.href = "";
    });
}
