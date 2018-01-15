// $(document).ready(function() {
//     var csrf = $("input[name='_csrf-backend']");
//     $('#logout').click(function(e) {
//         e.preventDefault();
//         console.log('asd');
//         $.ajax({
//             method: "POST",
//             url: "site/logout",
//             data: { "csrf": csrf }
//         }).done(function( msg ) {
//             console.log(msg);
//         });
//     });
// });