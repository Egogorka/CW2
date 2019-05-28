
// var regform = GetByID('reg_form');
//
// regform.onsubmit = function () {
//
//     var message = {
//         login : regform.elements.login.value,
//         pass  : regform.elements.pass.value,
//         email : regform.elements.email.value,
//     };
//
//     AjaxRequest('POST','/auth/signup/',JSON.stringify(message),function (response) {
//         alert(response);
//     },function () {alert('Time out');}, 7000);
//
//     return false;
// };