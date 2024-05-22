import Echo from 'laravel-echo';
 window.Pusher = require('pusher-js');
 window.Echo = new Echo({
     broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});



import * as bootstrap from 'bootstrap'



import { FormatMoney } from 'format-money-js';

import { CountUp } from 'countup.js';

import intlTelInput from 'intl-tel-input';


window.fm = new FormatMoney({
  decimals: 0,
  separator: ' ',
  append : true,

});

/*
let endval = 0;




let numAnim;
$.ajax({
  type:'GET',
  url: `${baseUrl}montant/pays`,
  success:function(res){
 endval = res.montantSenegal;
  }
}).then(()=>{
  numAnim = new CountUp('montantSenegal',endval ,{
    formattingFn(n){

      return fm.from(n);
    }
  });
  numAnim.start()
});
*/




try {
  window.CountUp = CountUp;
  window.intlTelInput = intlTelInput
}catch (e) {

}




try {
  window.bootstrap = bootstrap

} catch (e) {}

export { bootstrap }


