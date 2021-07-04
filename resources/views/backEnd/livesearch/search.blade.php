
<!-- jQuery UI 1.11.4 -->
<table id="search-data" class="table table-bordered table-striped">

   @foreach($show_datas as $show_data)
   <tr>
     <td>
      <a  href="#" value="{{$show_data->id}}" id="addtocart" class="addcartbutton anchor" data-id="{{$show_data->id}}">
        {{$show_data->name}}
      </a>
    </td>
   </tr>
   @endforeach

  </table>

  <script type="text/javascript">
    $(document).ready(function(){

    function cartContent(){
         $.ajax({
           type:"GET",
           url:"{{url('editor/cart/content')}}",
           dataType: "html",
           success: function(cartinfo){
             $('#cartTable').html(cartinfo)
           }
        });
    }

    $('.addcartbutton').click(function(e){
      var id = $(this).data("id");
    if(id){
        $.ajax({
           cache: 'false',
           type:"GET",
           url:"{{url('editor/add-to-cart')}}/"+id,
           dataType: "json",
        success: function(cartinfo){
            return cartContent();
        }
        });
    }
   });

  });
</script>
    <!-- main add to cart ajax end -->