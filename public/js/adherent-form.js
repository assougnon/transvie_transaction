(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else {
		var a = factory();
		for(var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
	}
})(self, function() {
return /******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/adherent-form.js ***!
  \***************************************/
var input = document.querySelector("#basic-icon-default-phone");
var telephone = intlTelInput(input, {
  initialCountry: "sn",
  onlyCountries: ["sn", "ci", "tg", "bj", "gm"],
  separateDialCode: true
});
var country = $("#telephone2");
input.addEventListener("keyup", function () {
  $("#telephone2").val('00' + telephone.getSelectedCountryData().dialCode);
});
/******/ 	return __webpack_exports__;
/******/ })()
;
});