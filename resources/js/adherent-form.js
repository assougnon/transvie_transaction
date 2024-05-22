

var input = document.querySelector("#basic-icon-default-phone");
  let telephone = intlTelInput(input,{
  initialCountry: "sn",
  onlyCountries : ["sn", "ci" , "tg", "bj", "gm"],
  separateDialCode : true,
});
let country = $("#telephone2");


input.addEventListener("keyup",function(){

  $("#telephone2").val('00'+telephone.getSelectedCountryData().dialCode)

});
