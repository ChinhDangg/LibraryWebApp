<?php
    echo '
    <footer>
        <div id="footer_wrapper">
            <div class="footer_col">
                <div onclick="viewMoreInfoFooter(0)">
                    <h3>Info</h3>
                    <div class="more_info_smallscreen">
                        <div>
                            <span class="plus_verticalLine"></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <a class="footer_info" href="">About Us</a>
            </div>
            <div class="footer_col">
                <div onclick="viewMoreInfoFooter(1)">
                    <h3>Contact</h3>
                    <div class="more_info_smallscreen">
                        <div>
                            <span class="plus_verticalLine"></span>
                            <span></span>
                        </div>    
                    </div>
                </div>
                <a class="footer_info" href="">Customer Service</a>
                <a class="footer_info" href="">Email</a>
                <a class="footer_info" href="">Feedback</a>
            </div>
            <div class="footer_col">
                <div onclick="viewMoreInfoFooter(2)">
                    <h3>Others</h3>
                    <div class="more_info_smallscreen">
                        <div>
                            <span class="plus_verticalLine"></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <a class="footer_info" href="">Term of Service</a>
                <a class="footer_info" href="">Policies</a>
                <a class="footer_info" href="">FAQ</a>
            </div>
            <div class="footer_col">
                <div id="copyright">
                    <p>Copyright University Library 2022</p>
                </div>
                <div id="visit_social_media_wrapper">
                    <a href=""><img src="Pic/facebook-2935402_640.png" alt="fb_icon"></a>
                    <a href=""><img src="Pic/instagram-2935404_640.png" alt="insta_icon"></a>
                    <a href=""><img src="Pic/twitter-2935414_640.png" alt="twit_icon"></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
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
    </script>
    ';
?>