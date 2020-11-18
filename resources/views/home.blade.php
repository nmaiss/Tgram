@extends('layouts.app')

@section('content')
    <div class="container box pt-5">
        <h3 align="center">Canaux Telegram francophones</h3><br />
        <div class="panel panel-default">
            <div class="panel-heading pb-2">Rechercher</div>
            <div class="panel-body">
                <div class="form-group pb-3">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Saisissez les mots-clés (nom, catégorie, description, ...)" />
                </div>

                <div class="container">
                    <div class="row pt-2" id="chaines">

                    </div>
                </div>



            </div>
        </div>
    </div>
<script>
    $(document).ready(function(){

        fetch_customer_data();

        function fetch_customer_data(query = '')
        {
            $.ajax({
                url:"{{ route('/.action') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#chaines').html(data.table_data);
                }
            })
        }

        $(document).on('keyup','#search', function () {
            var query = $(this).val();
            fetch_customer_data(query);
        });
    });
</script>

@endsection
