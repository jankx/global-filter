/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/scss/global-filter.scss":
/*!****************************************!*\
  !*** ./assets/scss/global-filter.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__webpack_require__.p + \"css/global-filter.css\");\n\n//# sourceURL=webpack://@jankx/global-filter/./assets/scss/global-filter.scss?");

/***/ }),

/***/ "./assets/src/global-filter.js":
/*!*************************************!*\
  !*** ./assets/src/global-filter.js ***!
  \*************************************/
/***/ (() => {

eval("function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }\nfunction _nonIterableRest() { throw new TypeError(\"Invalid attempt to destructure non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); }\nfunction _iterableToArrayLimit(r, l) { var t = null == r ? null : \"undefined\" != typeof Symbol && r[Symbol.iterator] || r[\"@@iterator\"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t[\"return\"] && (u = t[\"return\"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }\nfunction _arrayWithHoles(r) { if (Array.isArray(r)) return r; }\nfunction _createForOfIteratorHelper(r, e) { var t = \"undefined\" != typeof Symbol && r[Symbol.iterator] || r[\"@@iterator\"]; if (!t) { if (Array.isArray(r) || (t = _unsupportedIterableToArray(r)) || e && r && \"number\" == typeof r.length) { t && (r = t); var _n = 0, F = function F() {}; return { s: F, n: function n() { return _n >= r.length ? { done: !0 } : { done: !1, value: r[_n++] }; }, e: function e(r) { throw r; }, f: F }; } throw new TypeError(\"Invalid attempt to iterate non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); } var o, a = !0, u = !1; return { s: function s() { t = t.call(r); }, n: function n() { var r = t.next(); return a = r.done, r; }, e: function e(r) { u = !0, o = r; }, f: function f() { try { a || null == t[\"return\"] || t[\"return\"](); } finally { if (u) throw o; } } }; }\nfunction _unsupportedIterableToArray(r, a) { if (r) { if (\"string\" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return \"Object\" === t && r.constructor && (t = r.constructor.name), \"Map\" === t || \"Set\" === t ? Array.from(r) : \"Arguments\" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }\nfunction _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }\n/**\n *\n * @param {HTMLElement} element The <select> tag element\n */\nfunction parse_selector_id_from_element(element) {\n  var data_id = element.getAttribute('name');\n  var data_type = element.dataset.objectType || 'none';\n  return data_type + '-' + data_id;\n}\n\n/**\n *\n * @param {HTMLELement} element\n * @returns\n */\nfunction jankx_parse_choices_configurations(element) {\n  return {};\n}\nfunction jankx_global_filter_collapse_content() {\n  var collapseButtons = document.querySelectorAll('.jankx-global-filter .collapse-button');\n  if (collapseButtons.length > 0) {\n    collapseButtons.forEach(function (btn) {\n      btn.addEventListener('click', function (e) {\n        e.preventDefault();\n        var filter_wrapper = e.target.findParent('.jankx-filter');\n        if (!filter_wrapper) {\n          return;\n        }\n        if (filter_wrapper.hasClass('collapse')) {\n          filter_wrapper.addClass('expand');\n          filter_wrapper.removeClass('collapse');\n        } else {\n          filter_wrapper.addClass('collapse');\n          filter_wrapper.removeClass('expand');\n        }\n      });\n    });\n  }\n}\n\n/**\n * @param {Array} terms list terms of queried object\n * @param {string} data_type taxonomy name\n * @param {FormData} request_body\n * @return boolean\n */\nfunction jankx_check_queried_object_with_request_body(terms, data_type, request_body) {\n  var checkingKey = data_type + '[' + Object.keys(terms).join('') + '][]';\n  var isOk = false;\n  var entries = request_body.entries();\n  var _iterator = _createForOfIteratorHelper(entries),\n    _step;\n  try {\n    for (_iterator.s(); !(_step = _iterator.n()).done;) {\n      var _step$value = _slicedToArray(_step.value, 2),\n        key = _step$value[0],\n        _ = _step$value[1];\n      if (key == checkingKey) {\n        isOk = true;\n        break;\n      }\n    }\n  } catch (err) {\n    _iterator.e(err);\n  } finally {\n    _iterator.f();\n  }\n  return isOk;\n}\n\n/**\n *\n * @param {FormData} requestBody\n * @param {String} destLayout\n */\nfunction jankx_global_filter_request_ajax(requestBody, destLayout) {\n  var destLayoutDOM = document.getElementById(destLayout);\n  var post_type = destLayoutDOM.dataset.postType;\n  var current_page = destLayoutDOM.dataset.currentPage || 1;\n  var posts_per_page = destLayoutDOM.dataset.postsPerPage || 10;\n  var layout = destLayoutDOM.dataset.layout || 'card';\n  var engine_id = destLayoutDOM.dataset.engineId;\n  var thumb_pos = destLayoutDOM.dataset.thumbnailPosition;\n  requestBody.append('post_type', post_type);\n  requestBody.append('current_page', current_page);\n  requestBody.append('posts_per_page', posts_per_page);\n  requestBody.append('layout', layout);\n  requestBody.append('engine_id', engine_id);\n  requestBody.append('thumb_pos', thumb_pos);\n  requestBody.append('action', jkx_global_filter.action);\n\n  // Load current conditions\n  if (Object.keys(jkx_global_filter.current_conditions).length > 0) {\n    var current_conditions = jkx_global_filter.current_conditions;\n    Object.keys(current_conditions).forEach(function (data_type) {\n      var data_terms = current_conditions[data_type];\n      if (!jankx_check_queried_object_with_request_body(data_terms, data_type, requestBody) && Object.keys(data_terms).length > 0) {\n        Object.keys(data_terms).forEach(function (type) {\n          if (Array.isArray(data_terms[type])) {\n            data_terms[type].forEach(function (term) {\n              requestBody.append(data_type + '[' + type + '][]', term);\n            });\n          }\n        });\n      }\n    });\n  }\n  jankx_ajax(jkx_global_filter.ajax_url, 'GET', requestBody, {\n    beforeSend: function beforeSend() {},\n    complete: function complete(xhr) {\n      var jankx_post_wrap = destLayoutDOM.find('.jankx-posts');\n      var mode = jankx_post_wrap.dataset.mode || 'append';\n      if (xhr.readyState === 4 && xhr.status === 200) {\n        var success_flag = xhr.responseJSON && xhr.responseJSON.success;\n\n        // Success case\n        if (success_flag) {\n          var realContentWrap = jankx_post_wrap.dataset.contentWrapper ? jankx_post_wrap.find(jankx_post_wrap.dataset.contentWrapper) : jankx_post_wrap;\n          if (mode === 'replace') {\n            realContentWrap.html(xhr.responseJSON.data.content);\n          } else {\n            realContentWrap.appendHTML(xhr.responseJSON.data.content);\n          }\n          if (['carousel', 'preset-3', 'preset-5'].indexOf(layout) >= 0) {\n            var carouselWrap = destLayoutDOM.find('.splide');\n            var carouselId = carouselWrap.getAttribute('id').replaceAll(/-/ig, '_');\n            if (window[carouselId]) {\n              window[carouselId].destroy();\n            }\n            configs = window[carouselId + '__configs'] || {};\n            window[carouselId] = new Splide(carouselWrap, configs);\n            window[carouselId].mount();\n          }\n        }\n\n        // Support callback\n        var jankx_callback = jkx_post_layout['jankx_tabs_' + engine_id + '_' + layout + '_' + post_type];\n        if (window[jankx_callback]) {\n          window[jankx_callback](realContentWrap, body, success_flag);\n        }\n      }\n    }\n  });\n}\n\n/**\n *\n * @param {Event} e\n */\nfunction jankx_global_filter_control_change_value(e) {\n  var destLayout = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : undefined;\n  return function (destLayout) {\n    if (destLayout === undefined) {\n      var currentFilter = e.target.findParent('.jankx-global-filter');\n      var destLayout = currentFilter.dataset.destLayout || 'jankx-main-layout';\n    }\n    // get filter values\n    var filtersOfDestLayouts = document.querySelectorAll('[data-dest-layout=' + destLayout + ']');\n    var filterValues = new FormData();\n    filtersOfDestLayouts.forEach(function (filter) {\n      var formOffilter = filter.querySelector('form');\n      if (formOffilter) {\n        var data = new FormData(formOffilter);\n        var _iterator2 = _createForOfIteratorHelper(data),\n          _step2;\n        try {\n          for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {\n            var _step2$value = _slicedToArray(_step2.value, 2),\n              key = _step2$value[0],\n              val = _step2$value[1];\n            filterValues.append(key, val);\n          }\n        } catch (err) {\n          _iterator2.e(err);\n        } finally {\n          _iterator2.f();\n        }\n      }\n    });\n    if (destLayout === 'jankx-main-layout') {\n      var orderingFilter = document.querySelector('.jankx-product-ordering select.orderby');\n      if (orderingFilter) {\n        filterValues.append('order_product', orderingFilter.value);\n      }\n    }\n    jankx_global_filter_request_ajax(filterValues, destLayout);\n  }(destLayout);\n}\nfunction jankx_global_filter_monitor_filters() {\n  var filterControls = document.querySelectorAll('.jankx-filter .filter-control');\n  if (filterControls.length > 0) {\n    filterControls.forEach(function (filterControl) {\n      filterControl.addEventListener('change', jankx_global_filter_control_change_value);\n    });\n  }\n\n  // Support product order by\n  var orderByControl = document.querySelector('.jankx-product-ordering select.orderby');\n  if (orderByControl) {\n    orderByControl.addEventListener(\"change\", function (e) {\n      jankx_global_filter_control_change_value(e, 'jankx-main-layout');\n    });\n  }\n}\nfunction jankx_global_filter_disable_click_event_of_option_links() {\n  var optionLinks = document.querySelectorAll('.filter-options.multi-filters .filter-option a');\n  if (optionLinks.length > 0) {\n    optionLinks.forEach(function (optionLink) {\n      optionLink.addEventListener('click', function (e) {\n        e.preventDefault();\n        e.target.parentNode.click();\n      });\n    });\n  }\n\n  // Support product order by\n  var orderByControl = document.querySelector('.jankx-product-ordering select.orderby');\n  if (orderByControl) {\n    orderByControl.addEventListener(\"change\", function (e) {\n      jankx_global_filter_control_change_value(e, 'jankx-main-layout');\n    });\n  }\n}\nfunction jankx_global_filter_init() {\n  var filters = document.querySelectorAll('select.select-filter');\n  if (filters.length > 0) {\n    for (var filterIndex = 0; filterIndex < filters.length; filterIndex++) {\n      var element = filters[filterIndex];\n      window[parse_selector_id_from_element(element)] = new Choices(element, jankx_parse_choices_configurations(element));\n    }\n  }\n  jankx_global_filter_collapse_content();\n  jankx_global_filter_monitor_filters();\n  jankx_global_filter_disable_click_event_of_option_links();\n}\ndocument.addEventListener('DOMContentLoaded', jankx_global_filter_init);\n\n//# sourceURL=webpack://@jankx/global-filter/./assets/src/global-filter.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/publicPath */
/******/ 	(() => {
/******/ 		var scriptUrl;
/******/ 		if (__webpack_require__.g.importScripts) scriptUrl = __webpack_require__.g.location + "";
/******/ 		var document = __webpack_require__.g.document;
/******/ 		if (!scriptUrl && document) {
/******/ 			if (document.currentScript && document.currentScript.tagName.toUpperCase() === 'SCRIPT')
/******/ 				scriptUrl = document.currentScript.src;
/******/ 			if (!scriptUrl) {
/******/ 				var scripts = document.getElementsByTagName("script");
/******/ 				if(scripts.length) {
/******/ 					var i = scripts.length - 1;
/******/ 					while (i > -1 && (!scriptUrl || !/^http(s?):/.test(scriptUrl))) scriptUrl = scripts[i--].src;
/******/ 				}
/******/ 			}
/******/ 		}
/******/ 		// When supporting browsers where an automatic publicPath is not supported you must specify an output.publicPath manually via configuration
/******/ 		// or pass an empty string ("") and set the __webpack_public_path__ variable from your code to use your own logic.
/******/ 		if (!scriptUrl) throw new Error("Automatic publicPath is not supported in this browser");
/******/ 		scriptUrl = scriptUrl.replace(/^blob:/, "").replace(/#.*$/, "").replace(/\?.*$/, "").replace(/\/[^\/]+$/, "/");
/******/ 		__webpack_require__.p = scriptUrl + "../";
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	__webpack_modules__["./assets/src/global-filter.js"](0, {}, __webpack_require__);
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./assets/scss/global-filter.scss"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;