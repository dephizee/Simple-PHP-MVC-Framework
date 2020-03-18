<html>
  <head>
    <meta charset="utf-8">
    <title>Hafiz's MVC :: _Managespace</title>    
    <style type="text/css">
      a{
        color: inherit;
      }
      .header_div{
        font-family: sans-serif;
        text-align: center;
      }
      .controller_content, .view_content{
        background-color: rgb(240, 240, 247);
      }
      .controller_header, .view_header{
        font-weight: bold;
        font-size: 1.2em;
        font-family: cursive;
      }
      .controller_list_item, .view_list_item{
        background: #fff;
        font-family: monospace;
      }
      .controller_name:hover, .view_name:hover{
        outline: 1px solid #000;
      }
      .controller_remove, .view_remove{
        background: #B9121B;
        color: #fff;
        cursor: pointer;
        text-align: center;
      }
      .controller_remove:hover, .view_remove:hover{
        color: #B9121B;
        background: #fff;
        outline: 1px solid #f00;
      }
      .controller_add, .view_add{
        background: #168039;
        color: #fff;
        cursor: pointer;
        text-align: center;
      }
      .controller_add:hover, .view_add:hover{
        color: #168039;
        background: #fff;
        outline: 1px solid #168039;
      }
      .success{
        background: #34f534a8;
        color: #fff;
        padding: 10%;
      }
    </style>
  </head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="public/css/icon.min.css">
  <link rel="stylesheet" type="text/css" href="public/css/main.css">
  <body>
     <div class="row" id="">
        <div class="col-10 col-offset-2 header_div">
          
          <h1>Welcome _Managespace page</h1>
          
        </div>
        <div class="col-12 controller_content">
          <?php if (isset($_SESSION['_managespace_log']) ): ?>
              <div class="success" style="padding: 10px; margin: 20px;">
                <?= $_SESSION['_managespace_log'] ?>
                <?php unset($_SESSION['_managespace_log']); ?>

              </div>
          <?php endif ?>
          <div class="col-10 controller_header"> 
            All Controllers
          </div>
          <div class="col-2 controller_add" onclick="addController()"> 
            Add Controller
          </div>
          <div class="col-12 controller_list"> 
            <?php foreach ($data['controller'] as $key => $controller_val): ?>
              <div class="col-12 controller_list_item">

                  <a href="<?=$controller_val ?>">
                    <div class="col-10 controller_name"> 
                      <?=$controller_val ?>
                    </div>
                  </a>
                  <div class="col-2 controller_remove" onclick="removeController('<?=$controller_val ?>')"> 
                    Remove
                  </div>
              </div>              
            <?php endforeach ?>
          </div>
        </div>

        <div class="col-12 view_content">
          <div class="col-10 view_header"> 
            All views
          </div>
          <div class="col-2 view_add"  onclick="addView()"> 
            Add View
          </div>
          <div class="col-12 view_list"> 
            <?php foreach ($data['view'] as $key => $view_val): ?>
              <div class="col-12 view_list_item">
                  <a href="<?=$view_val ?>">
                    <div class="col-10 view_name"> 
                      <?=$view_val ?>
                    </div>
                  </a>
                  <div class="col-2 view_remove" onclick="removeView('<?=$view_val ?>')"> 
                    Remove
                  </div>
              </div>              
            <?php endforeach ?>
          </div>
        </div>
     </div>
  </body>
</html>


<script type="text/javascript">
var addController = ()=>{
  var controller = window.prompt("Enter Controller Name");
  if(controller == null || controller == "") return;
  window.location.href = window.location.href.toLowerCase().split("_managespace")[0] + "_Managespace/"+"add/controller/"+controller;
}
var addView = ()=>{
  var view = window.prompt("Enter View Name");
  if(view == null || view == "") return;
  window.location.href = window.location.href.toLowerCase().split("_managespace")[0] + "_Managespace/"+"add/view/"+view;
}
var removeController = (name)=>{
  if( ! confirm(`Are you sure you want to remove Controller ${name}?`) ) return;
  window.location.href = window.location.href.toLowerCase().split("_managespace")[0] + "_Managespace/"+"remove/controller/"+name;
}
var removeView = (name)=>{
  if( ! confirm(`Are you sure you want to remove View ${name}?`) ) return;
  window.location.href = window.location.href.toLowerCase().split("_managespace")[0] + "_Managespace/"+"remove/view/"+name;
}
</script>