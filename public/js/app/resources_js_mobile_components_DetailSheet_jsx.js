"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_mobile_components_DetailSheet_jsx"],{

/***/ "./resources/js/mobile/components/DetailSheet.jsx":
/*!********************************************************!*\
  !*** ./resources/js/mobile/components/DetailSheet.jsx ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   DetailSheet: () => (/* binding */ DetailSheet)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var swiper__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! swiper */ "./node_modules/swiper/swiper.mjs");
/* harmony import */ var swiper_swiper_bundle_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! swiper/swiper-bundle.css */ "./node_modules/swiper/swiper-bundle.css");
/* harmony import */ var _context_CartContext__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../context/CartContext */ "./resources/js/mobile/context/CartContext.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react/jsx-runtime */ "./node_modules/react/jsx-runtime.js");
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }





var DetailSheet = function DetailSheet(_ref) {
  var _detail$price;
  var controller = _ref.controller;
  var open = controller.open,
    detail = controller.detail,
    loading = controller.loading,
    closeDetail = controller.closeDetail;
  var _useCart = (0,_context_CartContext__WEBPACK_IMPORTED_MODULE_3__.useCart)(),
    cart = _useCart.cart,
    increment = _useCart.increment,
    decrement = _useCart.decrement,
    totalItems = _useCart.totalItems;
  var mediaRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  var swiperInstanceRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  var scrollRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null); // back on inner scroll
  var produkSectionRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  var specSectionRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  var _useState = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)('produk'),
    _useState2 = _slicedToArray(_useState, 2),
    activeTab = _useState2[0],
    setActiveTab = _useState2[1];
  var _useState3 = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false),
    _useState4 = _slicedToArray(_useState3, 2),
    descExpanded = _useState4[0],
    setDescExpanded = _useState4[1];
  var _useState5 = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false),
    _useState6 = _slicedToArray(_useState5, 2),
    fitMode = _useState6[0],
    setFitMode = _useState6[1]; // global toggle for contain

  // Debug marker (must stay BEFORE any conditional early return to keep hook order stable)
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(function () {
    if (open) console.debug('[DetailSheet] version 2025-10-01-c loaded');
  }, [open]);

  // Body scroll lock
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(function () {
    if (open) document.body.classList.add('no-scroll');else document.body.classList.remove('no-scroll');
  }, [open]);

  // Initialize media swiper
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(function () {
    if (!open || !detail) return;
    var container = mediaRef.current;
    if (!container) return;
    if (swiperInstanceRef.current) {
      try {
        swiperInstanceRef.current.destroy(true, true);
      } catch (_) {}
    }
    var inst = new swiper__WEBPACK_IMPORTED_MODULE_1__["default"](container, {
      pagination: {
        el: container.querySelector('.swiper-pagination'),
        clickable: true
      },
      navigation: {
        nextEl: container.querySelector('.swiper-button-next'),
        prevEl: container.querySelector('.swiper-button-prev')
      },
      loop: detail.media_list.length > 1,
      speed: 450,
      on: {
        slideChange: function slideChange() {
          var _this = this;
          var slides = container.querySelectorAll('.swiper-slide');
          slides.forEach(function (sl, i) {
            var vid = sl.querySelector('video');
            if (vid) {
              if (i === _this.realIndex) {
                try {
                  vid.play();
                } catch (_) {}
              } else {
                try {
                  vid.pause();
                } catch (_) {}
              }
            }
          });
        }
      }
    });
    swiperInstanceRef.current = inst;
    setTimeout(function () {
      try {
        var active = container.querySelector('.swiper-slide-active video');
        if (active) active.play();
      } catch (_) {}
    }, 80);
  }, [open, detail]);

  // Scroll spy
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(function () {
    if (!open) return;
    var sc = scrollRef.current;
    if (!sc) return;
    var tabsEl = sc.querySelector('.detail-tabs');
    var onScroll = function onScroll() {
      var _specSectionRef$curre;
      var tabsH = tabsEl ? tabsEl.getBoundingClientRect().height : 0;
      var specTop = ((_specSectionRef$curre = specSectionRef.current) === null || _specSectionRef$curre === void 0 ? void 0 : _specSectionRef$curre.offsetTop) || 0;
      var scrollY = sc.scrollTop;
      var threshold = specTop - tabsH - 8;
      var newTab = scrollY < threshold ? 'produk' : 'spec';
      if (newTab !== activeTab) setActiveTab(newTab);
    };
    sc.addEventListener('scroll', onScroll, {
      passive: true
    });
    onScroll();
    return function () {
      return sc.removeEventListener('scroll', onScroll);
    };
  }, [open, activeTab]);
  var scrollTo = function scrollTo(tab) {
    if (!open) return;
    var sc = scrollRef.current;
    if (!sc) return;
    var tabsEl = sc.querySelector('.detail-tabs');
    var tabsH = tabsEl ? tabsEl.getBoundingClientRect().height : 0;
    if (tab === 'produk') sc.scrollTo({
      top: 0,
      behavior: 'smooth'
    });else {
      var _specSectionRef$curre2;
      var y = (((_specSectionRef$curre2 = specSectionRef.current) === null || _specSectionRef$curre2 === void 0 ? void 0 : _specSectionRef$curre2.offsetTop) || 0) - tabsH - 4;
      sc.scrollTo({
        top: y < 0 ? 0 : y,
        behavior: 'smooth'
      });
    }
    setActiveTab(tab);
  };
  var handleImageLoad = function handleImageLoad(e) {
    var img = e.target;
    if (!img) return;
    var w = img.naturalWidth,
      h = img.naturalHeight;
    if (h > w * 1.15) {
      img.classList.add('portrait');
    }
  };
  var toggleFit = function toggleFit() {
    return setFitMode(function (m) {
      return !m;
    });
  };
  if (!open) return null; // early return placed AFTER all hooks

  var qty = detail ? cart[detail.id] || 0 : 0;
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
    className: "detail-overlay ".concat(open ? 'open' : ''),
    onClick: function onClick(e) {
      if (e.target.classList.contains('detail-overlay')) closeDetail();
    },
    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
      className: "detail-sheet",
      role: "dialog",
      "aria-modal": "true",
      onClick: function onClick(e) {
        return e.stopPropagation();
      },
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        className: "detail-content-scroll",
        ref: scrollRef,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
          className: "detail-media-wrapper",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
            className: "swiper detail-media-swiper",
            ref: mediaRef,
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
              className: "swiper-wrapper",
              children: ((detail === null || detail === void 0 ? void 0 : detail.media_list) || []).map(function (m, i) {
                return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
                  className: "swiper-slide",
                  children: m.type === 'video' ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("video", {
                    src: m.url,
                    muted: true,
                    playsInline: true,
                    loop: true,
                    preload: "metadata"
                  }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("img", {
                    onLoad: handleImageLoad,
                    onClick: toggleFit,
                    className: fitMode ? 'fit-mode' : '',
                    src: m.url,
                    loading: "lazy",
                    alt: (detail === null || detail === void 0 ? void 0 : detail.name) || 'Media'
                  })
                }, i);
              })
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
              className: "swiper-pagination"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
              className: "swiper-button-prev media-nav"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
              className: "swiper-button-next media-nav"
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("button", {
            className: "detail-close-btn right",
            onClick: closeDetail,
            children: "\u2715"
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
          className: "detail-tabs",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
            className: "detail-tab ".concat(activeTab === 'produk' ? 'active' : ''),
            onClick: function onClick() {
              return scrollTo('produk');
            },
            children: "Produk"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
            className: "detail-tab ".concat(activeTab === 'spec' ? 'active' : ''),
            onClick: function onClick() {
              return scrollTo('spec');
            },
            children: "Spesifikasi"
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
          ref: produkSectionRef,
          className: "detail-section",
          id: "detail-produk-section",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
            className: "detail-price-row",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
              className: "detail-price-current",
              children: detail && 'Rp' + ((_detail$price = detail.price) === null || _detail$price === void 0 ? void 0 : _detail$price.toLocaleString('id-ID'))
            }), (detail === null || detail === void 0 ? void 0 : detail.old_price) && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
              className: "detail-price-old",
              children: 'Rp' + detail.old_price.toLocaleString('id-ID')
            }), (detail === null || detail === void 0 ? void 0 : detail.discount) && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("span", {
              className: "detail-discount-badge",
              children: [detail.discount, "%"]
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("h3", {
            className: "detail-title",
            children: detail === null || detail === void 0 ? void 0 : detail.name
          }), (detail === null || detail === void 0 ? void 0 : detail.subtitle) && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
            className: "detail-sub",
            children: detail.subtitle
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
          className: "detail-soft-divider"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
          ref: specSectionRef,
          className: "detail-section",
          id: "detail-spec-section",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("h4", {
            style: {
              marginTop: 0
            },
            children: "Deskripsi"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
            className: "detail-desc-wrapper ".concat(descExpanded ? 'expanded' : ''),
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
              className: "detail-desc",
              children: detail === null || detail === void 0 ? void 0 : detail.description
            })
          }), (detail === null || detail === void 0 ? void 0 : detail.description) && detail.description.length > 160 && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("button", {
            className: "detail-readmore",
            onClick: function onClick() {
              return setDescExpanded(function (v) {
                return !v;
              });
            },
            children: descExpanded ? 'Sembunyikan' : 'Baca Selengkapnya'
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
            className: "detail-soft-divider"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("h4", {
            style: {
              marginTop: '0'
            },
            children: "Produk Terkait"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
            className: "detail-soft-divider"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("h4", {
            style: {
              marginTop: '0'
            },
            children: "Spesifikasi"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
            className: "detail-spec-wrapper expanded",
            children: detail !== null && detail !== void 0 && detail.spec_html ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
              className: "detail-spec-html",
              style: {
                fontSize: '12px',
                lineHeight: '1.5'
              },
              dangerouslySetInnerHTML: {
                __html: detail.spec_html
              }
            }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
              className: "spec-grid",
              children: ((detail === null || detail === void 0 ? void 0 : detail.specs) || []).map(function (s, i) {
                return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
                  className: "spec-item",
                  children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
                    className: "spec-label",
                    children: s.label
                  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
                    className: "spec-value",
                    children: s.value
                  })]
                }, i);
              })
            })
          }), (detail === null || detail === void 0 ? void 0 : detail.brochure_image) && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
            className: "detail-brochure-wrapper",
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("img", {
              src: detail.brochure_image,
              alt: "Brochure",
              onError: function onError(e) {
                e.target.onerror = null;
                e.target.src = '/placeholder/brochure-placeholder.png';
              }
            })
          })]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        className: "detail-bottom-bar",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
          className: "action-left",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("button", {
            className: "detail-icon-btn",
            "aria-label": "Wishlist",
            onClick: function onClick() {
              return alert('Wishlist placeholder');
            },
            children: "\u2661"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("button", {
            className: "detail-icon-btn",
            "aria-label": "Keranjang",
            onClick: function onClick() {
              return window.location.href = '/mycart';
            },
            children: ["\uD83D\uDED2", totalItems > 0 && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
              className: "badge",
              children: totalItems
            })]
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
          className: "detail-bottom-flex",
          children: detail && (qty === 0 ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("button", {
            className: "detail-cart-btn",
            onClick: function onClick() {
              return increment(detail);
            },
            children: "Tambah ke Keranjang"
          }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
            className: "detail-qty-inline",
            style: {
              marginLeft: 'auto',
              display: 'flex',
              alignItems: 'center',
              gap: '10px'
            },
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("button", {
              className: "detail-inline-btn",
              onClick: function onClick() {
                return decrement(detail);
              },
              children: "\u2212"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
              style: {
                fontWeight: 600,
                minWidth: '24px',
                textAlign: 'center'
              },
              children: qty
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("button", {
              className: "detail-inline-btn",
              onClick: function onClick() {
                return increment(detail);
              },
              children: "+"
            })]
          }))
        })]
      })]
    })
  });
};

/***/ })

}]);