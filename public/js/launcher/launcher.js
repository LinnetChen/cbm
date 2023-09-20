function showDiv(C, B, D) {
    for (var A = 1; A <= D; A++) { document.getElementById("divCode" + C + "_" + String(A)).style.display = "none" }
    document.getElementById("divCode" + C + "_" + B).style.display = "block"; for (var A in document.getElementById("ulMenu_" + C).getElementsByTagName("LI")) { document.getElementById("ulMenu_" + C).getElementsByTagName("LI")[A].className = "codeDemomouseOutMenu" }
}
$(document).ready(function () {
    jQuery.post("/script/get_banner_l.php", function (data) { data2 = eval('(' + data + ')'); var RetVal = data2.RetVal; $('#UPic').html(data2.banner_list); $('#UNum').html(data2.num_list); LoadPicRun("DPic", "UPic", "UNum", 300, data2.bn_count); }); $("#img-list4").YlMarquee({ step: 39, visible: 1, vertical: 7, NextControlID: "imgNext4", PreControlID: "imgPre4" });
});