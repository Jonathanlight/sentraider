
$('#list-annoncements').find('div').each(function () {
    var row = $(this);

    row.find('.target-annoncement').click(function(){
        let url_annoncement_teacher = $(this).data('annoncement-url');
        let counter_stats_url = $(this).data('counter-stats-url');

        $.ajax({
            type: 'POST',
            url: counter_stats_url,
            success: function (data) {
                data = JSON.parse(data);

                console.log(data)
            }
        });

        $.ajax({
            type: 'GET',
            url: url_annoncement_teacher,
            success: function(data) {
                data = JSON.parse(data);

                //Profil information
                $('#template-body .annoncement_picture').empty();
                if (typeof data.user_annoncement.media_profil.picture !== 'undefined') {
                    $('#template-body .annoncement_picture').append('<img src="https://devsprof.fr/assets/img/picture/' + data.user_annoncement.media_profil.picture + '" style="width: 100px;height: 100px;" class="rounded img-thumbnail" alt="profil">');
                } else {
                    $('#template-body .annoncement_picture').append('<img src="https://devsprof.fr/assets/front/img/avatar.png" style="width: 100px;height: 100px;" class="rounded img-thumbnail" alt="profil">');
                }

                $('#template-body .annoncement_price').empty();
                $('#template-body .annoncement_price').append('<h2 class="section-heading pt-5">' + data.price + ' € / H </h2>');

                $('#template-body .annoncement_profil').empty();
                $('#template-body .annoncement_profil').append('<h3 class="card-title"> <i class="fas fa-user mr-2"></i> ' + data.user_annoncement.prenom + ' ' + data.user_annoncement.nom + '</h3>');
                $('#template-body .annoncement_profil').append('<h5 class="card-title"> <i class="fas fa-code mr-2"></i> ' + data.language.content + '</h5>');
                $('#template-body .annoncement_profil').append('<p class="card-text"><strong>Description :</strong> ' + data.content + '</p>');

                //Availability
                $('#template-body .availability_morning').empty();
                $('#template-body .availability_morning').append('<th scope="row">Matin</th>');

                if (typeof data.user_annoncement.availability.monday_start !== 'undefined') { var d = new Date(data.user_annoncement.availability.monday_start); $('#template-body .availability_morning').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_morning').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.tuesday_start !== 'undefined') { var d = new Date(data.user_annoncement.availability.tuesday_start); $('#template-body .availability_morning').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_morning').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.wednesday_start !== 'undefined') { var d = new Date(data.user_annoncement.availability.wednesday_start); $('#template-body .availability_morning').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_morning').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.thursday_start !== 'undefined') { var d = new Date(data.user_annoncement.availability.thursday_start); $('#template-body .availability_morning').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_morning').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.friday_start !== 'undefined') { var d = new Date(data.user_annoncement.availability.friday_start); $('#template-body .availability_morning').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_morning').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.saturday_start !== 'undefined') { var d = new Date(data.user_annoncement.availability.saturday_start); $('#template-body .availability_morning').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_morning').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.sunday_start !== 'undefined') { var d = new Date(data.user_annoncement.availability.sunday_start); $('#template-body .availability_morning').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_morning').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }

                $('#template-body .availability_night').empty();
                $('#template-body .availability_night').append('<th scope="row">Soir</th>');

                if (typeof data.user_annoncement.availability.monday_end !== 'undefined') { var d = new Date(data.user_annoncement.availability.monday_end); $('#template-body .availability_night').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_night').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.tuesday_end !== 'undefined') { var d = new Date(data.user_annoncement.availability.tuesday_end); $('#template-body .availability_night').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_night').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.wednesday_end !== 'undefined') { var d = new Date(data.user_annoncement.availability.wednesday_end); $('#template-body .availability_night').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_night').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.thursday_end !== 'undefined') { var d = new Date(data.user_annoncement.availability.thursday_end); $('#template-body .availability_night').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_night').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.friday_end !== 'undefined') { var d = new Date(data.user_annoncement.availability.friday_end); $('#template-body .availability_night').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_night').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.saturday_end !== 'undefined') { var d = new Date(data.user_annoncement.availability.saturday_end); $('#template-body .availability_night').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_night').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }
                if (typeof data.user_annoncement.availability.sunday_end !== 'undefined') { var d = new Date(data.user_annoncement.availability.sunday_end); $('#template-body .availability_night').append('<td class="text-center"><span class="chip chip-sm green-own white-text">' + d.getHours() + ':' + d.getMinutes() + '</td>'); } else {  $('#template-body .availability_night').append('<td class="text-center"><i class="fas fa-ban red-text mr-3"></i></td>'); }

                //Niveau
                $('#template-body .niveau').empty();
                $('#template-body .niveau').append('<li class="list-group-item d-flex justify-content-between align-items-center active">' +
                    '<div class="md-v-line"></div><i class="fas fa-laptop mr-4 pr-3"></i> Niveau' +
                    '</li>');
                jQuery.each(data.niveau, function(index, item) {
                    console.log(item.toUpperCase());
                    $('#template-body .niveau').append('<li class="list-group-item d-flex justify-content-between align-items-center">' +
                        '<div class="md-v-line"></div><i class="fas fa-code mr-5"></i> ' + item.toUpperCase() +
                        '</li>');
                });

                //Type of cours
                $('#template-body .type-cours').empty();
                $('#template-body .type-cours').append('<li class="list-group-item d-flex justify-content-between align-items-center active">' +
                    '<div class="md-v-line"></div><i class="fas fa-laptop mr-4 pr-3"></i> Type de cours' +
                    '</li>');
                jQuery.each(data.type_cours, function(index, item) {
                    $('#template-body .type-cours').append('<li class="list-group-item d-flex justify-content-between align-items-center">' +
                        '<div class="md-v-line"></div><i class="fas fa-gem mr-5"></i> ' + item.toUpperCase() +
                        '</li>');
                });

                //Location
                $('#template-body .location').empty();
                $('#template-body .location').append('<li class="list-group-item d-flex justify-content-between align-items-center active">' +
                    '<div class="md-v-line"></div><i class="fas fa-laptop mr-4 pr-3"></i> Lieux des cours' +
                    '</li>');
                jQuery.each(data.location, function(index, item) {
                    $('#template-body .location').append('<li class="list-group-item d-flex justify-content-between align-items-center">' +
                        '<div class="md-v-line"></div><i class="fas fa-map mr-5"></i> ' + item.toUpperCase() +
                        '</li>');
                });
            }
        });

    });
});