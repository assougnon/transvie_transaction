!function(t,e){if("object"==typeof exports&&"object"==typeof module)module.exports=e();else if("function"==typeof define&&define.amd)define([],e);else{var n=e();for(var a in n)("object"==typeof exports?exports:t)[a]=n[a]}}(self,(function(){return function(){"use strict";return $((function(){var t=$(".datatables-users");baseUrl,$("#offcanvasAddUser");if($.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),t.length)var e=t.DataTable({processing:!0,serverSide:!0,ajax:{url:baseUrl+"banque/list"},columns:[{data:""},{data:"id"},{data:"nom"},{data:"telephone"},{data:"adresse"},{data:"pays_id"},{data:"action"}],columnDefs:[{className:"control",searchable:!1,orderable:!1,responsivePriority:2,targets:0,render:function(t,e,n,a){return""}},{searchable:!0,orderable:!1,targets:1,render:function(t,e,n,a){return"<span>".concat(n.fake_id,"</span>")}},{targets:2,responsivePriority:4,render:function(t,e,n,a){var s=["success","danger","warning","info","dark","primary","secondary"][Math.floor(6*Math.random())],r=n.nom,o=n.photo,i=r.match(/\b\w/g)||[];return'<div class="d-flex justify-content-start align-items-center user-name"><div class="avatar-wrapper"><div class="avatar avatar-sm me-3">'+(o?'<span class="avatar-initial rounded-circle "> <img src="'.concat(o,'" alt="" class="rounded-circle"></span>'):'<span class="avatar-initial rounded-circle bg-label-'+s+'">'+(i=((i.shift()||"")+(i.pop()||"")).toUpperCase())+"</span>")+'</div></div><div class="d-flex flex-column"><a href="banques/'+n.id+'" class="text-body text-truncate"><span class="fw-medium">'+r+"</span></a></div></div>"}},{targets:3,render:function(t,e,n,a){return'<span class="user-email">'+n.telephone+"</span>"}},{targets:4,responsivePriority:4,render:function(t,e,n,a){return'<div class="d-flex justify-content-start align-items-center user-name"><div class="d-flex flex-column"><span class="fw-medium">'+n.adresse+"</span></div></div>"}},{targets:5,className:"text-center",render:function(t,e,n,a){var s=n.pays;return"".concat(s)}},{targets:-1,title:"Actions",searchable:!1,orderable:!1,render:function(t,e,n,a){return'<div class="d-inline-block text-nowrap">'+'<button class="btn btn-sm btn-icon edit-record" data-id="'.concat(n.id,'" ><a href="banques/').concat(n.id,'"><i class="ti ti-edit"></i></a></button>')+'<button class="btn btn-sm btn-icon delete-record" data-id="'.concat(n.id,'"><i class="ti ti-trash"></i></button>')+"</div>"}}],order:[[2,"desc"]],dom:'<"row mx-2"<"col-md-2"<"me-3"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',language:{sLengthMenu:"_MENU_",search:"",searchPlaceholder:"Rechercher.."},buttons:[{extend:"collection",className:"btn btn-label-primary dropdown-toggle mx-3",text:'<i class="ti ti-logout rotate-n90 me-2"></i>Exporter',buttons:[{extend:"print",title:"Utilisateurs",text:'<i class="ti ti-printer me-2" ></i>Imprimer',className:"dropdown-item",exportOptions:{columns:[2,3,4,5],format:{body:function(t,e,n){if(t.length<=0)return t;var a=$.parseHTML(t),s="";return $.each(a,(function(t,e){void 0!==e.classList&&e.classList.contains("user-name")?s+=e.lastChild.textContent:s+=e.innerText})),s}}},customize:function(t){$(t.document.body).css("color",config.colors.headingColor).css("border-color",config.colors.borderColor).css("background-color",config.colors.body),$(t.document.body).find("table").addClass("compact").css("color","inherit").css("border-color","inherit").css("background-color","inherit")}},{extend:"csv",title:"Utilisateurs",text:'<i class="ti ti-file-text me-2" ></i>Csv',className:"dropdown-item",exportOptions:{columns:[2,3,4,5],format:{body:function(t,e,n){if(t.length<=0)return t;var a=$.parseHTML(t),s="";return $.each(a,(function(t,e){e.classList.contains("user-name")?s+=e.lastChild.textContent:s+=e.innerText})),s}}}},{extend:"excel",title:"Utilisateurs",text:'<i class="ti ti-file-spreadsheet me-2"></i>Excel',className:"dropdown-item",exportOptions:{columns:[2,3,4,5],format:{body:function(t,e,n){if(t.length<=0)return t;var a=$.parseHTML(t),s="";return $.each(a,(function(t,e){e.classList.contains("user-name")?s+=e.lastChild.textContent:s+=e.innerText})),s}}}},{extend:"pdf",title:"Utilisateurs",text:'<i class="ti ti-file-text me-2"></i>Pdf',className:"dropdown-item",exportOptions:{columns:[2,3,4,5],format:{body:function(t,e,n){if(t.length<=0)return t;var a=$.parseHTML(t),s="";return $.each(a,(function(t,e){e.classList.contains("user-name")?s+=e.lastChild.textContent:s+=e.innerText})),s}}}},{extend:"copy",title:"Utilisateur",text:'<i class="ti ti-copy me-1" ></i>Copy',className:"dropdown-item",exportOptions:{columns:[2,3,4,5],format:{body:function(t,e,n){if(t.length<=0)return t;var a=$.parseHTML(t),s="";return $.each(a,(function(t,e){e.classList.contains("user-name")?s+=e.lastChild.textContent:s+=e.innerText})),s}}}}]}],responsive:{details:{display:$.fn.dataTable.Responsive.display.modal({header:function(t){return"Details de "+t.data().prenom}}),type:"column",renderer:function(t,e,n){var a=$.map(n,(function(t,e){return""!==t.title?'<tr data-dt-row="'+t.rowIndex+'" data-dt-column="'+t.columnIndex+'"><td>'+t.title+":</td> <td>"+t.data+"</td></tr>":""})).join("");return!!a&&$('<table class="table"/><tbody />').append(a)}}}});setTimeout((function(){$(".dataTables_filter .form-control").removeClass("form-control-sm"),$(".dataTables_length .form-select").removeClass("form-select-sm")}),300),$(document).on("click",".delete-record",(function(){var t=$(this).data("id"),n=$(".dtr-bs-modal.show");n.length&&n.modal("hide"),Swal.fire({title:"êtes vous sur ?",text:"La suppression est irreversible !",icon:"warning",showCancelButton:!0,confirmButtonText:"Oui , Je supprime !",customClass:{confirmButton:"btn btn-primary me-3",cancelButton:"btn btn-label-secondary"},buttonsStyling:!1}).then((function(n){n.value?($.ajax({type:"DELETE",url:"".concat(baseUrl,"banques/").concat(t),success:function(){e.draw()},error:function(t){console.log(t)}}),Swal.fire({icon:"success",title:"Supprimer!",text:"La Banque a bien été Supprimée !",customClass:{confirmButton:"btn btn-success"}})):n.dismiss===Swal.DismissReason.cancel&&Swal.fire({title:"Annuler",text:"L'utilisateur n'a pas été supprimé!",icon:"error",customClass:{confirmButton:"btn btn-success"}})}))})),$(document).on("click",".edit-record",(function(){var t=$(this).data("id"),e=$(".dtr-bs-modal.show");e.length&&e.modal("hide"),$.get("".concat(baseUrl,"banques/").concat(t,"/edit"),(function(t){$("#user_id").val(t.id),$("#add-user-fullname").val(t.nom),$("#user-contry").val(t.pays_id),$("#user-adresse").val(t.adresse),$("#add-user-contact").val(t.telephone)}))}))})),{}}()}));