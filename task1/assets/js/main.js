$(document).ready(function() {
    // Функция для отображения списка пользователей
    function showUserList() {
        $.ajax({
            url: 'user.php',
            type: 'GET',
            success: function(response) {
                var users = JSON.parse(response);
                var rows = '';
                $.each(users, function(index, user) {
                    rows += '<tr>';
                    rows += '<td>' + user.id + '</td>';
                    rows += '<td>' + user.name + '</td>';
                    rows += '<td>' + user.surname + '</td>';
                    rows += '<td>' + user.position + '</td>';
                    rows += '<td>';
                    rows += '<button type="button" class="btn btn-sm btn-primary edit-button mr-2" data-id="' + user.id + '">Edit</button>'
                    rows += '<button type="button" class="btn btn-sm btn-danger delete-button" data-id="' + user.id + '">Delete</button>';
                    rows += '</td>';
                    rows += '</tr>';
                });
                $('#user-list').html(rows);
            }
        });
    }

    // При загрузке страницы отображаем список пользователей
    showUserList();

    // Функция для добавления/редактирования пользователя
    $('#user-form').submit(function(event) {
        event.preventDefault();
        var id = $('#id').val();
        var name = $('#name').val();
        var surname = $('#surname').val();
        var position = $('#position').val();

        $.ajax({
            url: 'user.php',
            type: $('#user-form').attr('method'),
            data: {
                id: id,
                name: name,
                surname: surname,
                position: position
            },
            success: function(response) {
                $('#user-form')[0].reset();
                $('#id').val('');
                showUserList();
            }
        });
    });

    // Функция для загрузки данных пользователя для редактирования
    $(document).on('click', '.edit-button', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'user.php?id=' + id,
            type: 'GET',
            success: function(response) {
                var user = JSON.parse(response);
                $('#id').val(user.id);
                $('#name').val(user.name);
                $('#surname').val(user.surname);
                $('#position').val(user.position);
                $('#user-form').attr('method', 'PUT')
            }
        });
    });

    // Функция для удаления пользователя
    $(document).on('click', '.delete-button', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: 'user.php',
                type: 'DELETE',
                data: {id: id},
                success: function(response) {
                    showUserList();
                }
            });
        }
    });

    // Функция для очистки формы
    $('#clear-button').click(function() {
        $('#user-form')[0].reset();
        $('#user-form').attr('method', 'POST')
        $('#id').val('');
    });
    showUserList();
});