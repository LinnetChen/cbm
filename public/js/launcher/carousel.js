var i = -1, imgArr = new Array();
imgArr[0] = {
    url: "https://example.com/page1",
    imgSrc: "/img/launcher/banner.png"
};
imgArr[1] = {
    url: "https://example.com/page2",
    imgSrc: "/img/launcher/banner02.png"
};
imgArr[2] = {
    url: "https://example.com/page3",
    imgSrc: "/img/launcher/banner03.png"
};

var timeout;

function showImg(imgNum) {
    if (imgNum >= 0) i = imgNum;
    document.getElementById('myImg').src = imgArr[i].imgSrc;

    document.querySelectorAll("#changeimg a").forEach(function (el) {
        el.style.backgroundColor = "#004d9b";
    });

    document.querySelector(`.c${i + 1}`).style.backgroundColor = "#0084c8";

    clearTimeout(timeout);
    timeout = setTimeout(showNextImg, 3000);
}

function showNextImg() {
    i = (i + 1) % imgArr.length;
    document.getElementById('myImg').src = imgArr[i].imgSrc;
    document.querySelectorAll("#changeimg a").forEach(function (el) {
        el.style.backgroundColor = "#004d9b";
    });
    document.querySelector(`.c${i + 1}`).style.backgroundColor = "#0084c8";
    timeout = setTimeout(showNextImg, 3000);
}

function show() {
    timeout = setTimeout(showNextImg, 3000);
}

function openNewWindow(index) {
    let url = imgArr[index].url;
    window.open(url, "_blank");
}
