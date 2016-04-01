$(function () {
    $('form').submit(function () {
        $.ajax({
            url: 'index/search',
            method: 'GET',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                var result = ' <table class="table table-hover"> <tr class="headTable"> <th>Title </th> <th>Year </th> <th>Synopsis </th><th>Producer</th> <th>Time</th> </tr>';
                for (var i = 0; i < data.films.length;i++) {

                    secondes = data.films[i].duration;
                    minutes = secondes / 60;
                    secondes = secondes % 60;
                    heures = minutes / 60;
                    minutes = minutes % 60;

                    result += '<tr><td>'+data.films[i].title+' </td><td>'+data.films[i].year+'</td><td>'+data.films[i].synopsis+'</td><td>' + data.films[i].first_name+' '+data.films[i].last_name + '</td><td>'+Math.trunc(heures) + 'h' + Math.trunc(minutes)+'</td></tr>';
                }
                result += '</table>';
                $('.results').html(result);
            }
        });
        return false;
    });
});