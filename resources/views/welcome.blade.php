<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Item Manager</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    </head>
    <body>
        
        <nav class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Item manager</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="/">Home</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <h1>Add item</h1>
            <form id="itemForm">
                <div class="form-group">
                    <label>Text</label>
                    <input type="text" id="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Body</label>
                    <textarea id="body" class="form-control"></textarea>
                </div>
                <input type="submit" value="Submit" class="btn btn-primary">
            </form>
            <hr>
            <ul id="items" class="list-group"></ul>
        </div>

    <script
    src="https://code.jquery.com/jquery-1.12.4.js"
    integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU="
    crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            getItems();

            //submit event
            $('#itemForm').on('submit', function(e) {
                e.preventDefault();

                let text = $('#text').val();
                let body = $('#body').val();

                addItem(text, body);
            });

            //delete event
            $('body').on('click', '.deleteLink', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                deleteItem(id);
            });

            //delete item through api
            function deleteItem(id){
                $.ajax({
                    method:'POST',
                    url: 'http://127.0.0.1:8000/api/items/'+id,
                    data: {_method: 'DELETE'}
                }).done(function(item) {
                    alert('Item Removed');
                    location.reload();
                });
            }

            //insert items using api
            function addItem(text, body){
                $.ajax({
                    method:'POST',
                    url: 'http://127.0.0.1:8000/api/items',
                    data: {text: text, body: body}
                }).done(function(item) {
                    alert('Item # '+item.id+' added');
                    location.reload();
                });
            }

            //get items from api
            function getItems() {
                $.ajax({
                    url:'http://127.0.0.1:8000/api/items'
                }).done(function(items) {
                    console.log(items);
                    let output = '';
                    $.each(items, function(key, item){
                        output += `
                            <li class="list-group-item">
                                <strong>${item.text}: </strong>${item.body} <a href="#" class="deleteLink" data-id="${item.id}">Delete</a>
                            </li>
                        `;
                    });
                    $('#items').append(output);
                });
            }
        });
    </script>
    </body>
</html>