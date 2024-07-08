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
  !*** ./resources/js/register-user.js ***!
  \***************************************/
$('#multicol-country').on('change', function () {
  var agenceID = $(this).val();
  $('#agence').empty();
  $('#agence').append("<option value=\"0\" disabled>Chargement des agences en cours..</option>");
  if (agenceID) {
    $.ajax({
      type: 'GET',
      url: "".concat(baseUrl, "auth/register-basic"),
      data: 'id=' + agenceID,
      success: function success(res) {
        $('#agence').empty();
        $('#agence').append("<option value=\"0\" disabled>Selectionnez l'agence</option>");
        for (var i = 0; i < res.length; i++) {
          $('#agence').append("<option value=\"".concat(res[i]['id'], "\">").concat(res[i]['nom'], "</option>"));
        }
      }
    });
  }
});
/******/ 	return __webpack_exports__;
/******/ })()
;
});