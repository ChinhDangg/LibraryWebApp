// show and hide footer info
let footer_info = document.getElementsByClassName("footer_info");
let plus_sign = document.getElementsByClassName("plus_verticalLine");
let footer_which_state = [false, false, false];

function viewMoreInfoFooter(which_Col) {
    if (!window.matchMedia("(min-width: 768px)").matches) {
        let start = 0, end = 0;
        if (which_Col == 0) {
            start = 0;
            end = 1;
        }
        else if (which_Col == 1) {
            start = 1;
            end = 4;
        }
        else {
            start = 4;
            end = 7;
        }
        if (footer_which_state[which_Col]) { //hide footer info
            footer_which_state[which_Col] = !footer_which_state[which_Col];
            plus_sign[which_Col].style.transform = "rotate(180deg)";
            for (var j = start; j < end; j++)
                footer_info[j].style.display = "none";
        }
        else { //show footer info
            footer_which_state[which_Col] = !footer_which_state[which_Col];
            plus_sign[which_Col].style.transform = "rotate(90deg)";
            for (var j = start; j < end; j++)
                footer_info[j].style.display = "block";
        }
    }
}


