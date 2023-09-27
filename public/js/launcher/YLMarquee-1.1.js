(function(A) {
    A.fn.extend({
        "totalWidth": function() {
            var B = 0;
            A(this).each(function() {
                B += A(this).outerWidth(true)
            });
            return B
        },
        "totalHeight": function() {
            var B = 0;
            A(this).each(function() {
                B += A(this).outerHeight(true)
            });
            return B
        }
    });
    A.fn.YlMarquee = function(I) {
        I = A.extend({
            step: 3,
            vertical: 1,
            width: 0,
            height: 0,
            visible: 0,
            pause: 3000,
            textMode: false,
            NextControlID: "",
            PreControlID: ""
        }, I || {});
        var d = A(this)
          , Q = A("ul", d)
          , J = A("li", Q)
          , E = I.visible
          , F = I.step
          , f = J.size()
          , B = J.slice(0, E);
        var c, G, T, L, K, S, b, Z, R, H, a, W;
        if (I.vertical == 1 || I.vertical == 2) {
            c = "normal";
            G = "none";
            T = "block";
            Z = I.height
        } else {
            c = "nowrap";
            G = "left";
            T = "inline";
            Z = I.width;
            K = I.textMode ? "*float:none;" : ""
        }
        d.css({
            position: "relative",
            overflow: "hidden"
        });
        Q.css({
            position: "relative",
            "white-space": c,
            overflow: "hidden",
            "list-style-type": "none",
            margin: "0",
            padding: "0"
        });
        J.css({
            "white-space": c,
            "display": T,
            overflow: "hidden"
        });
        J.attr("style", J.attr("style") + ";float:" + G + ";" + K);
        L = (I.vertical == 1 || I.vertical == 2) ? J.totalHeight() : J.totalWidth();
        (I.vertical == 1 || I.vertical == 2) ? Q.height(L) : Q.width(L);
        R = (I.vertical == 1 || I.vertical == 2) ? B.totalHeight() : B.totalWidth();
        if (Z == 0) {
            Z = R
        }
        (I.vertical == 1 || I.vertical == 2) ? d.height(Z) : d.width(Z);
        var U = 0;
        var X;
        var Y;
        var V = "";
        d.scrollTop(0);
        speed = 1000 / (R / F);
        P();
        if (Z < L) {
            Q.append(J.clone());
            var O = A("li", Q)
              , M = (I.vertical == 1 || I.vertical == 2) ? O.totalHeight() : O.totalWidth();
            O.attr("style", O.attr("style") + ";float:" + G + ";");
            (I.vertical == 1 || I.vertical == 2) ? Q.height(M) : Q.width(M);
            a = (I.vertical == 1 || I.vertical == 2) ? O.slice(0, f).totalHeight() : O.slice(0, f).totalWidth();
            X = setInterval(C, speed);
            Q.hover(function() {
                clearInterval(X);
                clearInterval(Y)
            }, function() {
                X = setInterval(C, speed)
            })
        }
        N();
        function P() {
            if (I.NextControlID.length > 0) {
                A("#" + I.NextControlID).click(e)
            }
            if (I.PreControlID.length > 0) {
                A("#" + I.PreControlID).click(N)
            }
        }
        function N() {
            clearInterval(X);
            clearInterval(Y);
            switch (I.vertical) {
            case 1:
                if (U >= 0 && U <= R) {
                    H = d.scrollTop() + R + (R - U);
                    d.scrollTop(H)
                } else {
                    d.scrollTop(d.scrollTop() - a + R)
                }
                break;
            case 2:
                if (U >= 0 && U <= R) {
                    H = d.scrollTop() - R - (R - U);
                    d.scrollTop(H)
                } else {
                    d.scrollTop(d.scrollTop() + a - R)
                }
                break;
            case 3:
                if ((U >= 0 && U <= R)) {
                    H = d.scrollLeft() + R + (R - U);
                    d.scrollLeft(H)
                } else {
                    d.scrollLeft(d.scrollLeft() - a + R)
                }
                break;
            case 4:
                if (U >= 0 && U <= R) {
                    H = d.scrollLeft() - R - (R - U);
                    d.scrollLeft(H)
                } else {
                    d.scrollLeft(d.scrollLeft() + a - R)
                }
                break
            }
            X = setInterval(C, speed)
        }
        function e() {
            clearInterval(X);
            clearInterval(Y);
            switch (I.vertical) {
            case 1:
                if (U >= 0 && U <= R) {
                    H = d.scrollTop() - R - (R - U);
                    U = 0;
                    d.scrollTop(H)
                } else {
                    d.scrollTop(d.scrollTop() - a - R)
                }
                break;
            case 2:
                if (U >= 0 && U <= R) {
                    H = d.scrollTop() + R + (R - U);
                    U = 0;
                    d.scrollTop(H)
                } else {
                    d.scrollTop(d.scrollTop() + a + R)
                }
                break;
            case 3:
                if (U >= 0 && U <= R) {
                    H = d.scrollLeft() - R - (R - U);
                    U = 0;
                    d.scrollLeft(H)
                } else {
                    d.scrollLeft(d.scrollLeft() - a - R)
                }
                break;
            case 4:
                if (U >= 0 && U <= R) {
                    H = d.scrollLeft() + R + (R - U);
                    U = 0;
                    d.scrollLeft(H)
                } else {
                    d.scrollLeft(d.scrollLeft() + a + R)
                }
                break
            }
            X = setInterval(C, speed)
        }
        function D() {
            X = setInterval(C, speed)
        }
        function C() {
            switch (I.vertical) {
            case 1:
                if (d.scrollTop() >= a) {
                    d.scrollTop(d.scrollTop() - a + F)
                } else {
                    H = d.scrollTop();
                    H += F;
                    d.scrollTop(H)
                }
                U += F;
                if (U >= R) {
                    clearInterval(X);
                    U = 0;
                    Y = setTimeout(D, I.pause)
                }
                break;
            case 2:
                if (d.scrollTop() <= 0) {
                    d.scrollTop(d.scrollTop() + a - F)
                } else {
                    H = d.scrollTop();
                    H -= F;
                    d.scrollTop(H)
                }
                U += F;
                if (U >= R) {
                    clearInterval(X);
                    U = 0;
                    Y = setTimeout(D, I.pause)
                }
                break;
            case 3:
                if (d.scrollLeft() >= a) {
                    d.scrollLeft(d.scrollLeft() - a + F)
                } else {
                    H = d.scrollLeft();
                    H += F;
                    d.scrollLeft(H)
                }
                U += F;
                if (U >= R) {
                    clearInterval(X);
                    U = 0;
                    Y = setTimeout(D, I.pause)
                }
                break;
            case 4:
                if (d.scrollLeft() <= 0) {
                    d.scrollLeft(d.scrollLeft() + a - F)
                } else {
                    H = d.scrollLeft();
                    H -= F;
                    d.scrollLeft(H)
                }
                U += F;
                if (U >= R) {
                    clearInterval(X);
                    U = 0;
                    Y = setTimeout(D, I.pause)
                }
                break
            }
        }
    }
}
)(jQuery);
