
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <title>Document</title>
    <script>
        $(document).ready(function(){
            $.get('process.php', function(response){
                $('tbody').append(response);
            })


            $('#input-product').submit(function(event){
                event.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "process.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        if(response == 'error'){
                            $('.insert').append("<div class='alert alert-danger' role='alert'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>");
                        }else{
                            $('tbody').empty();
                            $('tbody').append(response);
                        }
                        
                    },
                    error: function(error){
                        console.log(error);
                    }
                });

            })
            
            $('table').on('click', 'tbody tr .delete', function(){
                let input = $(this).closest('tr').find('td:first').text()
                console.log(input);
                $.post('process.php', { input: input, use: 'delete' }, function(response){
                    $('tbody').empty();
                    $('tbody').append(response);
                })
            })
            $('table').on('click', 'tbody tr a', function(){
                $('#update-product').addClass('show');
                $('.u-id').val($(this).closest('tr').find('td:eq(0)').text());
                $('.u-name').val($(this).closest('tr').find('td:eq(1)').text());
                $('.u-unit').val($(this).closest('tr').find('td:eq(2)').text());
                $('.u-price').val($(this).closest('tr').find('td:eq(3)').text());
                $('.u-xDate').val($(this).closest('tr').find('td:eq(4)').text());
                $('.u-inventory').val($(this).closest('tr').find('td:eq(5)').text());
                
            })
            $('#update-product').submit(function(){
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "process.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        if(response == 'error'){
                            $('.update').append("<div class='alert alert-danger' role='alert'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>");
                        }else{
                            $('tbody').empty();
                            $('tbody').append(response);
                            $('#update-product').removeClass('show');
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            })
        })
    </script>
</head>
<body>
   <div class="cont">
        <form id="input-product">
            <h2>INPUT PRODUCT</h2>
            <div class="inputs insert">
                <input type="hidden" name="use" value="insert" required>
                
                <label>Product name:
                    <input type="text" name="name" class="form-control" required>
                </label>
                <label>Unit:
                    <input type="text" name="unit" class="form-control" required>
                </label class="number">
                <div>
                    <label>Price:
                        <input type="number" name="price" min="0" class="form-control" required>
                    </label>
                    <label>Available Inventory:
                        <input type="number" name="inventory" min="0" class="form-control" required>
                    </label>
                </div>
                
                <label>Expiration Date:
                    <input type="date" name="xDate" class="form-control" required>
                </label>
                <label>Image:
                    <input type="file" name="image" class="form-control" required>
                </label>
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
        <div class="table-responsive-sm table-cont">
            <table class="table">
                <thead class="table-info">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Expiry Date</th>
                        <th>Available Inventory</th>
                        <th>Available Inventory cost</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
       

        <form id="update-product" class="hide">
            <h2>UPDATE PRODUCT</h2>
            <div class="inputs update">
                <input type="hidden" name="use" value="update">
                <input type="hidden" name="id" value="0" class="form-control u-id">
                <label>Product name:
                    <input type="text" name="u-name" class="form-control u-name" required>
                </label>
                <label>Unit:
                    <input type="text" name="u-unit" class="form-control u-unit" required>
                </label class="number">
                <div>
                    <label>Price:
                        <input type="number" name="u-price" min="0" class="form-control u-price" required>
                    </label>
                    <label>Available Inventory:
                        <input type="number" name="u-inventory" min="0" class="form-control u-inventory" required>
                    </label>
                </div>
                
                <label>Expiration Date:
                    <input type="date" name="u-xDate" class="form-control u-xDate" required>
                </label>
                <label>Image:
                    <input type="file" name="u-image" class="form-control u-image" required>
                </label>
                <input type="submit" value="UPDATE" class="btn btn-primary">
            </div>
        </form>
   </div>
    

</body>
</html>