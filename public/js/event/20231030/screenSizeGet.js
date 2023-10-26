var screenWidth = screen.width;
var screenHeight = screen.height;

var windowWidth = window.innerWidth;
var windowHeight = window.innerHeight;

console.log(screenWidth);
console.log(screenHeight);
$('#main_m').hide();

window.addEventListener('resize', function() {
    windowWidth = window.innerWidth;
    windowHeight = window.innerHeight;
    console.log(windowWidth);
    console.log(windowHeight);
    if(windowWidth <= 900 ){
        console.log("畫面寬度小於900");
        $('#main').hide();
        $('#main_m').show();
    }else if(windowWidth >= 900 ){
        $('#main_m').hide();
        $('#main').show();
    }
});