            </div>
            <?php $this->load->view('includes/sidebar'); ?>
            <div style="clear:both"></div>
        </div>
        <div class="footer">
            &copy; 2013 <a href="http://blockreich.net/">Blockreich</a> &bull; <a href="#">Impressum</a><br>
            Minecraft sowie einige der verwendeten Grafiken und Icons sind Eigentum der <a href="http://www.mojang.com/" target="_blank">Mojang AB</a>.<br>
            Dies ist keine offizielle Webseite von <a href="http://www.mojang.com/" target="_blank">Mojang AB</a>.
        </div>
        
    </div>
        
    <a href="#" id="slideshow_button"><div>Slideshow starten</div></a>
   
    <div id="slideshow-box">
        <span class="sTitle">Blockreich<br>Slideshow</span><br>
        <ul class="sPics">
            <li><a href="#" onclick="$.vegas('jump', 0)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg01.jpg"); ?>" width="120px" height="100px"></a></li>
            <li><a href="#" onclick="$.vegas('jump', 1)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg02.jpg"); ?>" width="120px" height="100px"></a></li>
            <li><a href="#" onclick="$.vegas('jump', 2)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg03.jpg"); ?>" width="120px" height="100px"></a></li>
            <li><a href="#" onclick="$.vegas('jump', 3)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg04.jpg"); ?>" width="120px" height="100px"></a></li>
            <li><a href="#" onclick="$.vegas('jump', 4)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg05.jpg"); ?>" width="120px" height="100px"></a></li>
            <li><a href="#" onclick="$.vegas('jump', 5)"><img src="<?php echo base_url("styles/js/vegas/images/pagebg06.jpg"); ?>" width="120px" height="100px"></a></li>
        </ul>
    </div>
    
    <script type="text/javascript" src="<?php echo base_url("styles/js/vegas/jquery.vegas.js"); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var slideActive = null;
            $("#slideshow_button").click(function() {
                if(slideActive) {
                    $.vegas('stop');
                    $.vegas('destroy');
                    $("#slideshow-box").hide();
                    $("#slideshow_button").html("<div>Slideshow starten</div>");
                    $("#page").show();
                    slideActive = false;
                } else {
                    $.vegas({
                        src:'styles/js/vegas/images/pagebg01.jpg'
                    });
                    $.vegas('slideshow', {
                      delay: 7000,
                      backgrounds:[
                        { src:'styles/js/vegas/images/pagebg01.jpg', fade:1000 },
                        { src:'styles/js/vegas/images/pagebg02.jpg', fade:1000 },
                        { src:'styles/js/vegas/images/pagebg03.jpg', fade:1000 },
                        { src:'styles/js/vegas/images/pagebg04.jpg', fade:1000 },
                        { src:'styles/js/vegas/images/pagebg05.jpg', fade:1000 },
                        { src:'styles/js/vegas/images/pagebg06.jpg', fade:1000 }
                      ]
                    })('overlay');
                    /* $.vegas('overlay', {
                        src: none
                    }); */
                    $("#page").hide();
                    $("#slideshow_button").html("<div>Slideshow beenden</div>");
                    $("#slideshow-box").show();
                    slideActive = true;
                }
            });
        });
    </script>
</body>
</html>