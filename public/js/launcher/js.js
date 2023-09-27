var playimages = function (A) {
  return "string" == typeof A ? document.getElementById(A) : A;
};
var Class = {
  create: function () {
    return function () {
      this.initialize.apply(this, arguments);
    };
  },
};
Object.extend = function (A, B) {
  for (var C in B) {
    A[C] = B[C];
  }
  return A;
};
var TransformView = Class.create();
TransformView.prototype = {
  initialize: function (F, C, B, A, E) {
    if (B <= 0 || A <= 0) {
      return;
    }
    var G = playimages(F),
      H = playimages(C),
      D = this;
    this.Index = 0;
    this._timer = null;
    this._slider = H;
    this._parameter = B;
    this._count = A || 0;
    this._target = 0;
    this.SetOptions(E);
    this.Up = !!this.options.Up;
    this.Step = Math.abs(this.options.Step);
    this.Time = Math.abs(this.options.Time);
    this.Auto = !!this.options.Auto;
    this.Pause = Math.abs(this.options.Pause);
    this.onStart = this.options.onStart;
    this.onFinish = this.options.onFinish;
    G.style.overflow = "hidden";
    G.style.position = "relative";
    H.style.position = "absolute";
    H.style.top = H.style.left = 0;
  },
  SetOptions: function (A) {
    this.options = {
      Up: true,
      Step: 3,
      Time: 20,
      Auto: true, // change this if you wanna toggle auto scroll
      Pause: 8000,
      onStart: function () {},
      onFinish: function () {},
    };
    Object.extend(this.options, A || {});
  },
  Start: function () {
    if (this.Index < 0) {
      this.Index = this._count - 1;
    } else {
      if (this.Index >= this._count) {
        this.Index = 0;
      }
    }
    this._target = -1 * this._parameter * this.Index;
    this.onStart();
    this.Move();
  },
  Move: function () {
    clearTimeout(this._timer);
    var B = this,
      A = this.Up ? "top" : "left",
      C = parseInt(this._slider.style[A]) || 0,
      D = this.GetStep(this._target, C);
    if (D != 0) {
      this._slider.style[A] = C + D + "px";
      this._timer = setTimeout(function () {
        B.Move();
      }, this.Time);
    } else {
      this._slider.style[A] = this._target + "px";
      this.onFinish();
      if (this.Auto) {
        this._timer = setTimeout(function () {
          B.Index++;
          B.Start();
        }, this.Pause);
      }
    }
  },
  GetStep: function (A, C) {
    var B = (A - C) / this.Step;
    if (B == 0) {
      return 0;
    }
    if (Math.abs(B) < 1) {
      return B > 0 ? 1 : -1;
    }
    return B;
  },
  Stop: function (A, B) {
    clearTimeout(this._timer);
    this._slider.style[this.Up ? "top" : "left"] = this._target + "px";
  },
};
function Each(C, B) {
  var D;
  for (var A = 0, D = C.length; A < D; A++) {
    B(C[A], A);
  }
}
function LoadPicRun(A, D, F, B, G) {
  var E = playimages(F).getElementsByTagName("li");
  var C = new TransformView(A, D, B, G, {
    onStart: function () {
      Each(E, function (I, H) {
        I.className = C.Index == H ? "on" : "";
      });
    },
    Up: false,
  });
  C.Start();
  Each(E, function (I, H) {
    I.onmouseover = function () {
      I.className = "on";
      C.Auto = false;
      C.Index = H;
      C.Start();
    };
    I.onmouseout = function () {
      I.className = "";
      C.Auto = true;
      C.Start();
    };
  });
}
