@extends('app')
@section('content')
<div class="col-md-8 col-xs-12" id="categories-admin-form">
  <h2 class="section-header" style="margin-bottom: 40px;">
    <i class="icon-directions"></i> Reported Users List
  </h2>
<table class="table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Reported Users List</th>
              <th>View</th>

             <!--  <th>Report To</th>
              <th>Detail</th>
              <th>Report Time</th> -->
            </tr>
          </thead>
          <tbody>
            @if(count($reports)>0)
            @foreach($reports as $report)
            <tr id="{{$report->id}}">
              <td>{{$report->from_name}}</td>
              <td>{{$report->from_email}}</td>  
              <td>{{$report->to_name}}</td>  

              <td class="text-center"><button data-attr="{{$report->id}}" class="btn btn-primary report_btn">VIEW</button></td>

              <div class="modal" id="modal_id_{{$report->id}}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Reason To Report</h5>
                      <button type="button" class="close close-modal" data-attr="{{$report->id}}" data-dismiss="modal_id_{{$report->id}}" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p><strong>{{$report->from_name}}</strong> Reported <strong>{{$report->to_name}} User</strong></p>
                      <p><strong>Reason : </strong>{{$report->message}}</p>
                    </div>
                   </div>
                </div>
              </div>


            <td>

            </tr>
            @endforeach
            @endif
          </tbody>
<style>

  body {
    font-family:Arial, Helvetica, sans-serif;
}
 
p {
    font-size: 16px;
    line-height: 26px;
    letter-spacing: 0.5px;
    color: #484848;
}
 
/* Popup Open button */ 
.open-button{
    color:#FFF;
    background:#0066CC;
    padding:10px;
    text-decoration:none;
    border:1px solid #0157ad;
    border-radius:3px;
}
 
.open-button:hover{
    background:#01478e;
}
 
.popup {
    position:fixed;
    top:0px;
    left:0px;
    background:rgba(0,0,0,0.75);
    width:100%;
    height:100%;
    display:none;
}
 
/* Popup inner div */
.popup-content {
    width: 500px;
    margin: 0 auto;
    box-sizing: border-box;
    padding: 40px;
    margin-top: 20px;
    box-shadow: 0px 2px 6px rgba(0,0,0,1);
    border-radius: 3px;
    background: #fff;
    position: relative;
}
 
/* Popup close button */
.close-button {
    width: 25px;
    height: 25px;
    position: absolute;
    top: -10px;
    right: -10px;
    border-radius: 20px;
    background: rgba(0,0,0,0.8);
    font-size: 20px;
    text-align: center;
    color: #fff;
    text-decoration:none;
}
 
.close-button:hover {
    background: rgba(0,0,0,1);
}

.modal-content {
    /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
    width:inherit;
    height:inherit;
    /* To center horizontally */
    margin: 0 auto;
}
 
@media screen and (max-width: 720px) {
.popup-content {
    width:90%;
    } 
}
h5.modal-title {
    font-weight: 600;
    font-size: 24px;
    color: #3a89b7;
}

.modal-header {
    display: flex !important;
    justify-content: space-between !important;
    width: 100% !important;
}
.modal-header .close {
    margin-left: auto !important;
}
.modal {
    background: #0000007a !important;
}
</style>



        
 </table>


      </div>


       


@include('components/sidebar')


  <div class="tab-content">
    <div>
      
  </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript">
  // function displaymsg(id){
  //   console.log(id);
  // }
</script>
<script>
$('.report_btn').on('click', function() {
    var id = $(this).attr('data-attr');
    console.log(id);
    $('#modal_id_'+id).show();
});

$('.close-modal').on('click', function() {
    var id = $(this).attr('data-attr');
    console.log(id);
    $('#modal_id_'+id).toggle();
});

</script>

<script type="text/javascript">
  $(function() {
    // Open Popup
    $('[popup-open]').on('click', function() {
        var popup_name = $(this).attr('popup-open');
 $('[popup-name="' + popup_name + '"]').fadeIn(300);
    });
 
    // Close Popup
    $('[popup-close]').on('click', function() {
 var popup_name = $(this).attr('popup-close');
 $('[popup-name="' + popup_name + '"]').fadeOut(300);
    });
 
    // Close Popup When Click Outside
    $('.popup').on('click', function() {
 var popup_name = $(this).find('[popup-close]').attr('popup-close');
 $('[popup-name="' + popup_name + '"]').fadeOut(300);
    }).children().click(function() {
 return false;
    });
 
});
</script>
  


@endsection
